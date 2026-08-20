<?php
use App\Mail\MyMail;

use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Pincode;
use App\Models\Organizer;
use App\Models\Venue;
use App\Models\SubVenue;
use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\EventScheduleList;
use App\Models\EventShowTime;
use App\Models\EventShowSchedule;
use App\Models\TicketType;
use App\Models\EventTicket;
use App\Models\EventSeat;
use App\Models\PaymentMethod;
use App\Models\CouponCategory;
use App\Models\Coupon;
use App\Models\Company;
use App\Models\BookingPlatform;
use App\Models\Setting;
use App\Models\Booking;
use App\Models\Layout;
use App\Models\LayoutDetail;
use App\Models\BookingDetail;
use App\Models\BookingPayment;
use App\Models\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Mail;

ini_set('memory_limit', '-1');

//nice date
if (!function_exists('nice_date')) {
    function nice_date($value = '', $format = 'd/m/Y')
    {
        return date($format, strtotime($value));
    }
}

//function to get number of days
if (!function_exists('dateDiffInDays')) {
    function dateDiffInDays($date1, $date2)
    {
        // Calulating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);

        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400));
    }
}

// Function to get all the dates in given range
if (!function_exists('getDatesFromRange')) {
    function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        // Declare an empty array
        $array = [];

        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        // Use loop to store date into array
        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        // Return the array elements
        return $array;
    }
}

if (!function_exists('simple_crypt')) {
    function simple_crypt($string, $action = 'e')
    {
        // you may change these values to your own
        $secret_key = 'cgllp@kanpur';
        $secret_iv = 'ZXCVBNMLKJHGFDSAQWERTYUIOP';

        $output = false;
        $encrypt_method = 'AES-256-CBC';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } elseif ($action == 'd') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
}

//delete image from folder
if (!function_exists('delete_image_from_server')) {
    function delete_image_from_server($path)
    {
        $full_path = $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            @unlink($full_path);
        }
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('unique_id_generate')) {
    function unique_id_generate()
    {
        date_default_timezone_set('Asia/Kolkata');
        $base = 'TKT' . date('dmy');
        $random = strtoupper(rand(11, 99));
        $un = uniqid();
        $un_sh = sha1($un);
        $unique = substr($un_sh, 8, 13);
        $unique = strtoupper($unique);
        return $full_random = $base . $random . $unique;
    }
}

//get setting
if (!function_exists('getSetting')) {
    function getSetting($id = 1)
    {
        $setting = Setting::where('id', $id)->first();
        return $setting;
    }
}

//get user
if (!function_exists('getUser')) {
    function getUser($id = 0)
    {
        if ($id == 0) {
            $users = User::with('role')
                ->where('status', 'ACTIVE')
                ->get();
        } else {
            $users = User::with('role')
                ->where('id', $id)
                ->first();
        }
        return $users;
    }
}

//get user
if (!function_exists('getCustomer')) {
    function getCustomer($id = 0)
    {
        if ($id == 0) {
            $customers = Customer::where('status', 'ACTIVE')->get();
        } else {
            $customers = Customer::where('id', $id)->first();
        }
        return $customers;
    }
}

//get state
if (!function_exists('getState')) {
    function getState($id = 0)
    {
        if ($id == 0) {
            $states = State::where('status', 'ACTIVE')->get();
        } else {
            $states = State::where('id', $id)->first();
        }
        return $states;
    }
}

//get city
if (!function_exists('getCity')) {
    function getCity($id = 0)
    {
        if ($id == 0) {
            $cities = City::where('status', 'ACTIVE')->get();
        } else {
            $cities = City::where('id', $id)->first();
        }
        return $cities;
    }
}

//get city by state ID
if (!function_exists('getCityByStateID')) {
    function getCityByStateID($state_id)
    {
        if ($state_id) {
            $cities = City::where(['state_id' => $state_id, 'status' => 'ACTIVE'])->get();
            return $cities;
        }
    }
}

//get pincode
if (!function_exists('getPincode')) {
    function getPincode($id = 0)
    {
        if ($id == 0) {
            $pincodes = Pincode::where('status', 'ACTIVE')->get();
        } else {
            $pincodes = Pincode::where('id', $id)->first();
        }
        return $pincodes;
    }
}

//get pincode by state ID
if (!function_exists('getPincodeByStateID')) {
    function getPincodeByStateID($state_id)
    {
        if ($state_id) {
            $pincodes = Pincode::where(['state_id' => $state_id, 'status' => 'ACTIVE'])->get();
            return $pincodes;
        }
    }
}

//get pincode by city ID
if (!function_exists('getPincodeByCityID')) {
    function getPincodeByCityID($city_id)
    {
        if ($city_id) {
            $pincodes = Pincode::where(['city_id' => $city_id, 'status' => 'ACTIVE'])->get();
            return $pincodes;
        }
    }
}

//get organizer
if (!function_exists('getOrganizer')) {
    function getOrganizer($id = 0)
    {
        if ($id == 0) {
            $organizers = Organizer::where('status', 'ACTIVE')->get();
        } else {
            $organizers = Organizer::where('id', $id)->first();
        }
        return $organizers;
    }
}

//get venue
if (!function_exists('getVenue')) {
    function getVenue($id = 0)
    {
        if ($id == 0) {
            $venues = Venue::where('status', 'ACTIVE')->get();
        } else {
            $venues = Venue::where('id', $id)->first();
        }
        return $venues;
    }
}

