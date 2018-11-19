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
        return $this->belongsTo("App\Criteria");
    }

    public function eye()
    {
        return $this->hasMany("App\EyeCriteria");
    }

    public function hair()
    {
        return $this->hasMany("App\HairCriteria");
    }

    public function ethnicity()
    {
        return $this->hasMany("App\EthnicityCriteria");
    }

    public function criterions()
    {
        $main = $this->criteria();
        $eye = $this->eye();
        $hair = $this->hair();
        $ethnicity = $this->ethnicity();
        return compact('main', 'eye', 'hair', 'ethnicity');
    }
}
