<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Donor;
use App\User;
use App\QuestionAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Ethnicity;
use App\HairColor;
use App\EyeColor;

class DonorController extends Controller
{
    public function myquestions()
    {
        return view('donor.myquestions');
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
        
        $image = request()->file('image');
        if($image){
            if($donor->photo_uri && $donor->photo_uri=='defaultuser.png'){
                Storage::disk('local')->delete($donor->photo_uri);
            }
            $filename = str_random(42) . "." . request('image')->getClientOriginalExtension();
            Storage::disk('local')->put($filename, File::get($image));
            $donor->photo_uri = $filename;
        }
        
        $donor->update();
        
        return back()->with('success','Profile Updated Successfully');
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

    public static function getDonorInfo(int $id)
    {
        $donorProfil = Donor::where('user_id', $id)->first();
        return $donorProfil;
    }

    public static function getUserInfo(int $id)
    {
        $userProfil = User::where('id', $id)->first();
        return $userProfil;
    }

    public static function getDonorIdFromuserId(int $id)
    {
      $donorId= Donor::where('user_id', $id)->first()->id;

      if ($donorId==null) {
          abort(404);
      }
      return $donorId;
    }

    public function image($filename)
    {
        if(!Storage::disk('local')->has($filename))
        {
            $filename = 'defaultuser.png';
        }
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
}
