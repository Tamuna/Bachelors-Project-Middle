<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{


    public function addFriend(Request $request)
    {
        $userOneId = auth('api')->user()->id;
        $userTwoId = DB::table('users')->where('user_name', $request->frind_user_name)->get()->pluck('id')[0];
        // Check if users are friends already/
        $checker1 = DB::table('FRIENDSHIPS')->where('user_one_id', $userOneId)->where('user_two_id', $userTwoId)->get();
        $checker2 = DB::table('FRIENDSHIPS')->where('user_one_id', $userTwoId)->where('user_two_id', $userOneId)->get();

        if ($checker1->isEmpty() and $checker2->isEmpty()) {
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

        $me = $request->user()->user_name;

        $friends = User::all()->whereNotIn('user_name', $me);
        $friends_res = [];
        foreach ($friends as $friend) {
            $friends_res[] = $friend;
        }

        $result =
            [
                "error" => null,
                "result" => [
                    "friends" => $friends_res
                ],
            ];
        return response()->json($result, 200);

//        $userId = auth('api')->user()->id;
//        $friendsIds = DB::table('FRIENDSHIPS')->where('user_one_id', $userId)->get()->pluck('user_two_id');
//        $friends = array();
//        foreach ($friendsIds as $friendsId) {
//            $friend = DB::table('USERS')->where('id', $friendsId)->pluck('user_name')[0];
//
//            array_push($friends, $friend);
//        }
//        $friendsIds1 = DB::table('FRIENDSHIPS')->where('user_two_id', $userId)->get()->pluck('user_one_id');
//        foreach ($friendsIds1 as $friendsId) {
//            $friend = DB::table('USERS')->where('id', $friendsId)->pluck('user_name')[0];
//            array_push($friends, $friend);
//        }
//        $result =
//            [
//                "error" => null,
//                "result" => [
//                    "friends" => $friends
//                ],
//
//            ];
//        return response()->json($result, 200);
    }

    function sendNotification(Request $request)
    {
        $friendToken = [];
        $usernames = $request->all()['friend_usernames'];
        $dialog_id = $request->all()['dialog_id'];
        foreach ($usernames as $username) {
            $friendToken[] = DB::table('users')->where('user_name', $username)->get()->pluck('device_token')[0];
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        foreach ($friendToken as $tok) {
            $notification = array('title' =>"" , 'text' => $request->all()['message']);
            $fields = array(
                'to' => $tok,
                'data' => $message = array(
                    "message" => $request->all()['message'],
                    "dialog_id" => $dialog_id),
                'notification' => $notification
            );
            $headers = array(
                'Authorization: key=AAAA46Umy7o:APA91bFeqx5dRXRUAsVTbwxz-XYr4pmKWlFD6__BQpvNLk0sZYaHLSx6lOFQzKF5dLOEgUOENf-fizQ4guyCQLdsx5dBuzBZhIFZlOx0h4arUcnFX_CYglVcYkJhyb_i7XxDKERrx273',
                'Content-type: Application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            curl_exec($ch);

            curl_close($ch);
        }

        $res =
            [
                "error" => null,
                "result" => "friends invited",
            ];
        return $res;
    }

    function getChatOccupants(Request $request)
    {
        $chatIds = $request->all()['chat_ids'];
        $occupantsObj = User::all()->whereIn("chat_user_id", $chatIds);
        $friends_res = [];
        foreach ($occupantsObj as $occupant) {
            $result[] = $occupant;
        }

        $result = [
            'error' => null,
            'result' => [
                'friends' => $result
            ]
        ];
        return response()->json($result, 200);
    }

    public function changeFirstName(Request $request)
    {
        $newName = $request->all()["first_name"];
        $id = auth('api')->user()->id;
        DB::table('users')->where('id', $id)
            ->update(['first_name' => $newName]);
        $result = [
            'error' => null,
            'result' => $newName
        ];
        return $result;
    }

    public function changeLastName(Request $request)
    {
        $newName = $request->all()["last_name"];
        $id = auth('api')->user()->id;
        DB::table('users')->where('id', $id)
            ->update(['last_name' => $newName]);
        $result = [
            'error' => null,
            'result' => $newName
        ];
        return $result;
    }

    public function changePassword(Request $request)
    {
        $oldPass = $request->all()["old_password"];
        $newPass = $request->all()["new_password"];

        if (Hash::check($oldPass, auth('api')->user()->password)) {
            auth('api')->user()->fill([
                'password' => Hash::make($newPass)
            ])->save();
            $result = [
                'error' => null,
                'result' => "success"
            ];
            return $result;
        } else {

        }
        $result = [
            'error' => "101"
        ];
    }
}
