<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $usertype=User::where('id', Auth::id())->first()->user_type_id;

            if ($usertype==2) {
                return view('seeker.home');
            } elseif ($usertype==1) {
                return view('donor.home');
            }
        } else {
            return view('home');
        }
    }
}
