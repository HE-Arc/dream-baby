<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Criteria;
use App\EyeCriteria;
use App\HairCriteria;
use App\EthnicityCriteria;
use App\Question;


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

    /**
     * Return Critera Model that belongs to the used Seeker
     * @return Critera
     */
    public function criteria()
    {
        return Criteria::where('seeker_id', $this->id)->first();
    }

    /**
     * Return EyeCriteria Models that belong to the used Seeker
     * @return Array[EyeCriteria]
     */
    public function eyes()
    {
        return $this->hasMany("App\EyeCriteria");
    }

    /**
     * Return HairCriteria Models that belong to the used Seeker
     * @return Array[HairCriteria]
     */
    public function hairs()
    {
        return $this->hasMany("App\HairCriteria");
    }

    /**
     * Return EthnicityCriteria Models that belong to the used Seeker
     * @return Array[EthnicityCriteria]
     */
    public function ethnicities()
    {
        return $this->hasMany("App\EthnicityCriteria");
    }

    /**
     * Return all criterions models that belongs to the used Seeker
     * @return MixedArray[string] Model
     */
    public function criterions()
    {
        $main = $this->criteria();
        $eye = $this->eyes;
        $hair = $this->hairs;
        $ethnicity = $this->ethnicities;
        return compact('main', 'eye', 'hair', 'ethnicity');
    }

    /**
     * Return Question Models of the used Seeker
     */
    public function questions()
    {
        return Question::where('seeker_id', $this->id)->get();
    }

    /**
     * Return User Model of the used Seeker
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User')->first();
    }
}
