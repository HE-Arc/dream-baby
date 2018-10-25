<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('donor.home');
    }

    public function questions()
    {
        return view('donor.questions');
    }

    public function profil()
    {
        return view('donor.profil');
    }
}
