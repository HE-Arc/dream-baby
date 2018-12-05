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
    /**
     * Update a Seeker Model using request object
     * @param int $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
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
        
        // User update
        $user = User::findOrFail($user_id);
        $user->name = request('name');
        $user->email = request('email');
        $user->update();

        // Seeker update
        $seeker = Seeker::where('user_id', $user_id)->firstOrFail();
        $seeker->bio = request('bio');
        $seeker->update();

        // Main cirteria update
        $main_criteria = $seeker->criteria();
        $main_criteria->sex = request('sex');
        $main_criteria->birth_date_max = Carbon::now()->subYears(request('age_max'))->format('Y-m-d');
        $main_criteria->update();

        // Eyes, hair and ethnicities criteria update
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

    /**
     * Search random donors for the authented seeker
     * can throw an error 403 if the authe user_type is not seeker
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        if (Auth::user()->user_type_id == 2) {
            $bufferSize = 2;
            Cookie::queue(Cookie::forget('hiddenDonorIds'));
            $donorsArray = DonorController::getRandomDonorProfil($bufferSize + 1);

            return view('seeker.search', $donorsArray);
        } else {
            abort(403);
        }
    }

    /**
     * Add a donor in auth user swipe history using request object
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Delete the swipe history of the auth user
     * Can throw an error 403 if auth user_type is not seeker
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSwipeHistory()
    {
        if (Auth::user()->user_type_id == 2) 
        {
            $seeker_id = SeekerController::getSeekerInfo(Auth::id())->id;
            HistorySwipe::where('seeker_id',$seeker_id)->delete();
            return back()->with('success', 'Swipe history deleted successfully');
        }else {
            abort(403);
        }
    }

    /**
     * Get the Seeker Model of a user using its user id
     * @param int $id
     * @return Seeker $seekerProfil
     */
    public static function getSeekerInfo(int $id)
    {
        $seekerProfil = Seeker::where('user_id', $id)->first();
        return $seekerProfil;
    }

    /**
     * Get the User Model of a user using its id
     * @param int $id
     * @return User $userProfil
     */
    public static function getUserInfo(int $id)
    {
        $userProfil = User::where('id', $id)->first();
        return $userProfil;
    }
}
