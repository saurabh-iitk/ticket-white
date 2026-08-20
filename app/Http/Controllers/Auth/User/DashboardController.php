<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use App\Models\City;
use App\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role_id = Auth::user()->role->id ?? null;
        $role_data = Role::find($role_id);
    
        $lastBooking = Booking::latest('created_at')->first();
        $eventId = $lastBooking->event_id ?? null;
    
        $event = $eventId ? Event::find($eventId) : null;
        $cityId = optional($event)->city_id;
        $city = $cityId ? City::find($cityId) : null;
    
        $monthlySales = collect();
        $dailySales = collect();
    
        if ($eventId) {
    
            $monthlySales = Booking::selectRaw("
                    DATE_FORMAT(esl.event_date, '%d %b %y') AS day,
                    SUM(bookings.total_quantity) AS total_quantity
                ")
                ->join('event_schedule_list AS esl', 'bookings.event_schedule_list_id', '=', 'esl.id')
                ->whereNotNull('esl.event_date')
                ->where('bookings.event_id', $eventId)
                ->groupBy(DB::raw("DATE_FORMAT(esl.event_date, '%Y-%m-%d')"))
                ->orderBy(DB::raw("DATE_FORMAT(esl.event_date, '%Y-%m-%d')"), 'asc')
                ->get();
    
            $dailySales = Booking::selectRaw("
                    DATE_FORMAT(booking_date, '%d %b %y') AS day,
                    COUNT(id) AS total_bookings,
                    SUM(booking_amount) AS total_booking_amount,
                    SUM(paid_amount) AS total_paid_amount,
                    SUM(discount) AS total_discount
                ")
                ->whereNotNull('booking_date')
                ->where('event_id', $eventId)
                ->groupBy(DB::raw("DATE_FORMAT(booking_date, '%Y-%m-%d')"))
                ->orderBy(DB::raw("DATE_FORMAT(booking_date, '%Y-%m-%d')"), 'asc')
                ->get();
        }
    
        return view('auth.user.dashboard', compact('monthlySales', 'dailySales', 'event', 'city', 'role_data'));
    }
}
