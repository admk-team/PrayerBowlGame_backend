<?php

use App\Http\Controllers\AddedUserController;
use App\Http\Controllers\RandomUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/cmd/{cmd}', function ($cmd) {
    \Artisan::call("$cmd");
    return \Artisan::output();
});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::middleware('admin')->group(function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users', [UserController::class, 'index']);
Route::get('/added/users', [AddedUserController::class, 'index']);
Route::get('/random/users', [RandomUserController::class, 'index']);
});
