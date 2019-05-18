from urllib.request import urlopen
from urllib.parse import unquote
from bs4 import BeautifulSoup

file_name = 'questions.txt'
url = 'http://moazrovne.net/chgk/'
# tmp (Levan)
max_page_num = 140

question_tag_name = 'p'
question_class_name = 'question_question'
img_tag_name = 'img'
attr_tag_name = 'span'
attr_class_name = 'right_nofloat'

attr_answer_num = 0
attr_comment_num = 1
attr_src_num = 2
attr_link_num = 4


def parse_div(div):
    content = ''
    img_src = ''
    answer = ''
    comment = ''
    src = ''
    link = ''

    content = div.find(question_tag_name, attrs={'class', question_class_name}).text.strip()

    try_img = div.find(img_tag_name, attrs={'class', 'question_image'})
    
    if try_img:
        try_img = str(try_img)
        img_src = try_img.split("src", 1)[1][2:-3]

    attrs = div.find_all(attr_tag_name, attrs={'class', attr_class_name})    
    answer = attrs[attr_answer_num].text.strip()
    if attr_comment_num < len(attrs):
        comment = attrs[attr_comment_num].text.strip()
    if attr_src_num < len(attrs):
        lis = attrs[attr_src_num].find_all('li')
        if lis:
            for i in range(len(lis)):
                src += unquote(lis[i].text.strip()) + '  '
        else:
            src = unquote(attrs[attr_src_num].text.strip())
    if attr_link_num < len(attrs):
        link = attrs[attr_link_num].text.strip()
    return(content, img_src, answer, comment, src, link)


def parse_page(url):
    result = []
    page = urlopen(url)
    soup = BeautifulSoup(page, 'html.parser')
    divs = soup.find_all('li', attrs={'class': 'q'})
    for div in divs:
        result.append(parse_div(div))
    return result
    

def main():
    questions = []
    page_num = 1
    for i in range(1, max_page_num + 1):
        current_url = url + str(i)
        page_questions = parse_page(current_url)
        questions.extend(page_questions)
        print('Parsing page. page_num: ' + str(page_num))
        page_num += 1
    print('The number of questions: ' + str(len(questions)))
    with open(file_name, 'w', encoding='utf-8') as out_file:
        counter = 1
        for question in questions:
            out_file.write('#' + str(counter) + '\n')
            out_file.write('question: ' + question[0] + '\n')
            out_file.write('img : ' +question[1] + '\n')
            out_file.write('answer : ' +question[2] + '\n')
            out_file.write('comment : ' +question[3] + '\n')
            out_file.write('src : ' +question[4] + '\n')
            out_file.write('link : ' +question[5] + '\n')
            out_file.write('\n\n')
            counter += 1

# Here we go
main()