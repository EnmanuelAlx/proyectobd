<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', ['only' => 'showLoginForm']);
    }

    public function login(){
        $credentials = $this->validate(request(), [
            $this->username() => 'required|integer',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($credentials)){

            return redirect()->route('dashboard');
        }

        return back()->withErrors([$this->username() => 'Estas credenciales no se encuentran en la base de datos'])->withInput(request([$this->username()]));
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function showLoginForm(){
        dd('hey');
        return view('auth.login');
    }

    public function username()
    {
        return 'id';
    }

}
