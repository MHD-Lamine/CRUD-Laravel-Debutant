<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view("auth.login");
    }
    public function doLogin(LoginRequest $request){

        $user = $request->validated();

        if(Auth::attempt($user)){
            $request->session()->regenerate();
            return redirect()->intended(route('blog.index'));

        }
        return to_route('auth.login')->withErrors([
            'email'=> 'email est invalide'
        ])->onlyInput('email');
    }
    public function logout(){
        Auth::logout();
        return redirect()->intended(route('auth.login'));
    }
}