//get venue by state ID
if (!function_exists('getVenueByStateID')) {
    function getVenueByStateID($state_id)
    {
        if ($state_id) {
            $venues = Venue::where(['state_id' => $state_id, 'status' => 'ACTIVE'])->get();
            return $venues;
        }
    }
}

//get venue by city ID
if (!function_exists('getVenueByCityID')) {
    function getVenueByCityID($city_id)
    {
        if ($city_id) {
            $venues = Venue::where(['city_id' => $city_id, 'status' => 'ACTIVE'])->get();
            return $venues;
        }
    }
}

//get venue by pincode ID
if (!function_exists('getVenueByPincodeID')) {
    function getVenueByPincodeID($pincode_id)
    {
        if ($pincode_id) {
            $venues = Venue::where(['pincode_id' => $pincode_id, 'status' => 'ACTIVE'])->get();
            return $venues;
        }
    }
}

//get sub venue
if (!function_exists('getSubVenue')) {
    function getSubVenue($id = 0)
    {
        if ($id == 0) {
            $sub_venues = SubVenue::where('status', 'ACTIVE')->get();
        } else {
            $sub_venues = SubVenue::where('id', $id)->first();
        }
        return $sub_venues;
    }
}

//get sub venue by venue ID
if (!function_exists('getSubVenueByVenueID')) {
    function getSubVenueByVenueID($venue_id)
    {
        if ($venue_id) {
            $sub_venues = SubVenue::where(['venue_id' => $venue_id, 'status' => 'ACTIVE'])->get();
            return $sub_venues;
        }
    }
}

//get event
if (!function_exists('getEvent')) {
    function getEvent($id = 0)
    {
        if ($id == 0) {
            $events = Event::where('status', 'ACTIVE')->get();
        } else {
            $events = Event::where('id', $id)->first();
        }
        return $events;
    }
}

//get event schedule
if (!function_exists('getEventSchedule')) {
    function getEventSchedule($id = 0)
    {
        if ($id == 0) {
            $event_schedules = EventSchedule::where('status', 'ACTIVE')->get();
        } else {
            $event_schedules = EventSchedule::where('id', $id)->first();
        }
        return $event_schedules;
    }
}

//get event schedule by event ID
if (!function_exists('getEventScheduleByEventID')) {
    function getEventScheduleByEventID($event_id)
    {
        if ($event_id) {
            $event_schedules = EventSchedule::where(['event_id' => $event_id, 'status' => 'ACTIVE'])->get();
            return $event_schedules;
        }
    }
}

//get event schedule list
if (!function_exists('getEventScheduleList')) {
    function getEventScheduleList($id = 0)
    {
        if ($id == 0) {
            $event_schedule_lists = EventScheduleList::where('status', 'ACTIVE')->get();
        } else {
            $event_schedule_lists = EventScheduleList::where('id', $id)->first();
        }
        return $event_schedule_lists;
    }
}

//get event schedule list by event shedule ID
if (!function_exists('getEventScheduleListByEventScheduleID')) {
    function getEventScheduleListByEventScheduleID($event_schedule_id)
    {
        if($event_schedule_id)
        {
            $user_id = Auth::user()->id;
            
             $user_with_role_data = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.*')
            ->where('users.id', $user_id)
            ->first();
            
            

            if(!isset($user_id)  || (isset($user_id) && $user_with_role_data->is_admin == 1))
            {
                $event_schedule_lists = EventScheduleList::where(['event_schedule_id' => $event_schedule_id, 'status' => 'ACTIVE'])->get();
                $event_show_times = EventShowTime::where(['event_schedule_id' => $event_schedule_id, 'status' => 'ACTIVE'])->get();
                foreach ($event_schedule_lists as $event_schedule_list)
                {
                    $event_schedule_list->event_date=date('D jS F, Y', strtotime($event_schedule_list->event_date));
                }
            }
            else
            {
                 $date = today()->format('Y-m-d');
                
               
                $event_schedule_lists = EventScheduleList::where(['event_schedule_id' => $event_schedule_id, 'status' => 'ACTIVE'])->where('event_date', '>=', $date)->get();
                $event_show_times = EventShowTime::where(['event_schedule_id' => $event_schedule_id, 'status' => 'ACTIVE'])->get();
                foreach ($event_schedule_lists as $event_schedule_list)
                {
                    $event_schedule_list->event_date=date('D jS F, Y', strtotime($event_schedule_list->event_date));
                }
            }
            // $event_schedule_lists = EventScheduleList::where(['event_schedule_id'=>$event_schedule_id,'status'=>'ACTIVE'])->get();
            return $event_schedule_lists;
        }
    }
}

if (!function_exists('getEventScheduleListByEventScheduleIDWithJson')) {
    function getEventScheduleListByEventScheduleIDWithJson($json_array)
    {
        $event_schedule_list_array = [];
        //$json_arrays = json_decode($json_array);
        $json_arrays = $json_array;
        if ($json_arrays) {
            foreach ($json_arrays as $id) {
                $event_schedule_list = EventScheduleList::where('id', $id)->first();
                if ($event_schedule_list) {
                    $event_schedule_list_array[] = date('d-m-Y', strtotime($event_schedule_list->event_date));
                }
            }
        }
        return json_encode($event_schedule_list_array);
    }
}

//get event show time
if (!function_exists('getEventShowTime')) {
    function getEventShowTime($id = 0)
    {
        if ($id == 0) {
            $event_show_time = EventShowTime::where('status', 'ACTIVE')->get();
        } else {
            $event_show_time = EventShowTime::where('id', $id)->first();
        }
        return $event_show_time;
    }
}

