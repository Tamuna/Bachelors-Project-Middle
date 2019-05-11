<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $question_id
 * @property string $answer
 * @property Question $question
 */
class Answer extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['question_id', 'answer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
