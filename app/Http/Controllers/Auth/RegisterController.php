<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
    protected $redirectTo = RouteServiceProvider::HOTELES;
    // protected $redirectTo = "/hoteles";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /* Esta función crea los usuarios. 
    Si la BD no tiene usuarios, el rol del usuario será 2 (superadmin).
    Si sí hay usuarios, el rol será 0 (usuario normal) */
    public function create(Request $request)
    {
        $rolAAnadir = 0;
        $users = User::all();
        if (sizeof($users) == 0) {
            $rolAAnadir = 2;
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'initials' => ['required', 'string', 'max:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        if (!($validator->fails())) {
            $user = User::create(['name'=>$request['name'], 'initials'=>$request['initials'], 'email'=>$request['email'], 'rol'=>$rolAAnadir, 'password' => Hash::make($request['password'])]);
           return Redirect::to('/')->with('success', "Erabiltzailea sortu da");
        } else {
             return Redirect::to('/register')->with('error', "Erabiltzailea ez da sortu. Mesedez, sartu datuak berriro");
        }
    }

}
