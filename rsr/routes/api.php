<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Auth
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Auth\PassportController@login');
    Route::post('register', 'Auth\PassportController@register');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::post('logout', 'Auth\PassportController@logout');
        Route::get('user', 'Auth\PassportController@user');
    });
});


Route::group([
    'middleware' => 'auth:api'
], function() {
    // Profile
    Route::post('profile/add-friend', 'Profile\ProfileController@addFriend');
    Route::get('profile/get-friends-list', 'Profile\ProfileController@getFriendsList');

    // Individual game
    Route::get('individual/answer/check-answer/{questionId}/{currentAnswer}', 'Question\QuestionController@checkAnswer');
    Route::get("individual/get-random-question/{numberOfQuestions?}", "Question\QuestionController@getRandomQuestion");
    Route::post("individual/finish-game", 'Game\GameController@finishGame');
});