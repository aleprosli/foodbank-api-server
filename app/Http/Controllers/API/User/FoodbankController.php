<?php

namespace App\Http\Controllers\API\User;

use App\Models\Foodbank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodbankController extends Controller
{
    public function list()
    {
        try {
            $foodbank = Foodbank::all();

            return response()->json([
                'success' => true,
                'message' => 'Successfully fetch foodbank information',
                'data' => $foodbank,
            ]);
        } 
        catch (Exception $e) {
            return response()->error($e->getMessage(),true);
        }
    }
}
