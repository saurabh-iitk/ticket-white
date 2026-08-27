<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
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
use App\Http\Controllers\Auth\User\ReportsController;
use App\Http\Controllers\Auth\User\PhotoGalleryController;
use App\Http\Controllers\Auth\User\PhotoContentController;
use App\Http\Controllers\Auth\User\VideoGalleryController;


// Public Routes

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::resource('/user', UserController::class);
Route::post('/user_block/{id}/{status}', [UserController::class, 'user_block'])->name('user.block');
Route::get('/edit', [UserController::class, 'profile']);
Route::get('/scan-ticket', [UserController::class, 'scan_ticket'])->name('scan-ticket');
Route::post('/scan-data-check', [UserController::class, 'scan_ticket_check'])->name('scan-data-check');
Route::get('/scan-ticket-report', [UserController::class, 'scan_ticket_report'])->name('scan-ticket-report');
// Route::post('/update-ticket-scan', [UserController::class, 'update_ticket_scan'])->name('update-ticket-scan');
Route::post('/update-ticket-scan', [UserController::class, 'update_ticket_scan'])->name('update-ticket-scan');


Route::get('/edit/{id}/{type}', [UserController::class, 'profile']);
Route::put('/profile/update/{id}', [UserController::class, 'update_profile']);
Route::put('/password/update/{id}', [UserController::class, 'update_password']);
// Route::resource('/role', RoleController::class);
Route::resource('/role', RoleController::class);


Route::resource('/module', ModuleController::class);


Route::get('photo-gallery', [PhotoGalleryController::class, 'index'])->name('photo_gallery.index');
Route::get('photo-gallery/create', [PhotoGalleryController::class, 'create'])->name('photo_gallery.create');
Route::post('photo-gallery', [PhotoGalleryController::class, 'store'])->name('photo_gallery.store');
Route::get('photo-gallery/{photo_gallery}', [PhotoGalleryController::class, 'show'])->name('photo_gallery.show');
Route::get('photo-gallery/{photo_gallery}/edit', [PhotoGalleryController::class, 'edit'])->name('photo_gallery.edit');
Route::put('photo-gallery/{photo_gallery}', [PhotoGalleryController::class, 'update'])->name('photo_gallery.update');
Route::delete('photo-gallery/{photo_gallery}', [PhotoGalleryController::class, 'destroy'])->name('photo_gallery.destroy');

Route::get('photo-content', [PhotoContentController::class, 'index'])->name('photo_content.index');
Route::get('photo-content/create', [PhotoContentController::class, 'create'])->name('photo_content.create');
Route::post('photo-content', [PhotoContentController::class, 'store'])->name('photo_content.store');
Route::get('photo-content/{photo_content}', [PhotoContentController::class, 'show'])->name('photo_content.show');
Route::get('photo-content/{photo_content}/edit', [PhotoContentController::class, 'edit'])->name('photo_content.edit');
Route::put('photo-content/{photo_content}', [PhotoContentController::class, 'update'])->name('photo_content.update');
Route::delete('photo-content/{photo_content}', [PhotoContentController::class, 'destroy'])->name('photo_content.destroy');

Route::resource('/video_gallery', VideoGalleryController::class);
Route::get('video_gallery', [VideoGalleryController::class, 'index'])->name('video_gallery.index');



// Master Routes
Route::resource('/state', StateController::class);
Route::resource('/city', CityController::class);
Route::resource('/pincode', PincodeController::class);
Route::resource('/organizer', OrganizerController::class);
Route::resource('/venue', VenueController::class);
Route::resource('/sub_venue', SubVenueController::class);
Route::resource('/event', EventController::class);
Route::resource('/event_schedule', EventScheduleController::class);
Route::resource('/event_show_time', EventShowTimeController::class);
Route::resource('/show_time_schedule', EventShowTimeScheduleController::class);
Route::resource('/ticket_type', TicketTypeController::class);

// Manage Events
Route::post('/show_time_schedule/update_event_ticket_rates', [EventShowTimeScheduleController::class, 'update_event_ticket_rates'])->name('event_ticket_rates.update');
Route::resource('/event_ticket', EventTicketController::class);
Route::get('/event_ticket/layout_mapping/{id}', [EventTicketController::class, 'layout_mapping']);
Route::get('/event_ticket/layout_mapping_canvas/{id}', [EventTicketController::class, 'layout_mapping_canvas']);
Route::post('/event_ticket/save_layout_designer', [EventTicketController::class, 'save_layout_designer'])->name('event_ticket.save_layout_designer');
Route::post('/event_ticket/update_event_seat', [EventTicketController::class, 'update_event_seat'])->name('event_ticket.update_event_seat');
Route::post('/event_ticket/update_event_seat_from_booking', [EventTicketController::class, 'update_event_seat_from_booking'])->name('event_ticket.update_event_seat_from_booking');

