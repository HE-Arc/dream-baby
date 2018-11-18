<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Seeker;
use App\Criteria;
use App\EthnicityCriteria;
use App\EyeCriteria;
use App\HairCriteria;

class CriteriaController extends Controller
{
    public function update($user_id)
    {
        //
    }

    public static function getUserCriteria($user_id)
    {
        $user_criteria = [
            "criteria"              => Criteria::where('user_id', $user_id)->first(),
            "ethnicity_criteria"    => EthnicityCriteria::where('user_id', $user_id),
            "eye_criteria"          => EyeCriteria::where('user_id', $user_id),
            "hair_criteria"         => HairCriteria::where('user_id', $user_id),
        ];
        return $user_criteria;
    }
}
