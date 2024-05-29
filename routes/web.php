<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AddedUserController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\RandomUserController;
use App\Http\Controllers\SupportersController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\EmailSettingsController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\MinistryPartnerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PrayerRequestController;
use App\Http\Controllers\StripeSubscriptionController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TestimonialController;
use App\Models\ContactMessage;

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
//route for banner redirect
Route::get('/show/banner/{Id}', [FrontController::class, 'showBanner'])
    ->name('show.banner');
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
    Route::post('saveministryPartner', [MinistryPartnerController::class, 'saveSortOrder'])->name('ministrypartner.reorder');

    // Supporters Routers with Donation
    Route::get('/supporters', [SupportersController::class, 'index'])->name('supporters.index');
    Route::get('/supporters/{id}', [SupportersController::class, 'show'])->name('supporters.show');
    Route::post('/supporters/store', [SupportersController::class, 'store'])->name('supporters.store');


    // Banner add Route
    // Show all banners
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

    //notification
    Route::resource('notification', NotificationController::class);
    //Donation
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/{id}', [DonationController::class, 'show'])->name('donations.show');

    Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'destroy']);

    Route::resource('faqs', FaqController::class)->except(['show']);

    Route::resource('page', PageController::class);

    //Testimonial
    Route::resource('testimonials', TestimonialController::class);
    Route::get('test/{id}', [TestimonialController::class, 'updateStatus'])->name('testimonials.updateStatus');

    //Prayer Section category
    Route::resource('category', CategoryController::class);
    //Prayer Section subcategory
    Route::resource('subcategory', SubCategoryController::class);
     //Prayer Request 
     Route::resource('prayrequest', PrayerRequestController::class);

});

Route::get('/stripepayment', [DonationController::class, 'success'])->name('donations.success');
