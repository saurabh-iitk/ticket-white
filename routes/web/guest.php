<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\User\ReportsController;


Route::get('/clean/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/clean/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/clean/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/clean/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/clean/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/clean/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
    
    
Route::get('/clean/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Clear Config cleared</h1>';
});
    
    
// Route definitions using `::class` syntax
Route::get('/login', [LoginController::class, 'login']);

Route::get('/refund_cancellation', [HomeController::class, 'refund_cancellation'])->name('refund_cancellation');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/book_ticket', [HomeController::class, 'book_ticket'])->name('book_ticket');

Route::post('/event_schedules/fetch_show_dates', [HomeController::class, 'fetch_show_time'])->name('fetch_show_time');

Route::post('/book_ticket_next', [HomeController::class, 'book_ticket_next'])->name('book_ticket_next');
// Route::match(['get', 'post'], '/book_ticket_next', [HomeController::class, 'book_ticket_next'])->name('book_ticket_next');

Route::post('/book_ticket_next/add_to_cart', [HomeController::class, 'add_to_cart'])->name('customer_add_to_cart');
Route::post('/book_ticket_next/clear_cart', [HomeController::class, 'clear_cart'])->name('customer_clear_cart');
Route::post('/book_ticket_next/seat_reserve_clear', [HomeController::class, 'seat_reserve_clear'])->name('seat_reserve_clear');

Route::post('/book_ticket_next/payment', [HomeController::class, 'raz_customer_payment'])->name('raz_customer_payment');
Route::post('/book_ticket_next/raz_customer_payment_success', [HomeController::class, 'raz_customer_payment_success'])->name('raz_customer_payment_success');
Route::get('/book_ticket_next/payment', [HomeController::class, 'customer_payment'])->name('customer_payment');
Route::post('/book_ticket_next/payment_process', [HomeController::class, 'payment_process'])->name('payment_process');
Route::post('/book_ticket_next/payment_success/{id}', [HomeController::class, 'payment_success'])->name('payment_success');
Route::post('/book_ticket_next/payment_fail/{id}', [HomeController::class, 'payment_fail'])->name('payment_fail');
Route::post('/book_ticket_next/payment_fail_rz', [HomeController::class, 'payment_fail_rz'])->name('payment_fail_rz');
Route::get('/book_ticket_next/payment_fail_print/{id}', [HomeController::class, 'payment_fail_print'])->name('payment_fail_print');

Route::get('/book_ticket/ticket_booked/{id}', [HomeController::class, 'ticket_booked'])->name('ticket_booked');

Route::get('/send/email', [HomeController::class, 'payment_confirm_mail']);
Route::get('/remove_hold_transaction', [HomeController::class, 'remove_hold_transaction'])->name('remove_hold_transaction');

Route::post('/pg_logs/payumoney', [HomeController::class, 'payumoney_webhook'])->name('payumoney_webhook');
Route::post('/pg_logs/razorpay', [HomeController::class, 'razorpay_webhook'])->name('razorpay_webhook');
Route::get('/invoice/{invoice_id}', [ReportsController::class, 'view_invoice'])->name('view_invoice');
Auth::routes();
