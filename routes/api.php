<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\ProfileController;
use App\Http\Controllers\API\User\FoodbankController;
use App\Http\Controllers\API\User\CrowdfundController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::prefix('v1')->middleware('auth:api')->group(function()
{
    Route::get('/profile/index', [ProfileController::class,'index']);
    Route::post('/profile/update/{user}', [ProfileController::class,'update']);

    Route::get('/foodbank/list', [FoodbankController::class,'list']);

    Route::get('/crowdfund/list', [CrowdfundController::class,'list']);
    Route::post('/create/crowdfund', [CrowdfundController::class,'createCrowdfund']);
});