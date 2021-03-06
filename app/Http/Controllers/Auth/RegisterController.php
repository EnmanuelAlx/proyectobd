<?php

namespace App\Http\Controllers\Auth;

use App\Escuelas;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function registrar(Request $request)
    {
        $input = $request->all();

        $user = '';
        if($input['optionsRadios'] == 2){
            $user = User::crearEgresado($input);
        }
        if($input['optionsRadios'] == 1){
            $user = User::crearProfesor($input);
        }
        if($user == 0){
            return back()->withErrors(['user' => 'Este usuario ya existe']);
        }
        return redirect()->route('/');
    }

    public function showRegister(){

        return view('auth.register')->with(array(
            'escuelas' => Escuelas::getEscuelas(),
            'extensiones' => Escuelas::getExtensiones()
        ));
    }


}
