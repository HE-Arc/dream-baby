<?php

namespace App\Http\Controllers;
use App\Seeker;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
