<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Donor;
use App\User;
use App\Ethnicity;
use App\HairColor;
use App\EyeColor;
use App\HistorySwipe;
use App\Seeker;
use App\QuestionAnswer;

class ProfilController extends Controller
{
    /**Return myprofil view of auth user depending on its user_type
     * Get all the informations related to it
     * @return \Illuminate\Http\Response
     */
    public function myprofil()
    {
        if (Auth::check()) {
            switch(Auth::user()->user_type_id){
                case 1: // Donor
                    $donor=DonorController::getDonorInfo(Auth::id());
                    if ($donor==null) {
                        abort(404);
                    }
                    $user=$donor->user();
                    $ethnicities=Ethnicity::all();
                    $hair_colors=HairColor::all();
                    $eye_colors=EyeColor::all();
                    
                    

                    return view('donor.myprofil', compact('donor', 'user', 'ethnicities', 'hair_colors', 'eye_colors'));
                case 2: // Seeker
                    $seeker=SeekerController::getSeekerInfo(Auth::id());
                    $user=SeekerController::getUserInfo(Auth::id());
                    $seekerCriteria = $seeker->criterions();
                    
                    if ($seeker==null || $seekerCriteria == null) {
                        abort(404);
                    }

                    $ethnicities=Controller::getNamesArray(Ethnicity::all());
                    $hair_colors=Controller::getNamesArray(HairColor::all());
                    $eye_colors=Controller::getNamesArray(EyeColor::all());



                    return view('seeker.myprofil', compact('seeker', 'user', 'seekerCriteria', 'ethnicities', 'hair_colors', 'eye_colors'));
            }
        } else {
            return view('home');
        }
    }

    /**
     * Return profil view of a user depending on its user_type
     * Get all his user_type info
     * @return \Illuminate\Http\Response
     */
    public function profil(int $id)
    {
        $user = User::where('id', $id)->first();
        if (Auth::check() && isset($user) && $user->user_type_id==1) {
        
                    $donor=DonorController::getDonorInfo($id);
                    if ($donor==null) {
                        abort(404);
                    }
                    $user=DonorController::getUserInfo($id);
                    $ethnicity=Ethnicity::where('id',$donor->ethnicity)->first()->name;
                    $haircolor=HairColor::where('id',$donor->hair_color)->first()->name;
                    $eyecolor=EyeColor::where('id',$donor->eye_color)->first()->name;

                    return view('donor.profil', compact('donor','user','ethnicity','haircolor','eyecolor'));
                
        } else {
            abort(404);
        }
    }
}
