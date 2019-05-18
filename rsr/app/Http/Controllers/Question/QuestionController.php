<?php


namespace App\Http\Controllers\Question;


use App\Answer;
use DB;

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
    public function getRandomQuestion($userId, $numberOfQuestions = 1)
    {
        $alreadyAnsweredQuestions = DB::table('answered_questions')->where("user_id", $userId)->pluck('question_id');
        $questions = DB::table('questions')->inRandomOrder()->whereNotIn('id', $alreadyAnsweredQuestions)->get()->take($numberOfQuestions);
        $questionIds = $questions->pluck('id');
        foreach ($questionIds as $questionId) {
            DB::table('answered_questions')->insert(
                ['user_id' => $userId, "question_id" => $questionId]
            );
        }
        return $questions;
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