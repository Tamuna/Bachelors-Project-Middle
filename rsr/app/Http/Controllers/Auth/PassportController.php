<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
use App\Notifications\SignupActivate;
use Redirect;

class PassportController extends Controller
{

    /*
     * Register
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            $result =
                [
                    "error" => $validator->errors()->first(),
                    "result" => null,
                ];
            return response()->json($result, 200);
        }
        $input = $request->all();
        if (strlen($input['password']) < 8) {
            $result = [
                "error" => "პაროლი უნდა შედგებოდეს მინიმუმ 8 სიმბოლოსგან",
                "result" => null,
            ];
            return response()->json($result, 200);
        }
        $input['password'] = bcrypt($input['password']);
        $input['activation_token'] = str_random(60);
        $user = User::create($input);
        $success['token'] = $user->createToken('My App')->accessToken;
        $user->notify(new SignupActivate($user));
        $result =
            [
                "error" => null,
                "result" => ['token' => $success['token']]
            ];
        return response()->json($result, 200);
    }

    public function sendConfirmation(Request $request) {
        $user = User::where('email', $request->all()['email']) -> first();
        $user->notify(new SignupActivate($user));
        $result =
            [
                "error" => null,
                "result" => "success"
            ];
        return response()->json($result, 200);
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
//        if (!$user) {
//            return response()->json([
//                'message' => 'This activation token is invalid.'
//            ], 404);
//        }
        if ($user) {
            $user->active = true;
            $user->activation_token = '';
            $user->save();
        }
        $url = "https://ra-sad-rodis.flycricket.io/privacy.html";
        return Redirect::away($url);
//        $result =
//            [
//                "result" => "success"
//            ];
//        return response();
    }

    /*
     * Login
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->password])) {
            $user = Auth::user();

//            $credentials = request(['email', 'password']);
//
//            $credentials['active'] = 1;

            if($user->active != 1) {
                return response()->json([
                    "error" => "Please, Confirm Your Email Address!",
                    'result' => null
                ], 200);
            }

//            if(!Auth::attempt($credentials))
//                return response()->json([
//                    "error" => "Please, Confirm Your Email Address!",
//                    'result' => null
//                ], 200);

            $success['token'] = $user->createToken('My App')->accessToken;
            $result =
                [
                    "error" => null,
                    'result' => ["token" => $success['token']]
                ];
            return response()->json($result, 200);
        }
        return response()->json(['error' => 'Unauthorized'
            , 'result' => null], 200);
    }

    public function getAuthenticatedUser()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
    }


    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $result =
            [
                "error" => null,
                "result" => "success"
            ];
        return response()->json($result, 200);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $result =
            [
                "error" => null,
                "result" => [
                    "user" => $request->user()
                ],

            ];

        return response()->json($result, 200);
    }

    public function setChatId(Request $request)
    {
        $chatId = $request->all()['chat_id'];
        $device_token = $request->all()['device_token'];
        $user = $request->user();
        if ($chatId != null) {
            $user->chat_user_id = $chatId;
        }
        if ($device_token != null) {
            $user->device_token = $device_token;
        }
        $user->save();

        $result =
            [
                "error" => null,
                "result" => [
                    "user" => $user
                ],

            ];
        return response()->json($result, 200);
    }
}
