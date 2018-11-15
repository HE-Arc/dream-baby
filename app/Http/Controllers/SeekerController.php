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
      
      if (Auth::user()->user_type_id==2){
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