//get event show time by event shedule ID
if (!function_exists('getEventShowTimeByEventScheduleID')) {
    function getEventShowTimeByEventScheduleID($event_schedule_id)
    {
        if ($event_schedule_id) {
            $event_show_times = EventShowTime::where(['event_schedule_id' => $event_schedule_id, 'status' => 'ACTIVE'])->get();
            return $event_show_times;
        }
    }
}

//get ticket type
if (!function_exists('getTicketType')) {
    function getTicketType($id = 0)
    {
        if ($id == 0) {
            $ticket_types = TicketType::where('status', 'ACTIVE')->get();
        } else {
            $ticket_types = TicketType::where('id', $id)->first();
        }
        return $ticket_types;
    }
}
if (!function_exists('getTicketTypeWithJson')) {
    function getTicketTypeWithJson($json_array)
    {
        $ticket_type_name_array = [];
        $json_arrays = json_decode($json_array);
        if ($json_arrays) {
            foreach ($json_arrays as $id) {
                $ticket_types = TicketType::where('id', $id)->first();
                $ticket_type_name_array[] = $ticket_types->ticket_type_name;
            }
        }
        return json_encode($ticket_type_name_array);
    }
}

//get ticket type by event ID
if (!function_exists('getTicketTypeByEventID')) {
    function getTicketTypeByEventID($event_id)
    {
        if ($event_id) {
            $ticket_types = TicketType::where(['event_id' => $event_id, 'status' => 'ACTIVE'])->get();
            return $ticket_types;
        }
    }
}

//get coupon category
if (!function_exists('getCouponCategory')) {
    function getCouponCategory($id = 0)
    {
        if ($id == 0) {
            $coupon_category = CouponCategory::where('status', 'ACTIVE')->get();
        } else {
            $coupon_category = CouponCategory::where('id', $id)->first();
        }
        return $coupon_category;
    }
}

//get coupon
if (!function_exists('getCoupon')) {
    function getCoupon($id = 0)
    {
        if ($id == 0) {
            $coupons = Coupon::where('status', 'ACTIVE')->get();
        } else {
            $coupons = Coupon::where('id', $id)->first();
        }
        return $coupons;
    }
}

//get company
if (!function_exists('getCompany')) {
    function getCompany($id = 0)
    {
        if ($id == 0) {
            $company = Company::where('status', 'ACTIVE')->get();
        } else {
            $company = Company::where('id', $id)->first();
        }
        return $company;
    }
}

//get payment method
if (!function_exists('getPaymentMethod')) {
    function getPaymentMethod($id = 0)
    {
        if ($id == 0) {
            $payment_methods = PaymentMethod::where('status', 'ACTIVE')->get();
        } else {
            $payment_methods = PaymentMethod::where('id', $id)->first();
        }
        return $payment_methods;
    }
}

//get payment method
if (!function_exists('getAllPaymentMethod')) {
    function getAllPaymentMethod()
    {
        $payment_methods = PaymentMethod::select('id', 'name', 'method_type', 'color')
            ->where('status', 'ACTIVE')
            ->get();
        return $payment_methods;
    }
}

//get booking platform
if (!function_exists('getBookingPlatform')) {
    function getBookingPlatform($id = 0)
    {
        if ($id == 0) {
            $booking_platform = BookingPlatform::where('status', 'ACTIVE')->get();
        } else {
            $booking_platform = BookingPlatform::where('id', $id)->first();
        }
        return $booking_platform;
    }
}

//get layout
if (!function_exists('getLayout')) {
    function getLayout($id = 0)
    {
        if ($id == 0) {
            $data = Layout::where('status', 'ACTIVE')->get();
        } else {
            $data = Layout::where('id', $id)->first();
        }
        return $data;
    }
}

//find seat id
if (!function_exists('find_seat_id')) {
    function find_seat_id($layout_id, $row, $col)
    {
        $count = LayoutDetail::where(['layout_id' => $layout_id, 'row_no' => $row, 'col_no' => $col])->count();
        if ($count > 0) {
            $result = LayoutDetail::where(['layout_id' => $layout_id, 'row_no' => $row, 'col_no' => $col])->first();
            return $result->id;
        } else {
            return false;
        }
    }
}

//check seat visibility
if (!function_exists('check_seat_visibility')) {
    function check_seat_visibility($seat_id)
    {
        $count = LayoutDetail::where(['id' => $seat_id, 'is_visible' => 'YES'])->count();
        if ($count == 1) {
            $result = LayoutDetail::where(['id' => $seat_id, 'is_visible' => 'YES'])->first();
            return $result;
        } else {
            return false;
        }
    }
}


//check seat removed
if (!function_exists('check_seat_removed')) {
    function check_seat_removed($seat_id)
    {
        $count = LayoutDetail::where(['id' => $seat_id, 'is_removed' => 'YES'])->count();
        if ($count == 1) {
            $result = LayoutDetail::where(['id' => $seat_id, 'is_removed' => 'YES'])->first();
            return $result;
        } else {
            return false;
        }
    }
}

if (!function_exists('check_seat_labeled')) {
    function check_seat_labeled($seat_id)
    {
        $count = LayoutDetail::where(['id' => $seat_id, 'is_labeled' => 'YES'])->count();
        if ($count == 1) {
            $result = LayoutDetail::where(['id' => $seat_id, 'is_labeled' => 'YES'])->first();
            return $result;
        } else {
            return false;
        }
    }
}



