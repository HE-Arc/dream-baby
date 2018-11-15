<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Seeker;

class SeekerController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
      if (Auth::user()->user_type_id==2){
          return view('seeker.home');
      }else{
        abort(403);
      }

    }

    public function update($user_id)
    { 
        // https://laracasts.com/discuss/channels/laravel/edit-user-profile-best-practice-in-laravel-55?page=1
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|exists:users',
            'bio' => 'required',
        ]);

        $user = User::findOrFail($user_id);
        $user->name = request('name');
        $user->email = request('email');
        $user->update();
        
        $seeker = Seeker::where('user_id', $user_id)->firstOrFail();
        $seeker->bio = request('bio');
        $seeker->update();

        return back();
    }

    public function myprofil()
    {
        $seekerProfil=SeekerController::getSeekerInfo(Auth::id());
        $userProfil=SeekerController::getUserInfo(Auth::id());
        if ($seekerProfil==null) {
            abort(404);
        }
        return view('seeker.myprofil', ['seeker'=>$seekerProfil,'user'=>$userProfil]);
    }

    private function getSeekerInfo(int $id)
    {
        $seekerProfil = Seeker::where('user_id', $id)->first();
        return $seekerProfil;
    }

    private function getUserInfo(int $id)
    {
        $userProfil = User::where('id', $id)->first();
        return $userProfil;
    }

    public function search()
    {
        return view('seeker.search');
    }

    public function criteria()
    {
        return view('seeker.criteria');
    }
}
