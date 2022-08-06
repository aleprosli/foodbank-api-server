<?php

namespace App\Http\Controllers\API\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createBill(Request $request)
    {
        $billplz_secret_key = config('services.billplz.secret');

        $url = config('services.billplz.url').'bills';

        $body =[
            'collection_id' => 'wnxlndwr',
            'email' => $request->email,
            'mobile' => '0135162634',
            'name' => 'Aliff',
            'amount' => 200,
            'callback_url'=>'http://example.com/webhook/',
            'description'=>$request->description,
        ];
        
        $response = Http::withHeaders([
            'Authorization' => $billplz_secret_key,
        ])->post($url, $body);

       return redirect($response->json(['url']));
    }
}
