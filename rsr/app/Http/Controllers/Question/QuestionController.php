<?php


namespace App\Http\Controllers\Question;


use App\Answer;
use DB;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;

class QuestionController
{

    /*
     * Params:
     *  userId: userId
     *  $numberOfQuestions (optional = 1): Number of questions to return.
     *
     * Gets requested number of random questions from questions table.
     * Saves questions in answered_questions table to avoid duplicate questions for users
     *
     * Returns:
     *  Requested number of questions
     */
    public function getRandomQuestion(Request $request, $numberOfQuestions = 1)
    {
        $userId = $request->user()->id;
        $alreadyAnsweredQuestions = DB::table('answered_questions')->where("user_id", $userId)->pluck('question_id');

        $questions = DB::table('questions')->inRandomOrder()->
        whereNotIn('id', $alreadyAnsweredQuestions)->
        where('is_tour_question', false)->get()->take($numberOfQuestions);

        $questionIds = $questions->pluck('id');
        foreach ($questionIds as $questionId) {
            DB::table('answered_questions')->insert(
                ['user_id' => $userId, "question_id" => $questionId]
            );
        }
        $result =
            [
                "error" => null,
                "result" => [
                    "questions" => $questions
                ],

            ];
        return response()->json($result, 200);
    }

    private function stringsMatch($s1, $s2)
    {
        $result = false;
        $maxDif = strlen($s1) / 4;
        try {
            if (levenshtein(substr($s1, 0, 255), substr($s2, 0, 255)) <= $maxDif) {
                $result = true;
            }
        } catch (Exception $e) {
            $result = $s1 == $s2;
        }
        return $result;
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

    public function addQuestion(Request $request)
    {
        $question_content = $request->all()["question_content"];
        $answers = $request->all()["answers"];
        $tournamentId = $request->all()["tour_id"];
        $userId = $request->all()["user_id"];

        $questionId = DB::table('questions')->insertGetId([
            'question_content' => $question_content,
            'user_id' => $userId,
            'is_tour_question' => true
        ]);

        foreach ($answers as $answer) {
            DB::table('answers')->insertGetId([
                'answer' => $answer,
                'question_id' => $questionId
            ]);
        }

        DB::table('tournament_questions')->insert([
            'question_id' => $questionId,
            'tournament_id' => $tournamentId
        ]);

        $result = [
            'error' >= null,
            'result' => $questionId
        ];

        return $result;
    }
}