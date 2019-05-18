<?php

namespace App\Http\Controllers\Game;

use DB;

class GameController
{

    public function index()
    {
        echo "index";
    }

    /*
     * Params:
     *  userId
     *  numberOfCorrectAnswers: The number of correctly answered questions.
     *
     * Saves the cumulative number of correct answers.
     * Does not delete old values (Table saves history of correct answers).
     *
     * Returns:
     *  Updated number of correct answers.
     */
    public function finishGame($userId, $numberOfCorrectAnswers)
    {
        $points = 0;
        $firstPlay = DB::table('points')->where("user_id", $userId)->get();
        if (!$firstPlay->isEmpty()) {
            $subQuery = DB::table('points')->selectRaw('MAX(id)')->groupBy('user_id');
            $query = DB::table('points')->whereIn('id', $subQuery)->where('user_id', $userId);
            $currentPointInDb = $query->get('point')->pluck('point')[0];
            if (!empty($currentPointInDb)) {
                $points += $currentPointInDb;
            }
        }
        $points += $numberOfCorrectAnswers;
        DB::table('points')->insert(
            ['user_id' => $userId, "point" => $points]
        );
        $result =
            [
                "status" => "200",
                "error" => "",
                "currentNumberOfCorrectAnswers" => $points
            ];
        return response()->json($result);
    }
}
