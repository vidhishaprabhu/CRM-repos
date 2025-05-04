<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function(){
    Route::get('sales-chart',[AuthController::class,'getLoginChartData']);
    Route::get('admin-chart',[AuthController::class,'getLoginChartAdminData']);
    Route::get('sales-manager-chart',[AuthController::class,'getLoginChartSalesData']);
    Route::get('/users',[AuthController::class,'getAllUsers']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::put('/users/{id}',[AuthController::class,'update']);
    Route::delete('/users/{id}',[AuthController::class,'delete']);
    
});