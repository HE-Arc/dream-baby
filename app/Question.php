<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * Return Answer Model of th used Question or null
     * @return Answer
     */
    public function answer()
    {
        return $this->hasOne('App\Answer')->first();
    }
}
