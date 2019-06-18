<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\User;

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
            'c_password' => 'required|same:password',
            'chat_user_id' => 'unique:users'
        ]);
        if ($validator->fails()) {
            $result =
                [
                    "error" => $validator->errors(),
                    "result" => [],
                ];
            return response()->json($result, 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
//        return $input;
//        $user = User::create([
//            'user_name' => $input['user_name'],
//            'email' => $input['email'],
//            'password' => $input['password'],
//            'chat_user_id' => $input['chat_user_id']
//        ]);
        $success['token'] = $user->createToken('My App')->accessToken;
        $success['name'] = $user->name;
        $result =
            [
                "error" => "",
                "result" => [
                    "success" => $success
                ],

            ];
        return response()->json($result, 200);
    }

    /*
     * Login
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('My App')->accessToken;
            $result =
                [
                    "error" => "",
                    "result" => [
                        "success" => $success
                    ],

                ];
            return response()->json($result, 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
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
                "error" => "",
                "result" => [
                    "success" => "1"
                ],

            ];
        return response()->json($result , 200);
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
                "error" => "",
                "result" => [
                    "user" => $request->user()
                ],

            ];

        return response()->json($result, 200);
    }
}