//check seat reserved
if (!function_exists('check_seat_reserved')) {
    function check_seat_reserved($seat_id)
    {
        $count = LayoutDetail::where(['id' => $seat_id, 'is_reserved' => 'YES'])->count();
        if ($count == 1) {
            $result = LayoutDetail::where(['id' => $seat_id, 'is_reserved' => 'YES'])->first();
            return $result;
        } else {
            return false;
        }
    }
}

//check seat damaged
if (!function_exists('check_seat_damaged')) {
    function check_seat_damaged($seat_id)
    {
        $count = LayoutDetail::where(['id' => $seat_id, 'is_damaged' => 'YES'])->count();
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }
}

//check event seat damaged
if (!function_exists('check_event_seat_damaged')) {
    function check_event_seat_damaged($seat_id)
    {
        $count = EventSeat::where(['id' => $seat_id, 'is_damaged' => 'YES'])->count();
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }
}

//find event seat id
if (!function_exists('find_event_seat_id')) {
    function find_event_seat_id($eslid_temp, $estid_temp, $event_ticket_id, $layout_id, $row, $col)
    {
        $count = EventSeat::where(['event_schedule_list_id' => $eslid_temp, 'event_show_time_id' => $estid_temp, 'event_ticket_id' => $event_ticket_id, 'layout_id' => $layout_id, 'row_no' => $row, 'col_no' => $col])->count();
        if ($count > 0) {
            $result = EventSeat::where(['event_schedule_list_id' => $eslid_temp, 'event_show_time_id' => $estid_temp, 'event_ticket_id' => $event_ticket_id, 'layout_id' => $layout_id, 'row_no' => $row, 'col_no' => $col])->first();
            return $result->id;
        } else {
            return false;
        }
    }
}

//check event seat visibility
if (!function_exists('check_event_seat_visibility')) {
    function check_event_seat_visibility($seat_id)
    {
        $count = EventSeat::where(['id' => $seat_id, 'is_visible' => 'YES'])->count();
        if ($count == 1) {
            $result = EventSeat::where(['id' => $seat_id, 'is_visible' => 'YES'])->first();
            return $result;
        } else {
            return false;
        }
    }
}

