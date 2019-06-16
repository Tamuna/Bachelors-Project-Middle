<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


// individual game api
Route::get('api/individual/answer/{questionId}/{currentAnswer}', 'Question\QuestionController@checkAnswer');
Route::get("api/individual/getRandomQuestion/{userId}/{number-of-questions?}", "Question\QuestionController@getRandomQuestion");
Route::get("api/individual/finishGame/{userId}/{number-of-correct-answers}", "Game\GameController@finishGame");
