<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
        'seeker_id','donor_id', 'message', 'anonymous',
    ];
    
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
        return Seeker::where('id', $this->seeker_id)->first();
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