//check event seat reserved
if (!function_exists('check_event_seat_reserved')) {
    function check_event_seat_reserved($seat_id)
    {
        $count = EventSeat::where(['id' => $seat_id, 'is_reserved' => 'YES'])->count();
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('fetch_event_ticket_type_id')) {
    function fetch_event_ticket_type_id($seat_id)
    {
        $count = EventSeat::where(['id' => $seat_id])->count();
        if ($count == 1) {
            $result = EventSeat::where(['id' => $seat_id])->first();
            return $result;
        } else {
            return false;
        }
    }
}

//find booking event seat id
if (!function_exists('find_booking_event_seat_id')) {
    function find_booking_event_seat_id($event_id, $eslid_temp, $estid_temp, $layout_id, $row, $col)
    {
        $result = EventSeat::where(['event_id' => $event_id, 'event_schedule_list_id' => $eslid_temp, 'event_show_time_id' => $estid_temp, 'layout_id' => $layout_id, 'row_no' => $row, 'col_no' => $col])->first();
        if (isset($result)) {
            return $result->id;
        } else {
            return false;
        }

        // $count = EventSeat::where(['event_id' => $event_id, 'event_schedule_list_id'=>$eslid_temp, 'event_show_time_id'=>$estid_temp, 'layout_id' => $layout_id, 'row_no' => $row, 'col_no' => $col])->count();
        // if($count > 0)
        // {
        //     $result = EventSeat::where(['event_id' => $event_id, 'event_schedule_list_id'=>$eslid_temp, 'event_show_time_id'=>$estid_temp, 'layout_id' => $layout_id, 'row_no' => $row, 'col_no' => $col])->first();
        //     return $result->id;
        // }
        // else
        // {
        //     return false;
        // }
    }
}

//find booking event seat id
if (!function_exists('find_booking_event')) {
    function find_booking_event($event_id, $eslid_temp, $estid_temp, $layout_id)
    {
        $result = EventSeat::select('id', 'row_no', 'col_no')
            ->where(['event_id' => $event_id, 'event_schedule_list_id' => $eslid_temp, 'event_show_time_id' => $estid_temp, 'layout_id' => $layout_id])
            ->get();

        $data = [[]];
        foreach ($result as $row) {
            // echo $row->row_no;  echo " | ";
            // echo $row->col_no; echo " | ";
            // echo $row->id; echo " | ";
            // echo "<br>";
            $data[$row->row_no][$row->col_no] = $row->id;
        }

        if (isset($data)) {
            return $data;
        } else {
            return false;
        }

        // $count = EventSeat::where(['event_id' => $event_id, 'event_schedule_list_id'=>$eslid_temp, 'event_show_time_id'=>$estid_temp, 'layout_id' => $layout_id, 'row_no' => $row, 'col_no' => $col])->count();
        // if($count > 0)
        // {
        //     $result = EventSeat::where(['event_id' => $event_id, 'event_schedule_list_id'=>$eslid_temp, 'event_show_time_id'=>$estid_temp, 'layout_id' => $layout_id, 'row_no' => $row, 'col_no' => $col])->first();
        //     return $result->id;
        // }
        // else
        // {
        //     return false;
        // }
    }
}

//get cart by seat id
if (!function_exists('getCartBySeatID')) {
    function getCartBySeatID($id)
    {
        $data = \App\Models\Cart::where('seat_id', $id)->first();
        return $data;
    }
}

//get all cart seat
if (!function_exists('fetch_all_cart_seat')) {
    function fetch_all_cart_seat($user_id = 0)
    {
        if ($user_id == 0) {
            $data = \App\Models\Cart::all();
        } else {
            $data = \App\Models\Cart::where('user_id', $user_id)->get();
        }
        return $data;
    }
}

if (!function_exists('fetch_all_customer_cart_seat')) {
    function fetch_all_customer_cart_seat($user_id)
    {
        $data = \App\Models\CustomerCart::where('user_id', $user_id)->get();
        return $data;
    }
}

if (!function_exists('fetch_current_show_cart_seat')) {
    function fetch_current_show_cart_seat($conditions)
    {
        if (count($conditions) > 0) {
            $data = \App\Models\CustomerCart::where($conditions)->get();
            return $data;
        }
       
    }
}

if (!function_exists('fetch_payment_method')) {
    function fetch_payment_method($payment_method_id)
    {
        $data = \App\Models\PaymentMethod::where('id', $payment_method_id)->first();
        return $data;
    }
}

if (!function_exists('fetch_seat_no')) {
    function fetch_seat_no($seat_id)
    {
        $data = EventSeat::where('id', $seat_id)->first();
        return $data;
    }
}

if (!function_exists('fetch_layout_seat_no')) {
    function fetch_layout_seat_no($seat_id)
    {
        $data = LayoutDetail::where('id', $seat_id)->first();
        return $data;
    }
}

if (!function_exists('fetch_layout_seat_name')) {
    function fetch_layout_seat_name($seat_id)
    {
        $data = EventSeat::where('id', $seat_id)->first();
        return $data;
    }
}

if (!function_exists('fetch_all_seat_data')) {
    function fetch_all_seat_data($conditions = [])
    {
        if (count($conditions) > 0) {
            $data = EventSeat::where($conditions)->get();
        } else {
            $data = EventSeat::all();
        }
        return $data;
    }
}

//get payment method by vendor id
if (!function_exists('getPaymentMethodByvendor')) {
    function getPaymentMethodByvendor($id, $start_date, $end_date)
    {
        if (empty($start_date)) {
            $data = DB::select('SELECT sum(booking_payments.amount) amount, sum(booking_payments.discount) discount,  payment_method.name, payment_method.show_hide_price, payment_method.operation FROM booking_payments, payment_method where booking_id in (SELECT bookings.id from bookings where bookings.vendor_id=' . $id . ') and booking_payments.deleted_at is null and booking_payments.payment_method_id=payment_method.id GROUP by booking_payments.payment_method_id');
        } else {
            if ($start_date == $end_date) {
                //$payment_methods = PaymentMethod::where('id', $id)->first();
                $data = DB::select(
                    'SELECT sum(booking_payments.amount) amount, sum(booking_payments.discount) discount,booking_payments.created_at, payment_method.name, payment_method.show_hide_price, payment_method.operation FROM booking_payments, payment_method where booking_id in (SELECT bookings.id from bookings where bookings.vendor_id=' .
                        $id .
                        " and   date(bookings.created_at) = '" .
                        $start_date .
                        "') and booking_payments.deleted_at is null and
                    booking_payments.payment_method_id=payment_method.id GROUP by booking_payments.payment_method_id"
                );
            } else {
                $data = DB::select('SELECT sum(booking_payments.amount) amount, sum(booking_payments.discount) discount, booking_payments.created_at, payment_method.name,payment_method.show_hide_price, payment_method.operation FROM booking_payments, payment_method where booking_id in (SELECT bookings.id from bookings where bookings.vendor_id=' . $id . " and   date(bookings.created_at) >= '" . $start_date . "' and date( bookings.created_at) <= '" . $end_date . "') and booking_payments.deleted_at is null and booking_payments.payment_method_id=payment_method.id GROUP by booking_payments.payment_method_id");
            }
        }
        return $data;
    }
}
//get ticket type name
if (!function_exists('getTicketType')) {
    function getTicketType($id = 0)
    {
        if ($id == 0) {
            $ticket_type = TicketType::where('status', 'ACTIVE')->get();
        } else {
            $ticket_type = TicketType::where('id', $id)->first();
        }
        return $ticket_type;
    }
}
//get ticket quantity
if (!function_exists('getTicketQuantity')) {
    function getTicketQuantity($id = 0)
    {
        if ($id == 0) {
            $query = BookingDetail::select('booking_details.booking_id', 'booking_details.ticket_type_id', 'booking_details.quantity', DB::raw('SUM(booking_details.quantity) as totalQuantity'))
                ->where('ticket_type_id', $id)
                ->first();
        } else {
            $query = BookingDetail::select('booking_details.booking_id', 'booking_details.ticket_type_id', 'booking_details.quantity', DB::raw('SUM(booking_details.quantity) as totalQuantity'))
                ->where('ticket_type_id', $id)
                ->first();
        }
        return $query;
    }
}
//get ticket amount
if (!function_exists('getTicketAmount')) {
    function getTicketAmount($id = 0)
    {
        if ($id == 0) {
            $query = BookingDetail::select('booking_details.booking_id', 'booking_details.ticket_type_id', 'booking_details.base_price', DB::raw('SUM(booking_details.base_price) as totalPrice'))
                ->where('ticket_type_id', $id)
                ->first();
        } else {
            $query = BookingDetail::select('booking_details.booking_id', 'booking_details.ticket_type_id', 'booking_details.base_price', DB::raw('SUM(booking_details.base_price) as totalPrice'))
                ->where('ticket_type_id', $id)
                ->first();
        }
        return $query;
    }
}

//get payment complementry amount
if (!function_exists('getPaymentMethodAmount')) {
    function getPaymentMethodAmount($id = 0)
    {
        if ($id == 0) {
            $query = BookingPayment::select('booking_payments.amount', 'booking_payments.payment_method_id', DB::raw('SUM(booking_payments.amount) as total_amount, SUM(booking_payments.discount) as total_discount'))
                ->where('payment_method_id', $id)
                ->first();
        } else {
            $query = BookingPayment::select('booking_payments.amount', 'booking_payments.payment_method_id', DB::raw('SUM(booking_payments.amount) as total_amount, SUM(booking_payments.discount) as total_discount'))
                ->where('payment_method_id', $id)
                ->first();
        }
        return $query;
    }
}

//get event Time
if (!function_exists('get_Event_date')) {
    function get_Event_date($id = 0)
    {
        if ($id == 0) {
            $events_date = EventScheduleList::where('status', 'ACTIVE', 'id', $id)->get();
        } else {
            $events_date = EventScheduleList::where('id', $id)->first();
        }
        return $events_date;
    }
}
if (!function_exists('show_time_data_exist_in_db')) {
    function show_time_data_exist_in_db($event_schedule_list_id, $event_show_time_id, $event_id)
    {
        //echo $event_schedule_list_id;
        //echo $event_show_time_id;
        //echo $event_id;
        //exit;
        $data = EventShowSchedule::where('event_schedule_list_id', $event_schedule_list_id)
            ->where('event_show_time_id', $event_show_time_id)
            ->where('event_id', $event_id)
            ->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('show_time_in_db')) {
    function show_time_in_db($event_show_time_id, $event_id)
    {
        $time_data = EventShowTime::where('id', $event_show_time_id)
            ->where('event_id', $event_id)
            ->first();
        return $time_data;
    }
}

if (!function_exists('fetch_booking_payments_data')) {
    function fetch_booking_payments_data($booking_id)
    {
        $booking_payments_data = \App\Models\BookingPayment::where('booking_id', $booking_id)->first();
        return $booking_payments_data;
    }
}

if (!function_exists('fetch_booking_payments_data_deleted')) {
    function fetch_booking_payments_data_deleted($booking_id)
    {
        $booking_payments_data = \App\Models\BookingPayment::where('booking_id', $booking_id)
            ->onlyTrashed()
            ->first();
        return $booking_payments_data;
    }
}

if (!function_exists('fetch_booking_deails')) {
    function fetch_booking_deails($booking_id)
    {
        $booking = Booking::where('id', $booking_id)->first();
        return $booking;
    }
}

//fetch booking details data
if (!function_exists('fetch_booking_details_data')) {
    function fetch_booking_details_data($booking_id)
    {
        // $ticket_query = BookingDetail::join('ticket_type', 'booking_details.ticket_type_id', '=', 'ticket_type.id')->select('booking_details.*','bookings.*')->get();
        $ticket_query = BookingDetail::join('ticket_type', 'booking_details.ticket_type_id', '=', 'ticket_type.id')
            ->select('ticket_type.*', 'booking_details.ticket_type_id', DB::raw('COUNT(booking_details.is_scanned) as total_ticket_scanned') , DB::raw('COUNT(booking_details.ticket_type_id) as total_ticket'))
            ->where('booking_id', $booking_id)
            ->groupBy('booking_details.ticket_type_id')
            ->get();
        return $ticket_query;
    }
}

if (!function_exists('fetch_booking_details_data_deleted')) {
    function fetch_booking_details_data_deleted($booking_id)
    {
        // $ticket_query = BookingDetail::join('ticket_type', 'booking_details.ticket_type_id', '=', 'ticket_type.id')->select('booking_details.*','bookings.*')->get();
        $ticket_query = BookingDetail::join('ticket_type', 'booking_details.ticket_type_id', '=', 'ticket_type.id')
            ->select('ticket_type.*', 'booking_details.ticket_type_id', DB::raw('COUNT(booking_details.ticket_type_id) as total_ticket'))
            ->where('booking_id', $booking_id)
            ->onlyTrashed()
            ->groupBy('booking_details.ticket_type_id')
            ->get();
        return $ticket_query;
    }
}


if (!function_exists('fetch_all_seat_by_booking_id')) {
    function fetch_all_seat_by_booking_id($booking_id)
    {
        $result = EventSeat::where(['booking_id' => $booking_id])->orderBy('name', 'asc')->get();
        return $result;
    }
}


if (!function_exists('update_whatsapp_sent')) {
    function update_whatsapp_sent($id)
    {
        return Booking::where(['id' => $id])->update(['is_whatsapp_sent' => 'YES']);
    }
}


if (!function_exists('update_email_sent')) {
    function update_email_sent($id)
    {
        return Booking::where(['id' => $id])->update(['is_email_sent' => 'YES']);
    }
}

if (!function_exists('random_strings')) {
    function random_strings($length_of_string)
    {
        // String of all alphanumeric character
        $str_result = '123456789ABCDEFGHJKMNPQRSTUVWXYZ';
        // Shuffle the $str_result and returns substring  of specified length
        $booking_id_str=substr(str_shuffle($str_result),  0, $length_of_string);
        $count = Booking::where(['booking_id_str' => $booking_id_str ])->count();
        if($count==0)
        {
            return strtoupper($booking_id_str);
        }
        else
        {
            random_strings($length_of_string);
        }
    }
}



if (!function_exists('send_whatsapp')) {
    function send_whatsapp($data)
    {
        // Default values for empty fields
        if ($data['txnid'] == '') {
            $data['txnid'] = 'N/A';
        }
    
        if ($data['bank_ref_num'] == '') {
            $data['bank_ref_num'] = 'N/A';
        }
    
        if ($data['pg_txn'] == '') {
            $data['pg_txn'] = 'N/A';
        }
    
        // Permanent token and mobile number formatting
        $access_token = env('WHATSAPP_ACCESS_TOKEN');
        $mobile = str_replace(['+', '-', ' '], '', $data['mobile']);
        if (strlen($mobile) == 10) {
            $mobile = '91' . $mobile;
        }
    
        $booking_id = $data['booking_id'];
        $booking_id_str = $data['booking_id_str'];
    
        // cURL setup
        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v17.0/144035558786887/messages');
        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v21.0/106023275709219/messages');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
    
        // Message template array
        $a = [
            'messaging_product' => 'whatsapp',
            'to' => $mobile,
            'type' => 'template',
            'template' => [
                'name' => 'booking_confirmation',
                'language' => ['code' => 'en_US'],
                'components' => []
            ]
        ];
    
        // Parameters array for text
        $parameters = [
            ['type' => 'text', 'text' => ucwords($data['status'])],
            ['type' => 'text', 'text' => $booking_id_str],
            ['type' => 'text', 'text' => $data['amount']],
            ['type' => 'text', 'text' => $data['tickets']],
            ['type' => 'text', 'text' => $data['show_name']],
            ['type' => 'text', 'text' => $data['venue']],
            ['type' => 'text', 'text' => $data['txnid']],
            ['type' => 'text', 'text' => $data['bank_ref_num'] ?: 'N/A'],
            ['type' => 'text', 'text' => $data['pg_txn'] ?: 'N/A'],
            ['type' => 'text', 'text' => $data['name'] ?: 'N/A'],
            ['type' => 'text', 'text' => $data['email'] ?: 'N/A'],
            ['type' => 'text', 'text' => trim($mobile)],
            ['type' => 'text', 'text' => $data['updated_at']],
            ['type' => 'text', 'text' => 'https://opsharma.in/?' .$data['booking_id_str']]
        ];
    
        // Add body component with parameters
        $a['template']['components'][] = [
            'type' => 'body',
            'parameters' => $parameters
        ];
    
        // JSON encode and cURL setup
        $json_data = json_encode($a, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: application/json'
        ]);
    
        // Execute and handle response
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            // print_r($result);
        }

        curl_close($ch);
        send_sms($mobile, $booking_id, $booking_id_str);
        return 'SENT';
    }

}

