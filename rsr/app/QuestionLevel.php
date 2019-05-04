<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $question_level
 * @property Question[] $questions
 */
class QuestionLevel extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['question_level'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
