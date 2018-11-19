<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Donor;
use App\User;
use App\Ethnicity;
use App\HairColor;
use App\EyeColor;

class ProfilController extends Controller
{
    public function myprofil()
    {
        if (Auth::check()) {
            switch(Auth::user()->user_type_id){
                case 1: // Donor
                    $donor=DonorController::getDonorInfo(Auth::id());
                    $user=DonorController::getUserInfo(Auth::id());
                    $ethnicities=Ethnicity::all();
                    $hair_colors=HairColor::all();
                    $eye_colors=EyeColor::all();
                    if ($donor==null) {
                        abort(404);
                    }
                    return view('donor.myprofil', compact('donor', 'user', 'ethnicities', 'hair_colors', 'eye_colors'));
                case 2: // Seeker
                    $seeker=SeekerController::getSeekerInfo(Auth::id());
                    $user=SeekerController::getUserInfo(Auth::id());
                    $seekerCriteria = $seeker->criterions();
                    $ethnicities=ProfilController::getNamesArray(Ethnicity::all());
                    $hair_colors=ProfilController::getNamesArray(HairColor::all());
                    $eye_colors=ProfilController::getNamesArray(EyeColor::all());
                    if ($seeker==null || $seekerCriteria == null) {
                        abort(404);
                    }
                    return view('seeker.myprofil', compact('seeker', 'user', 'seekerCriteria', 'ethnicities', 'hair_colors', 'eye_colors'));
            }
        } else {
            return view('home');
        }
    }

    private static function getNamesArray($tab)
    {
        $new_tab = [];
        foreach($tab as $item) {
            $new_tab[$item->id] = $item->name;
        }
        return $new_tab;
    }

    public function profil(int $id)
    {
        $user = User::where('id', $id)->first();
        if (Auth::check() && isset($user)) {
            switch($user->user_type_id){
                case 1: //Donor
                    $donor=DonorController::getDonorInfo($id);
                    $user=DonorController::getUserInfo($id);
                    $ethnicity=Ethnicity::where('id',$donor->ethnicity)->first()->name;
                    $haircolor=HairColor::where('id',$donor->hair_color)->first()->name;
                    $eyecolor=EyeColor::where('id',$donor->eye_color)->first()->name;
                    if ($donor==null) {
                        abort(404);
                    }
                    return view('donor.profil', compact('donor','user','ethnicity','haircolor','eyecolor'));
                case 2: //Seeker
                    // TODO seeker.profil view 
                    return view('seeker.home');
            }
        } else {
            abort(404);
        }
    }
}
