<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Role;
use App\Models\PaymentTransaction;
use App\Models\BookingDetail;
use App\Models\BookingPayment;
use App\Models\Booking;
use App\Models\EventSeat;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use DateTime;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('role')->get();

        return view('auth.user.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment_methods = PaymentMethod::all();
        $roles = Role::select('name', 'id')->get();
        return view('auth.user.user.add', compact('payment_methods','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|min:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required',
        ]);

        if($request->has('payment_methods'))
        {
            foreach ($request->payment_methods as $payment_methods) 
            {
                $payment_methods_array[] = $payment_methods;
            }
            $request->payment_methods = implode(',',$payment_methods_array);
        }



        if($request->has('reserve_unreserve'))
        {
            $reserve_unreserve='ALLOWED';
        }
        else
        {
            $reserve_unreserve='NOT_ALLOWED';
        }

        if($request->has('res_unres_dmg_hide'))
        {
            $res_unres_dmg_hide='ALLOWED';
        }
        else
        {
            $res_unres_dmg_hide='NOT_ALLOWED';
        }


        User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'payment_method_not_allowed' => $request->payment_methods,
            'reserve_unreserve' => $reserve_unreserve,
            'res_unres_dmg_hide' => $res_unres_dmg_hide
        ]);

        return redirect('/user')->with('success', 'User successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('role')->where('id', $id)->first();

        return view('auth.user.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('role')->where('id', $id)->first();
        $payment_methods = PaymentMethod::all();
        $roles = Role::select('name', 'id')->get();
        return view('auth.user.user.edit', compact('user', 'roles', 'payment_methods'));
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
        $user = User::with('role')->where('id', $id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => [
                'required',
                'numeric',
                'min:15',
                Rule::unique('users', 'mobile')->ignore($user)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user)
            ],
            'role_id' => 'required',
        ]);

        if($request->has('payment_methods'))
        {
            foreach ($request->payment_methods as $payment_methods) 
            {
                $payment_methods_array[] = $payment_methods;
            }
            $request->payment_methods = implode(',',$payment_methods_array);
        }   


        if($request->has('reserve_unreserve'))
        {
            $reserve_unreserve='ALLOWED';
        }
        else
        {
            $reserve_unreserve='NOT_ALLOWED';
        }

        if($request->has('remove_unremoved'))
        {
            $remove_unremoved='ALLOWED';
        }
        else
        {
            $remove_unremoved='NOT_ALLOWED';
        }


        if($request->has('res_unres_dmg_hide'))
        {
            $res_unres_dmg_hide='ALLOWED';
        }
        else
        {
            $res_unres_dmg_hide='NOT_ALLOWED';
        }



        $user->name = $request->name;
        $user->reserve_unreserve = $reserve_unreserve;
        $user->remove_unremoved = $remove_unremoved;
        $user->res_unres_dmg_hide = $res_unres_dmg_hide;
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->payment_method_not_allowed = $request->payment_methods;

        if ($request->has('password') && !empty($request->password)) {
            $request->validate([
                'password' => 'required|string|min:8',
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('/user')->with('success', 'User successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect('/user')->with('success', 'User successfully deleted!');
    }

    public function user_block($id, $status)
    {
        $user = User::with('role')->where('id', $id)->first();
        $user->status = $status;
        $user->save();
        return redirect('/user')->with('success', 'User Status Updated!');
    }

    //profile
    public function profile(Request $request)
    {
        $id = simple_crypt($request->id, 'd');
        $user = User::with('role')->where('id', $id)->first();
        return view('auth.user.user.profile', compact('user'));
    }

    //update profile
    public function update_profile(Request $request, $id)
    {
        $user = User::with('role')->where('id', $id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => [
                'required',
                'numeric',
                'min:15',
                Rule::unique('users', 'mobile')->ignore($user)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user)
            ],
        ]);

        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'User Profile successfully updated!');
    }

    //update password
    public function update_password(Request $request, $id)
    {
        $user = User::with('role')->where('id', $id)->first();

        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['same:new_password'],
        ]);

        if (!\Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'The Old Password does not match Original Password!');
        } else {
            $user->password = bcrypt($request->new_password);
            $user->save();

            return back()->with('success', 'Password successfully updated!');
        }
    }

    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }

    public function scan_ticket()
    {
        $payment_methods = PaymentMethod::all();
        $roles = Role::select('name', 'id')->get();
        $user_id = Auth::user()->id;
        $totalScans = BookingDetail::where('scanned_by', $user_id)->count();

        $today = date('Y-m-d');

        $todayScans = BookingDetail::where('scanned_by', $user_id)->whereDate('scan_time', $today)->count();

        $today_data = EventSeat::select(
            'event_seat.booking_id',
            'bookings.booking_id_str',
            'event_seat.name',
            'event_seat.label',
            DB::raw('MAX(event_seat.scan_time) as last_scan_time'),
            DB::raw('(SELECT COUNT(*) FROM event_seat es WHERE es.booking_id = event_seat.booking_id) as total_seat_count'),
            DB::raw('(SELECT COUNT(*) FROM event_seat es WHERE es.booking_id = event_seat.booking_id AND es.is_scanned = true) as scanned_seat_count'),
            DB::raw('(SELECT COUNT(*) FROM event_seat es WHERE es.booking_id = event_seat.booking_id AND es.is_scanned = false) as remaining_seat_count')
        )
        ->join('bookings', 'event_seat.booking_id', '=', 'bookings.id') // Adjust the join condition as necessary
        ->where('event_seat.scanned_by', $user_id)
        ->whereDate('event_seat.scan_time', $today)
        ->groupBy('event_seat.booking_id', 'bookings.booking_id_str', 'event_seat.name', 'event_seat.label')
        ->orderBy('last_scan_time', 'desc')
        ->take(10)
        ->get();

        $data['totalScans']=$totalScans;
        $data['todayScans']=$todayScans;

        return view('auth.user.user.scan', compact('today_data'), $data);
    }


    public function scan_ticket_check(Request $request)
    {
        if(!empty($request->booking_id))
        {
            $booking_id = $request->booking_id;
            $booking_id= simple_crypt($booking_id, 'd');
          $check = Booking::where('id', $booking_id)->count();
        }

        if(!empty($request->booking_reference))
        {
            $booking_reference = $request->booking_reference;
            $check = Booking::where('booking_id_str', $booking_reference)->count();
            if($check == 1)
            {
                $booking = Booking::where('booking_id_str', $booking_reference)->first();
                $booking_id = $booking->id;
            }
        }
       
       
        if($check == 1)
        {
            $response = array();
            $booking = Booking::where('id', $booking_id)->first();
            $payment_details = BookingPayment::where('booking_id', $booking_id)->first();
            $booking_details = BookingDetail::where('booking_id', $booking_id)->get();
            $customer_details = Customer::where('id', $booking->customer_id)->first();
            $seat_id_arr = [];
            $seat_no_arr = [];
            $show_name = true;

            foreach ($booking_details as $key => $booking_detail)
            {
                $seat_name = fetch_seat_no($booking_detail->seat_id);
                $seat_id_arr[] = $seat_name;
                $seat_no_arr[] = $seat_name->label . $seat_name->name;
            }
            
            if (getTicketType($booking_detail->ticket_type_id)) {
                $ticket_type_name = getTicketType($booking_detail->ticket_type_id)->ticket_type_name;
            } else {
                $ticket_type_name = '';
            }
            
            if (getEventScheduleList($booking->event_schedule_list_id)) {
                $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                $show_date=date('D d M Y', strtotime($event_date));
            }
                                                            
                                                            
            if (getEventShowTime($booking->event_show_time_id)) {
                $event_show_time = getEventShowTime($booking->event_show_time_id);
                $start_time=$event_show_time->start_time;
                $end_time=$event_show_time->end_time;
            }

            if (getVenue($booking->venue_id)) {
                $venue = getVenue($booking->venue_id);
                $venue_name = $venue->name;
            }
            if ($show_name == true)
            {
                $seat_no = implode(', ', $seat_no_arr);
            }
            else
            {
                $seat_no = '';
            }

            $payment_method_name = fetch_payment_method($payment_details->payment_method_id);
            $today = strtotime(date('Y-m-d'));
            $sd =  strtotime($event_date);
            if($sd != $today)
            {
                $response = array();
                $response['data'] = null;
                $response['status'] = 'NOT_FOUND';
                $response['message'] = 'Invalid QR,<Br>Please Check Date & Show Time';
               // return json_encode($response);
            }


            $start_time1 = new DateTime($start_time);
            $end_time1 = new DateTime($end_time);
            $adjusted_start_time = clone $start_time1;
            $adjusted_start_time->modify('-1 hour');
            $current_time = new DateTime();

            if ($current_time < $adjusted_start_time || $current_time > $end_time1) {

                $response = array();
                $response['data'] = null;
                $response['status'] = 'ENTRY_NOT_START';
                $response['message'] = 'Invalid QR,<Br>Please Check Date & Show Time';
                //return json_encode($response);
            }


            $seat_no_message = '';
            $booking_data = [];
            $booking_data['status'] = $booking['status'];
            $booking_data['booking_id'] = $booking_id;
            $booking_data['total_tickets'] = count($seat_no_arr);
            $booking_data['ticket_category'] = $ticket_type_name;
            $booking_data['ticket_name'] = $seat_no;
            $booking_data['tickets'] = $seat_no . ' - ' .count($seat_no_arr).' Ticket(s)' . ' (' . $ticket_type_name . ')' . $seat_no_message;
            $booking_data['seats'] = $seat_id_arr;
            $booking_data['show_date'] = date('D, d-M-Y', strtotime($event_date));
            $booking_data['show_time'] =  $start_time;
            $booking_data['payment_method_name'] =  $payment_method_name->name;
            $booking_data['venue'] = $venue_name;
            $booking_data['name'] = $customer_details['customer_name'];
            $booking_data['booking_id_str'] = $booking->booking_id_str;
            
            
            $maxColumns = 5;  // Number of columns per row
            $columnCount = 0; // Counter for columns in the current row

            $str ="<hr><div class='seat_row overflow-auto'><table>";
            $str .='<tr>';
            for ($i = 0; $i < count($seat_id_arr); $i++)
            {

                if ($columnCount % $maxColumns == 0) {
                    if ($columnCount > 0) {
                        $str .= '</tr><tr>'; // Close the previous row
                    }
                }

                $seat_id = $seat_id_arr[$i]->id;
                $label = $seat_id_arr[$i]->label;
                $name = $seat_id_arr[$i]->name;
                $is_scanned = $seat_id_arr[$i]->is_scanned;
              
                if($is_scanned == 1)
                {
                    $seat_name = "<div style='text-align:center'>$label$name</div>";
                    $str .= "<td  title='$seat_id' class='seatUnavailable hiddenCheckbox'>" . $seat_name."</td>";
                }
                else
                {
                    $seat_name = "<div style='margin-top:-14px; text-align:center'>$label$name</div>";
                    $str .= "<td onclick='choose_seat($seat_id)' title='$seat_id' class='seatAvailable hiddenCheckbox'><input title='seatAvailable' type='checkbox' name='seat_ids[]' value='$seat_id'>" . $seat_name."</td>";
                }
                $columnCount++;
            }
            $str .='</tr>';
            $str .='</table>';
            $str .='</div>';
            $booking_data['seat_html'] = $str;
            $response['data'] = $booking_data;
            $response['status'] = 'FOUND';
            $response['message'] = 'Booking Found Succesfull';
            return json_encode($response);
        }
        else
        {
            $response = array();
            $response['data'] = null;
            $response['status'] = 'NOT_FOUND';
            $response['message'] = 'Booking Not Found';
            return json_encode($response);
        }
    }

    // public function update_ticket_scan(Request $request)
    // {
    //     $request->validate([
    //         'seat_ids' => 'required|array',
    //         'seat_ids.*' => 'integer|exists:event_seat,id',
    //         'booking_id' => 'required|integer|exists:booking_details,booking_id',
    //     ]);

    //     $seatIds = $request->input('seat_ids');
    //     $bookingId = $request->input('booking_id');
    //     $scannedBy = Auth::user()->id;

    //     DB::beginTransaction();

    //     try {
    //         // Fetch seats to check their availability
    //         $seats = EventSeat::whereIn('id', $seatIds)
    //             ->where('is_scanned', false)
    //             ->get();

    //         if ($seats->count() != count($seatIds)) {
    //             // Redirect with an error message if some seats are not available
    //             return redirect()->back()->with('error', 'One or more seats are not available for check-in.');
    //         }

    //         // Update seats
    //         EventSeat::whereIn('id', $seatIds)
    //             ->update([
    //                 'is_scanned' => true,
    //                 'scan_time' => now(),
    //                 'scanned_by' => $scannedBy,
    //             ]);

    //         // Optionally update booking details if needed
    //         BookingDetail::whereIn('seat_id', $seatIds)
    //             ->update([
    //                 'is_scanned' => true,
    //                 'scan_time' => now(),
    //                 'scanned_by' => $scannedBy,
    //             ]);

    //         DB::commit();

    //         // Redirect with a success message
    //         return redirect()->back()->with('success', 'Seats Scanned successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         // Redirect with an error message if something goes wrong
    //         return redirect()->back()->with('error', 'Unable to Save Scanning ' . $e->getMessage());
    //     }
    // }
    
    public function update_ticket_scan(Request $request)
    {
        $request->validate([
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'integer|exists:event_seat,id',
            'booking_id' => 'required|integer|exists:booking_details,booking_id',
        ]);
    
        $seatIds = $request->input('seat_ids');
        $bookingId = $request->input('booking_id');
        $scannedBy = Auth::user()->id;
    
        DB::beginTransaction();
    
        try {
            $seats = EventSeat::whereIn('id', $seatIds)
                ->where('is_scanned', false)
                ->get();
    
            if ($seats->count() != count($seatIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or more seats are not available for check-in.'
                ], 400);
            }
    
            EventSeat::whereIn('id', $seatIds)->update([
                'is_scanned' => true,
                'scan_time' => now(),
                'scanned_by' => $scannedBy,
            ]);
    
            BookingDetail::whereIn('seat_id', $seatIds)->update([
                'is_scanned' => true,
                'scan_time' => now(),
                'scanned_by' => $scannedBy,
            ]);
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Seats scanned successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Unable to Save Scanning: ' . $e->getMessage()
            ], 500);
        }
    }

    
    public function scan_ticket_report()
    {
        $role_id = Auth::user()->role_id;
        $role = Role::select('is_admin')->find($role_id);
        $is_admin = $role->is_admin;
        
        
        $user_id = Auth::user()->id;
        $totalScans = BookingDetail::where('scanned_by', $user_id)->count();
        $today = date('Y-m-d');
        $todayScans = BookingDetail::where('scanned_by', $user_id)->whereDate('scan_time', $today)->count();
      
        
       $today_data = EventSeat::select(
            'event_seat.booking_id',
            'bookings.booking_id_str',
             'bookings.total_quantity',
            DB::raw('MAX(event_seat.scan_time) as last_scan_time'),
            DB::raw('COUNT(*) as total_seat_count'),
            DB::raw('SUM(CASE WHEN event_seat.is_scanned = true THEN 1 ELSE 0 END) as scanned_seat_count'),
            DB::raw('SUM(CASE WHEN event_seat.is_scanned = false THEN 1 ELSE 0 END) as remaining_seat_count'),
            DB::raw('GROUP_CONCAT(CONCAT(event_seat.label, event_seat.name) SEPARATOR ", ") as seat_info'), // Concatenate label and name
            'event_seat.updated_at',
            'users.name as scanned_by_name' // Add scanning person's name
        )
        ->join('bookings', 'event_seat.booking_id', '=', 'bookings.id')
        ->join('users', 'event_seat.scanned_by', '=', 'users.id') // Join with the users table to get the scanner's name
        ->whereNotNull('event_seat.scanned_by');
        
        if ($is_admin == 0) {
            $today_data->where('event_seat.scanned_by', $user_id)
                       ->whereDate('event_seat.scan_time', $today);
        }
        
        $today_data = $today_data->groupBy(
            'event_seat.booking_id', 
            'bookings.booking_id_str', 
            'event_seat.updated_at', 
            'users.name' // Group by scanned_by_name
        )
        ->orderBy('last_scan_time', 'desc')
        ->get();
        
        
        $data['totalScans']=$totalScans;
        $data['todayScans']=$todayScans;
        return view('auth.user.user.scan-report', compact('today_data'), $data);
    }
}