if (!function_exists('send_feedback_whatsapp')) {
    function send_feedback_whatsapp($data)
    {
        //permanent_token_ops 
       $access_token=env('WHATSAPP_ACCESS_TOKEN');

        $mobile = $data['mobile'];
        // $mobile =  '+916387707276';

        $mobile = str_replace('+', '', $mobile);
        $mobile = str_replace('-', '', $mobile);
        $mobile = str_replace(' ', '', $mobile);
        if (strlen($mobile) == 10) {
            $mobile = '91' . $mobile;
        }


        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v21.0/144035558786887/messages');
        curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v21.0/106023275709219/messages');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $a = new stdClass();

        $temp = new stdClass();
        $lng = new stdClass();
        $lng->code='en_US';

        $temp->name='feedbackmsg';
        $temp->language=$lng;


        $components_arr=array();
        $parameters=array();

        $temp_params = new stdClass();
        $temp_params->type='text';
        $temp_params->text= $data['booking_id'];
        $parameters[]=$temp_params;
        
       

        $components_inner = new stdClass();
        $components_inner->type='button';
        $components_inner->sub_type='url';
        $components_inner->index="0";
                

        $components_inner->parameters=$parameters;

        $components_arr[]=$components_inner;
        $temp->components=$components_arr;


        $a->messaging_product='whatsapp';
        $a->to=$mobile;
        $a->type='template';
        $a->template=$temp;

        $data=json_encode($a, true);


        curl_setopt($ch, CURLOPT_POSTFIELDS, $data );

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$access_token;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        
        curl_close($ch);
        
        $data = json_decode($result, true);



        // Access the "message_status" value
        if (isset($data['messages'][0]['message_status'])) {
            $messageStatus = $data['messages'][0]['message_status'];
            if($messageStatus == 'accepted')
            {
                return 'SENT';
            }
            else
            {
                return "ERROR";
            }
        } else {
            return "ERROR";
        }
    }
}



