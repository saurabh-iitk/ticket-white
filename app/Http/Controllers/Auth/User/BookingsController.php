<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BookingPayment;
use App\Models\EventShowSchedule;
use App\Models\CancelledBooking;
use App\Models\PaymentTransaction;
use App\Models\Customer;
use App\Models\CustomerCart;
use App\Models\Cart;
use App\Models\User;
use App\Models\EventSeat;
use App\Models\EventTicket;
use App\Models\Layout;
use App\Models\LayoutDetail;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    public function index(Request $request)
    {
        $data = [];
        $data['form_url'] = 'reports/booking';
        $data['reset_url'] = 'reports.booking';
        if ($request->get('esd_id') != null) {
            $data['count'] = 2;

            $query = Booking::latest()->take(300);
        } else {
            $data['count'] = 1;
            $query = Booking::latest()->take(1);
        }

        $this->set_filter_query($request, $query);
        $bookings = $query->get();
        return view('auth.user.reports.booking_report', compact('bookings'), $data);

        // $bookings = Booking::all();

        // return view('auth.user.bookings.index', compact('bookings'));
    }
    //public function booking_pos()
    //{
    // $bookings = Booking::all();

    //return view('auth.user.bookings.booking_pos',compact('bookings'));
    //}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = Auth::user()->id;
        $events = \App\Models\Event::where('status', 'ACTIVE')
        ->orderBy('id', 'DESC')
        ->get();
        $user_data = User::where('id', $user_id)->first();

        $user_with_role_data = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.*')
            ->where('users.id', $user_id)
            ->first();

        $venues = \App\Models\Venue::where('status', 'ACTIVE')->get();
        $layouts = \App\Models\Layout::where('status', 'ACTIVE')
            ->where('default_layout', 'YES')
            ->get();
        $payment_methods = \App\Models\PaymentMethod::where('status', 'ACTIVE')->get();

        //http://localhost:8888/event/ticket_demo/booking/create?e_id=1&es_id=1&esd_id=23&est_id=3&venue_id=1&layout_id=1

        if ($request->get('es_id') !== null && $request->get('esd_id') !== null && $request->get('est_id') !== null && $request->get('layout_id') !== null) {
            $e_id = $request->get('e_id');
            $es_id = $request->get('es_id');
            $esd_id = $request->get('esd_id');
            $est_id = $request->get('est_id');
            $venue_id = $request->get('venue_id');
            $layout_id = $request->get('layout_id');
            if ($request->get('renaming')) {
                $renaming = true;
            } else {
                $renaming = false;
            }

            if ($request->get('seat_arrangement')) {
                $seat_arrangement = true;
            } else {
                $seat_arrangement = false;
            }

            $layouts = \App\Models\Layout::where('status', 'ACTIVE')
                ->where('id', $layout_id)
                ->get();

            $data['event_seats'] = EventSeat::where(['event_id' => $e_id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id, 'layout_id' => $layout_id])->get();
            $data['e_id'] = $e_id;
            $data['es_id'] = $es_id;
            $data['esd_id'] = $esd_id;
            $data['est_id'] = $est_id;
            $data['venue_id'] = $venue_id;
            $data['layout_id'] = $layout_id;
            $data['renaming'] = $renaming;
            $data['seat_arrangement'] = $seat_arrangement;
            $data['user_data'] = $user_data;
            $e_data=EventTicket::where(['event_id' => $e_id, 'event_schedule_id' => $es_id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id, 'layout_id' => $layout_id])->first();

            $data['skip_label'] = $e_data->skip_label;
            $data['event_ticket_id'] = $e_data->id;

            $setting_data = getSetting(1);
            $convenience_fee = $setting_data->convenience_fee;
            $ticket_hold_time = $setting_data->ticket_hold_time;
            $date = new DateTime();
            $date->modify('-' . $ticket_hold_time . ' minutes');
            $formatted_date = $date->format('Y-m-d H:i:s');

            $customer_cart = CustomerCart::selectRaw('seat_id')
                ->where('is_hold_for_booking', 'YES')
                ->where('hold_on', '>=', $formatted_date)
                ->get();

            $seat_arr = [];
            foreach ($customer_cart as $single) {
                $seat_arr[] = $single->seat_id;
            }

            $data['customer_cart'] = $seat_arr;

            return view('auth.user.bookings.add_detail', compact('events', 'venues', 'layouts', 'payment_methods', 'user_data', 'user_with_role_data'), $data);
        } else {
            return view('auth.user.bookings.add', compact('events', 'venues', 'layouts'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            //'mobile_no'=>'required|numeric',
            //'customer_name'=>'required',
            'payment_method_id' => 'required',
            'seat_ids' => 'required',
        ]);
        $mobile_no = $request->mobile_no;

        if ($mobile_no == '') {
            $request->mobile_no = '0000000000';
        }
        $customer_name = $request->customer_name;
        if ($customer_name == '') {
            $request->customer_name = 'Walk In Customer';
        }

        $current_url = $request->current_url;
        $current_url = simple_crypt($current_url, 'd');

        $event_id = $request->event_id;

        $event_id = simple_crypt($event_id, 'd');

        $event_schedule_id = $request->event_schedule_id;
        $event_schedule_id = simple_crypt($event_schedule_id, 'd');

        $event_schedule_list_id = $request->event_schedule_list_id;
        $event_schedule_list_id = simple_crypt($event_schedule_list_id, 'd');

        $event_show_time_id = $request->event_show_time_id;
        $event_show_time_id = simple_crypt($event_show_time_id, 'd');

        $venue_id = $request->venue_id;
        $venue_id = simple_crypt($venue_id, 'd');

        $layout_id = $request->layout_id;
        $layout_id = simple_crypt($layout_id, 'd');

        $seat_ids = $request->seat_ids;
        $seat_ids = simple_crypt($seat_ids, 'd');



        /*********SEAT LOCKING START HERE*********************/
        $setting_data = getSetting(1);
        $ticket_hold_time = $setting_data->ticket_hold_time;

        $date = new DateTime();
        $date->modify('-' . $ticket_hold_time . ' minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $cart_check = CustomerCart::selectRaw('seat_id')
            ->where('user_id', '!=', Auth::user()->id)
            ->where('is_hold_for_booking', 'YES')
            ->where('hold_on', '>=', $formatted_date)
            ->get();

        $choosen_seat_by_someone = [];
        foreach ($cart_check as $single_cart) {
            $choosen_seat_by_someone[] = $single_cart->seat_id;
        }

        $cart_check_2 = Cart::selectRaw('count(*) as total_choosen')
            ->where('user_id', Auth::user()->id)
            ->whereIn('seat_id', $choosen_seat_by_someone)
            ->first();

        if (!empty($cart_check_2['total_choosen']) && $cart_check_2['total_choosen'] > 0) {
            return back()->with('error', 'One or more tickets are Unavailable for Booking, Please choose another seats');
            exit();
        }
        $payment_method_id = $request->payment_method_id;

        if($payment_method_id==7 || $payment_method_id==9)
        {
            if(isset($request->bms_id))
            {
                $is_exist = Booking::where(['bms_id' => $request->bms_id, 'status' => 'ACTIVE'])->count();
                if($is_exist>0)
                {
                    return back()->with('error', 'BookMyShow / Insider / Website ID Already Exist in System, You can not Book Ticket with this ID');
                    exit();
                }
            }
        }

        /*********SEAT LOCKING END HERE*********************/



        /*********SEAT BOOKED LOCKING HERE*********************/
        $cart_check = Cart::selectRaw('seat_id')
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        $choosen_seat_by_you = [];
        foreach ($cart_check as $single_cart) {
            $choosen_seat_by_you[] = $single_cart->seat_id;
        }


        /*********CHECKING FOR SEAT RESERVED OR  NOT END HERE*********************/
        $cart_reserved = EventSeat::whereIn('id', $choosen_seat_by_you)->where('is_reserved', 'YES')->count();
        if($cart_reserved>0)
        {
            return back()->with('error', 'One or more tickets are Reserved, Please Unreserve the Seats');
            exit();
        }
        /*********CHECKING FOR SEAT RESERVED OR  NOT  END HERE*********************/
        
        
        $cart_check_2 = BookingDetail::selectRaw('count(*) as total_choosen')
            ->whereIn('seat_id', $choosen_seat_by_you)
            ->first();

        if (!empty($cart_check_2['total_choosen']) && $cart_check_2['total_choosen'] > 0) {
            return back()->with('error', 'One or more tickets are Unavailable for Booking, Please choose another seats');
            exit();
        }
        /*********SEAT BOOKED END HERE*********************/



        $mobile_no = $request->mobile_no;
        $customer_name = $request->customer_name;
        $email = $request->email;
        $coupon_code = $request->coupon_code;
        // $discount = $request->discount;
   
        $bms_id = $request->bms_id;

        $qty = 0;
        $total_discount = 0;
        $grand_total = 0;
        $net_grand_total = 0;

        $seat_ids_array = explode(',', $seat_ids);
        $carts = Cart::whereIn('seat_id', $seat_ids_array)->get();
        foreach ($carts as $key => $cart_item) {
            $seat_id = $cart_item->seat_id;
            $ticket_type_id = $cart_item->ticket_type_id;
            $quantity = $cart_item->quantity;
            $rate = $cart_item->rate;
            $discount = $cart_item->discount;
            $total_discount = $total_discount + $discount * $quantity;
            $total_amount = $quantity * $rate;
            $grand_total = $grand_total + $total_amount;
            $net_grand_total = number_format($grand_total, 2);
            $qty = $qty + $quantity;
        }

        //Begin Transaction
        DB::beginTransaction();

        try {
            $customer_query = Customer::where(['mobile_no' => $mobile_no, 'status' => 'ACTIVE']);
            if ($customer_query->count() == 0) {
                //customers
                $customer = new Customer();
                $customer->mobile_no = $mobile_no;
                $customer->customer_name = $customer_name;
                $customer->email = $email;
                $customer->coupon_code = $coupon_code;
                $customer->save();
            } else {
                $customer = $customer_query->first();
            }

            //bookings
            // $ip=Request::ip();
            $booking = new Booking();
            $booking->event_id = $event_id;
            $booking->event_schedule_id = $event_schedule_id;
            $booking->event_schedule_list_id = $event_schedule_list_id;
            $booking->event_show_time_id = $event_show_time_id;
            $booking->venue_id = $venue_id;
            $booking->layout_id = $layout_id;
            $booking->payment_method_id = $payment_method_id;
            $booking->booking_amount = $grand_total;
            $paid_amount = $grand_total - $total_discount;
            $booking->paid_amount = $paid_amount;
            $booking->total_quantity = $qty;
            $booking->bms_id = $bms_id;
            // $booking->ip = $ip;
            $booking->booking_id_str = random_strings(6);
            $booking->discount = $total_discount;
            $booking->grand_total = $grand_total;
            $booking->guest_designation = $request->guest_designation;
            $booking->issued_by = $request->issued_by;
            $booking->booking_code = unique_id_generate();
            $booking->booking_date = date('Y-m-d');
            $booking->booking_time = date('H:i:s A');
            $booking->customer_id = $customer->id;
            $booking->vendor_id = Auth::user()->id;

            $gst_waiver_rate = $setting_data->gst_waiver_rate;
            $per_ticket_paid = $paid_amount / $qty;
            $is_gst_applicable = $per_ticket_paid > $gst_waiver_rate;

            if ($is_gst_applicable) {
                $per_ticket_taxable = round($per_ticket_paid / 1.18, 2);
                $per_ticket_gst     = round($per_ticket_paid - $per_ticket_taxable, 2);
                $taxable_amount     = round($per_ticket_taxable * $qty, 2);
                $gst_amount         = round($per_ticket_gst * $qty, 2);
            } else {
                $taxable_amount = 0.00;
                $gst_amount     = 0.00;
            }

            $booking->is_gst_applicable = $is_gst_applicable;
            $booking->taxable_amount = $taxable_amount;
            $booking->gst_amount = $gst_amount;
            $booking->save();

            //booking_details
            foreach ($seat_ids_array as $seat_ids_arr) {
                $event_seat = EventSeat::where(['id' => $seat_ids_arr])->first();

                $booking_detail = new BookingDetail();
                $booking_detail->booking_id = $booking->id;
                $booking_detail->venue_id = $venue_id;
                $booking_detail->seat_id = $event_seat->id;
                $booking_detail->ticket_type_id = $event_seat->event_ticket_type_id;
                $booking_detail->base_price = $event_seat->base_price;
                // $booking_detail->discount = $event_seat->total_discount;
                $booking_detail->discount = $discount;
                $booking_detail->seat_no = $event_seat->seatno;
                $booking_detail->row_id = $event_seat->row_no;
                $booking_detail->col_id = $event_seat->col_no;
                $booking_detail->save();

                $carts = Cart::where('seat_id', $seat_ids_arr)->first();
                $discount = $carts->discount;

                EventSeat::where(['id' => $seat_ids_arr])->update(['total_discount' => $discount, 'payment_method_id' => $payment_method_id, 'booking_id' => $booking->id, 'booking_time' => date('Y-m-d H:i:s')]);

                EventSeat::where(['id' => $seat_ids_arr])->decrement('total_ticket', 1);
            }

            //booking_payments
            $booking_payment = new BookingPayment();
            $booking_payment->booking_id = $booking->id;
            $booking_payment->payment_method_id = $payment_method_id;
            $booking_payment->reference_no = date('dmyhi') . rand(11111, 9999);
            $booking_payment->amount = $grand_total;
            $booking_payment->discount = $total_discount;

            $payable_amount = $grand_total - $total_discount;
            $booking_payment->note = 'Payable Amount: ' . $payable_amount;
            $booking_payment->save();

            //clear cart
            Cart::whereIn('seat_id', $seat_ids_array)->delete();

            DB::commit();


            if ($request->send_whatsapp=='YES') {
                if (getEventScheduleList($booking->event_schedule_list_id)) {
                    $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                    $event_date = date('D d M Y', strtotime($event_date));
                }
            
                if (getEventShowTime($booking->event_show_time_id)) {
                    $event_show_time = getEventShowTime($booking->event_show_time_id);
                    $event_show_time = $event_show_time->start_time;
                }
            
                if (getVenue($booking->venue_id)) {
                    $venue = getVenue($booking->venue_id);
                    $venue = $venue->name;
                }
            
                if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW') {
                    $seat_no_message = '';
                } else {
                    $seat_no_message = ' -  Seat Number not allotted';
                }

                if (getTicketType($booking_detail->ticket_type_id)) {
                    $ticket_type_name = getTicketType($booking_detail->ticket_type_id)->ticket_type_name;
                } else {
                    $ticket_type_name = '';
                }
                
                $seat_no_arr = [];
                $show_name = false;
                $booking_details = BookingDetail::where('booking_id', $booking->id)->get();
                if ($booking_details)
                {
                    foreach ($booking_details as $key => $booking_detail)
                    {
                        $seat_name = fetch_seat_no($booking_detail->seat_id);
                        $row_no = $seat_name->row_no;
                        $total_discount = $seat_name->total_discount;
                        // $layout_row_label = getLayout($seat_name->layout_id)->layout_row_label;
                        // $layout_row_label = explode(',', $layout_row_label);
                        // $row_name = $layout_row_label[$row_no - 1];
                        
                        if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW')
                        {
                            $show_name = true;
                        }
                        $seat_no_arr[] = $seat_name->label . $seat_name->name;
                    }
                }

                if ($show_name == true)
                {
                    $seat_no = implode(', ', $seat_no_arr) . ' - ';
                }
                else
                {
                    $seat_no = '';
                    $seat_no_message=' -  Seat Number not allotted';
                }
                    
                $data = [];
                $data['status'] = 'SUCCESS';
                $data['booking_id'] = $booking->id; 
                $data['amount'] = $booking->grand_total;
                $data['tickets'] = $seat_no . count($seat_no_arr) . ' Ticket(s)' . ' (' . $ticket_type_name . ')' . $seat_no_message;
                $data['show_name'] = $event_date . ' ' . $event_show_time;
                $data['txnid'] = $booking_payment->reference_no;
                $data['venue'] = $venue;
                $data['bank_ref_num'] = 'N/A';
                $data['pg_txn'] = 'N/A';
                $data['name'] = $customer->customer_name;
                $data['email'] = $customer->email;
                $data['mobile'] = $customer->mobile_no;
                $data['booking_id_str'] = $booking->booking_id_str;
                $data['updated_at'] =  date('D d M Y h:i:s A', strtotime($booking->created_at));
                $res = send_whatsapp($data);
                if ($res == 'SENT') {
                    update_whatsapp_sent($booking->id);
                }
            }


            // $print_url = route('reports.print_ticket1', $booking->id);

            // echo "<script>window.open('".$print_url."', '_blank', 'toolbar=no,scrollbars=yes,resizable=no,top=500,left=500,width=500,height=1000');";

            return redirect()
                ->route('reports.print_ticket', $booking->id)
                ->with('current_url', $current_url);

            //return back()->with('success', 'Booking successfully added!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Some problems occurred, please try again!');
        }
    }
    
    public function unbook($id)
    {
        DB::beginTransaction();

        $id = simple_crypt($id, 'd');

        $booking = Booking::where('id', $id)->first();
        $quantity = $booking->total_quantity;
        $amount = $booking->grand_total;
        $discount = $booking->discount;
        $user_id = Auth::user()->id;

        $booking_details = BookingDetail::where('booking_id', $id)->first();
        $ticket_type_id = $booking_details->ticket_type_id;

        $event_seat = EventSeat::where('booking_id', $id)->get();
        foreach ($event_seat as $cart_item)
        {
            $seat_id = $cart_item->id;
            $seat_name = fetch_seat_no($seat_id);
            $row_no = $seat_name->row_no;
            $row_name =  $seat_name->label;
            $seat_no_arr[] = $row_name . $seat_name->name;
        }
        $seat_details= implode(', ', $seat_no_arr);
        
       
        
        Booking::where('id', $id)->update(['seat_details' => $seat_details]);
         
         

        $cancelled_booking = new CancelledBooking();
        $cancelled_booking->ticket_type_id = $ticket_type_id;
        $cancelled_booking->quantity = $quantity;
        $cancelled_booking->amount = $amount;
        $cancelled_booking->discount = $discount;
        $cancelled_booking->seat_details = $seat_details;
        $cancelled_booking->user_id = $user_id;
        $cancelled_booking->created_at = date('Y-m-d H:i:s');
        $cancelled_booking->save();



        $del_booking = Booking::where('id', $id)->delete();
        $del_BookingDetail = BookingDetail::where('booking_id', $id)->delete();
        $del_BookingPayment = BookingPayment::where('booking_id', $id)->delete();
       
        $del_BookingTransaction = PaymentTransaction::where('booking_id', $id)->exists();
        if ($del_BookingTransaction) {
             $del_BookingTransaction = PaymentTransaction::where('booking_id', $id)->delete();
        }


        if (!$del_booking || !$del_BookingDetail || !$del_BookingPayment) {
            DB::rollback();
            return back()->with('error', 'Some problems occurred, please try again!');
        }



        $booking_id = null; // for event seat
        $booking_time = null;
        $is_scanned = 0;
        $scanned_by = null;
        $scan_time = null;
        $event_seat = EventSeat::where('booking_id', $id)->update([
            'booking_id' => $booking_id,
            'booking_time' => $booking_time, 
            'is_scanned' => $is_scanned,
            'scanned_by' => $scanned_by,
            'scan_time' => $scan_time
        ]);


        
        if (!$event_seat) {
            DB::rollback();
            return back()->with('error', 'Some problems occurred, please try again!');
        } else {
            // Else commit the queries
            DB::commit();
        }
        return redirect()
            ->back()
            ->with('success', ' Booking Cancelled successfully');
    }

    
  
    // public function force_delete(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $booking_ids = explode(',', $request->booking_ids);

    //         foreach ($booking_ids as $id) {
    //             $booking = Booking::find($id);
    //             if (!$booking) continue;
    //              $skipped = [];

    //             if ($booking->invoice_no != "") {
    //                 $skipped[] = $id;
    //                 continue;
    //             }
                
    //             DB::table('fc')->insert([
    //                 'bid' => $id
    //             ]);

    //             // Delete child records first
    //             BookingDetail::where('booking_id', $id)->delete();
    //             BookingPayment::where('booking_id', $id)->delete();
    //             PaymentTransaction::where('booking_id', $id)->delete();

    //             // Reset event seats
    //             EventSeat::where('booking_id', $id)->update([
    //                 'booking_id' => null,
    //                 'booking_time' => null,
    //                 'is_scanned' => 0,
    //                 'scanned_by' => null,
    //                 'scan_time' => null
    //             ]);

    //             // Now delete parent booking
    //             $booking->delete(); // or forceDelete() if soft deletes enabled
    //         }

    //         DB::commit();

    //         if (count($skipped)) {
    //             return redirect()->back()->with('warning', 'Some bookings were not cleaned because invoice was already generated: ' . implode(', ', $skipped));
    //         }

    //         return redirect()->back()->with('success', 'Bookings force cleaned');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    //     }
    // }
    
    
    public function force_delete(Request $request)
    {
        DB::beginTransaction();

        try {
            $booking_ids = explode(',', $request->booking_ids);
            $skipped = [];

            foreach ($booking_ids as $id) {
                $booking = Booking::find($id);
                if (!$booking) continue;

                if (!empty($booking->invoice_no)) {
                    $skipped[] = $id;
                    continue;
                }

                // Log before deletion
                DB::table('fc')->insert([
                    'bid' => $id
                ]);

                // Delete child records
                BookingDetail::where('booking_id', $id)->forceDelete();
                BookingPayment::where('booking_id', $id)->forceDelete();
                PaymentTransaction::where('booking_id', $id)->forceDelete();

                // Reset event seats
                EventSeat::where('booking_id', $id)->update([
                    'booking_id' => null,
                    'booking_time' => null,
                    'is_scanned' => 0,
                    'scanned_by' => null,
                    'scan_time' => null
                ]);

                // Force delete booking (even if soft deleted)
                $booking->forceDelete();
            }

            DB::commit();

            if (count($skipped)) {
                return redirect()->back()->with('warning', 'Some bookings were not cleaned because invoice was already generated: ' . implode(', ', $skipped));
            }

            return redirect()->back()->with('success', 'Bookings force cleaned successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::where('id', $id)->first();

        return view('auth.user.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking = Booking::where('id', $id)->first();

        return view('auth.user.bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $booking = Booking::where('id', $id)->first();

        $booking->event_id = $request->event_id;
        $booking->venue_id = $request->venue_id;
        $booking->booking_code = $request->booking_code;
        $booking->booking_date = $request->booking_date;
        $booking->booking_time = $request->booking_time;
        $booking->payment_status = $request->payment_status;
        $booking->status = $request->status;
        $booking->vendor_id = Auth::user()->id;

        $booking->save();

        return redirect('/booking')->with('success', 'Booking successfully updated!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        Booking::where('id', $id)->delete();
        BookingDetail::where('booking_id', $id)->delete();
        BookingPayment::where('booking_id', $id)->delete();

        return redirect('/booking')->with('success', 'Booking successfully deleted!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add_to_cart(Request $request)
    {
        $data = [];

        $id = $request->event_seat_id;

        if (isset($request->discount) && !empty($request->discount))
        {
            $discount = $request->discount;
        }
        else
        {
            $discount =0;
        }


        $event_schedule_list_id = $request->event_schedule_list_id;
        $event_show_time_id = $request->event_show_time_id;
        $user_id = Auth::user()->id;
        $event_seat = EventSeat::where(['id' => $id])->first();




        // if($event_seat->is_reserved=='YES')
        // {
        //     $response = [
        //     'status' => 'error',
        //     'message' => 'Seat is Reserved, Please Unreserve it',
        //     ];
        //     return json_encode($response);
        // }




        $cart_count_temp = Cart::where('seat_id', $id)->where('user_id', '!=' ,$user_id)->count();
        if($cart_count_temp>0)
        {
            $response = [
            'status' => 'error',
            'message' => 'Seat already choosen by another vendor',
            ];
        }
        else
        {
            $cart_count = Cart::where('ticket_type_id', $event_seat->event_ticket_type_id)->count();
            if ($cart_count > 0)
            {
                $cart_data_temp = Cart::where('ticket_type_id', $event_seat->event_ticket_type_id)
                    ->where('user_id', $user_id)
                    ->first();
                if (isset($cart_data_temp->discount) && !empty($cart_data_temp->discount))
                {
                    $per_ticket_discount = $cart_data_temp->discount;
                }
                else
                {
                    $per_ticket_discount =0;
                }
            } else {
                $per_ticket_discount = 0;
            }
        
            if (isset($event_seat) && $event_seat->event_ticket_type_id != '' && $event_seat->booking_id == '') {
                $cart_data = [
                    'seat_id' => $id,
                    'ticket_type_id' => $event_seat->event_ticket_type_id,
                    'quantity' => 1,
                    'rate' => $event_seat->base_price,
                    'discount' => $per_ticket_discount,
                    'user_id' => $user_id,
                    'event_schedule_list_id' => $event_schedule_list_id,
                    'event_show_time_id' => $event_show_time_id,
                ];

                $cart_count = Cart::where('seat_id', $id)->count();
                if ($cart_count == 0) {
                    $insert = Cart::create($cart_data);

                    // $cart_records = Cart::where(['event_schedule_list_id' => $event_schedule_list_id, 'event_show_time_id' => $event_show_time_id, 'user_id' => $user_id])->count();

                    // $single_discount = round($discount / $cart_records, 2);

                    // Cart::where(['event_schedule_list_id' => $event_schedule_list_id, 'event_show_time_id' => $event_show_time_id, 'user_id' => $user_id])->update(['discount' =>  $single_discount]);

                    if ($insert) {
                        $seat_ids = [];
                        $seat_ids = Cart::where('user_id', $user_id)
                            ->where('status', 'ACTIVE')
                            ->pluck('seat_id')
                            ->toArray();
                        if (!empty($seat_ids)) {
                            $seat_ids_str = simple_crypt(implode(',', $seat_ids));
                        } else {
                            $seat_ids_str = '';
                        }

                        $grand_total = 0;
                        $net_grand_total = 0;
                        $net_total_discount = 0;

                        $cart_groups = Cart::selectRaw('*, count(*) as total')
                            ->where('user_id', $user_id)
                            ->groupBy('ticket_type_id')
                            ->get();
                        foreach ($cart_groups as $key => $cart_item) {
                            $ticket_type_id = $cart_item->ticket_type_id;
                            $qty = $cart_item->total;
                            $rate = $cart_item->rate;
                            $discount = $cart_item->discount;
                            $total_discount = $discount;
                            $net_total_discount = number_format($total_discount, 2);
                            $total_amount = ($rate - $discount) * $qty;
                            $grand_total = $grand_total + $total_amount;
                            $net_grand_total = number_format($grand_total, 2);

                            $data[] = [
                                'ticket_type_id' => $ticket_type_id,
                                'ticket_type_name' => !empty(getTicketType($ticket_type_id)) ? getTicketType($ticket_type_id)->ticket_type_name : '',
                                'qty' => $qty,
                                'rate' => $rate,
                                'discount' => $net_total_discount,
                                'total' => number_format($total_amount, 2),
                            ];
                        }

                        $response = [
                            'status' => 'success',
                            'action' => 'added',
                            'message' => 'Successfully added.',
                            'data' => $data,
                            'grand_total' => $net_grand_total,
                            'seat_ids' => $seat_ids_str,
                        ];
                    }
                } else {
                    $delete = Cart::where('seat_id', $id)->delete();
                    if ($delete) {
                        $seat_ids = [];
                        $seat_ids = Cart::where('user_id', $user_id)
                            ->where('status', 'ACTIVE')
                            ->pluck('seat_id')
                            ->toArray();
                        if (!empty($seat_ids)) {
                            $seat_ids_str = simple_crypt(implode(',', $seat_ids));
                        } else {
                            $seat_ids_str = '';
                        }

                        $grand_total = 0;
                        $net_grand_total = 0;
                        $cart_groups = Cart::selectRaw('*, count(*) as total')
                            ->where('user_id', $user_id)
                            ->groupBy('ticket_type_id')
                            ->get();
                        foreach ($cart_groups as $key => $cart_item) {
                            $ticket_type_id = $cart_item->ticket_type_id;
                            $qty = $cart_item->total;
                            $rate = $cart_item->rate;
                            $discount = $cart_item->discount;
                            $total_amount = ($rate - $discount) * $qty;
                            $grand_total = $grand_total + $total_amount;
                            $net_grand_total = number_format($grand_total, 2);

                            $data[] = [
                                'ticket_type_id' => $ticket_type_id,
                                'ticket_type_name' => !empty(getTicketType($ticket_type_id)) ? getTicketType($ticket_type_id)->ticket_type_name : '',
                                'qty' => $qty,
                                'rate' => $rate,
                                'discount' => $discount,
                                'total' => number_format($total_amount, 2),
                            ];
                        }

                        $response = [
                            'status' => 'success',
                            'action' => 'deleted',
                            'message' => 'Successfully deleted.',
                            'data' => $data,
                            'grand_total' => $net_grand_total,
                            'seat_ids' => $seat_ids_str,
                        ];
                    }
                }
            } elseif (isset($event_seat) && $event_seat->event_ticket_type_id != '' && $event_seat->booking_id != '') {
                $response = [
                    'status' => 'error',
                    'message' => 'Seat already booked.',
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Please Map Seat First.',
                ];
            }
        }

        return json_encode($response);
    }

    public function clear_cart(Request $request)
    {
        $seat_ids = $request->seat_ids;
        $seat_ids = simple_crypt($seat_ids, 'd');
        $seat_ids_arr = explode(',', $seat_ids);
        $delete = Cart::whereIn('seat_id', $seat_ids_arr)->delete();
        if ($delete) {
            $response = [
                'status' => 'success',
                'message' => 'Successfully deleted.',
            ];
            return json_encode($response);
        }
    }

    public function update_cart_discount(Request $request)
    {
        $ticket_type_id = $request->ticket_type_id;
        $discount = $request->discount;
        $user_id = Auth::user()->id;

        $carts = Cart::where('user_id', $user_id)
            ->where('ticket_type_id', $ticket_type_id)
            ->get();
        if (count($carts)) {
            foreach ($carts as $key => $cart) {
                $cart->update([
                    'discount' => $discount,
                ]);
            }

            $response = [
                'status' => 'success',
                'message' => 'Successfully updated.',
            ];
            return json_encode($response);
        }
    }

    public function add_pos(Request $request)
    {
        $events = \App\Models\Event::where('status', 'ACTIVE')->get();
        $venues = \App\Models\Venue::where('status', 'ACTIVE')->get();
        $layouts = \App\Models\Layout::where('status', 'ACTIVE')->get();
        $payment_methods = \App\Models\PaymentMethod::where('status', 'ACTIVE')->get();

        if ($request->get('es_id') !== null && $request->get('esd_id') !== null && $request->get('est_id') !== null && $request->get('layout_id') !== null) {
            $e_id = $request->get('e_id');
            $es_id = $request->get('es_id');
            $esd_id = $request->get('esd_id');
            $est_id = $request->get('est_id');
            $venue_id = $request->get('venue_id');
            $layout_id = $request->get('layout_id');

            $data['event_seats'] = EventSeat::where(['event_id' => $e_id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id, 'layout_id' => $layout_id])->get();
            $data['e_id'] = $e_id;
            $data['es_id'] = $es_id;
            $data['esd_id'] = $esd_id;
            $data['est_id'] = $est_id;
            $data['venue_id'] = $venue_id;
            $data['layout_id'] = $layout_id;

            return view('auth.user.bookings.add_detail', compact('events', 'venues', 'layouts', 'payment_methods'), $data);
        } else {
            return view('auth.user.bookings.add_pos', compact('events', 'venues', 'layouts'));
        }
    }

    //block booking list
    public function block_booking(Request $request)
    {
        $events = \App\Models\Event::where('status', 'ACTIVE')->get();
        $venues = \App\Models\Venue::where('status', 'ACTIVE')->get();
        $layouts = \App\Models\Layout::where('status', 'ACTIVE')->get();
        $event_schedule_list = \App\Models\EventShowSchedule::orderBy('id', 'DESC')->get();
        $payment_methods = \App\Models\PaymentMethod::where('status', 'ACTIVE')->get();

        if ($request->get('es_id') !== null && $request->get('esd_id') !== null && $request->get('est_id') !== null && $request->get('layout_id') !== null) {
            $e_id = $request->get('e_id');
            $es_id = $request->get('es_id');
            $esd_id = $request->get('esd_id');
            $est_id = $request->get('est_id');
            $venue_id = $request->get('venue_id');
            $layout_id = $request->get('layout_id');

            $data['event_seats'] = EventSeat::where(['event_id' => $e_id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id, 'layout_id' => $layout_id])->get();
            $data['e_id'] = $e_id;
            $data['es_id'] = $es_id;
            $data['esd_id'] = $esd_id;
            $data['est_id'] = $est_id;
            $data['venue_id'] = $venue_id;
            $data['layout_id'] = $layout_id;

            return view('auth.user.bookings.add_detail', compact('events', 'venues', 'layouts', 'payment_methods'), $data);
        } else {
            return view('auth.user.bookings.block_booking', compact('events', 'venues', 'layouts', 'event_schedule_list'));
        }
    }

    //vendor block booking
    public function vendor_block_booking(Request $request, $id, $status)
    {
        if ($status == 'ALLOWED') {
            $event_show_schedule = EventShowSchedule::where('id', $id)
                ->where('vendor_booking', 'ALLOWED')
                ->update(['vendor_booking' => 'NOT_ALLOWED']);
            return redirect('/bookings/block_booking')->with('success', 'Booking Blocked');
        }
        if ($status == 'NOT_ALLOWED') {
            $event_show_schedule = EventShowSchedule::where('id', $id)
                ->where('vendor_booking', 'NOT_ALLOWED')
                ->update(['vendor_booking' => 'ALLOWED']);
            return redirect('/bookings/block_booking')->with('success', 'Booking Unblocked');
        }
    }

    //customer block booking
    public function customer_block_booking(Request $request, $id, $status)
    {
        if ($status == 'ALLOWED') {
            $event_show_schedule = EventShowSchedule::where('id', $id)
                ->where('customer_booking', 'ALLOWED')
                ->update(['customer_booking' => 'NOT_ALLOWED']);
            return redirect('/bookings/block_booking')->with('success', 'Booking Blocked');
        }
        if ($status == 'NOT_ALLOWED') {
            $event_show_schedule = EventShowSchedule::where('id', $id)
                ->where('customer_booking', 'NOT_ALLOWED')
                ->update(['customer_booking' => 'ALLOWED']);
            return redirect('/bookings/block_booking')->with('success', 'Booking Unblocked');
        }
    }

    //all block booking
    public function all_block_booking(Request $request, $id)
    {
        $event_show_schedule = EventShowSchedule::where('id', $id)->update(['customer_booking' => 'NOT_ALLOWED', 'vendor_booking' => 'NOT_ALLOWED', 'booking' => 'NOT_ALLOWED']);
        return redirect('/bookings/block_booking')->with('success', 'Booking Blocked');
    }

    //all unblock booking
    public function all_unblock_booking(Request $request, $id)
    {
        $event_show_schedule = EventShowSchedule::where('id', $id)->update(['customer_booking' => 'ALLOWED', 'vendor_booking' => 'ALLOWED', 'booking' => 'ALLOWED']);
        return redirect('/bookings/block_booking')->with('success', 'Booking Unblocked');
    }

    ///sale status
    public function sale_status(Request $request)
    {
        $user_id = Auth::user()->id;
        $events = \App\Models\Event::where('status', 'ACTIVE')
            ->orderBy('id', 'DESC')
            ->get();
        $user_data = User::where('id', $user_id)->first();
        $venues = \App\Models\Venue::where('status', 'ACTIVE')->get();
        $layouts = \App\Models\Layout::where('status', 'ACTIVE')->get();
        $payment_methods = \App\Models\PaymentMethod::where('status', 'ACTIVE')->get();

        if ($request->get('es_id') !== null && $request->get('esd_id') !== null && $request->get('est_id') !== null && $request->get('layout_id') !== null) {
            $e_id = $request->get('e_id');
            $es_id = $request->get('es_id');
            $esd_id = $request->get('esd_id');
            $est_id = $request->get('est_id');
            $venue_id = $request->get('venue_id');
            $layout_id = $request->get('layout_id');

            $layouts = \App\Models\Layout::where('status', 'ACTIVE')
                ->where('id', $layout_id)
                ->get();

            $data['event_seats'] = EventSeat::where(['event_id' => $e_id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id, 'layout_id' => $layout_id])->get();
            $data['e_id'] = $e_id;
            $data['es_id'] = $es_id;
            $data['esd_id'] = $esd_id;
            $data['est_id'] = $est_id;
            $data['venue_id'] = $venue_id;
            $data['layout_id'] = $layout_id;

            return view('auth.user.bookings.sale_status_details', compact('events', 'venues', 'layouts', 'payment_methods', 'user_data'), $data);
        } else {
            return view('auth.user.bookings.sale_status', compact('events', 'venues', 'layouts'));
        }

        // $events = \App\Models\Event::where('status', 'ACTIVE')->get();
        // $venues = \App\Models\Venue::where('status', 'ACTIVE')->get();
        // $layouts = \App\Models\Layout::where('status', 'ACTIVE')->get();
        // $payment_methods = \App\Models\PaymentMethod::where('status', 'ACTIVE')->get();
        // $user_data = User::where('id', $user_id)->first();

        // if ($request->get('es_id') !== null && $request->get('esd_id') !== null && $request->get('est_id') !== null && $request->get('layout_id') !== null) {
        //     $e_id = $request->get('e_id');
        //     $es_id = $request->get('es_id');
        //     $esd_id = $request->get('esd_id');
        //     $est_id = $request->get('est_id');
        //     $venue_id = $request->get('venue_id');
        //     $layout_id = $request->get('layout_id');

        //     $data['event_seats'] = EventSeat::where(['event_id' => $e_id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id, 'layout_id' => $layout_id])->get();
        //     $data['e_id'] = $e_id;
        //     $data['es_id'] = $es_id;
        //     $data['esd_id'] = $esd_id;
        //     $data['est_id'] = $est_id;
        //     $data['venue_id'] = $venue_id;
        //     $data['layout_id'] = $layout_id;

        //     return view('auth.user.bookings.sale_status_details', compact('events', 'venues', 'layouts', 'payment_methods', 'user_data'), $data);
        // } else {
        //     return view('auth.user.bookings.sale_status', compact('events', 'venues', 'layouts'));
        // }
    }

    public function update_event_seat_name(Request $request)
    {
        $seat_id = $request->id;
        $seat_name = $request->name;
        EventSeat::where('id', $seat_id)->update(['name' => $seat_name]);

        $data = EventSeat::where('id', $seat_id)->first();
        $event_id = $data->event_id;
        $event_schedule_list_id = $data->event_schedule_list_id;
        $event_show_time_id = $data->event_show_time_id;
        $layout_id = $data->layout_id;
        $row_no = $data->row_no;

        if($data->is_labeled == 'YES')
        {
            $layout_id = $data->layout_id;
            EventSeat::where('row_no', $row_no)
            ->where('event_id', $event_id)
            ->where('event_schedule_list_id', $event_schedule_list_id)
            ->where('event_show_time_id', $event_show_time_id)
            ->where('layout_id', $layout_id)
            ->update(['label' => $seat_name]);  

            EventSeat::where('row_no', $row_no)
            ->where('event_id', $event_id)
            ->where('event_schedule_list_id', $event_schedule_list_id)
            ->where('event_show_time_id', $event_show_time_id)
            ->where('layout_id', $layout_id)
            ->where('is_labeled', 'YES')
            ->update(['name' => $seat_name]);  
        }



    }

    public function get_layout_by_show_time_id(Request $request)
    {
        $event_show_time_id = $request->event_show_time_id;
        $event_schedule_list_id = $request->event_schedule_list_id;
        $event_schedule_id = $request->event_schedule_id;
        $event_id = $request->event_id;

        $layout = EventTicket::where('event_id', $event_id)
            ->where('event_schedule_id', $event_schedule_id)
            ->where('event_schedule_list_id', $event_schedule_list_id)
            ->where('event_show_time_id', $event_show_time_id)
            ->first();

        $layouts = Layout::where('status', 'ACTIVE')
            ->where('id', $layout->layout_id)
            ->first();

        $response['layout'] = $layouts;
        return json_encode($response);
    }

    public function clear_discount_from_cart(Request $request)
    {
        $user_id = $request->user_id;
        Cart::where('user_id', $user_id)->update(['discount' => 0]);
        $response['status'] = true;
        return json_encode($response);
    }

    public function update_event_label_name(Request $request)
    {
        $id = $request->id;
        $skip_label = $request->skip_label;
        EventTicket::where('id', $id)->update(['skip_label' => $skip_label]);
        $response['status'] = true;
        return json_encode($response);
    }
    
    
     public function fetch_booking(Request $request)
    {
        $id = $request->booking_id;
        $booking = Booking::find($id);
        $customer_id = $booking->customer_id;
        $customer_data = Customer::find($customer_id);
        $customer_phone = $customer_data->mobile_no;
        $customer_name =  $customer_data->customer_name;
        $customer_email =  $customer_data->email;

        $data = array();
        $data['customer_name'] = $customer_name;
        $data['customer_email'] = $customer_email;
        $data['customer_phone'] = $customer_phone;
        $response = [
            'status' => 'success',
            'data' => $data
        ];

        return json_encode($response);
    }

    public function update_booking(Request $request)
    {
        $id = $request->booking_id;
        $customer_name = $request->customer_name;
        $customer_phone = $request->customer_phone;
        $customer_email = $request->customer_email;

        $rules = [
            'customer_name' => 'required|min:3|max:50',
            'customer_phone' => 'required|digits_between:10,10|numeric',
            'customer_email' => 'nullable|email|max:191', 
           ];

        $validator = Validator::make($request->post(), $rules);
        if ($validator->fails()) {
            $response = [
                'status' => 'error',
                'errors' => array_map(function($fieldErrors) { return $fieldErrors[0]; }, $validator->getMessageBag()->toArray())
            ];
            return json_encode($response);
        }

        $customer_query = Customer::where(['mobile_no' => $customer_phone, 'status' => 'ACTIVE']);
        if ($customer_query->count() == 0) {
            //customers
            $customer = new Customer();
            $customer->mobile_no = $customer_phone;
            $customer->customer_name = $customer_name;
            $customer->email = $customer_email;
            $customer->save();
        } else {
            $customer = $customer_query->first();
        }

        $customer_data = Customer::find($customer->id);
        $customer_data->mobile_no = $customer_phone;
        $customer_data->customer_name = $customer_name;
        $customer_data->email = $customer_email;
        $customer_data->save();


        $booking = Booking::find($id);
        $booking->customer_id = $customer->id;
        $booking->save();

        $response = [
            'status' => 'success',
            'message' => 'Updated Successfully',
        ];
        return json_encode($response);
    }
}
