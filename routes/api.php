<?php

use App\Http\Controllers\AddedUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\RandomUserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\MinistryPartnerController;
use App\Http\Controllers\Api\SupportersApiController;
use App\Http\Controllers\Api\StripeController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\PrayerRequestController;
use App\Http\Controllers\Api\PrayerSectionController;
use App\Http\Controllers\Api\ReminderNotificationController;
use App\Http\Controllers\Api\StreakController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TestimonialController;

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
Route::post('/password/otp', [PasswordResetController::class, 'sendOtp']);
Route::post('/password/otp/verify', [PasswordResetController::class, 'verifyOtp']);
Route::post('/password/update', [PasswordResetController::class, 'updatePassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/add/user', [AddedUserController::class, 'store']);
    Route::get('/edit/user/{id}', [AddedUserController::class, 'edit']);
    Route::post('/update/user/{id}', [AddedUserController::class, 'update']);
    Route::get('/users', [AddedUserController::class, 'get_users']);
    Route::get('/user/details/{id}', [AddedUserController::class, 'get_user_details']);
    Route::get('/user/delete/{id}', [AddedUserController::class, 'delete_user']);
    Route::get('/random/user', [RandomUserController::class, 'get_random_user']);
    Route::post('/profile/update', [AuthController::class, 'profile_update']);
    Route::post('/destroy', [AuthController::class, 'destroy']);

    // Ministry Parters Route
    // Route::apiResource('ministryPartners',MinistryPartnerController::class);
    Route::get('/ministrypartners', [MinistryPartnerController::class, 'index']);
    // Route::post('/storepartners', [MinistryPartnerController::class, 'store']);
    // Route::post('ministryPartners/saveministrypartner', [MinistryPartnerController::class, 'saveSortOrder'])->name('ministrypartner.reorder');

    // Supporters Router
    Route::get('/supporters', [SupportersApiController::class, 'index']);
    // Route::get('/supportershow', [SupportersApiController::class, 'show'])->name('supporters.show');
    Route::post('/supporterstore', [SupportersApiController::class, 'store']);

    // Donation Routes
    Route::post('/donation', [DonationController::class, 'donation']);
    // Route::get('/donationshow/{id}', [DonationController::class, 'show']);
    Route::get('/allproducts', [DonationController::class, 'allproducts']);

    //random user notification with admin notification
    Route::get('/user/notification', [NotificationController::class, 'notification']);
    //user has view notification
    // Route definition
    Route::post('/view/notification/{id}', [NotificationController::class, 'view_notification']);
    Route::get('/view/user/{id}', [NotificationController::class, 'view_notification_user']);
    //
    Route::get('/donations/details', [DonationController::class, 'getDonationDetails']);
    //show notification
    Route::get('/show/notification/{id}', [NotificationController::class, 'show']);
    //faq
    Route::get('/faqs', [FaqController::class, 'index']);

    //testimonials
    Route::post('/testimonial', [TestimonialController::class, 'store']);
    Route::get('/all/testimonials', [TestimonialController::class, 'allTestimonials']);

    Route::get('cancelsubuser/{id}', [DonationController::class, 'canclesubuser']);
    Route::get('getusersubs', [DonationController::class, 'getsubscriptiondata']);
    Route::get('setuserlanguage/{lang}', [AuthController::class, 'setlanguageuser']);

    //Prayer Section
    Route::get('all/categories', [PrayerSectionController::class, 'index']);
    //Show Prayer Section with subcategories
    Route::get('/show/category/{id}', [PrayerSectionController::class, 'show']);
    //Prayer request with user and category
    Route::get('prayer/request/categories', [PrayerRequestController::class, 'index']);
    Route::post('prayer/request', [PrayerRequestController::class, 'store']);
    //Prayer request user itself
    Route::get('my/prayer/request', [PrayerRequestController::class, 'myprayer']);
    //Public And Approved Prayer request 
    Route::get('approved/prayer/request', [PrayerRequestController::class, 'approvedprayer']);
    //User Streak count or reset
    Route::get('streak/counter', [StreakController::class, 'updateStreak'])->name('streak.update');
    //ReminderNotification
    Route::apiResource('reminder', ReminderNotificationController::class);
});
//page
Route::get('/pages', [PageController::class, 'pages']);
Route::post('/contact', [ContactMessageController::class, 'store']);

Route::get('test', [RandomUserController::class, 'test']);
Route::get('topwarriors', [SupportersApiController::class, 'topwarriors']);



Route::get('/paymentonetime/{id}', [DonationController::class, 'sendThankYouEmail'])->name('donations.onetime.success');
