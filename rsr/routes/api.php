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
    Route::get('signup/activate/{token}', 'Auth\PassportController@signupActivate');
    Route::post('send-confirmation-email', 'Auth\PassportController@sendConfirmation');
    Route::post('reset-email', 'Auth\ProfileController@resetEmail');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('logout', 'Auth\PassportController@logout');
        Route::get('user', 'Auth\PassportController@user');
        Route::post('register-chat-id', 'Auth\PassportController@setChatId');

        Route::post('verify-email', 'Auth\VerificationController@verify');

    });
});


Route::group([
    'middleware' => 'auth:api'
], function () {
    // Profile
    Route::post('profile/send-friend-request', 'Profile\ProfileController@sendFriendRequest');
    Route::post('profile/response-friend-request', 'Profile\ProfileController@responseFriendRequest');
//    Route::post('profile/delete-friend', 'Profile\ProfileController@deleteFriend');
    Route::get('profile/get-friends-list', 'Profile\ProfileController@getFriendsList');
    Route::post('profile/search-user', 'Profile\ProfileController@searchUser');
    Route::post('profile/change-first-name', 'Profile\ProfileController@changeFirstName');
    Route::post('profile/change-last-name', 'Profile\ProfileController@changeLastName');
    Route::post('profile/change-password', 'Profile\ProfileController@changePassword');

    // Individual game
    Route::get('individual/check-answer/{questionId}/{currentAnswer}', 'Question\QuestionController@checkAnswer');
    Route::get("individual/get-random-question/{numberOfQuestions?}", "Question\QuestionController@getRandomQuestion");
    Route::post("individual/finish-game/{numberOfCorrect}", 'Game\GameController@finishGame');

    //Group chat 1
    Route::post("group/send-notification", 'Profile\ProfileController@sendNotification');
    Route::post("group/get-chat-occupants", 'Profile\ProfileController@getChatOccupants');
    Route::get('group/get-dialogs', 'Profile\ProfileController@getDialogs');

    //Tours
    Route::post("tour/save-tour", 'Game\GameController@saveTour');
    Route::post("tour/add-question-to-tour", 'Question\QuestionController@addQuestion');

    Route::get("tour/get-all-tours", 'Game\GameController@getTournaments');
    Route::get("tour/get-selected-tour/{tournamentId}", 'Game\GameController@getSelectedTournament');
    Route::post("tour/save-tour-results", 'Game\GameController@saveTourResults');
    Route::get("tour/get-tournament-results/{tournamentId}", 'Game\GameController@getTourRatings');


});