<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $token = auth()->user()->createToken('api_token')->accessToken;

            $user = auth()->user();

            return response()->json([
                'success' => $user,
                'message' => 'User successfully logged in',
                'token' => $token,
            ]);
        }
        else
        {
            //return response wrong credential
            return response()->json([
                'success' => false,
                'message' => 'Please check your credentials'
            ]);
        }
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name, 
            'email' => $request->email, 
            'password' => Hash::make($request->password), 
            'api_token' => Str::random(60),
        ]);

        $token = $user->createToken('api_token')->accessToken;

        return response()->json([
            'success' => $user,
            'message' => 'You have successfully register new account',
            'token' => $token,
        ]);
    }
}
