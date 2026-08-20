<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BookingPayment;
use App\Models\Customer;
use App\Models\Event;
use App\Models\User;
use App\Models\Role;
use App\Models\City;
use App\Models\EventSchedule;
use App\Models\PaymentLogs;
use App\Models\VisitorLog;
use App\Models\GeneralFeedback;
use App\Models\PaymentTransaction;
use Carbon\Carbon;
use App\Models\TicketType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ReportsController extends Controller
{
    public function set_filter_query($request, $query)
    {
        if ($request->get('e_id') != null) {
            $query->where('bookings.event_id', $request->get('e_id'));
        }
        if ($request->get('es_id') != null) {
            $query->where('bookings.event_schedule_id', $request->get('es_id'));
        }
        if ($request->get('esd_id') != null) {
            $query->where('bookings.event_schedule_list_id', $request->get('esd_id'));
        }
        if ($request->get('est_id') != null) {
            $query->where('bookings.event_show_time_id', $request->get('est_id'));
        }
        if ($request->get('venue_id') != null) {
            $query->where('bookings.venue_id', $request->get('venue_id'));
        }
        if ($request->get('layout_id') != null) {
            $query->where('bookings.layout_id', $request->get('layout_id'));
        }
        if ($request->get('u_id') != null) {
            $query->where('bookings.vendor_id', $request->get('u_id'));
        }
    }

    public function booking_report(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/booking';
        $data['reset_url'] = 'reports.booking';
        if ($request->get('esd_id') != null) {
            $data['count'] = 2;

            $query = Booking::latest()->take(400);
        } else {
            $data['count'] = 1;
            $query = Booking::latest()->take(1);
        }

        $this->set_filter_query($request, $query);
        if ($request->get('paid_by') != null) {
            $query->where('bookings.payment_method_id', $request->get('paid_by'));
        }
        $bookings = $query->get();
        
        
        foreach ($bookings as $booking) {
            // Count total scanned tickets for each booking
            $booking->total_ticket_scanned = BookingDetail::where('is_scanned', 1)
                ->where('booking_id', $booking->id)
                ->sum('quantity');
        }
        
         $query_response = Booking::selectRaw('count(feedback_value) as count, feedback_value')->whereNotNull('feedback_value')->orderBy('count', 'DESC')->groupBy('feedback_value');
        $this->set_filter_query($request, $query_response);
        if ($request->get('paid_by') != null) {
            $query_response->where('bookings.payment_method_id', $request->get('paid_by'));
        }
        $bookings_response = $query_response->get();
        
        


        return view('auth.user.reports.booking_report', compact('bookings'), $data);
    }
    
    
    public function feedback_report(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/feedback_report';
        $data['reset_url'] = 'reports.feedback_report';
        if ($request->get('esd_id') != null) {
            $data['count'] = 2;

            $query = Booking::latest()->take(300);
        } else {
            $data['count'] = 1;
            $query = Booking::latest()->take(1);
        }

        $this->set_filter_query($request, $query);
        if ($request->get('paid_by') != null) {
            $query->where('bookings.payment_method_id', $request->get('paid_by'));
        }
        $bookings = $query->get();
        
        
        
        $query_summary = Booking::selectRaw('count(is_feedback_sent) as count, is_feedback_sent')->groupBy('is_feedback_sent');
        $this->set_filter_query($request, $query_summary);
        if ($request->get('paid_by') != null) {
            $query_summary->where('bookings.payment_method_id', $request->get('paid_by'));
        }
        $bookings_summary = $query_summary->get();
        
        
        $query_response = Booking::selectRaw('count(feedback_value) as count, feedback_value')->whereNotNull('feedback_value')->orderBy('count', 'DESC')->groupBy('feedback_value');
        $this->set_filter_query($request, $query_response);
        if ($request->get('paid_by') != null) {
            $query_response->where('bookings.payment_method_id', $request->get('paid_by'));
        }
        $bookings_response = $query_response->get();
        
        
        return view('auth.user.reports.feedback_report', compact('bookings', 'bookings_summary', 'bookings_response'), $data);
    }
    
    public function source_report(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/source_report';
        $data['reset_url'] = 'reports.source_report';
    
        $data['start_date'] = $request->input('start_date', '');
        $data['end_date'] = $request->input('end_date', '');
    
          $findUsCounts = PaymentTransaction::selectRaw("UPPER(REPLACE(find_us, ' ', '')) as find_us, COUNT(*) as count")
        ->whereNotNull('find_us');
    
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $findUsCounts->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
        }
    
        if (!empty($request->e_id)) {
            $data['e_id'] = $request->e_id;
            $findUsCounts->where('event_id', $request->e_id);
        } else {
            $data['e_id'] = '';
        }
    
        $records = $findUsCounts->groupBy('find_us')->get();
       
        return view('auth.user.reports.source_report', compact('records'), $data);
    }
    
    
    public function analytics_summary(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/analytics_summary';
        $data['reset_url'] = 'reports.analytics_summary';
    
        $data['start_date'] = $request->input('start_date', '');
        $data['end_date'] = $request->input('end_date', '');
        
        $utm_sources = Booking::select('utm_source')->distinct()->whereNotNull('utm_source')->get();
        $utm_mediums = Booking::select('utm_medium')->distinct()->whereNotNull('utm_medium')->get();
        $utm_campaigns = Booking::select('utm_campaign')->distinct()->whereNotNull('utm_campaign')->get();
        
        $data['utm_sources'] = $utm_sources;
        $data['utm_mediums'] = $utm_mediums;
        $data['utm_campaigns'] = $utm_campaigns;

    
        // Extract filters from the request
        $utmSource = $request->input('utm_source');         // Example: 'Website'
        $utmMedium = $request->input('utm_medium');         // Example: 'button'
        $utmCampaign = $request->input('utm_campaign');     // Example: 'HomepagePromotion'
        $e_id = $request->input('e_id');             // Example: 123
        $startDate = $request->input('start_date');         // Example: '2024-12-01'
        $endDate = $request->input('end_date');             // Example: '2024-12-31'
    
        // Build the query using the Booking model
        $query = Booking::select(
            'utm_source',
            'utm_medium',
            'utm_campaign',
            DB::raw('count(id) as total_booking'),
            DB::raw('SUM(total_quantity) as total_quantity'),
            DB::raw('SUM(grand_total) as grand_total')
        );
    
        // Apply filters dynamically
        if ($utmSource) {
            $query->where('utm_source', $utmSource);
        }
    
        if ($utmMedium) {
            $query->where('utm_medium', $utmMedium);
        }
    
        if ($utmCampaign) {
            $query->where('utm_campaign', $utmCampaign);
        }
    
        if ($e_id) {
            $data['e_id'] = $request->e_id;
            $query->where('event_id', $e_id);
        } else {
            $data['e_id'] = '';
        }
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }
        $query->whereNotNull('utm_source');
        $query->groupBy('utm_source', 'utm_medium', 'utm_campaign');
        $records = $query->get();



        $visitor_stats = VisitorLog::selectRaw('
            COUNT(*) as traffic_count, 
            SUM(amount) as total_business, 
            SUM(tickets) as total_tickets, 
            utm_source, 
            utm_medium, 
            utm_campaign
        ')
        ->groupBy('utm_source', 'utm_medium', 'utm_campaign')
        ->orderByDesc('traffic_count', 'utm_source')
        ->get();
        
        
          $visitor_stats2 = VisitorLog::selectRaw('
            COUNT(*) as traffic_count, 
            SUM(amount) as total_business, 
            SUM(tickets) as total_tickets, 
            utm_source
        ')
        ->groupBy('utm_source')
        ->orderByDesc('traffic_count', 'utm_source')
        ->get();
        
        
        
       $visitor_stats3 = VisitorLog::selectRaw('
            COUNT(DISTINCT ip_address) as unique_traffic_count, 
            SUM(amount) as total_business, 
            SUM(tickets) as total_tickets, 
            utm_source
        ')
        ->groupBy('utm_source')
        ->orderByDesc('unique_traffic_count')
        ->get();
    
        return view('auth.user.reports.analytics_summary', compact('records', 'visitor_stats', 'visitor_stats2', 'visitor_stats3'), $data);
    }


    
    
    public function general_feedback_report(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/general_feedback_report';
        $data['reset_url'] = 'reports.general_feedback_report';
    
        // Initialize start_date and end_date from the request or set default values
        $data['start_date'] = $request->input('start_date', '');
        $data['end_date'] = $request->input('end_date', '');
    
        // Start building the query
        $query_response = GeneralFeedback::selectRaw('count(feedback) as count, feedback')
            ->groupBy('feedback');
    
        // Apply date filtering if start_date and end_date are provided
        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $query_response->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
             $feedback_counts = $query_response->get();
        }
        else
        {
            $feedback_counts = [];
        }
    
        // Execute the query
       
        
        
      
        // Apply date filtering if start_date and end_date are provided
        if (!empty($data['start_date']) && !empty($data['end_date']))
        {
            $feedbacks = GeneralFeedback::query();
            $feedbacks->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
            $feedbacks = $feedbacks->get();
        }
        else
        {
            $feedbacks = [];
        }
        
        // Retrieve the filtered feedbacks
       
    
    
    
        return view('auth.user.reports.general_feedback_report', compact('feedback_counts', 'feedbacks'), $data);
    }



    public function booking_detail_report(Request $request, $id)
    {
        $booking = Booking::where('id', $id)->first();
        $booking_details = BookingDetail::where('booking_id', $id)->get();
        $booking_payment = BookingPayment::where('booking_id', $id)->first();

        return view('auth.user.reports.booking_detail_report', compact('booking', 'booking_details', 'booking_payment'));
    }

    public function print_ticket(Request $request, $id)
    {
        $booking = Booking::where('id', $id)->first();
        $booking_details = BookingDetail::where('booking_id', $id)->orderBy('seat_id', 'asc')->get();
        $booking_payment = BookingPayment::where('booking_id', $id)->first();

        return view('auth.user.reports.print_ticket', compact('booking', 'booking_details', 'booking_payment'));
    }

    public function payment_mode(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/payment_mode';
        $data['reset_url'] = 'reports.payment_mode';

        if (isset($request->e_id) && $request->e_id != null) {
            $data['e_id'] = $request->e_id;
        } else {
            $data['e_id'] = '';
        }

        $query = Booking::join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
            ->select('bookings.*', 'booking_payments.id as booking_payment_id', 'booking_payments.*', DB::raw('SUM(booking_payments.amount) as total_amount'))
            ->groupBy('booking_payments.payment_method_id');

        $this->set_filter_query($request, $query);

        $bookings = $query->get();

        return view('auth.user.reports.payment_mode_report', compact('bookings'), $data);
    }

    public function ticket_sale(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/ticket_sale';
        $data['reset_url'] = 'reports.ticket_sale';

        if (isset($request->e_id) && $request->e_id != null) {
            $data['e_id'] = $request->e_id;
        } else {
            $data['e_id'] = '';
        }

        $query = Booking::join('booking_details', 'booking_details.booking_id', '=', 'bookings.id')
            ->select('bookings.*', 'booking_details.id as booking_detail_id', 'booking_details.*', DB::raw('SUM(booking_details.base_price) as total_base_price'), DB::raw('SUM(booking_details.discount) as total_discount'), DB::raw('COUNT(booking_details.id) as total_count'))
            ->groupBy('booking_details.ticket_type_id');

        $this->set_filter_query($request, $query);

        $bookings = $query->get();

        return view('auth.user.reports.ticket_sale_report', compact('bookings'), $data);
    }

    public function booking_type(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/booking_type';
        $data['reset_url'] = 'reports.booking_type';

        if (isset($request->e_id) && $request->e_id != null) {
            $data['e_id'] = $request->e_id;
        } else {
            $data['e_id'] = '';
        }

        $query = Booking::join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
            ->select('bookings.*', 'booking_payments.id as booking_payment_id', 'booking_payments.*', DB::raw('SUM(booking_payments.amount) as total_amount'))
            ->groupBy('bookings.customer_id', 'booking_payments.payment_method_id');

        $this->set_filter_query($request, $query);

        $bookings = $query->get();

        return view('auth.user.reports.booking_type_report', compact('bookings'), $data);
    }

    
    public function cashier_shift_summary(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/cashier_shift_summary';
        $data['reset_url'] = 'reports.cashier_shift_summary';
    
        $role_id = Auth::user()->role_id;
        $role_data = Role::find($role_id);
        $data['is_admin'] = $role_data->is_admin;
        $is_admin = $role_data->is_admin;
    
        $today = date('Y-m-d');
    
        // Set default date values
        $start_date = $request->start_date ?? $today;
        $end_date = $request->end_date ?? $today;
    
        // Restrict non-admins from selecting past dates
        if ($is_admin == 0 && $start_date < $today) {
            return redirect()->back()->with('error', 'You are not allowed to select a date earlier than today.');
        }
    
        // Send the dates to the view
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
    
        // Get active events
        $events = Event::where('status', 'ACTIVE')
            ->orderBy('id', 'DESC')
            ->get();
    
        $data['e_id'] = $request->e_id ?? '';
    
        // First query: payment method breakdown
        $query = Booking::join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
            ->select(
                'booking_payments.payment_method_id',
                'booking_payments.amount',
                DB::raw('SUM(booking_payments.amount) as total_amount'),
                DB::raw('SUM(bookings.grand_total) as total_amount1'),
                DB::raw('SUM(bookings.discount) as total_discount')
            )
            ->whereNull('booking_payments.deleted_at')
            ->groupBy('booking_payments.payment_method_id')
            ->whereRaw('DATE(bookings.created_at) >= ? AND DATE(bookings.created_at) <= ?', [$start_date, $end_date]);
    
        $this->set_filter_query($request, $query);
        $bookings = $query->get();
    
        // Second query: vendor data
        $query1 = Booking::select('bookings.vendor_id', 'bookings.created_at')
            ->groupBy('bookings.vendor_id')
            ->whereRaw('DATE(bookings.created_at) >= ? AND DATE(bookings.created_at) <= ?', [$start_date, $end_date]);
    
        $this->set_filter_query($request, $query1);
        $vendor_data = $query1->get();
    
        return view('auth.user.reports.cashier_shift_summary', compact('events', 'bookings', 'vendor_data'), $data);
    }

    
    public function cashier_shift_summary_multiple_day(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/cashier_shift_summary_multiple_day';
        $data['reset_url'] = 'reports.cashier_shift_summary_multiple_day';

        $events = Event::where('status', 'ACTIVE')
            ->orderBy('id', 'DESC')
            ->get();

        if (isset($request->e_id) && $request->e_id != null) {
            $data['e_id'] = $request->e_id;
        } else {
            $data['e_id'] = '';
        }

        if (!empty($request->start_date)) {
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            
            
            $startDate = new Carbon( $data['start_date']);
            $endDate = new Carbon($data['end_date']);
            $all_dates = array();
            while ($startDate->lte($endDate)){
                $all_dates[] = $startDate->toDateString();
                $startDate->addDay();
            }
            $data['all_dates'] = $all_dates;

        } else {
            $data['start_date'] = '';
            $data['all_dates'] = '';
            $data['end_date'] = '';
        }

        if (!empty($request->start_date)) {
            $query = Booking::join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
                ->select('booking_payments.payment_method_id', 'booking_payments.amount', DB::raw('SUM(booking_payments.amount) as total_amount'), DB::raw('SUM(bookings.grand_total) as total_amount1'), DB::raw('SUM(bookings.discount) as total_discount'))
                ->whereNull('booking_payments.deleted_at')
                ->groupBy('booking_payments.payment_method_id')
                // ->groupBy(DB::raw('Date(bookings.created_at)'))
                ->whereRaw('(date(bookings.created_at) >= ? AND date(bookings.created_at )<= ?)', [$request->start_date, $request->end_date]);
        } else {
            $query = Booking::join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
                ->select('booking_payments.payment_method_id', 'booking_payments.amount', DB::raw('SUM(booking_payments.amount) as total_amount'), DB::raw('SUM(bookings.grand_total) as total_amount1'), DB::raw('SUM(bookings.discount) as total_discount'))
                ->whereNull('booking_payments.deleted_at')
                ->groupBy('booking_payments.payment_method_id');
        }
        $this->set_filter_query($request, $query);

        // dd($query->toSql());
        
        $bookings = $query->get();

        if (!empty($request->start_date)) {
            $query1 = Booking::select('bookings.vendor_id', 'bookings.created_at')
                ->groupBy('bookings.vendor_id')
                ->whereRaw('(date(bookings.created_at) >= ? AND date(bookings.created_at) <= ?)', [$request->start_date, $request->end_date]);
            $this->set_filter_query($request, $query1);
            $vendor_data = $query1->get();
        } else {
            $query1 = Booking::select('bookings.vendor_id', 'bookings.created_at')->groupBy('bookings.vendor_id');
            $this->set_filter_query($request, $query1);
            $vendor_data = $query1->get();
        }

        return view('auth.user.reports.cashier_shift_summary_multiple_day', compact('events', 'bookings', 'vendor_data'), $data);
    }

    public function cashier_shift_summary_vs_payment(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/cashier_shift_summary_vs_payment';
        $data['reset_url'] = 'reports.cashier_shift_summary_vs_payment';
 
        
        // Active events
        $events = Event::where('status', 'ACTIVE')->orderBy('id', 'DESC')->get();
        $data['e_id'] = $request->e_id ?? '';
        
        $today = date('Y-m-d');
        
        $event_schedule = EventSchedule::where('status', 'ACTIVE')->where('event_id', $events[0]->id)->orderBy('id', 'DESC')->first();
        $start_date = $event_schedule->start_date ?? $today;;
        $end_date = $event_schedule->end_date ?? $today;
        
        
        
        $start_date = $request->start_date ?? $start_date;
        $end_date = $request->end_date ?? $end_date;
    
      
    
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
    
        
        
    
        // Prepare list of all dates between start and end
        $startDate = Carbon::parse($start_date);
        $endDate = Carbon::parse($end_date);
        $all_dates = [];
    
        while ($startDate->lte($endDate)) {
            $all_dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
    
        $data['all_dates'] = $all_dates;
    
        // Prepare custom SQL
        if (!empty($data['e_id'])) {
            $custom_sql = "
                SELECT pay_date,
                    SUM(IF(payment_method_id = '1', total_amount - total_discount, 0)) AS UPI,
                    SUM(IF(payment_method_id = '2', total_amount - total_discount, 0)) AS Cash,
                    SUM(IF(payment_method_id = '3', total_amount - total_discount, 0)) AS Barter,
                    SUM(IF(payment_method_id = '4', total_amount - total_discount, 0)) AS DiscountCash,
                    SUM(IF(payment_method_id = '5', total_amount - total_discount, 0)) AS DiscountUPI,
                    SUM(IF(payment_method_id = '6', total_amount - total_discount, 0)) AS Complementry,
                    SUM(IF(payment_method_id = '7', total_amount - total_discount, 0)) AS BookMyShow,
                    SUM(IF(payment_method_id = '8', total_amount - total_discount, 0)) AS Website,
                    SUM(IF(payment_method_id = '9', total_amount - total_discount, 0)) AS Insider
                FROM (
                    SELECT DATE(booking_payments.created_at) AS pay_date,
                           booking_payments.payment_method_id,
                           SUM(booking_payments.amount) AS total_amount,
                           SUM(bookings.discount) AS total_discount
                    FROM bookings
                    INNER JOIN booking_payments ON booking_payments.booking_id = bookings.id
                    WHERE booking_payments.deleted_at IS NULL
                      AND bookings.deleted_at IS NULL
                      AND bookings.event_id = {$data['e_id']}
                      AND booking_payments.created_at >= '{$start_date} 00:00:00'
                      AND booking_payments.created_at <= '{$end_date} 23:59:59'
                    GROUP BY booking_payments.payment_method_id, DATE(booking_payments.created_at)
                    ORDER BY pay_date, payment_method_id ASC
                ) AS t
                GROUP BY pay_date;
            ";
        } else {
            $custom_sql = "
                SELECT pay_date,
                    SUM(IF(payment_method_id = '1', total_amount, 0)) AS UPI,
                    SUM(IF(payment_method_id = '2', total_amount, 0)) AS Cash,
                    SUM(IF(payment_method_id = '3', total_amount, 0)) AS Barter,
                    SUM(IF(payment_method_id = '4', total_amount, 0)) AS DiscountCash,
                    SUM(IF(payment_method_id = '5', total_amount, 0)) AS DiscountUPI,
                    SUM(IF(payment_method_id = '6', total_amount, 0)) AS Complementry,
                    SUM(IF(payment_method_id = '7', total_amount, 0)) AS BookMyShow,
                    SUM(IF(payment_method_id = '8', total_amount, 0)) AS Website,
                    SUM(IF(payment_method_id = '9', total_amount, 0)) AS Insider
                FROM (
                    SELECT DATE(booking_payments.created_at) AS pay_date,
                           booking_payments.payment_method_id,
                           SUM(booking_payments.amount) AS total_amount
                    FROM bookings
                    INNER JOIN booking_payments ON booking_payments.booking_id = bookings.id
                    WHERE booking_payments.deleted_at IS NULL
                      AND bookings.deleted_at IS NULL
                      AND booking_payments.created_at >= '{$start_date} 00:00:00'
                      AND booking_payments.created_at <= '{$end_date} 23:59:59'
                    GROUP BY booking_payments.payment_method_id, DATE(booking_payments.created_at)
                    ORDER BY pay_date, payment_method_id ASC
                ) AS t
                GROUP BY pay_date;
            ";
        }
        
        
        if (!empty($data['e_id'])) {
            $custom_sql1 = "
                SELECT pay_date,
                    SUM(IF(payment_method_id = '1', total_amount - total_discount, 0)) AS UPI,
                    SUM(IF(payment_method_id = '2', total_amount - total_discount, 0)) AS Cash,
                    SUM(IF(payment_method_id = '3', total_amount - total_discount, 0)) AS Barter,
                    SUM(IF(payment_method_id = '4', total_amount - total_discount, 0)) AS DiscountCash,
                    SUM(IF(payment_method_id = '5', total_amount - total_discount, 0)) AS DiscountUPI,
                    SUM(IF(payment_method_id = '6', total_amount - total_discount, 0)) AS Complementry,
                    SUM(IF(payment_method_id = '7', total_amount - total_discount, 0)) AS BookMyShow,
                    SUM(IF(payment_method_id = '8', total_amount - total_discount, 0)) AS Website,
                    SUM(IF(payment_method_id = '9', total_amount - total_discount, 0)) AS Insider
                FROM (
                    SELECT DATE(booking_payments.created_at) AS pay_date,
                           booking_payments.payment_method_id,
                           SUM(booking_payments.amount) AS total_amount,
                           SUM(bookings.discount) AS total_discount
                    FROM bookings
                    INNER JOIN booking_payments ON booking_payments.booking_id = bookings.id
                    WHERE booking_payments.deleted_at IS NULL
                      AND bookings.deleted_at IS NULL
                      AND bookings.event_id = {$data['e_id']}
                      AND booking_payments.created_at >= '{$start_date} 00:00:00'
                      AND booking_payments.created_at <= '{$end_date} 23:59:59'
                    GROUP BY booking_payments.payment_method_id, DATE(booking_payments.created_at)
                    ORDER BY pay_date, payment_method_id ASC
                ) AS t;
            ";
        } else {
            $custom_sql1 = "
                SELECT pay_date,
                    SUM(IF(payment_method_id = '1', total_amount, 0)) AS UPI,
                    SUM(IF(payment_method_id = '2', total_amount, 0)) AS Cash,
                    SUM(IF(payment_method_id = '3', total_amount, 0)) AS Barter,
                    SUM(IF(payment_method_id = '4', total_amount, 0)) AS DiscountCash,
                    SUM(IF(payment_method_id = '5', total_amount, 0)) AS DiscountUPI,
                    SUM(IF(payment_method_id = '6', total_amount, 0)) AS Complementry,
                    SUM(IF(payment_method_id = '7', total_amount, 0)) AS BookMyShow,
                    SUM(IF(payment_method_id = '8', total_amount, 0)) AS Website,
                    SUM(IF(payment_method_id = '9', total_amount, 0)) AS Insider
                FROM (
                    SELECT DATE(booking_payments.created_at) AS pay_date,
                           booking_payments.payment_method_id,
                           SUM(booking_payments.amount) AS total_amount
                    FROM bookings
                    INNER JOIN booking_payments ON booking_payments.booking_id = bookings.id
                    WHERE booking_payments.deleted_at IS NULL
                      AND bookings.deleted_at IS NULL
                      AND booking_payments.created_at >= '{$start_date} 00:00:00'
                      AND booking_payments.created_at <= '{$end_date} 23:59:59'
                    GROUP BY booking_payments.payment_method_id, DATE(booking_payments.created_at)
                    ORDER BY pay_date, payment_method_id ASC
                ) AS t;
            ";
        }
        
        
    
        $bookings = DB::select($custom_sql);
        $booking_total = DB::select($custom_sql1);
    
        // Vendor data (optional)
        $query1 = Booking::select('bookings.vendor_id', 'bookings.created_at')
            ->groupBy('bookings.vendor_id')
            ->whereRaw('DATE(bookings.created_at) >= ? AND DATE(bookings.created_at) <= ?', [$start_date, $end_date]);
    
        $this->set_filter_query($request, $query1);
        $vendor_data = $query1->get();
    
        return view('auth.user.reports.cashier_shift_vs_payment_summary', compact('events', 'bookings', 'booking_total',  'vendor_data'), $data);
    }



    public function individual_cashier_shift_summary(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/individual_cashier_shift_summary';
        $data['reset_url'] = 'reports.individual_cashier_shift_summary';

        $events = Event::where('status', 'ACTIVE')
            ->orderBy('id', 'DESC')
            ->get();

        if (isset($request->e_id) && $request->e_id != null) {
            $data['e_id'] = $request->e_id;
        } else {
            $data['e_id'] = '';
        }

        if (!empty($request->start_date)) {
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
        } else {
            $data['start_date'] = '';
            $data['end_date'] = '';
        }

        if (!empty($request->start_date)) {
            $query = Booking::join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
                ->select('booking_payments.payment_method_id', 'booking_payments.amount', DB::raw('SUM(booking_payments.amount) as total_amount'), DB::raw('SUM(bookings.grand_total) as total_amount1'), DB::raw('SUM(bookings.discount) as total_discount'))
                ->whereNull('booking_payments.deleted_at')
                ->groupBy('booking_payments.payment_method_id')
                ->whereRaw('(date(bookings.created_at) >= ? AND date(bookings.created_at )<= ?)', [$request->start_date, $request->end_date]);
        } else {
            $query = Booking::join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
                ->select('booking_payments.payment_method_id', 'booking_payments.amount', DB::raw('SUM(booking_payments.amount) as total_amount'), DB::raw('SUM(bookings.grand_total) as total_amount1'), DB::raw('SUM(bookings.discount) as total_discount'))
                ->whereNull('booking_payments.deleted_at')
                ->groupBy('booking_payments.payment_method_id');
        }
        $this->set_filter_query($request, $query);

        $user_id = Auth::user()->id;
        $query->where('bookings.vendor_id', $user_id);

        $bookings = $query->get();

        if (!empty($request->start_date)) {
            $query1 = Booking::select('bookings.vendor_id', 'bookings.created_at')
                ->groupBy('bookings.vendor_id')
                ->whereRaw('(date(bookings.created_at) >= ? AND date(bookings.created_at) <= ?)', [$request->start_date, $request->end_date]);
            $this->set_filter_query($request, $query1);
            $query1->where('bookings.vendor_id', $user_id);
            $vendor_data = $query1->get();
        } else {
            $query1 = Booking::select('bookings.vendor_id', 'bookings.created_at')->groupBy('bookings.vendor_id');
            $this->set_filter_query($request, $query1);
            $query1->where('bookings.vendor_id', $user_id);
            $vendor_data = $query1->get();
        }

        return view('auth.user.reports.individual_cashier_shift_summary', compact('events', 'bookings', 'vendor_data'), $data);
    }

    public function cashier_shift_summary_show_wise(Request $request)
    {
        $event_days = $request->input('event_day', []);
       
        $data = [];
        $data['form_url'] = 'reports/cashier_shift_summary_show_wise';
        $data['reset_url'] = 'reports.cashier_shift_summary_show_wise';

        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['event_id'] = $request->event_id;
        $data['Filter'] = $request->Filter;
        $data['event_day'] = $event_days;
        $data['event_show_time_id_get'] = $request->event_show_time_id;

        $sale_sum = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\') ,  \' \',`event_show_time`.`start_time`) AS event_show'), DB::raw('SUM(bookings.total_quantity) as total_ticket_quantity'), DB::raw('SUM(bookings.paid_amount) as total_paid_amount'), DB::raw('SUM(bookings.discount) as total_discount'), DB::raw('SUM(bookings.grand_total) as total_grand_total'))
            ->groupBy('bookings.event_schedule_list_id')
            ->groupBy('bookings.event_show_time_id')
            ->groupBy('bookings.payment_method_id');

        $sale_sum_total = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('SUM(bookings.paid_amount) as total_grand_total'))
            ->groupBy('bookings.payment_method_id');

        $ticket_sum = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\') ,  \' \',`event_show_time`.`start_time`) AS event_show'), DB::raw('SUM(bookings.total_quantity) as total_ticket_quantity'))
            ->groupBy('bookings.event_schedule_list_id')
            ->groupBy('bookings.event_show_time_id')
            ->groupBy('bookings.payment_method_id');

        $ticket_sum_total = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('SUM(bookings.total_quantity) as total_ticket_quantity'))
            ->groupBy('bookings.payment_method_id');

        $ticket_count = Booking::join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->join('ticket_type', 'ticket_type.id', '=', 'booking_details.ticket_type_id')
            ->select('ticket_type.ticket_type_name as name', 'ticket_type.id', DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\') ,  \' \',`event_show_time`.`start_time`) AS event_show'), DB::raw('event_schedule_list.id as event_schedule_list_id, event_show_time.id as event_show_time_id'), DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'))
            ->whereNull('bookings.deleted_at')
            ->groupBy('bookings.event_schedule_list_id')
            ->groupBy('bookings.event_show_time_id')
            ->groupBy('booking_details.ticket_type_id');

        $ticket_sum_count = TicketType::join('booking_details', 'ticket_type.id', '=', 'booking_details.ticket_type_id')
            ->join('bookings', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('ticket_type.ticket_type_name as name', 'ticket_type.id', DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'))
            ->whereNull('bookings.deleted_at')
            ->groupBy('booking_details.ticket_type_id');

        if (!empty($request->start_date)) {
            $sale_sum = $sale_sum->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $sale_sum_total = $sale_sum_total->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_sum = $ticket_sum->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_sum_total = $ticket_sum_total->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_count = $ticket_count->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_sum_count = $ticket_sum_count->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
        }

        if (!empty($request->event_show_time_id)) {
            $sale_sum = $sale_sum->where('bookings.event_show_time_id', $request->event_show_time_id);
            $sale_sum_total = $sale_sum_total->where('bookings.event_show_time_id', $request->event_show_time_id);
            $ticket_sum = $ticket_sum->where('bookings.event_show_time_id', $request->event_show_time_id);
            $ticket_sum_total = $ticket_sum_total->where('bookings.event_show_time_id', $request->event_show_time_id);
            $ticket_count = $ticket_count->where('bookings.event_show_time_id', $request->event_show_time_id);
            $ticket_sum_count = $ticket_sum_count->where('bookings.event_show_time_id', $request->event_show_time_id);
        }

       /* if (!empty($request->event_day)) {
            $sale_sum = $sale_sum->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $sale_sum_total = $sale_sum_total->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_sum = $ticket_sum->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_sum_total = $ticket_sum_total->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_count = $ticket_count->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_sum_count = $ticket_sum_count->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
        }
*/


// print_r($event_days);

// exit;
        if (!empty($request->event_day)) {
            // Apply the filter for multiple days using whereIn
            $sale_sum = $sale_sum->whereIn(DB::raw("DATE_FORMAT(event_schedule_list.event_date, '%W')"), $event_days);
            $sale_sum_total = $sale_sum_total->whereIn(DB::raw("DATE_FORMAT(event_schedule_list.event_date, '%W')"), $event_days);
            $ticket_sum = $ticket_sum->whereIn(DB::raw("DATE_FORMAT(event_schedule_list.event_date, '%W')"), $event_days);
            $ticket_sum_total = $ticket_sum_total->whereIn(DB::raw("DATE_FORMAT(event_schedule_list.event_date, '%W')"), $event_days);
            $ticket_count = $ticket_count->whereIn(DB::raw("DATE_FORMAT(event_schedule_list.event_date, '%W')"), $event_days);
            $ticket_sum_count = $ticket_sum_count->whereIn(DB::raw("DATE_FORMAT(event_schedule_list.event_date, '%W')"), $event_days);
        }


        $sale_sum_data = $sale_sum->get();
        $sale_sum_total = $sale_sum_total->get();
        $ticket_sum_data = $ticket_sum->get();
        $ticket_sum_total = $ticket_sum_total->get();
        $ticket_count = $ticket_count->get();

        $ticket_sum_count = $ticket_sum_count->get();

        $events = Event::get()->sortByDesc('created_at');

        return view('auth.user.reports.cashier_shift_summary_show_wise', compact('sale_sum_data', 'sale_sum_total', 'ticket_sum_data', 'ticket_sum_total', 'ticket_count', 'ticket_sum_count', 'events'), $data);
    }
    
     public function scan_summary_show_wise(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/scan_summary_show_wise';
        $data['reset_url'] = 'reports.scan_summary_show_wise';

        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['event_id'] = $request->event_id;
        $data['Filter'] = $request->Filter;
        $data['event_day'] = $request->event_day;
        $data['event_show_time_id_get'] = $request->event_show_time_id;
        $data['u_id'] =  $request->u_id;
        $role_id = Auth::user()->role_id;
        $role_data = Role::find($role_id);
        $data['is_admin'] = $role_data->is_admin;
        $users_data = User::all();
       

            
        $sale_sum = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->join('booking_details', 'booking_details.booking_id', '=', 'bookings.id') // join booking_details to get ticket quantities
            ->select(
                'payment_method.name',
                'payment_method.id',
                'payment_method.method_group',
                DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\') ,  \' \',`event_show_time`.`start_time`) AS event_show'),
                DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'), // Total quantity
                DB::raw('SUM(CASE WHEN booking_details.is_scanned = 1 THEN booking_details.quantity ELSE 0 END) as scanned_ticket_quantity'), // Scanned quantity
                DB::raw('SUM(bookings.paid_amount) as total_paid_amount'), // Sum of paid amounts
                DB::raw('SUM(bookings.discount) as total_discount'), // Sum of discounts
                DB::raw('SUM(bookings.grand_total) as total_grand_total') // Sum of grand total
            )
            ->whereNull('bookings.deleted_at')
            ->groupBy('bookings.event_schedule_list_id')
            ->groupBy('bookings.event_show_time_id')
            ->groupBy('bookings.payment_method_id');
    
        $sale_sum_total = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->join('booking_details', 'booking_details.booking_id', '=', 'bookings.id') // Join booking_details for ticket data
            ->select(
                'payment_method.name',
                'payment_method.id',
                'payment_method.method_group',
                DB::raw('SUM(bookings.paid_amount) as total_grand_total'), // Sum of paid amounts
                DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'), // Total ticket quantity
                DB::raw('SUM(CASE WHEN booking_details.is_scanned = 1 THEN booking_details.quantity ELSE 0 END) as scanned_ticket_quantity') // Scanned ticket quantity
            )
            ->whereNull('bookings.deleted_at')
            ->groupBy('bookings.payment_method_id');

            
        $ticket_sum = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->join('booking_details', 'booking_details.booking_id', '=', 'bookings.id') // join booking_details for quantity
            ->select(
                'payment_method.name',
                'payment_method.id',
                'payment_method.method_group',
                DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\') ,  \' \',`event_show_time`.`start_time`) AS event_show'),
                DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'), // Total quantity
                DB::raw('SUM(CASE WHEN booking_details.is_scanned = 1 THEN booking_details.quantity ELSE 0 END) as scanned_ticket_quantity') // Scanned quantity
            )
            ->whereNull('bookings.deleted_at')
            ->groupBy('bookings.event_schedule_list_id')
            ->groupBy('bookings.event_show_time_id')
            ->groupBy('bookings.payment_method_id');
    

        // $ticket_sum_total = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
        //     ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
        //     ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
        //     ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('SUM(bookings.total_quantity) as total_ticket_quantity'))
        //     ->groupBy('bookings.payment_method_id');
        
        
        $ticket_sum_total = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->join('booking_details', 'booking_details.booking_id', '=', 'bookings.id') // Join booking_details for ticket data
            ->select(
                'payment_method.name',
                'payment_method.id',
                'payment_method.method_group',
                DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'), // Total ticket quantity
                DB::raw('SUM(CASE WHEN booking_details.is_scanned = 1 THEN booking_details.quantity ELSE 0 END) as scanned_ticket_quantity') // Scanned ticket quantity
            )
            ->whereNull('bookings.deleted_at')
            ->groupBy('bookings.payment_method_id');

            
      $ticket_count = Booking::join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
        ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
        ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
        ->join('ticket_type', 'ticket_type.id', '=', 'booking_details.ticket_type_id')
        ->select(
            'ticket_type.ticket_type_name as name', 
            'ticket_type.id', 
            DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\') ,  \' \',`event_show_time`.`start_time`) AS event_show'), 
            DB::raw('event_schedule_list.id as event_schedule_list_id, event_show_time.id as event_show_time_id'), 
            DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'),
            DB::raw('SUM(CASE WHEN booking_details.is_scanned = 1 THEN booking_details.quantity ELSE 0 END) as scanned_ticket_quantity')
        )
        ->whereNull('bookings.deleted_at')
        ->groupBy('bookings.event_schedule_list_id')
        ->groupBy('bookings.event_show_time_id')
        ->groupBy('booking_details.ticket_type_id');
        
            

        $ticket_sum_count = TicketType::join('booking_details', 'ticket_type.id', '=', 'booking_details.ticket_type_id')
            ->join('bookings', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('ticket_type.ticket_type_name as name', 'ticket_type.id', 
                        DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'), 
                        DB::raw('SUM(CASE WHEN booking_details.is_scanned = 1 THEN booking_details.quantity ELSE 0 END) as scanned_ticket_quantity') )
            ->whereNull('bookings.deleted_at')
            ->groupBy('booking_details.ticket_type_id');
        
        



        if (!empty($request->start_date)) {
            $sale_sum = $sale_sum->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $sale_sum_total = $sale_sum_total->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_sum = $ticket_sum->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_sum_total = $ticket_sum_total->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_count = $ticket_count->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_sum_count = $ticket_sum_count->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
        }

        if (!empty($request->event_show_time_id)) {
            $sale_sum = $sale_sum->where('bookings.event_show_time_id', $request->event_show_time_id);
            $sale_sum_total = $sale_sum_total->where('bookings.event_show_time_id', $request->event_show_time_id);
            $ticket_sum = $ticket_sum->where('bookings.event_show_time_id', $request->event_show_time_id);
            $ticket_sum_total = $ticket_sum_total->where('bookings.event_show_time_id', $request->event_show_time_id);
            $ticket_count = $ticket_count->where('bookings.event_show_time_id', $request->event_show_time_id);
            $ticket_sum_count = $ticket_sum_count->where('bookings.event_show_time_id', $request->event_show_time_id);
        }

        if (!empty($request->event_day)) {
            $sale_sum = $sale_sum->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $sale_sum_total = $sale_sum_total->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_sum = $ticket_sum->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_sum_total = $ticket_sum_total->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_count = $ticket_count->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_sum_count = $ticket_sum_count->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
        }
        
        if (!empty($request->u_id)) {
            $sale_sum = $sale_sum->where('booking_details.scanned_by', $request->u_id);
            $sale_sum_total = $sale_sum_total->where('booking_details.scanned_by', $request->u_id);
            $ticket_sum = $ticket_sum->where('booking_details.scanned_by', $request->u_id);
            $ticket_sum_total = $ticket_sum_total->where('booking_details.scanned_by', $request->u_id);
            $ticket_count = $ticket_count->where('booking_details.scanned_by', $request->u_id);
            $ticket_sum_count = $ticket_sum_count->where('booking_details.scanned_by', $request->u_id);
        }
        
        

        $sale_sum_data = $sale_sum->get();
        $sale_sum_total = $sale_sum_total->get();
        $ticket_sum_data = $ticket_sum->get();
        $ticket_sum_total = $ticket_sum_total->get();
        $ticket_count = $ticket_count->get();
        
        $ticket_sum_count = $ticket_sum_count->get();
        $events = Event::get()->sortByDesc('created_at');
        return view('auth.user.reports.scan_summary_show_wise', compact('users_data','sale_sum_data', 'sale_sum_total', 'ticket_sum_data', 'ticket_sum_total', 'ticket_count', 'ticket_sum_count', 'events'), $data);
    }

    public function cashier_shift_summary_day_wise(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/cashier_shift_summary_day_wise';
        $data['reset_url'] = 'reports.cashier_shift_summary_day_wise';

        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['event_id'] = $request->event_id;
        $data['Filter'] = $request->Filter;
        $data['event_day'] = $request->event_day;
        $data['event_show_time_id'] = $request->event_show_time_id;

        $sale_sum = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\')) AS event_show'), DB::raw('SUM(bookings.total_quantity) as total_ticket_quantity'), DB::raw('SUM(bookings.paid_amount) as total_paid_amount'), DB::raw('SUM(bookings.discount) as total_discount'), DB::raw('SUM(bookings.grand_total) as total_grand_total'))
            ->groupBy('bookings.event_schedule_list_id')
            ->groupBy('bookings.payment_method_id');

        $sale_sum_total = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('SUM(bookings.paid_amount) as total_grand_total'))
            ->groupBy('bookings.payment_method_id');

        $ticket_sum = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\') ,  \' \',`event_show_time`.`start_time`) AS event_show'), DB::raw('SUM(bookings.total_quantity) as total_ticket_quantity'))
            ->groupBy('bookings.event_schedule_list_id')

            ->groupBy('bookings.payment_method_id');

        $ticket_sum_total = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('SUM(bookings.total_quantity) as total_ticket_quantity'))
            ->groupBy('bookings.payment_method_id');

        $ticket_count = Booking::join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->join('ticket_type', 'ticket_type.id', '=', 'booking_details.ticket_type_id')
            ->select('ticket_type.ticket_type_name as name', 'ticket_type.id', DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\')) AS event_show'), DB::raw('event_schedule_list.id as event_schedule_list_id, event_show_time.id as event_show_time_id'), DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'))
            ->whereNull('bookings.deleted_at')
            ->groupBy('bookings.event_schedule_list_id')
            ->groupBy('booking_details.ticket_type_id');

        $ticket_sum_count = TicketType::join('booking_details', 'ticket_type.id', '=', 'booking_details.ticket_type_id')
            ->join('bookings', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->select('ticket_type.ticket_type_name as name', 'ticket_type.id', DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'))
            ->whereNull('bookings.deleted_at')
            ->groupBy('booking_details.ticket_type_id');

        if (!empty($request->start_date)) {
            $sale_sum = $sale_sum->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $sale_sum_total = $sale_sum_total->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_sum = $ticket_sum->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_sum_total = $ticket_sum_total->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_count = $ticket_count->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
            $ticket_sum_count = $ticket_sum_count->whereRaw('(date(event_schedule_list.event_date) >= ? AND date(event_schedule_list.event_date)<= ?)', [$request->start_date, $request->end_date]);
        }

        if (!empty($request->event_day)) {
            $sale_sum = $sale_sum->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $sale_sum_total = $sale_sum_total->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_sum = $ticket_sum->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_sum_total = $ticket_sum_total->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_count = $ticket_count->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
            $ticket_sum_count = $ticket_sum_count->whereRaw(" DATE_FORMAT(event_schedule_list.event_date, '%W')= ? ", [$request->event_day]);
        }

        $sale_sum_data = $sale_sum->get();
        $sale_sum_total = $sale_sum_total->get();
        $ticket_sum_data = $ticket_sum->get();
        $ticket_sum_total = $ticket_sum_total->get();

        // echo $ticket_count->toSql();
        
        $ticket_count = $ticket_count->get();


        $ticket_sum_count = $ticket_sum_count->get();
        $events = Event::get()->sortByDesc('created_at');

        return view('auth.user.reports.cashier_shift_summary_day_wise', compact('sale_sum_data', 'sale_sum_total', 'ticket_sum_data', 'ticket_sum_total', 'ticket_count', 'ticket_sum_count', 'events'), $data);
    }

    public function sale_summary(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/sale_summary';
        $data['reset_url'] = 'reports.sale_summary';

        $query = Booking::join('booking_payments', 'booking_payments.booking_id', '=', 'bookings.id')
            ->select('bookings.*', 'booking_payments.id as booking_payment_id', 'booking_payments.*', DB::raw('SUM(booking_payments.amount) as total_amount'))
            ->groupBy('booking_payments.payment_method_id');
        $this->set_filter_query($request, $query);
        $bookings = $query->get();

        $ticket_query = BookingDetail::select('booking_details.*')->groupBy('booking_details.ticket_type_id');

        // $ticket_query =Booking::join('booking_details', 'booking_details.booking_id', '=', 'bookings.id')
        // ->select('booking_details.*','bookings.*')
        // ->groupBy('booking_details.ticket_type_id');

        $ticket_query = BookingDetail::join('bookings', 'booking_details.booking_id', '=', 'bookings.id')
            ->select('booking_details.*', 'bookings.*', DB::raw('SUM(booking_details.quantity) as total_quantity'), DB::raw('SUM(booking_details.base_price) as total_ticket_price'))
            ->groupBy('booking_details.ticket_type_id');

        $this->set_filter_query($request, $ticket_query);
        $tickets = $ticket_query->get();

        // echo $ticket_query->toSql();

        //BookingDetail::select('booking_details.*')->groupBy('booking_details.ticket_type_id');

        $payment_query_complementry = BookingPayment::join('payment_method', 'payment_method.id', '=', 'booking_payments.payment_method_id')
            ->select('payment_method.*', 'booking_payments.payment_method_id', DB::raw('SUM(booking_payments.amount) as totalAmount'))
            //->where('payment_method.show_hide_price', 'HIDE')
            ->groupBy('payment_method.method_type');

        //      $payment_query_complementry = BookingPayment::join('payment_method', 'booking_payments.payment_method_id', '=', 'payment_method.id')
        //      ->join('bookings', 'booking_details.booking_id', '=', 'bookings.id')
        //   ->select('bookings.*','payment_method.*','booking_payments.id as booking_payment_id','booking_payments.*',
        //   DB::raw('SUM(booking_payments.amount) as total_amount'))
        //   ->groupBy('payment_method.method_type');

        //$this->set_filter_query($request, $payment_query_complementry);
        $payments_complementry = $payment_query_complementry->get();

        $payment_query_full = BookingPayment::select('booking_payments.payment_method_id', 'booking_payments.amount', DB::raw('SUM(booking_payments.amount) as totalAmount'));
        $payments_full = $payment_query_full->first();

        return view('auth.user.reports.sale_summary', compact('bookings', 'tickets', 'payments_complementry', 'payments_full'), $data);
    }

    public function cashier_shift_summary_show_wise_ajax(Request $request)
    {
        $event_schedule_list_id = $request->event_schedule_list_id;
        $event_show_time_id = $request->event_show_time_id;
        $ticket_type_id = $request->ticket_type_id;
        $shift_summary = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->join('booking_details', 'booking_details.booking_id', '=', 'bookings.id')
            ->select('payment_method.name', 'payment_method.id', 'payment_method.method_group', DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'))
            ->where('bookings.event_show_time_id', $event_show_time_id)
            ->where('event_schedule_list.id', $event_schedule_list_id)
            ->where('booking_details.ticket_type_id', $ticket_type_id)
            ->groupBy('bookings.payment_method_id');
        $shift_summary = $shift_summary->get();
        return view('auth.user.reports.shift_summary_ajax', compact('shift_summary'));
    }
    
    
    public function scan_summary_show_wise_ajax(Request $request)
    {
        $event_schedule_list_id = $request->event_schedule_list_id;
        $event_show_time_id = $request->event_show_time_id;
        $ticket_type_id = $request->ticket_type_id;
        
        $shift_summary = Booking::join('payment_method', 'bookings.payment_method_id', '=', 'payment_method.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'bookings.event_show_time_id')
            ->join('booking_details', 'booking_details.booking_id', '=', 'bookings.id')
            ->select(
                'payment_method.name',
                'payment_method.id',
                'payment_method.method_group',
                DB::raw('SUM(booking_details.quantity) as total_ticket_quantity'), // Total tickets
                DB::raw('SUM(CASE WHEN booking_details.is_scanned = 1 THEN booking_details.quantity ELSE 0 END) as scanned_ticket_quantity') // Scanned tickets
            )
            ->where('bookings.event_show_time_id', $event_show_time_id)
            ->where('event_schedule_list.id', $event_schedule_list_id)
            ->where('booking_details.ticket_type_id', $ticket_type_id)
            ->groupBy('bookings.payment_method_id');
    
    
        $shift_summary = $shift_summary->get();
        return view('auth.user.reports.scan_summary_ajax', compact('shift_summary'));
    }


    
    public function payment_logs_ajax(Request $request)
    {
        $mobile_no = $request->mobile_no;
        $email_id = $request->email_id;

        $payment_transactions = PaymentLogs::where(function ($query)   use ($mobile_no, $email_id) {
            $query->where('customerPhone', '=', $mobile_no)
                    ->orWhere('customerEmail', '=', $email_id);
        })->orderBy('id', 'DESC');
        $payment_transactions = $payment_transactions->get();



        $customers = Customer::select('id')->where(function ($query)   use ($mobile_no, $email_id) {
            $query->where('mobile_no', '=', $mobile_no)
                    ->orWhere('email', '=', $email_id);
        })->get()->toArray();

        $data['count']=2;
        $bookings=Booking::whereIn('customer_id', $customers)->get();
        return view('auth.user.reports.pg_logs_ajax', compact('payment_transactions', 'bookings'), $data);
    }
    
    
    public function cancelled_booking_report(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/cancelled_booking_report';
        $data['reset_url'] = 'reports.cancelled_booking_report';
       
        $events = Event::where('status', 'ACTIVE')
        ->orderBy('id', 'DESC')
        ->get();

        if (!empty($request->event_id)) {
             $data['count'] = 2;
            $event_id = $request->event_id;
            $data['event_id'] = $request->event_id;
            $bookings = DB::table('bookings')
                ->where('event_id', $event_id)
                ->whereNotNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();
        } else {
             $data['count'] = 1;
            $data['event_id'] = $request->event_id;
            $bookings = DB::table('bookings')
                ->whereNotNull('deleted_at')
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('auth.user.reports.cancelled_booking_report', compact('bookings', 'events'), $data);
    }

    public function pg_transaction_report(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/pg_transaction_report';
        $data['reset_url'] = 'reports.pg_transaction_report';
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['Filter'] = $request->Filter;
        $events = Event::where('status', 'ACTIVE')
            ->orderBy('id', 'DESC')
            ->get();

        $payment_transactions = PaymentTransaction::join('events', 'events.id', '=', 'transactions.event_id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'transactions.event_schedule_list_id')
            ->join('event_show_time', 'event_show_time.id', '=', 'transactions.event_show_time_id')
            ->join('ticket_type', 'ticket_type.id', '=', 'transactions.ticket_type_id')
            ->select('events.event_title as event_name','ticket_type.ticket_type_name as ticket_type_name',
                DB::raw('CONCAT(DATE_FORMAT(`event_schedule_list`.`event_date`,  \'%a, %d-%M-%Y\') ,  \' \',`event_show_time`.`start_time`) AS event_show, transactions.quantity , transactions.name
            , transactions.email, transactions.mobile,  transactions.find_us, transactions.txnid, transactions.pg_txn,  transactions.booked_by_cron,  transactions.amount, transactions.status, transactions.booking_id,  transactions.note, transactions.seat_details, transactions.created_at'),
            );

        if (isset($request->e_id) && $request->e_id != null)
        {
            $data['e_id'] = $request->e_id;
            if (!empty($request->start_date)) 
            {
                $payment_transactions = $payment_transactions->where('transactions.event_id', $request->e_id)->whereRaw('(date(transactions.created_at) >= ? AND date(transactions.created_at)<= ?)', [$request->start_date, $request->end_date])->orderBy('transactions.created_at', 'desc')->get();
            }
            else
            {
                $date = Carbon::now()->subDays(7);
                $payment_transactions = $payment_transactions->where('transactions.event_id', $request->e_id)->whereRaw('(date(transactions.created_at) >= ?)', [$date])->orderBy('transactions.created_at', 'desc')->get();
            }
            
        } else {
            $data['e_id'] = '';
            // $payment_transactions = $payment_transactions->get()->sortByDesc('created_at');
        }

        return view('auth.user.reports.pg_transaction_report', compact('events', 'payment_transactions'), $data);
    }


    public function pg_logs(Request $request)
    {
        
        
        $data = [];
        $data['form_url'] = 'reports/pg_logs';
        $data['reset_url'] = 'reports.pg_logs';

        if (!empty($request->start_date)) {
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
        } else {
            $data['start_date'] = '';
            $data['end_date'] = '';
        }


        if (!empty($request->status)) {
            $data['status'] = $request->status;
        } else {
            $data['status'] = '';
        }

        if (!empty($request->start_date)) {

            if ($data['status']=='SUCCESS' || $data['status']=='FAILED' )
            {
                $payment_transactions = PaymentLogs::whereRaw('(date(created_at) >= ? AND date(created_at )<= ?)', [$request->start_date, $request->end_date])
                ->where('status', $data['status'])
                ->orderBy('id', 'DESC')
                ->get();
            }
            else
            {
                $payment_transactions = PaymentLogs::whereRaw('(date(created_at) >= ? AND date(created_at )<= ?)', [$request->start_date, $request->end_date])->orderBy('id', 'DESC')->get();
            }
        }
        else
        {
            $date = \Carbon\Carbon::today()->subDays(7);
            
            if ($data['status']=='SUCCESS' || $data['status']=='FAILED' )
            {
                $payment_transactions = PaymentLogs::where('created_at','>=',$date)
                ->where('status', $data['status'])
                ->orderBy('id', 'DESC')
                ->get();
            }
            else
            {
                $payment_transactions = PaymentLogs::where('created_at','>=',$date)->orderBy('id', 'DESC')->get();
            }
        }
        return view('auth.user.reports.pg_logs_report', compact('payment_transactions'), $data);
    }
    
    public function complementry_report(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/complementry_report';
        $data['reset_url'] = 'reports.complementry_report';
        if ($request->get('esd_id') != null) {
            $data['count'] = 2;

            $query = Booking::latest()->take(300);
        } else {
            $data['count'] = 1;
            $query = Booking::latest()->take(1);
        }

        $this->set_filter_query($request, $query);
       
        
        $query->where('bookings.payment_method_id', 6);
        $bookings = $query->get();
        return view('auth.user.reports.complementry_report', compact('bookings'), $data);
    }


    public function gst_report_r1(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/gst_report_r1';
        $data['reset_url'] = 'reports.gst_report_r1';
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['event_id'] = $request->event_id;

        $bookings = collect(); // default empty collection

        // Only fetch bookings if event_id is provided
        if (!empty($request->event_id)) {
            $bookings_get = Booking::join('booking_details', 'booking_details.booking_id', '=', 'bookings.id')
                ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
                ->join('ticket_type', 'ticket_type.id', '=', 'booking_details.ticket_type_id')
                ->join('customers', 'customers.id', '=', 'bookings.customer_id')
                ->join('payment_method', 'payment_method.id', '=', 'bookings.payment_method_id')
                ->select(
                    'bookings.*',
                    'ticket_type.ticket_type_name as ticket_type_name',
                    'customers.customer_name as customer_name',
                    'payment_method.name as payment_method_name',
                )
                ->where('bookings.event_id', $request->event_id)
                 ->whereNotNull('bookings.invoice_no')
                ->groupBy('bookings.id');

            // Apply date filter if provided
            if (!empty($request->start_date)) {
                $bookings_get = $bookings_get->whereRaw(
                    '(date(bookings.created_at) >= ? AND date(bookings.created_at) <= ?)',
                    [$request->start_date, $request->end_date]
                );
            }

            $bookings = $bookings_get->get();
        }

        $events = Event::orderByDesc('created_at')->get();

        return view('auth.user.reports.gst_report_r1', compact('bookings', 'events'), $data);
    }


    public function generate_invoice_no(Request $request)
    {
        $eventId = $request->event_id;

        // Step 1: Validate event_id
        if (!$eventId) {
            return redirect()->back()->with('error', 'Event ID is required.');
        }

        // Step 2: Fetch prefix from event
        $event = Event::find($eventId);

        if (!$event || !$event->invoice_prefix) {
            return redirect()->back()->with('error', 'Invalid event or prefix not found.');
        }

        $eventPrefix = $event->invoice_prefix;

        // Step 3: Get current financial year (e.g., 24-25)
        $currentYear = now()->year;
        $nextYear = now()->month >= 4 ? $currentYear + 1 : $currentYear;
        $prevYear = $nextYear - 1;
        $fy = substr($prevYear, 2) . '-' . substr($nextYear, 2);

        $finalPrefix = $eventPrefix . '/' . $fy . '/';

        // Step 4: Get all bookings for this event with NULL invoice_no
        $bookings = Booking::where('event_id', $eventId)
                    ->whereNull('invoice_no')
                    ->whereNotIn('payment_method_id', [3, 6])
                    ->orderBy('id')
                    ->get();

        if ($bookings->isEmpty()) {
            return redirect()->back()->with('info', 'No bookings found without invoice number.');
        }

        // Step 5: Get last invoice number for this FY and event
        $lastInvoice = Booking::where('event_id', $eventId)
                        ->whereNotNull('invoice_no')
                        ->where('invoice_no', 'like', $finalPrefix . '%')
                        ->orderByDesc('id')
                        ->value('invoice_no');

        $lastNumber = 0;
        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice, strlen($finalPrefix));
        }

        // Step 6: Generate and update invoice numbers inside transaction
        DB::transaction(function () use ($bookings, &$lastNumber, $finalPrefix) {
            foreach ($bookings as $booking) {
                $lastNumber++;
                $invoice_no = $finalPrefix . str_pad($lastNumber, 6, '0', STR_PAD_LEFT);
                $booking->invoice_no = $invoice_no;
                $booking->save();
            }

            // Log::info("Invoice numbers generated successfully starting from: " . $finalPrefix . str_pad($lastNumber, 6, '0', STR_PAD_LEFT));
        });

        return redirect()->back()->with('success', 'Invoice numbers generated successfully.');
    } 


    public function view_invoice($invoice_id)
    {
        $invoice_id = simple_crypt($invoice_id, 'd');
        $booking = Booking::where('invoice_no', $invoice_id)->first();
        $booking_details = BookingDetail::where('booking_id', $booking->id)->get();
        $customer = Customer::where('id', $booking->customer_id)->first();
        $event = Event::join('cities', 'events.city_id', '=', 'cities.id')
              ->join('states', 'events.state_id', '=', 'states.id')
              ->select(
                  'events.*',
                  'cities.name as city_name',
                  'states.name as state_name',
                  'states.id as state_id'
              )
              ->where('events.id', $booking->event_id)
              ->first();
              
        $trans = PaymentTransaction::where('booking_id', $booking->id);
        $paymentTransaction = $trans->count();
        
        $gstState       = $event->state;          // Your GST registration state
        $eventState     = $event->event_state;    // Where event is happening
       // Customer selected state (nullable)
        
        
        // ------------------------------
        // CASE 1: Customer did NOT choose a state
        // ------------------------------
        if ($paymentTransaction == 1) {
             $customerState  = optional($paymentTransaction)->state;   
        
            if ($gstState === $eventState) {
                $taxType = "CGST_SGST";   // Same state → CGST + SGST
            } else {
                $taxType = "IGST";        // Different state → IGST
            }
        }
        
        // ------------------------------
        // CASE 2: Customer chose a state
        // ------------------------------
        if ($eventState === $gstState) {
            $taxType = "CGST_SGST";       // Customer = GST state → CGST/SGST
        } else {
            $taxType = "IGST";            // Customer different state → IGST
        }


        $data['taxType']=$taxType;
    
        $bookings_get = Booking::join('booking_details', 'booking_details.booking_id', '=', 'bookings.id')
            ->join('event_schedule_list', 'event_schedule_list.id', '=', 'bookings.event_schedule_list_id')
            ->join('ticket_type', 'ticket_type.id', '=', 'booking_details.ticket_type_id')
            ->join('customers', 'customers.id', '=', 'bookings.customer_id')
            ->select(
                'bookings.*',
                'ticket_type.ticket_type_name as ticket_type_name',
                'customers.customer_name as customer_name',
            )
            ->where('bookings.event_id', $booking->event_id)
                ->whereNotNull('bookings.invoice_no')
                ->where('bookings.id', $booking->id)
            ->groupBy('bookings.id')->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }
        return view('auth.user.reports.invoice', compact('booking', 'booking_details', 'customer', 'event', 'bookings_get'), $data);
    }
}