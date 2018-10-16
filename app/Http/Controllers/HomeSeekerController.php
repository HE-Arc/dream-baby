<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeSeekerController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('seeker.home');
    }
}
