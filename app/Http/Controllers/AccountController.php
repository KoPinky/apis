<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $user = User::forceCreate([
            'login' => $request['login'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            
        ]);
        return $user;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Auth(Request $request)
    {   
        echo "shaha\n";
        $credentials = $request->only('login', 'password');
        if(!Auth::check()){
            if (Auth::attempt($credentials, true))
            {
                $request->session()->regenerate();

                return redirect()->intended('dashboard');
            }
            else{
                return 'invalid data';
            }
        }
        else{
            return 'You are logged in_';
        }
        
    }     
}