Route::post('/event_ticket/check_for_duplicate_mapping', [EventTicketController::class, 'check_for_duplicate_mapping'])->name('event_ticket.check_for_duplicate_mapping');


Route::get('/event_ticket/delete_event_ticket_lists/{id}', [EventTicketController::class, 'delete_event_ticket_lists']);
Route::resource('/coupon_category', CouponCategoryController::class);
Route::resource('/coupon', CouponController::class);
Route::resource('/company', CompanyController::class);
Route::resource('/configuration', ConfigurationController::class);
Route::resource('/payment_method', PaymentMethodController::class);
Route::resource('/booking_platform', BookingPlatformController::class);
Route::resource('/setting', SettingController::class);

// Booking
// Route::resource('/booking', BookingsController::class);
Route::get('/booking/sale_status', [BookingsController::class, 'sale_status'])->name('bookings.saleStatus');
Route::post('/booking/clear_discount_from_cart', [BookingsController::class, 'clear_discount_from_cart'])->name('bookings.clear_discount_from_cart');

// Route::get('/bookings/pos', [BookingsController::class, 'add_pos'])->name('bookings.addPos');

Route::get('/booking/index', [BookingsController::class, 'index'])->name('booking.index');
Route::get('/booking/create', [BookingsController::class, 'create'])->name('booking.create');
Route::post('/booking/save', [BookingsController::class, 'store'])->name('booking.save');

Route::get('/booking/block_booking', [BookingsController::class, 'block_booking'])->name('bookings.block_booking');
Route::get('/booking/vendor_block_booking/{id}/{vendor_booking}', [BookingsController::class, 'vendor_block_booking'])->name('bookings.vendor_block_booking');
Route::get('/booking/customer_block_booking/{id}/{customer_booking}', [BookingsController::class, 'customer_block_booking'])->name('bookings.customer_block_booking');
Route::get('/booking/all_block_booking/{id}', [BookingsController::class, 'all_block_booking'])->name('bookings.all_block_booking');
Route::get('/booking/all_unblock_booking/{id}', [BookingsController::class, 'all_unblock_booking'])->name('bookings.all_unblock_booking');
Route::post('/booking/add_to_cart', [BookingsController::class, 'add_to_cart'])->name('booking.add_to_cart');
Route::post('/booking/clear_cart', [BookingsController::class, 'clear_cart'])->name('booking.clear_cart');
Route::post('/booking/update_cart_discount', [BookingsController::class, 'update_cart_discount'])->name('booking.update_cart_discount');
Route::post('/booking/fetch_layout_name', [BookingsController::class, 'get_layout_by_show_time_id'])->name('event_ticket.get_layout_by_show_time_id');
Route::post('/booking/fetch_booking', [BookingsController::class, 'fetch_booking'])->name('booking.fetch_booking');
Route::post('/booking/update_booking', [BookingsController::class, 'update_booking'])->name('booking.update_booking');


// Unbook Booking
Route::post('/booking/unbook/{id}', [BookingsController::class, 'unbook'])->name('booking.unbook');

//layout
Route::resource('/layout', LayoutController::class);
Route::get('/layout/create/{id}', [LayoutController::class, 'create']);
Route::post('/layout/layout_row_label/{id}', [LayoutController::class, 'layout_row_label']);
Route::get('/layout/seat_name_regenerate/{id}', [LayoutController::class, 'seat_name_regenerate'])->name('layout.seat_name_regenerate');
Route::post('/layout/create_seat/{id}', [LayoutController::class, 'create_seat']);
Route::post('/layouts/update_layout', [LayoutController::class, 'update_layout'])->name('layouts.update_layout');
Route::post('/layouts/update_seat_name', [LayoutController::class, 'update_seat_name'])->name('layouts.update_seat_name');
Route::post('/booking/update_event_seat_name', [BookingsController::class, 'update_event_seat_name'])->name('booking.update_event_seat_name');
Route::post('/booking/update_event_label_name', [BookingsController::class, 'update_event_label_name'])->name('booking.update_event_label_name');
Route::post('/layouts/update_stage_direction', [LayoutController::class, 'update_stage_direction'])->name('layouts.update_stage_direction');

