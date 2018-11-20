<?php

namespace App\Http\Controllers;

use App\Donor;
use App\Ethnicity;
use App\EyeColor;
use App\HairColor;
use App\HistorySwipe;
use App\QuestionAnswer;
use App\Seeker;
use App\User;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            'birth_date' => 'date|required',
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
        $donor->birth_date = request('birth_date');
        $donor->eye_color = request('eye_color');
        $donor->ethnicity = request('ethnicity');
        $donor->hair_color = request('hair_color');
        $donor->medical_antecedents = request('medical_antecedents');
        $donor->family_antecedents = request('family_antecedents');

        $image = request()->file('image');
        if ($image) {
            if ($donor->photo_uri != 'defaultuser.png') {
                Storage::disk('local')->delete($donor->photo_uri);
            }
            $filename = str_random(42) . '.' . request('image')->getClientOriginalExtension();
            Storage::disk('local')->put($filename, File::get($image));
            $donor->photo_uri = $filename;
        }

        $donor->update();

        return back()->with('success', 'Profile Updated Successfully');
    }

    private function getQuestions($id)
    {
        $questions = QuestionAnswer::where('donor_id', $id)->get();
        return $questions;
    }

    public function questions(int $id)
    {
        $questions = DonorController::getQuestions(getDonorIdFromuserId($id));

        if ($questions == null) {
            abort(404);
        }

        return view('donor.questions', ['questions' => $questions]);
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
        $donorId = Donor::where('user_id', $id)->first()->id;

        if ($donorId == null) {
            abort(404);
        }
        return $donorId;
    }

    public function image($filename)
    {
        if (!Storage::disk('local')->has($filename)) {
            $filename = 'defaultuser.png';
        }
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }

    private static function getCriterionIdArray($criterions, $criterionKey)
    {
        $criterionsIds = [];
        foreach ($criterions[$criterionKey] as $item) {
            if ($item->searched) {
                array_push($criterionsIds, $item->id);
            }
        }
        return $criterionsIds;
    }

    public static function getRandomDonorProfil($count)
    {
        $seekerId = SeekerController::getSeekerInfo(Auth::id())->id;

        $criterions = Seeker::where('id', $seekerId)->first()->criterions();

        if (Cookie::get('hiddenDonorIds') != null && $count == 1) { //if count == 1 it means that this function is called from an ajax request
            $hiddenDonorIds = json_decode(Cookie::get('hiddenDonorIds'));
        } else {
            $hiddenDonorIds = [];
        }

        $alreadySwipedId = HistorySwipe::where('seeker_id', $seekerId)->pluck('donor_id')->toArray();
        $donorProfil = Donor::whereNotIn('id', $alreadySwipedId)
            ->whereNotIn('id', $hiddenDonorIds)
            ->where('sex', $criterions['main']->sex)
            ->whereIn('eye_color', DonorController::getCriterionIdArray($criterions, 'eye'))
            ->whereIn('hair_color', DonorController::getCriterionIdArray($criterions, 'hair'))
            ->whereIn('ethnicity', DonorController::getCriterionIdArray($criterions, 'ethnicity'))
            ->inRandomOrder()->take($count)->get();

        if (count($donorProfil) == 0) {
            return ['donorsArray' => null];
        }

        $donorsArray = array();

        for ($i = 0; $i < $count; $i++) {
            if (isset($donorProfil[$i])) {
                $donor = $donorProfil[$i];
                $username = User::where('id', $donor->user_id)->first()->name;
                $ethnicity = Ethnicity::where('id', $donor->ethnicity)->first()->name;
                $haircolor = HairColor::where('id', $donor->hair_color)->first()->name;
                $eyecolor = EyeColor::where('id', $donor->eye_color)->first()->name;
                array_push($donorsArray, compact('donor', 'username', 'ethnicity', 'haircolor', 'eyecolor'));
            }
        }

        return ['donorsArray' => $donorsArray];
    }

}
