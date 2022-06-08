<?php

namespace App\Http\Controllers\API\User;

use App\Models\Crowdfund;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CrowdfundController extends Controller
{
    public function list()
    {
        try {
            $crowdfund = Crowdfund::all();

            return response()->json([
                'success' => true,
                'message' => 'Successfully fetch crowdfund list',
                'data' => $crowdfund,
            ]);
        } 
        catch (Exception $e) {
            return response()->error($e->getMessage(),true);
        }
    }
    public function createCrowdfund(Request $request)
    {
        try {
            $crowdfund = Crowdfund::create([
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'target' => $request->target,
                'gps_location' => $request->gps_location,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Crowdfund created with target RM'.$crowdfund->target,
                'data' => $crowdfund,
            ]);
        } 
        catch (Exception $e) {
            return response()->error($e->getMessage(),true);
        }
    }
}
