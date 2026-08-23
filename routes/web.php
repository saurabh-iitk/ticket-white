<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SoftwareLandingController;
use App\Http\Controllers\Auth\User\BookingsController;
use App\Http\Controllers\Auth\User\DashboardController;
use App\Http\Controllers\Auth\User\UserController;
use App\Http\Controllers\Auth\User\RoleController;
use App\Http\Controllers\Auth\User\ModuleController;
use App\Http\Controllers\Auth\User\StateController;
use App\Http\Controllers\Auth\User\CityController;
use App\Http\Controllers\Auth\User\PincodeController;
use App\Http\Controllers\Auth\User\OrganizerController;
use App\Http\Controllers\Auth\User\VenueController;
use App\Http\Controllers\Auth\User\SubVenueController;
use App\Http\Controllers\Auth\User\EventController;
use App\Http\Controllers\Auth\User\EventScheduleController;
use App\Http\Controllers\Auth\User\EventShowTimeController;
use App\Http\Controllers\Auth\User\EventShowTimeScheduleController;
use App\Http\Controllers\Auth\User\TicketTypeController;
use App\Http\Controllers\Auth\User\EventTicketController;
use App\Http\Controllers\Auth\User\CouponCategoryController;
use App\Http\Controllers\Auth\User\CouponController;
use App\Http\Controllers\Auth\User\CompanyController;
use App\Http\Controllers\Auth\User\ConfigurationController;
use App\Http\Controllers\Auth\User\PaymentMethodController;
use App\Http\Controllers\Auth\User\BookingPlatformController;
use App\Http\Controllers\Auth\User\SettingController;
use App\Http\Controllers\Auth\User\LayoutController;
use App\Http\Controllers\Auth\User\AjaxController;
use App\Http\Controllers\ImageController;


Route::group(['middleware' => ['web']], function () {
    include 'web/guest.php';

});

Route::group(['middleware' => ['auth']], function () {
    include 'web/customer.php';
});

Route::group(['middleware' => ['auth']], function () {
    require_once __DIR__ . '/web/auth.php';
});


Route::get('/generate-image', [ImageController::class, 'generateImage']);

// General public routes
// Route::get('/', [HomeController::class, 'home']);
Route::get('/index', function() {
    return redirect()->route('software.home');
});
Route::get('/about', [HomeController::class, 'about'])->name('about');

// BookMyTicket Software Landing Page Routes
Route::get('/', [SoftwareLandingController::class, 'home'])->name('software.home');
Route::get('/features', [SoftwareLandingController::class, 'features'])->name('software.features');
Route::get('/pricing', [SoftwareLandingController::class, 'pricing'])->name('software.pricing');
Route::post('/contact-submit', [SoftwareLandingController::class, 'submitContact'])->name('software.contact.submit');
Route::get('/user-register', [HomeController::class,'user_register'])->name('user-register');
Route::get('/user-login', [HomeController::class,'user_login'])->name('user-login');
Route::get('/showcase', [HomeController::class, 'showcase'])->name('showcase');
Route::get('/events', [HomeController::class, 'events'])->name('events');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/photo_gallery', [HomeController::class, 'photo_gallery'])->name('photo_gallery');
Route::get('/photo_gallery_details/{id}', [HomeController::class, 'photo_gallery2'])->name('photo_gallery2');

Route::get('/video_gallery', [HomeController::class, 'video_gallery'])->name('video_gallery');
// Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/contact', [SoftwareLandingController::class, 'contact'])->name('software.contact');
Route::get('/schedule', [HomeController::class, 'schedule'])->name('schedule');
Route::get('/payment', [HomeController::class, 'payment'])->name('payment');
Route::get('/gallery_images', [HomeController::class, 'gallery_images'])->name('gallery_images');
Route::get('/terms_conditions', [HomeController::class, 'terms_conditions'])->name('terms_conditions');
Route::get('/privacy_policy', [HomeController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/business_enquiry', [HomeController::class, 'business_enquiry'])->name('business_enquiry');
Route::get('/bulk_booking', [HomeController::class, 'bulk_booking'])->name('bulk_booking');
Route::get('/process_payu_booking', [HomeController::class, 'pending_payu_ticket_booking_cron'])->name('pending_payu_ticket_booking_cron');
Route::get('/process_rz_booking', [HomeController::class, 'pending_razorpay_ticket_booking_cron'])->name('pending_razorpay_ticket_booking_cron');


// Feedback routes
Route::get('/feedback/{id}', [HomeController::class, 'customer_feedback'])->name('customer_feedback');
Route::post('/customer-feedback/{id}', [HomeController::class, 'store_customer_feedback'])->name('feedback.store');
Route::get('/sent-feedback', [HomeController::class, 'feedback_sent_to_customer'])->name('feedback_sent_to_customer');

Route::get('/general-feedback', [HomeController::class, 'general_feedback'])->name('general_feedback');
Route::post('/general-feedback', [HomeController::class, 'store_general_feedback'])->name('general_feedback.store');
Route::get('/api_check_alert', [HomeController::class, 'api_check_alert'])->name('api_check_alert');
Route::get('/cgst_sgst_fix', [HomeController::class, 'cgst_sgst_fix'])->name('cgst_sgst_fix');


// Authentication routes
Auth::routes();
