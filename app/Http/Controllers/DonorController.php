<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor;
use App\User;
use App\QuestionAnswer;
use Illuminate\Support\Facades\Auth;

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
        $donorProfil=DonorController::getDonorInfo(Auth::id());
        $userProfil=DonorController::getUserInfo(Auth::id());
        if ($donorProfil==null) {
            abort(404);
        }
        return view('donor.myprofil', ['donor'=>$donorProfil,'user'=>$userProfil]);
    }


    private function getQuestions($id)
    {
      $questions=QuestionAnswer::where('donor_id',$id)->get();
      return $questions;
    }

    public function questions(int $id)
    {
        $questions=DonorController::getQuestions($id);

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


    public function profil(int $id)
    {
        $donorProfil=DonorController::getDonorInfo($id);
        $userProfil=DonorController::getUserInfo($id);
        if ($donorProfil==null) {
            abort(404);
        }
        return view('donor.profil', ['donor'=>$donorProfil,'user'=>$userProfil]);
    }
}
