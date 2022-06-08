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
        $users = auth()->user();

        //return to json
        return response()->json([
            'success' => true,
            'message' => 'Successfully fetch '.$users->name.' details',
            'data' => $users,
        ]);
    }

    public function update(Request $request, User $user)
    {
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
            }
            else
            {
                $user->donor->image = $filename;
            }

            $user->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Successfully update '.$user->name.' details',
            'data' => $user,
        ]);
    }
}
