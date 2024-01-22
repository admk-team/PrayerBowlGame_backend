<?php

use App\Http\Controllers\AddedUserController;
use App\Http\Controllers\RandomUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MinistryPartnerController;
use App\Http\Controllers\EmailSettingsController;
use App\Http\Controllers\FrontController;
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

Route::view('/terms-and-conditions', 'pages.terms-and-conditions');
Route::view('/privacy-policy', 'pages.privacy-policy');
Route::view('/about-us', 'pages.about');
//account delete request routes
Route::view('/account-delete', 'pages.account-delete');
Route::post('user/mail', [FrontController::class, 'handleMailForm'])->name('mail');
Route::get('/delete-account/{userId}', [FrontController::class, 'confirmAccountDeletion'])
    ->name('confirm.account.deletion');
Auth::routes();
Route::middleware('admin')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}/', [UserController::class, 'destroy'])->name('users.delete');
    // added user
    Route::get('/added/users', [AddedUserController::class, 'index']);
    Route::get('/added/{id}/', [AddedUserController::class, 'destroy'])->name('added.delete');
    // random users
    Route::get('/random/users', [RandomUserController::class, 'index']);
    Route::get('/random/{id}/', [RandomUserController::class, 'destroy'])->name('random.delete');
    // Email settings
    Route::get('/email-settings', [EmailSettingsController::class, 'index'])->name('email-settings');
    Route::post('/email-settings', [EmailSettingsController::class, 'update'])->name('email-settings');
    
    // Ministry Parters Route
    Route::resource('ministryPartners', MinistryPartnerController::class); 

});


