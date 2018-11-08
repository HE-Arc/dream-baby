<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Seeker;
use App\Donor;
use App\Ethnicity;
use App\HairColor;
use App\EyeColor;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if (isset($data['user_type']) && $data['user_type']=='seeker') {
            $userType=2;
        } elseif (isset($data['user_type']) && $data['user_type']=='donor') {
            $userType=1;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type_id'=>$userType,
            'password' => Hash::make($data['password']),
        ]);

        if (isset($data['user_type']) && $data['user_type']=='seeker') {
            $this->redirectTo = '/seeker';
            $donor=Seeker::create([
            'user_id'=>$user->id,
          ]);
        } elseif (isset($data['user_type']) && $data['user_type']=='donor') {
            $this->redirectTo = '/donor';
            $donor=Donor::create([
            'user_id'=>$user->id,
            'sex'=>$data['sex']=='1'?true:false,
            'eye_color'=>$data['eye_color'],
            'ethnicity'=>$data['ethnicity'],
            'hair_color'=>$data['hair_color'],
            'medical_antecedents'=>$data['medical_antecedents'],
            'family_antecedents'=>$data['family_antecedents'],
          ]);
        }
        return $user;
    }

    public function showRegistrationForm() {
      $ethnicityNames=Ethnicity::all();
      $hairColorNames=HairColor::all();
      $eyeColorNames=EyeColor::all();
      return view('auth.register',['ethnicities'=>$ethnicityNames, 'hair_colors'=>$hairColorNames, 'eye_colors'=>$eyeColorNames]);
    }
}
