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

  public function seeker()
  {
      return $this->belongsTo('App\Seeker');
  }
}
