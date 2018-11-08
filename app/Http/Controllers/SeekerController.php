<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class SeekerController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $usertype=User::where('id',Auth::id())->first()->user_type_id;

      if ($usertype==2){
          return view('seeker.home');
      }else{
        abort(403);
      }

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
