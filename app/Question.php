<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * Return Donor Model of the used Question
     * @return Donor
     */
    public function donor()
    {
        return Donor::where('id', $this->donor_id)->first();
    }

    /**
     * Return Seeker Model of the used Question
     * @return Seeker
     */
    public function seeker()
    {
        return $this->hasOne('App\Seeker')->first();
    }

    /**
     * Return Answer Model of the used Question or null
     * @return Answer
     */
    public function answer()
    {
        return $this->hasOne('App\Answer')->first();
    }
}
