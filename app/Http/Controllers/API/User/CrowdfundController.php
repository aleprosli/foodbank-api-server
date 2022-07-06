<?php

namespace App\Http\Controllers\API\User;

use File;
use Storage;
use App\Models\Donor;
use App\Models\Crowdfund;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    public function listEmergencyFund(Request $request, Crowdfund $crowdfund)
    {
        try {
            $emergencyFund = $crowdfund->EmergencyFund;

            return response()->json([
                'success' => true,
                'message' => 'Successfully fetch emergency fund list',
                'data' => $emergencyFund,
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
                'user_id' => Auth::user()->id,
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

            $user = Auth::user();
            
            if($user->is_donor == 1)
            {
                if($crowdfund->target == NULL && $crowdfund->total_donation || $crowdfund->target == NULL && $crowdfund->total_donation == NULL)
                {
                    $donorPay = $request->priceDonate;

                    $new_total_donation = $crowdfund->total_donation + (int)$donorPay;

                    $crowdfund->update([
                        'total_donation' => $new_total_donation,
                    ]);

                    $updateDonationWithLevel = $this->updateDonationCount($donorPay,$user);

                    return response()->json([
                        'success' => true,
                        'message' => 'Thankyou for donation on Emergency Funds.',
                        'data' => $crowdfund,
                    ]);
                }
                else if($crowdfund->target != $crowdfund->total_donation)
                {
                    $donorPay = $request->priceDonate;

                    $new_total_donation = $crowdfund->total_donation + (int)$donorPay;

                    $exceed_target = $crowdfund->target - $crowdfund->total_donation;

                    if($new_total_donation <= $crowdfund->target)
                    {
                        $crowdfund->update([
                            'total_donation' => $new_total_donation,
                        ]);

                        $updateDonationWithLevel = $this->updateDonationCount($donorPay,$user);
                    
                    }
                    else
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'You donation exceed our target. Maximum donation amount we can accept is below RM '.$exceed_target,
                            'data' => $crowdfund,
                        ]);
                    }
                }
                else
                {
                    return response()->json([
                        'success' => true,
                        'message' => 'The donation has meet our target. Hence if you interest to make a donation, you can choose another crowdfund. Thankyou!',
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

    public function updateDonationCount($donorPay,$user)
    {
        $crowdfund = $user->donor->update([
            'donation_count' => $user->donor->donation_count + (int)$donorPay
        ]);

        $updateDonationWithLevel = $this->checkAndUpdateLevelByLatestDonationCount($user);

        return $updateDonationWithLevel;
    }

    public function checkAndUpdateLevelByLatestDonationCount($user)
    {
        $donation_count = $user->donor->donation_count;

        if($donation_count < 199)
        {
            $new_donation_count = $user->donor->update([
                'level_id' => 1,
            ]);
        }
        else if($donation_count < 299)
        {
            $new_donation_count = $user->donor->update([
                'level_id' => 2,
            ]);
        }
        else if($donation_count < 399)
        {
            $new_donation_count = $user->donor->update([
                'level_id' => 3,
            ]);
        }
        else if($donation_count < 499)
        {
            $new_donation_count = $user->donor->update([
                'level_id' => 4,
            ]);
        }
        else
        {
            $new_donation_count = $user->donor->update([
                'level_id' => 5,
            ]);
        }

        return $donation_count;
    }
    
}
