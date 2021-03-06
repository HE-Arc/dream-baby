<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EyeCriteria extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'seeker_id','eye_color','searched',
    ];
}
