<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;
use App\User;
use App\QuestionAnswer;
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
        return view('donor.home');
    }

    public function myquestions()
    {
        return view('donor.myquestions');
    }

    public function myprofil()
    {
        return view('donor.myprofil');
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
}
