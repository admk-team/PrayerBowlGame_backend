<?php

use App\Http\Controllers\AddedUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\RandomUserController;
use Illuminate\Support\Facades\Auth;

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
Auth::routes();
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/add/user', [AddedUserController::class , 'store']); 
    Route::post('/update/user', [AddedUserController::class , 'update']); 
    Route::get('/users', [AddedUserController::class , 'get_users']); 
    Route::get('/user/details/{id}', [AddedUserController::class , 'get_user_details']); 
    Route::get('/user/delete/{id}', [AddedUserController::class , 'delete_user']); 
    Route::get('/random/user', [RandomUserController::class , 'get_random_user']);
    Route::post('/profile/update', [AuthController::class , 'profile_update']);
});