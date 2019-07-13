<?php

namespace App\Http\Controllers\Game;

use DB;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use function PHPSTORM_META\elementType;

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
    public function finishGame(Request $request, $numberOfCorrect)
    {
        $user = $request->user();
        $userId = $user->id;
        $numberOfCorrectAnswers = $numberOfCorrect;
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
                "error" => null,
                "result" => [
                    "current-number-of-correct-answers" => $points
                ]
            ];
        return response()->json($result, 200);
    }

    public function saveTour(Request $request)
    {
        $tourName = $request->all()["name"];
        $userid = (int)$request->all()["user_id"];
        $startTime = $request->all()["start_time"];


        $date = strtotime($startTime);

        $startTime = date('Y-m-d H:i:s', $date);

        $id = DB::table('tournaments')->insertGetId([
            'tournament_name' => $tourName,
            'user_id' => $userid,
            'start_time' => $startTime

        ]);

        $result = ['error' => null,
            'result' => $id];
        return $result;
    }

    private function getSecsToTournament(String $date)
    {
        $tour_date = strtotime($date);
        $now_date = time() + 4 * 3600;
        $diff = $tour_date - $now_date;

        return $diff;
    }

    public function getTournaments(Request $request)
    {
        $result = json_decode(DB::table("tournaments")->get(), true);
        for ($i = 0; $i < count($result); $i++) {
            $secondsToTour = $this->getSecsToTournament($result[$i]["start_time"]);

            $tour_quest_ids = DB::table("tournament_questions")->
            where("tournament_id", $result[$i]["id"])->get()->pluck("question_id");

            $tour_questions = json_decode(DB::table("questions")->
            whereIn('id', $tour_quest_ids)->get(), true);

            if ($secondsToTour < 0) {
                $result[$i]["expired"] = true;
            } else {
                $result[$i]["expired"] = false;
            }
            $result[$i]["question_count"] = count($tour_questions);
        }
        return response()->json(["error" => null, "result" => $result], 200);
    }

    public function getSelectedTournament($tournamentId)
    {
        $result = json_decode(DB::table("tournaments")->where("id", $tournamentId)->get(), true);

        $tour_quest_ids = DB::table("tournament_questions")->
        where("tournament_id", $result[0]["id"])->get()->pluck("question_id");

        $tour_questions = json_decode(DB::table("questions")->
        whereIn('id', $tour_quest_ids)->get(), true);

        $secondsToTour = $this->getSecsToTournament($result[0]["start_time"]);

        if (0 > $secondsToTour) {
            return [
                "error" => "expired",
                "result" => null
            ];
        }

        for ($j = 0; $j < count($tour_questions); $j++) {
            $tour_questions[$j]["answers"] = json_decode(DB::table("answers")->
            where("question_id", $tour_questions[$j]["id"])->get(), true);
        }
        $result[0]['questions'] = $tour_questions;

        $result[0]['seconds_until'] = $secondsToTour;

        return ["error" => null,
            "result" => $result[0]];
    }

    public function saveTourResults(Request $request)
    {
        $points = $request->all()["points"];
        $userId = $request->user()->id;
        $tourId = $request->all()["tour_id"];

        DB::table('tournament_points')->insert(
            ['user_id' => $userId, "tournament_id" => $tourId, "points" => $points]
        );

        return ["error" => null, "result" => "tour_ended"
        ];
    }


    function cmp($a, $b)
    {
        if ($a == $b)
            return 0;
        return $a["point"] > $b["point"] ? -1 : 1;
    }

    public function getTourRatings($tournamentId)
    {
        $tournament_points = DB::table("tournament_points")->where("tournament_id", $tournamentId)->get();
        $res_arr = [];
        foreach ($tournament_points as $point) {

            $username = DB::table("users")->where("id", $point->user_id)->get();
            $res_arr[] = ["username" => $username[0]->user_name, "point" => $point->points];
        }
        usort($res_arr, array($this, "cmp"));
        return
            ["result" => $res_arr,
                "error" => null];
    }
}
