<?php

namespace App\Http\Controllers;

use App\Donor;
use App\Ethnicity;
use App\EyeColor;
use App\HairColor;
use App\QuestionAnswer;
use App\Seeker;
use App\User;
use App\HistorySwipe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DonorController extends Controller
{
    /**
     * Upate a Donor Model using request object
     * @param int $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $user_id)
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

    /**
     * Get the donor info from a donor id
     * @param int $id
     */
    public static function getDonorInfo(int $id)
    {
        $donorProfil = Donor::where('user_id', $id)->first();
        return $donorProfil;
    }

    /**
     * Get the user info from a user id
     * @param int $id
     */
    public static function getUserInfo(int $id)
    {
        $userProfil = User::where('id', $id)->first();
        return $userProfil;
    }

    /**
     * Get the donor id from its user id. Can return an error 404
     * @param int $id
     */
    public static function getDonorIdFromuserId(int $id)
    {
        $donorId = Donor::where('user_id', $id)->first()->id;

        if ($donorId == null) {
            abort(404);
        }
        return $donorId;
    }

    /**
     * Search an image from its filename
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function image($filename)
    {
        if (!Storage::disk('local')->has($filename)) {
            $filename = 'defaultuser.png';
        }
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }
}
