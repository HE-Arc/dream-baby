<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;
use App\User;
use App\QuestionAnswer;
use Illuminate\Support\Facades\Auth;
use App\Ethnicity;
use App\HairColor;
use App\EyeColor;

class DonorController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (Auth::user()->user_type_id==1){
          return view('donor.home');
        }else{
          abort(403);
        }
    }

    public function myquestions()
    {
        return view('donor.myquestions');
    }

    public function myprofil()
    {
        $donorProfil=DonorController::getDonorInfo(Auth::id());
        $userProfil=DonorController::getUserInfo(Auth::id());
        $ethnicityNames=Ethnicity::all();
        $hairColorNames=HairColor::all();
        $eyeColorNames=EyeColor::all();
        if ($donorProfil==null) {
            abort(404);
        }
        return view('donor.myprofil', ['donor'=>$donorProfil,'user'=>$userProfil, 'ethnicities'=>$ethnicityNames, 'hair_colors'=>$hairColorNames, 'eye_colors'=>$eyeColorNames]);
    }

    public function update($user_id)
    { 
        // https://laracasts.com/discuss/channels/laravel/edit-user-profile-best-practice-in-laravel-55?page=1
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|exists:users',
            'eye_color' => 'required',
            'ethnicity' => 'required',
            'hair_color' => 'required',
            'medical_antecedents' => 'required',
            'family_antecedents' => 'required',
        ]);

        $user = User::findOrFail($user_id);
        $user->name = request('name');
        $user->email = request('email');
        $user->update();
        
        $donor = Donor::where('user_id', $user_id)->firstOrFail();
        $donor->eye_color = request('eye_color');
        $donor->ethnicity = request('ethnicity');
        $donor->hair_color = request('hair_color');
        $donor->medical_antecedents = request('medical_antecedents');
        $donor->family_antecedents = request('family_antecedents');
        $donor->update();

        return back();
    }

    private function getQuestions($id)
    {
      $questions=QuestionAnswer::where('donor_id',$id)->get();
      return $questions;
    }

    public function questions(int $id)
    {
        $questions=DonorController::getQuestions(getDonorIdFromuserId($id));

        if ($questions==null) {
            abort(404);
        }

      return view('donor.questions', ['questions'=>$questions]);
    }

    private function getDonorInfo(int $id)
    {
        $donorProfil = Donor::where('user_id', $id)->first();
        return $donorProfil;
    }

    private function getUserInfo(int $id)
    {
        $userProfil = User::where('id', $id)->first();
        return $userProfil;
    }

    private function getDonorIdFromuserId(int $id)
    {
      $donorId= Donor::where('user_id', $id)->first()->id;

      if ($donorId==null) {
          abort(404);
      }
      return $donorId;
    }


    public function profil(int $id)
    {
        $donorProfil=DonorController::getDonorInfo($id);
        $userProfil=DonorController::getUserInfo($id);
        $ethnicityName=Ethnicity::where('id',$donorProfil->ethnicity)->first()->name;
        $hairColorName=HairColor::where('id',$donorProfil->hair_color)->first()->name;
        $eyeColorName=EyeColor::where('id',$donorProfil->eye_color)->first()->name;
        if ($donorProfil==null) {
            abort(404);
        }
        return view('donor.profil', ['donor'=>$donorProfil,'user'=>$userProfil,'ethnicity'=>$ethnicityName,'haircolor'=>$hairColorName,'eyecolor'=>$eyeColorName]);
    }


    //TO-DO: don't get a donor profil if you have already swiped it
    public static function getRandomDonorProfil(int $seekerId)
    {
        $donorProfil=Donor::inRandomOrder()->take(2)->get();
        
        $userName=User::where('id', $donorProfil[0]->user_id)->first()->name;
        $ethnicityName=Ethnicity::where('id',$donorProfil[0]->ethnicity)->first()->name;
        $hairColorName=HairColor::where('id',$donorProfil[0]->hair_color)->first()->name;
        $eyeColorName=EyeColor::where('id',$donorProfil[0]->eye_color)->first()->name;

        $donor1=['donor'=>$donorProfil[0],'username'=>$userName,'ethnicity'=>$ethnicityName,'haircolor'=>$hairColorName,'eyecolor'=>$eyeColorName];

        $userName=User::where('id', $donorProfil[1]->user_id)->first()->name;
        $ethnicityName=Ethnicity::where('id',$donorProfil[1]->ethnicity)->first()->name;
        $hairColorName=HairColor::where('id',$donorProfil[1]->hair_color)->first()->name;
        $eyeColorName=EyeColor::where('id',$donorProfil[1]->eye_color)->first()->name;

        $donor2=['donor'=>$donorProfil[1],'username'=>$userName,'ethnicity'=>$ethnicityName,'haircolor'=>$hairColorName,'eyecolor'=>$eyeColorName];

        return ['donor1'=>$donor1,'donor2'=>$donor2];
    }
}
