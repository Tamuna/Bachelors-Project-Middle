<?php


namespace App\Http\Controllers\Question;


use App\Question;

class QuestionController
{
    public function getSeveralQuestions($numQuestions)
    {
        return Question::inRandomOrder()->get()->take($numQuestions);
    }
}