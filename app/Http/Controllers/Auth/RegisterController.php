<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistred;
use App\Models\City;
use App\Models\MusicType;
use App\Models\Voivodeship;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		// Add your stuff there
		$musicTypes = MusicType::all();
		$cities = City::all();
		return view('auth.register', compact('musicTypes', 'cities'));
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'city' => 'required',
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
	       $user = User::create([
	            'first_name' => $data['first_name'],
	            'last_name' => $data['last_name'],
	            'email' => $data['email'],
	            'password' => Hash::make($data['password']),
	            'city_id' => $data['city'],
            ]);

	       if($data['music_types']) {
		       $user->favoriteMusic()->attach( $data['music_types'] );
	       }

	       //Event instance
	       event(new UserRegistred($user));

	       return $user;

    }

}
