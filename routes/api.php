<?php

use App\Http\Controllers\CalculatorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/codecar/calculator', [CalculatorController::class,'calc_function']);
Route::get('/codecar/calculator', [CalculatorController::class,'calc_function_get']);
Route::get('/', [CalculatorController::class,'calc_function_get']);

// Route::get('/', [CalculatorController::class,'calc_function']);

