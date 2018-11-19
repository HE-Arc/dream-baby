<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Criteria;
use App\EyeCriteria;
use App\HairCriteria;
use App\EthnicityCriteria;


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

    public function criteria()
    {
        return Criteria::where('seeker_id', $this->id)->first();
    }

    public function eyes()
    {
        return $this->hasMany("App\EyeCriteria");
    }

    public function hairs()
    {
        return $this->hasMany("App\HairCriteria");
    }

    public function ethnicities()
    {
        return $this->hasMany("App\EthnicityCriteria");
    }

    public function criterions()
    {
        $main = $this->criteria();
        $eye = $this->eyes;
        $hair = $this->hairs;
        $ethnicity = $this->ethnicities;
        return compact('main', 'eye', 'hair', 'ethnicity');
    }
}