if (!function_exists('send_email')) {
    function send_email($data)
    {
        $response=Mail::to($data['email'])->send(new MyMail($data));
        return 'SENT';
    }
}

if (!function_exists('send_sms_old')) {
    function send_sms_old($mobile, $booking_id, $booking_id_str)
    {
        $booking_url =  'https://opsharma.in/'.$booking_id_str;
        $mobile = str_replace('+', '', $mobile);
        $mobile = str_replace('-', '', $mobile);
        $mobile = str_replace(' ', '', $mobile);
        if(strlen($mobile)==12)
        {
            $mobile = substr($mobile, 2);
        }
        
       $SMS_API_KEY=env('SMS_API_KEY');


$data='
{
  "SenderId": "OPSTKT",
  "Is_Unicode": false,
  "Is_Flash": false,
  "SchedTime": "",
  "GroupId": "",
  "Message": "Ticket Booking Confirmed for O P Sharma Magic Show\nBooking ID: '.$booking_id.'\nView Booking: '.$booking_url.'\n- PRAKASH MAGICO",
  "MobileNumbers": "'.$mobile.'",
  "ApiKey": "'.$SMS_API_KEY.'",
  "ClientId": "5474760a-5f9e-4351-bbf5-58e11100cc11"
}';
$curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://zapsms.co.in//api/v2/SendSMS",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $data,
          CURLOPT_HTTPHEADER => array(
            "content-type: application/json",
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }
}




function send_sms($mobile, $booking_id, $booking_id_str)
{
	$booking_url = 'https://opsharma.in/?'.$booking_id_str;
	$mobile = str_replace('+', '', $mobile);
	$mobile = str_replace('-', '', $mobile);
	$mobile = str_replace(' ', '', $mobile);
	if(strlen($mobile)==12)
	{
		$mobile = substr($mobile, 2);
	}

    $SMS_API_KEY_NEW=env('SMS_API_KEY_NEW');
    $api_key = $SMS_API_KEY_NEW;
    $contacts = $mobile;
    $from = 'OPSTKT';
    $sms_text = 'Ticket Booking Confirmed for O P Sharma Magic Show Booking ID: '.$booking_id_str.' View Booking: '.$booking_url.' - PRAKASH MAGICO';
   
    $sms_text = urlencode($sms_text);
    
    $pe_id = '1501581260000042120';
    $template_id = '1707173373156020386';
    
    $api_url = "https://whysms.in/app/smsapi/index.php?key=".$api_key."&campaign=11176&routeid=6&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text."&template_id=".$template_id."&pe_id=".$pe_id;
    $response = file_get_contents( $api_url);
}



function verify_payu_payment($txid)
{
    $url = "https://info.payu.in/merchant/postservice?form=2";
    if (env('PAYU_MODE') == 'LIVE') {
        $PAYU_URL = env('PAYU_URL_LIVE');
        $PAYU_KEY = env('PAYU_KEY_LIVE');
        $PAYU_SALT = env('PAYU_SALT_LIVE');
    } else {
        $PAYU_URL = env('PAYU_URL_TEST');
        $PAYU_KEY = env('PAYU_KEY_TEST');
        $PAYU_SALT = env('PAYU_SALT_TEST');
    }

    $text = $PAYU_KEY . '|verify_payment|' . $txid . '|'. $PAYU_SALT;
    $hash = hash('sha512', $text);
    $data = "key=".$PAYU_KEY."&command=verify_payment&var1=".$txid."&hash=".$hash."";

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array("content-type: application/x-www-form-urlencoded",),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    return $response;
}

function verify_razorpay_payment($order_id)
{
    $RAZPAY_VERIFICATION_TOKEN=env('RAZPAY_VERIFICATION_TOKEN');

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.razorpay.com/v1/orders/'.$order_id.'/payments',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: Basic '.$RAZPAY_VERIFICATION_TOKEN],
    ]);

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	$output = curl_exec($ch);
	curl_close($ch);
	$output = json_decode($output, true);
	$payment_success=false;
	$transaction_id=false;
	if(isset($output['items']))
	{
		$items=$output['items'];
		foreach($items as $item)
		{
			if($item['status']=='captured')
			{
				$payment_success=true;
				$pg_txn=$item['id'];
			}
		}
	}

	if($payment_success===true)
	{
		return json_encode(array('status'=>true, 'pg_txn'=>$pg_txn));
	}
	else
	{
		return json_encode(array('status'=>false, 'pg_txn'=>''));
	}
}

