<?php

namespace App\Http\Controllers;

use App\HistorySwipe;
use App\Seeker;
use App\User;
use Carbon\Carbon;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Response;

class SeekerController extends Controller
{
    public function update($user_id)
    {
        // https://laracasts.com/discuss/channels/laravel/edit-user-profile-best-practice-in-laravel-55?page=1
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|exists:users',
            'bio' => 'required',
            'sex' => 'required',
            'age_max' => 'numeric|min:18|max:99|required',
            'eye_criteria' => 'required', // https://github.com/laravel/framework/issues/21728
            //'eye_criteria.*' => 'accepted',   // should pass but no...
            'hair_criteria' => 'required',
            //'hair_criteria.*' => 'accepted',
            'ethnicity_criteria' => 'required',
            //'ethnicity_criteria.*' => 'accepted',
        ]);

        $user = User::findOrFail($user_id);
        $user->name = request('name');
        $user->email = request('email');
        $user->update();

        $seeker = Seeker::where('user_id', $user_id)->firstOrFail();
        $seeker->bio = request('bio');
        $seeker->update();

        $main_criteria = $seeker->criteria();
        $main_criteria->sex = request('sex');
        $main_criteria->birth_date_max = Carbon::now()->subYears(request('age_max'))->format('Y-m-d');
        $main_criteria->update();

        $eyes = $seeker->eyes;
        $eyes_criteria = request('eye_criteria');
        foreach ($eyes as $eye) {
            $eye->searched = $eyes_criteria[$eye->id];
            $eye->update();
        }

        $hairs = $seeker->hairs;
        $hair_criteria = request('hair_criteria');
        foreach ($hairs as $hair) {
            $hair->searched = $hair_criteria[$hair->id];
            $hair->update();
        }

        $ethnicities = $seeker->ethnicities;
        $ethnicity_criteria = request('ethnicity_criteria');
        foreach ($ethnicities as $eth) {
            $eth->searched = $ethnicity_criteria[$eth->id];
            $eth->update();
        }

        return back()->with('success', 'Criterias Updated Successfully');
    }

    public static function getSeekerInfo(int $id)
    {
        $seekerProfil = Seeker::where('user_id', $id)->first();
        return $seekerProfil;
    }

    public static function getUserInfo(int $id)
    {
        $userProfil = User::where('id', $id)->first();
        return $userProfil;
    }

    public function search()
    {
        if (Auth::user()->user_type_id == 2) {
            $bufferSize = 3;

            $donorsArray = DonorController::getRandomDonorProfil($bufferSize + 1);
            Cookie::queue(Cookie::forget('hiddenDonorIds'));
            $hiddenDonorIds = array();
            if ($donorsArray['donorsArray'] != null) {
                foreach ($donorsArray['donorsArray'] as $key => $value) {
                    array_push($hiddenDonorIds, $value['donor']->id);
                }
                Cookie::queue(Cookie::forever('hiddenDonorIds', json_encode($hiddenDonorIds)));
            }

            return view('seeker.search', $donorsArray);
        } else {
            abort(403);
        }
    }

    public function criteria()
    {
        if (Auth::user()->user_type_id == 2) {
            return view('seeker.criteria');
        } else {
            abort(403);
        }
    }

    public function addToSwipeHistory(Request $request)
    {
        //TO-DO: add validator for request
        if (Auth::user()->user_type_id == 2) {
            $historySwipe = new HistorySwipe();

            $historySwipe->seeker_id = SeekerController::getSeekerInfo(Auth::id())->id;
            $historySwipe->donor_id = Input::get('donor_id');
            $historySwipe->like = Input::get('like');

            $historySwipe->save();

            return Response::json(DonorController::getRandomDonorProfil(1));

        } else {
            $response = array(
                'status' => 'KO',
                'msg' => 'Invalid use',
            );
            return Response::json($response, 401);
        }
    }
}
