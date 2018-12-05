<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{

    public $table = 'question_answers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seeker_id','donor_id','message','anonymous'
    ];

    /**
     * Return Seeker Model related to the used QuestionAnser Model
     * @return Seeker
     */
    public function seeker()
    {
        return $this->belongsTo('App\Seeker');
    }
}
