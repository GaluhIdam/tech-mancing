<?php

use App\Http\Controllers\AcaraController;
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

Route::get('images-pemancingan/{filename}', [PemancinganController::class, 'showImage']);
Route::get('images-acara/{filename}', [AcaraController::class, 'showImage']);

//Login
Route::post('login', [UserController::class, 'login']);


//Protect By Sanctum
Route::middleware('auth:sanctum')->group(
    function () {
        //Log out
        Route::post('logout', [UserController::class, 'logout']);

        //Getting User
        Route::get('users', [UserController::class, 'index']);

        //Getting User By Email
        Route::get('get-user', [UserController::class, 'getUserByEmail']);

        //Getting Pemancingan
        Route::get('pemancingan', [PemancinganController::class, 'index']);
        //Getting Pemancingan By User
        Route::get('pemancingan-by-user/{id_user}', [PemancinganController::class, 'getPemancinganByUser']);
        //Getting Pemancingan For User
        Route::get('pemancingan-for-user', [PemancinganController::class, 'getPemancinganForUser']);
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

        //Getting Acara
        Route::get('acara', [AcaraController::class, 'index']);
        //Getting Acara by ID
        Route::get('acara/{id}', [AcaraController::class, 'show']);
        Route::get('acara-user/{id}', [AcaraController::class, 'getByUser']);
        //Creating Acara
        Route::post('acara', [AcaraController::class, 'create']);
        //Updating Acara
        Route::post('acara/{id}', [AcaraController::class, 'update']);
        //Deleting Acara
        Route::delete('acara/{id}', [AcaraController::class, 'destroy']);
    }
);
