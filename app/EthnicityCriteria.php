<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EthnicityCriteria extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'user_id','ethnicity_id',
    ];
}