// Venue Layout Designer Routes
Route::get('/layout/designer/{id}', [LayoutController::class, 'designer'])->name('layout.designer');
Route::get('/layout/designer/{id}/load', [LayoutController::class, 'load_designer_data'])->name('layout.designer.load');
Route::post('/layout/designer/{id}/save', [LayoutController::class, 'save_designer_data'])->name('layout.designer.save');
Route::get('/layout/designer/pricing-categories/list', [LayoutController::class, 'list_pricing_categories'])->name('layout.designer.pricing_categories');
Route::post('/layout/designer/pricing-categories/store', [LayoutController::class, 'store_pricing_category'])->name('layout.designer.pricing_categories.store');
Route::delete('/layout/designer/pricing-categories/{id}/delete', [LayoutController::class, 'delete_pricing_category'])->name('layout.designer.pricing_categories.delete');


//Ajax Controller Routing
Route::post('/cities/get_city_by_state_id', [AjaxController::class, 'get_city_by_state_id'])->name('cities.get_city_by_state_id');
Route::post('/pincodes/get_pincode_by_city_id', [AjaxController::class, 'get_pincode_by_city_id'])->name('pincodes.get_pincode_by_city_id');
Route::post('/venues/get_venue_by_city_id', [AjaxController::class, 'get_venue_by_city_id'])->name('venues.get_venue_by_city_id');
Route::post('/sub_venues/get_sub_venue_by_venue_id', [AjaxController::class, 'get_sub_venue_by_venue_id'])->name('sub_venues.get_sub_venue_by_venue_id');
Route::post('/event_schedules/get_event_schedule_by_event_id', [AjaxController::class, 'get_event_schedule_by_event_id'])->name('event_schedules.get_event_schedule_by_event_id');
Route::post('/event_schedules/update_show_status', [AjaxController::class, 'update_show_status'])->name('event_schedules.update_show_status');
Route::post('/event_schedules/get_event_schedule_list_by_event_schedule_id', [AjaxController::class, 'get_event_schedule_list_by_event_schedule_id'])->name('event_schedules.get_event_schedule_list_by_event_schedule_id');
Route::post('/event_schedules/get_event_schedule_list_by_event_schedule_id_unmapped', [AjaxController::class, 'get_event_schedule_list_by_event_schedule_id_unmapped'])->name('event_schedules.get_event_schedule_list_by_event_schedule_id_unmapped');
Route::post('/event_schedules/event_schedule_import_data', [AjaxController::class, 'event_schedule_import_data'])->name('event_schedules.event_schedule_import_data');
Route::post('/event_schedules/event_schedule_import_data_show', [AjaxController::class, 'event_schedule_import_data_show'])->name('event_schedules.event_schedule_import_data_show');
Route::post('/event_schedules/event_ticket_data', [AjaxController::class, 'event_ticket_data'])->name('event_schedules.event_ticket_data');
Route::post('/event_schedules/get_ticket_type_by_event_id', [AjaxController::class, 'get_ticket_type_by_event_id'])->name('event_schedules.get_ticket_type_by_event_id');
Route::post('/event_schedules/get_event_schedule_time_by_event_schedule_date', [AjaxController::class, 'get_event_schedule_time_by_event_schedule_date'])->name('event_schedules.get_event_schedule_time_by_event_schedule_date');
Route::post('/event_schedules/get_event_schedule_time_by_event_schedule_date_booking', [AjaxController::class, 'get_event_schedule_time_by_event_schedule_date_booking'])->name('event_schedules.get_event_schedule_time_by_event_schedule_date_booking');
Route::post('/event_tickets/get_tickets_by_show_time_id', [AjaxController::class, 'get_tickets_by_show_time_id'])->name('event_tickets.get_tickets_by_show_time_id');
Route::post('/event_schedules/get_event_schedule_list_block', [AjaxController::class, 'get_event_schedule_list_block'])->name('event_schedules.get_event_schedule_list_block');
Route::post('/event_show_time/get_event_show_time_by_event_id', [AjaxController::class, 'get_event_show_time_by_event_id'])->name('event_show_time.get_event_show_time_by_event_id');
Route::post('/booking/get_customer_by_mobile_no', [AjaxController::class, 'get_customer_by_mobile_no'])->name('booking.get_customer_by_mobile_no');
Route::post('/booking/fetch_bms_id_exist', [AjaxController::class, 'fetch_bms_id_exist'])->name('booking.fetch_bms_id_exist');
Route::post('/booking/force_delete', [BookingsController::class, 'force_delete'])->name('booking.force_delete');