function getBetweenDates($startDate, $endDate) {
    $array = array();
    $interval = new DateInterval('P1D');
 
    $realEnd = new DateTime($endDate);
    $realEnd->add($interval);
 
    $period = new DatePeriod(new DateTime($startDate), $interval, $realEnd);
 
    foreach($period as $date) {
        $array[] = $date->format('Y-m-d');
    }
 
    return $array;
}

// function moneyFormatIndia($number)
// {
//     $decimal = '';
//     if (strpos($number, '.') !== false) {
//         list($number, $decimal) = explode('.', $number);
//         $decimal = '.' . substr($decimal . '00', 0, 2); // ensure two decimals
//     }

//     $length = strlen($number);
//     if ($length <= 3) {
//         return $number . $decimal;
//     }

//     $last3 = substr($number, -3);
//     $rest = substr($number, 0, -3);
//     $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);

//     return $rest . ',' . $last3 . $decimal;
// }

function moneyFormatIndia($num)
{
    $explrestunits = "" ;
    $num=preg_replace('/,+/', '', $num);
    $words = explode(".", $num);
    $des="00";
    if(count($words)<=2){
        $num=$words[0];
        if(count($words)>=2){$des=$words[1];}
        if(strlen($des)<2){$des="$des";}else{$des=substr($des,0,2);}
    }
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return "$thecash.$des"; // writes the final format where $currency is the currency symbol.
}
?>
