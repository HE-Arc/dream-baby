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
        if (Auth::user()->user_type_id == 1) {
            $donor=DonorController::getDonorInfo(Auth::id());
            $user=DonorController::getUserInfo(Auth::id());

            $questions=QuestionAnswer::where('donor_id',$donor->id)
                ->select('question_answers.*','users.name','seekers.id as seeker_id')
                ->join('seekers','question_answers.seeker_id','seekers.id')
                ->join('users','seekers.user_id','users.id')->get();

        } else {
            abort(403);
        }
        return view('donor.myquestions',compact('questions','donor','user'));
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
            $filename = str_random(42) . 'profilImage.' . request('image')->getClientOriginalExtension();
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
        $donor = DonorController::getDonorInfo($id);
        $user = DonorController::getUserInfo($donor->user_id);
        
        $questions = QuestionAnswer::where('donor_id', $id)
            ->select('question_answers.*', 'users.name','seekers.id as seeker_id')
            ->join('seekers', 'question_answers.seeker_id', 'seekers.id')
            ->join('users', 'seekers.user_id', 'users.id')->get();

        if ($questions == null) {
            abort(404);
        }

        $swiped = null;

        if (Auth::user()->user_type_id == 2) {
            $swiped = HistorySwipe::where('seeker_id', SeekerController::getSeekerInfo(Auth::user()->id)->id)->where('donor_id', $donor->id)->first();
        }

        return view('donor.questions', compact('user','donor','questions','swiped'));
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

    public function deleteQuestion($id)
    {
        if (Auth::user()->user_type_id == 1) {
            $donorId = DonorController::getDonorInfo(Auth::id())->id;
            QuestionAnswer::where('donor_id', $donorId)->where('id', $id)->delete();
            return back()->with('success', 'Question deleted successfully');
        } else {
            abort(403);
        }
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
            ->whereDate('birth_date', '>', $criterions['main']->birth_date_max)
            ->whereIn('eye_color', DonorController::getCriterionIdArray($criterions, 'eye'))
            ->whereIn('hair_color', DonorController::getCriterionIdArray($criterions, 'hair'))
            ->whereIn('ethnicity', DonorController::getCriterionIdArray($criterions, 'ethnicity'))
            ->inRandomOrder()->take($count)->get();

        if (count($donorProfil) == 0) {
            return ['donorsArray' => null];
        }

        $donorsArray = [];

        for ($i = 0; $i < $count; $i++) {
            if (isset($donorProfil[$i])) {
                $donor = $donorProfil[$i];
                $username = User::where('id', $donor->user_id)->first()->name;
                $ethnicity = Ethnicity::where('id', $donor->ethnicity)->first()->name;
                $haircolor = HairColor::where('id', $donor->hair_color)->first()->name;
                $eyecolor = EyeColor::where('id', $donor->eye_color)->first()->name;
                array_push($donorsArray, compact('donor', 'username', 'ethnicity', 'haircolor', 'eyecolor'));
                array_push($hiddenDonorIds, $donor->id);
            }
        }

        Cookie::queue(Cookie::forever('hiddenDonorIds', json_encode($hiddenDonorIds)));
        return ['donorsArray' => $donorsArray];
    }

    public function ask($id)
    {
        if (Auth::user()->user_type_id == 2) {
            $this->validate(request(), [
                'message' => 'required',
            ]);

            $question = new QuestionAnswer();

            $question->seeker_id = SeekerController::getSeekerInfo(Auth::id())->id;
            $question->donor_id = $id;
            $question->message = request('message');
            $anonymous = request('anonymous');
            if ($anonymous == 1) {
                $question->anonymous = true;
            } else {
                $question->anonymous = false;
            }

            $question->question = true;
            $question->save();

            return back()->with('success', 'Question asked successfully');
        }
    }

    public function reply()
    {
        if (Auth::user()->user_type_id == 1) {
            $this->validate(request(), [
                'message' => 'required',
                'seeker_id'=>'required',
            ]);

            $question = new QuestionAnswer();
            $question->seeker_id = request('seeker_id');
            $question->donor_id = DonorController::getDonorInfo(Auth::user()->id)->id;
            $question->message = request('message');
            $question->anonymous = false;
            $question->question = false;
            $question->save();

            return back()->with('success', 'Question answered successfully');
        }
    }

    public function deleteAllQuestions()
    {
        if (Auth::user()->user_type_id == 1) 
        {
            $donor_id = DonorController::getDonorInfo(Auth::id())->id;
            QuestionAnswer::where('donor_id',$donor_id)->delete();
            return back()->with('success', 'Questions deleted successfully');
        }else {
            abort(403);
        }
    }

}
