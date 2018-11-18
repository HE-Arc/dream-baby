<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'user_id','sex','birth_date_max',
    ];
}
