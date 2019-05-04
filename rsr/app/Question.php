<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $question_level_id
 * @property string $question_content
 * @property boolean $is_public
 * @property User $user
 * @property QuestionLevel $questionLevel
 * @property AnsweredQuestion[] $answeredQuestions
 * @property Answer[] $answers
 * @property TournamentQuestion[] $tournamentQuestions
 */
class Question extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'question_level_id', 'question_content', 'is_public'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionLevel()
    {
        return $this->belongsTo('App\QuestionLevel');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answeredQuestions()
    {
        return $this->hasMany('App\AnsweredQuestion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tournamentQuestions()
    {
        return $this->hasMany('App\TournamentQuestion');
    }
}
