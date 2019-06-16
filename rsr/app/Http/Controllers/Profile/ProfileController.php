<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ProfileController extends Controller
{


    public function addFriend(Request $request)
    {
        $userOneId = auth('api')->user()->id;
        $userTwoId = DB::table('users')->where('user_name', $request->frind_user_name)->get()->pluck('id')[0];
        // Check if users are friends already/
        $checker1 = DB::table('FRIENDSHIPS')->where('user_one_id', $userOneId)->where('user_two_id', $userTwoId)->get();
        $checker2 = DB::table('FRIENDSHIPS')->where('user_one_id', $userTwoId)->where('user_two_id', $userOneId)->get();

        if($checker1->isEmpty() and $checker2->isEmpty())
        {
            DB::table('FRIENDSHIPS')->insert(
                ['user_one_id' => $userOneId, 'user_two_id' => $userTwoId]
            );
            DB::table('FRIENDSHIPS')->insert(
                ['user_one_id' => $userTwoId, 'user_two_id' => $userOneId]
            );
            $result =
                [
                    "error" => "",
                    "result" => [
                        "success" => '1'
                    ],

                ];
            return response()->json($result, 200);
        }
        $result =
            [
                "error" => "already friends",
                "result" => [
                    "user_one_id" => "",
                    "user_two_id" => ""
                ],

            ];
        return response()->json($result, 200);
    }

    public function getFriendsList(Request $request)
    {
        $userId = auth('api')->user()->id;
        $friendsIds = DB::table('FRIENDSHIPS')->where('user_one_id', $userId)->get()->pluck('user_two_id');
        $friends = array();
        foreach ($friendsIds as $friendsId) {
            $friend = DB::table('USERS')->where('id', $friendsId)->pluck('user_name')[0];

            array_push($friends ,$friend);
        }
        $friendsIds1 = DB::table('FRIENDSHIPS')->where('user_two_id', $userId)->get()->pluck('user_one_id');
        foreach ($friendsIds1 as $friendsId) {
            $friend = DB::table('USERS')->where('id', $friendsId)->pluck('user_name')[0];
            array_push($friends ,$friend);
        }
        $result =
            [
                "error" => "",
                "result" => [
                    "friends" => $friends
                ],

            ];
        return response()->json($result, 200);
    }
}
