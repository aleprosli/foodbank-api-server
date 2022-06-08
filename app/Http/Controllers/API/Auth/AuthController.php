<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use App\Models\Donor;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserRequest;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
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
        catch (Exception $e) {
            return response()->error($e->getMessage(),true);
        }
        
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            if($request->is_client == 1)
            {   
                $user = User::create([
                    'name' => $request->name, 
                    'email' => $request->email, 
                    'password' => Hash::make($request->password),
                    'password_confirmation' => Hash::make($request->password), 
                    'api_token' => Str::random(60),
                    'is_client' => $request->is_client,
                ]);
    
                $client = Client::create([
                    'user_id' => $user->id
                ]);
            }
            else
            {
                $user = User::create([
                    'name' => $request->name, 
                    'email' => $request->email, 
                    'password' => Hash::make($request->password), 
                    'api_token' => Str::random(60),
                    'is_donor' => $request->is_donor,
                ]);
    
                $donor = Donor::create([
                    'user_id' => $user->id
                ]);
            }
    
            $token = $user->createToken('api_token')->accessToken;
    
            return response()->json([
                'success' => $user,
                'message' => 'You have successfully register new account',
                'token' => $token,
            ]);
        } 
        catch (Exception $e) {
            return response()->error($e->getMessage(),true);
        }
        
    }
}
