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
    public function myprofil()
    {
        if (Auth::check()) {
            switch(Auth::user()->user_type_id){
                case 1: // Donor
                    $donor=DonorController::getDonorInfo(Auth::id());
                    if ($donor==null) {
                        abort(404);
                    }
                    $user=DonorController::getUserInfo(Auth::id());
                    $ethnicities=Ethnicity::all();
                    $hair_colors=HairColor::all();
                    $eye_colors=EyeColor::all();
                    
                    $positiveSwipeSeekerIds=HistorySwipe::where('donor_id',$donor->id)->where('like',1)->pluck('seeker_id')->toArray();
                    $positiveSwipeUserIds=Seeker::whereIn('id',$positiveSwipeSeekerIds)->pluck('user_id')->toArray();
                    $positiveSwipeSeekerNames=User::whereIn('id',$positiveSwipeUserIds)->pluck('name')->toArray();

                    $positiveSwipesArray=array_combine($positiveSwipeUserIds,$positiveSwipeSeekerNames);

                    return view('donor.myprofil', compact('donor', 'user', 'ethnicities', 'hair_colors', 'eye_colors','positiveSwipesArray'));
                case 2: // Seeker
                    $seeker=SeekerController::getSeekerInfo(Auth::id());
                    $user=SeekerController::getUserInfo(Auth::id());
                    $seekerCriteria = $seeker->criterions();
                    
                    if ($seeker==null || $seekerCriteria == null) {
                        abort(404);
                    }

                    $ethnicities=ProfilController::getNamesArray(Ethnicity::all());
                    $hair_colors=ProfilController::getNamesArray(HairColor::all());
                    $eye_colors=ProfilController::getNamesArray(EyeColor::all());

                    $positiveSwipeDonorIds=HistorySwipe::where('seeker_id',$seeker->id)->where('like',1)->pluck('donor_id')->toArray();
                    $positiveSwipeUserIds=Donor::whereIn('id',$positiveSwipeDonorIds)->pluck('user_id')->toArray();
                    $positiveSwipeDonorNames=User::whereIn('id',$positiveSwipeUserIds)->pluck('name')->toArray();

                    $positiveSwipesArray=array_combine($positiveSwipeUserIds,$positiveSwipeDonorNames);

                    return view('seeker.myprofil', compact('seeker', 'user', 'seekerCriteria', 'ethnicities', 'hair_colors', 'eye_colors','positiveSwipesArray'));
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
                case 1: //Donor
                    $donor=DonorController::getDonorInfo($id);
                    if ($donor==null) {
                        abort(404);
                    }
                    $user=DonorController::getUserInfo($id);
                    $ethnicity=Ethnicity::where('id',$donor->ethnicity)->first()->name;
                    $haircolor=HairColor::where('id',$donor->hair_color)->first()->name;
                    $eyecolor=EyeColor::where('id',$donor->eye_color)->first()->name;

                    return view('donor.profil', compact('donor','user','ethnicity','haircolor','eyecolor'));
                case 2: //Seeker
                    // TODO seeker.profil view 
                    return view('seeker.home');
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get an array of names from a model array
     */
    private static function getNamesArray($tab)
    {
        $new_tab = [];
        foreach($tab as $item) {
            $new_tab[$item->id] = $item->name;
        }
        return $new_tab;
    }
}
