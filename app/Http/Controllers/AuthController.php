<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class  AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if( !auth()->attempt($loginData))
        {
            return response(['message'=>'Niepoprawne dane logowania']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
}
