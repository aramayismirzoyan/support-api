<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RequestController;
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

Route::post('/auth', [AuthController::class, 'generateToken']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/requests', [RequestController::class, 'getRequests']);
    Route::post('/requests', [RequestController::class, 'store']);
    Route::put('/requests/{request}', [RequestController::class, 'addAnswer']);
});
