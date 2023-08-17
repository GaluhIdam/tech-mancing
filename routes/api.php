<?php

use App\Http\Controllers\PemancinganController;
use App\Http\Controllers\UserController;
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

//Register
Route::post('register', [UserController::class, 'register']);

//Login
Route::post('login', [UserController::class, 'login']);


//Protect By Sanctum
Route::middleware('auth:sanctum')->group(
    function () {
        //Log out
        Route::post('logout', [UserController::class, 'logout']);

        //Getting User
        Route::get('users', [UserController::class, 'index']);

        //Getting Pemancingan
        Route::get('pemancingan', [PemancinganController::class, 'index']);
        //Creating Pemancingan
        Route::post('pemancingan', [PemancinganController::class, 'store']);
    }
);