//Reports Controller Routing
Route::get('/reports/booking', [ReportsController::class, 'booking_report'])->name('reports.booking');
Route::get('/reports/feedback_report', [ReportsController::class, 'feedback_report'])->name('reports.feedback_report');
Route::get('/reports/general_feedback_report', [ReportsController::class, 'general_feedback_report'])->name('reports.general_feedback_report');
Route::get('/reports/source_report', [ReportsController::class, 'source_report'])->name('reports.source_report');
Route::get('/reports/booking_detail/{id}', [ReportsController::class, 'booking_detail_report'])->name('reports.booking_detail');
Route::get('/reports/print_ticket/{id}', [ReportsController::class, 'print_ticket'])->name('reports.print_ticket');
Route::get('/reports/payment_mode', [ReportsController::class, 'payment_mode'])->name('reports.payment_mode');
Route::get('/reports/ticket_sale', [ReportsController::class, 'ticket_sale'])->name('reports.ticket_sale');
Route::get('/reports/booking_type', [ReportsController::class, 'booking_type'])->name('reports.booking_type');
Route::get('/reports/cashier_shift_summary', [ReportsController::class, 'cashier_shift_summary'])->name('reports.cashier_shift_summary');
Route::get('/reports/cashier_shift_summary_multiple_day', [ReportsController::class, 'cashier_shift_summary_multiple_day'])->name('reports.cashier_shift_summary_multiple_day');
Route::get('/reports/cashier_shift_summary_vs_payment', [ReportsController::class, 'cashier_shift_summary_vs_payment'])->name('reports.cashier_shift_summary_vs_payment');
Route::get('/reports/individual_cashier_shift_summary', [ReportsController::class, 'individual_cashier_shift_summary'])->name('reports.individual_cashier_shift_summary');
Route::get('/reports/cashier_shift_summary_show_wise', [ReportsController::class, 'cashier_shift_summary_show_wise'])->name('reports.cashier_shift_summary_show_wise');
Route::get('/reports/scan_summary_show_wise', [ReportsController::class, 'scan_summary_show_wise'])->name('reports.scan_summary_show_wise');
Route::get('/reports/sale_summary', [ReportsController::class, 'sale_summary'])->name('reports.sale_summary');
Route::post('/reports/cashier_shift_summary_show_wise_ajax', [ReportsController::class, 'cashier_shift_summary_show_wise_ajax'])->name('cashier_shift_summary_show_wise_ajax');
Route::post('/reports/scan_summary_show_wise_ajax', [ReportsController::class, 'scan_summary_show_wise_ajax'])->name('scan_summary_show_wise_ajax');
Route::post('/reports/payment_logs_ajax', [ReportsController::class, 'payment_logs_ajax'])->name('payment_logs_ajax');
Route::get('/reports/cashier_shift_summary_day_wise', [ReportsController::class, 'cashier_shift_summary_day_wise'])->name('reports.cashier_shift_summary_day_wise');
Route::get('/reports/gst_report_r1', [ReportsController::class, 'gst_report_r1'])->name('reports.gst_report_r1');
Route::get('/reports/cancelled_booking_report', [ReportsController::class, 'cancelled_booking_report'])->name('reports.cancelled_booking_report');
Route::get('/reports/pg_transaction_report', [ReportsController::class, 'pg_transaction_report'])->name('reports.pg_transaction_report');
Route::get('/reports/pg_logs', [ReportsController::class, 'pg_logs'])->name('reports.pg_logs');
Route::get('/reports/complementry_report', [ReportsController::class, 'complementry_report'])->name('reports.complementry_report');
Route::get('/reports/analytics_summary', [ReportsController::class, 'analytics_summary'])->name('reports.analytics_summary');


Route::get('/generate-invoice/{event_id}', [ReportsController::class, 'generate_invoice_no'])->name('generate.invoice');

// Route::get('/permission-updated', function () {
//     return view('auth.permission-updated');
// });
