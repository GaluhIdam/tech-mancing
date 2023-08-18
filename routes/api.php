<?php

use App\Http\Controllers\KomentarRateController;
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
        //Getting Pemancingan by ID
        Route::get('pemancingan/{id}', [PemancinganController::class, 'show']);
        //Creating Pemancingan
        Route::post('pemancingan', [PemancinganController::class, 'store']);
        //Updating Pemancingan
        Route::post('pemancingan/{id}', [PemancinganController::class, 'update']);
        //Deleting Pemancingan
        Route::delete('pemancingan/{id}', [PemancinganController::class, 'destroy']);

        //Getting Komentar Rate
        Route::get('komentar-rate', [KomentarRateController::class, 'index']);
        //Creating Komentar Rate
        Route::post('komentar-rate', [KomentarRateController::class, 'create']);
        //Updating Komentar Rate
        Route::put('komentar-rate/{id}', [KomentarRateController::class, 'update']);
        //Deleting Komentar Route
        Route::delete('komentar-rate/{id}', [KomentarRateController::class, 'destroy']);
    }
);
