<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];


}
