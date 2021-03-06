<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HairCriteria extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'seeker_id','hair_color', 'searched',
    ];
}
