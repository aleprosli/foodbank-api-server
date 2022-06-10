<?php

namespace App\Http\Controllers\API\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Storage;
use File;

class ProfileController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            
            if($user->is_client == 1)
            { 
                $user_details = $user->client;
            }
            else
            {
                $user_details = $user->donor;
            }
            //return to json
            return response()->json([
                'success' => true,
                'message' => 'Successfully fetch '.$user->name.' details',
                'data' => $user
            ]);
        } 
        catch (Exception $e) {
            return response()->error($e->getMessage(),true);
        }
        
    }

    public function update(Request $request, User $user)
    {
        try {
            //use ternary operator condition ? true : false
            $user->name = is_null($request->name) ? $user->name : $request->name;
            $user->email = is_null($request->email) ? $user->email : $request->email;
            $user->password = is_null($request->password) ? $user->password : Hash::make($request->password);
            
            if($request->hasFile('image')){
                $filename = $user->name.'-'.date("d-m-Y").'.'.$request->image->getClientOriginalExtension();

                Storage::disk('public')->put($filename, File::get($request->image));
                
                if($user->is_client == 1)
                { 
                    $user->client->image = $filename;
                    $user->client->save();
                }
                else
                {
                    $user->donor->image = $filename;
                    $user->donor->save();
                }
            }

            
            return response()->json([
                'success' => true,
                'message' => 'Successfully update '.$user->name.' details',
                'data' => $user,
                
            ]);
        } 
        catch (Exception $e) {
            return response()->error($e->getMessage(),true);
        }
       
    }
}
