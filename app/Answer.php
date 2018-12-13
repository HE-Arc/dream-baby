<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * Return Question Model of the used Answer
     * @return Question
     */
    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
