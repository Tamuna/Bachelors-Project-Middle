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

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/login', 'Auth\LoginController@login');


Route::get('api/questions/{numQuestions}', 'Question\QuestionController@getSeveralQuestions');

Route::get('api/individual/answer/{questionId}/{currentAnswer}', 'Question\QuestionController@checkAnswer');
