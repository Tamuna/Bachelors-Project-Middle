<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //

    public function index()
    {
        echo "index";
    }

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
        foreach($questionIds as $questionId)
        {
            DB::table('answered_questions')->insert(
                ['user_id' => $userId, "question_id" => $questionId]
            );
        }
        $result =
            [
                "status" => "200",
                "error" => [],
                "result" =>
                    [
                        $questions
                    ]

            ];
        return response()->json($result);
    }
}