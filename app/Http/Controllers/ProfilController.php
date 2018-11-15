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
                    $donorProfil=DonorController::getDonorInfo(Auth::id());
                    $userProfil=DonorController::getUserInfo(Auth::id());
                    $ethnicityNames=Ethnicity::all();
                    $hairColorNames=HairColor::all();
                    $eyeColorNames=EyeColor::all();
                    if ($donorProfil==null) {
                        abort(404);
                    }
                    return view('donor.myprofil', ['donor'=>$donorProfil,'user'=>$userProfil, 'ethnicities'=>$ethnicityNames, 'hair_colors'=>$hairColorNames, 'eye_colors'=>$eyeColorNames]);
                case 2: // Seeker
                    $seekerProfil=SeekerController::getSeekerInfo(Auth::id());
                    $userProfil=SeekerController::getUserInfo(Auth::id());
                    if ($seekerProfil==null) {
                        abort(404);
                    }
                    return view('seeker.myprofil', ['seeker'=>$seekerProfil,'user'=>$userProfil]);
            }
        } else {
            return view('home');
        }
    }

    public function profil(int $id)
    {
        $user = User::where('id', $id)->first();
        if (Auth::check() && isset($user)) {
            switch($user->user_type_id){
                case 1:
                    $donorProfil=DonorController::getDonorInfo($id);
                    $userProfil=DonorController::getUserInfo($id);
                    $ethnicityName=Ethnicity::where('id',$donorProfil->ethnicity)->first()->name;
                    $hairColorName=HairColor::where('id',$donorProfil->hair_color)->first()->name;
                    $eyeColorName=EyeColor::where('id',$donorProfil->eye_color)->first()->name;
                    if ($donorProfil==null) {
                        abort(404);
                    }
                    return view('donor.profil', ['donor'=>$donorProfil,'user'=>$userProfil,'ethnicity'=>$ethnicityName,'haircolor'=>$hairColorName,'eyecolor'=>$eyeColorName]);
                case 2:
                    // TODO seeker.profil view 
                    return view('seeker.home');
            }
        } else {
            abort(404);
        }
    }
}
