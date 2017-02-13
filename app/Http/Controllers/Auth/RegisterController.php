<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Redirect;

class RegisterController extends Controller {
//    /*
//      |--------------------------------------------------------------------------
//      | Register Controller
//      |--------------------------------------------------------------------------
//      |
//      | This controller handles the registration of new users as well as their
//      | validation and creation. By default this controller uses a trait to
//      | provide this functionality without requiring any additional code.
//      |
//     */
//
//use RegistersUsers;
//
//    /**
//     * Where to redirect users after login / registration.
//     *
//     * @var string
//     */
//    protected $redirectTo = '/projects';
//
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct() {
//        Redirect::to('/projects')->send();
//    }
//
//    /**
//     * Get a validator for an incoming registration request.
//     *
//     * @param  array  $data
//     * @return \Illuminate\Contracts\Validation\Validator
//     */
//    protected function validator(array $data) {
//        return Validator::make($data, [
//                    'first_name' => 'required|max:255',
//                    'last_name' => 'required|max:255',
//                    'phone_number' => 'required|max:30',
//                    'user_image' => 'max:255',
//                    'discord_account' => 'max:255|unique:users',
//                    'email' => 'required|email|max:255|unique:users',
//                    'superuser' => 'required',
//                    'password' => 'required|min:6|confirmed',
//        ]);
//    }
//
//    /**
//     * Create a new user instance after a valid registration.
//     *
//     * @param  array  $data
//     * @return User
//     */
//    protected function create(array $data) {
//        return User::create([
//                    'first_name' => $data['first_name'],
//                    'last_name' => $data['last_name'],
//                    'phone_number' => $data['phone_number'],
//                    'user_image' => $data['user_image'],
//                    'discord_account' => $data['discord_account'],
//                    'email' => $data['email'],
//                    'superuser' => $data['superuser'],
//                    'password' => bcrypt($data['password']),
//        ]);
//    }
//
}
