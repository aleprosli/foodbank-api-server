<?php

namespace App\Http\Controllers\API\User;

use App\Models\Crowdfund;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use File;
use Storage;

class CrowdfundController extends Controller
{
    public function listAll()
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

    public function listTargetCompleted(Request $request, Crowdfund $crowdfund)
    {
        try {
            $crowdfundComplete = $crowdfund->TargetCompleted;

            return response()->json([
                'success' => true,
                'message' => 'Successfully fetch crowdfund list completed',
                'data' => $crowdfundComplete,
            ]);
        } 
        catch (Exception $e) {
            return response()->error($e->getMessage(),true);
        }
    }

    public function listTargetUncomplete(Request $request, Crowdfund $crowdfund)
    {
        try {
            $crowdfundUncomplete = $crowdfund->TargetUncompleted;

            return response()->json([
                'success' => true,
                'message' => 'Successfully fetch crowdfund list uncompleted',
                'data' => $crowdfundUncomplete,
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

            if($request->hasFile('image')){
                $filename = $crowdfund->title.'-'.date("d-m-Y").'.'.$request->image->getClientOriginalExtension();

                Storage::disk('public')->put($filename, File::get($request->image));
 
                $crowdfund->image = $filename;
    
                $crowdfund->save();
            }

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

    public function donorPayCrowdfund(Request $request, Crowdfund $crowdfund)
    {
        try {
            if(Auth::user()->is_donor == 1)
            {
                $donorPay = $request->priceDonate;

                $newTargetPrice = $crowdfund->target - $donorPay;
    
                if($newTargetPrice > -1)
                {
                    $crowdfund->update([
                        'target' => $newTargetPrice,
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'You donation exceed our target. Maximum donation amount we can accept is RM '.$crowdfund->target,
                        'data' => $crowdfund,
                    ]);
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your donation '.Auth::user()->name,
                    'data' => $crowdfund,
                ]);
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong identity. Only donor can donate this crowdfund',
                ]);
            }
        } 
        catch (Exception $e) {
            return response()->error($e->getMessage(),true);
        }
    }
}
