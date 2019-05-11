<?php


namespace App\Http\Controllers\Question;


use App\Answer;
use App\Question;
use function MongoDB\BSON\toJSON;
use function Sodium\add;

class QuestionController
{
    public function getSeveralQuestions($numQuestions)
    {
        return Question::inRandomOrder()->get()->take($numQuestions);
    }

    private function stringsMatch($s1, $s2)
    {
        if ($s1 == $s2) {
            echo "equals";
            return true;
        }
        return false;
    }

    public function checkAnswer($questionId, $currentAnswer)
    {
        $answers = Answer::All()->where('question_id', $questionId);
        $data = [
            'correct' => false,
            'answers' => []
        ];
        foreach ($answers as $key => $answer) {
            array_push($data['answers'], $answer);
            if ($this->stringsMatch($currentAnswer, $answer->answer)) {
                $data['correct'] = true;
            }
        }
        return $data;
    }
}