<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MyMail;
use App\Models\User;
use App\Models\Event;
use App\Models\EventSeat;
use App\Models\EventSchedule;
use App\Models\EventScheduleList;
use App\Models\EventShowTime;
use App\Models\EventTicketList;
use App\Models\EventTicket;
use App\Models\EventShowSchedule;
use App\Models\EventShowScheduleList;
use App\Models\Layout;
use App\Models\PaymentMethod;
use App\Models\Venue;
use App\Models\Customer;
use App\Models\CustomerCart;
use App\Models\Cart;
use App\Models\PhotoGallery;
use App\Models\PhotoContent;
use App\Models\VideoGallery;
use App\Models\Booking;
use App\Models\BookingPayment;
use App\Models\BookingDetail;
use App\Models\PaymentTransaction;
use App\Models\PaymentLogs;
use App\Models\VisitorLog;
use App\Models\GeneralFeedback;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use DateTime;
use Cookie;

class HomeController extends Controller
{ 
    

    protected $redirectTo = '/dashboard';
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        if($request->has('utm_source')) {
            Cookie::queue('utm_source', $request->get('utm_source'), 60 * 24 * 20); // 7 days
        }
    
        if($request->has('utm_medium')) {
            Cookie::queue('utm_medium', $request->get('utm_medium'), 60 * 24 * 20); // 7 days
        }
    
        if($request->has('utm_campaign')) {
            Cookie::queue('utm_campaign', $request->get('utm_campaign'), 60 * 24 * 20); // 7 days
        }
    
        if($request->has('utm_content')) {
            Cookie::queue('utm_content', $request->get('utm_content'), 60 * 24 * 20); // 7 days
        }
        
        
        
        $utmSource = Cookie::get('utm_source', $request->query('utm_source', 'direct'));
        $utmMedium = Cookie::get('utm_medium', $request->query('utm_medium', 'direct'));
        $utmCampaign = Cookie::get('utm_campaign', $request->query('utm_campaign', 'direct'));
        $utmContent = Cookie::get('utm_content', $request->query('utm_content', 'none'));

        // Capture IP address
        
        $ipAddress = '';
    
    
        $ipAddress = $request->ip();
        
        
        // Capture browser details
        $browser = $request->header('User-Agent', 'Unknown');

        // Save to database
        $a = VisitorLog::create([
            'utm_source'   => $utmSource,
            'utm_medium'   => $utmMedium,
            'utm_campaign' => $utmCampaign,
            'utm_content'  => $utmContent,
            'ip_address'   => $ipAddress,
            'browser'      => $browser,
        ]);
        
        
        return view('home.index');
    }

    ///website pages
    public function home(Request $request)
    {
        
        if ($request->has('utm_source')) {
            Cookie::queue('utm_source', $request->get('utm_source'), 60 * 24 * 20); // 7 days
        }
    
        if ($request->has('utm_medium')) {
            Cookie::queue('utm_medium', $request->get('utm_medium'), 60 * 24 * 20); // 7 days
        }
    
        if ($request->has('utm_campaign')) {
            Cookie::queue('utm_campaign', $request->get('utm_campaign'), 60 * 24 * 20); // 7 days
        }
    
        if ($request->has('utm_content')) {
            Cookie::queue('utm_content', $request->get('utm_content'), 60 * 24 * 20); // 7 days
        }
            
        
        $utmSource = Cookie::get('utm_source', $request->query('utm_source', 'direct'));
        $utmMedium = Cookie::get('utm_medium', $request->query('utm_medium', 'direct'));
        $utmCampaign = Cookie::get('utm_campaign', $request->query('utm_campaign', 'direct'));
        $utmContent = Cookie::get('utm_content', $request->query('utm_content', 'none'));

        // Capture IP address
        // $ipAddress = $request->ip();
        $ipAddress = '';
        $ipAddress = $request->ip();
     
     
        // Capture browser details
        $browser = $request->header('User-Agent', 'Unknown');

        // Save to database
        $a = VisitorLog::create([
            'utm_source'   => $utmSource,
            'utm_medium'   => $utmMedium,
            'utm_campaign' => $utmCampaign,
            'utm_content'  => $utmContent,
            'ip_address'   => $ipAddress,
            'browser'      => $browser,
        ]);
        // print_r($a);
        
        
        
        $events = DB::table('events')
            // ->where('is_default', 'YES')
            ->where('is_published', 'YES')
            ->get();
            
        return view('home.index', compact('events'));
    }


    public function about()
    {
        return view('home.about');
    }

    public function showcase()
    {
        return view('home.showcase');
    }

    public function events()
    {
        $events = DB::table('events')
            // ->where('is_default', 'YES')
            ->where('is_published', 'YES')
            ->get();
        return view('home.events', compact('events'));
    }

    public function gallery()
    {
        return view('home.gallery');
    }
    public function photo_gallery()
    {
        $photo_gallery = PhotoGallery::orderBy('sequence', 'ASC')->get();


        return view('home.photo_gallery' , compact('photo_gallery'));
    }
 
    public function photo_gallery2($id)
    {
        $photo_gallery = PhotoGallery::find($id);
        
        if (!$photo_gallery) {
            abort(404, 'Gallery not found');
        }
      
        $photo_content = PhotoContent::where('gallery_id', $id)->get();
        
        return view('home.photo_gallery2', compact('photo_content', 'photo_gallery'));
    }
    
    public function video_gallery()
    {
        $video_gallery = VideoGallery::orderBy('sequence', 'ASC')->get();
        return view('home.video_gallery' , compact('video_gallery'));

    }
    
    public function contact()
    {
        return view('home.contact');
    }
    public function schedule()
    {
        return view('home.schedule');
    }
    public function stage()
    {
        return view('home.stage');
    }
    public function payment()
    {
        return view('home.payment');
    }
    public function gallery_images()
    {
        return view('home.gallery_images');
    }
    public function terms_conditions()
    {
        return view('home.terms_conditions');
    }
    public function privacy_policy()
    {
        return view('home.privacy_policy');
    }
    public function business_enquiry()
    {
        return view('home.business_enquiry');
    }
    public function bulk_booking()
    {
        return view('home.bulk_booking');
    }

    public function refund_cancellation()
    {
        return view('home.refund_cancellation');
    }

    public function user_register()
    {
        return view('home.user_register');
    }
    public function user_login()
    {
        return view('home.user_login');
    }

    public function book_ticket(Request $request)
    {
        Session::forget('user_id');
        $event_id ='';
        $data = [];
        
        if( $request->has('event_id') ) {
          $event_id =  $request->query('event_id');
          $data['event_id'] =  $event_id;
        }

        $event_schedules = Event::whereDate('end_date', '>=', date('Y-m-d'))->where('id', $event_id)->get();

        $events = [];
        foreach ($event_schedules as $event_schedule) {
            $is_published = Event::where(['id' => $event_schedule->event_id, 'is_published' => 'YES'])->count();
            if ($is_published == 1) {
                $events[] = $event_schedule->event_id;
            }
        }

        return view('home.book_ticket', ['events' => $events], $data);
    }

    public function fetch_show_time(Request $request)
    {
        $event_show_times = EventShowSchedule::where(['event_schedule_list_id' => $request->event_schedule_list_id, 'customer_booking' => 'ALLOWED'])
            ->orderBy('start_time', 'ASC')
            ->get();

        $show_data = [];
        $event_schedule_list = EventScheduleList::where('status', 'ACTIVE')
            ->where('id', $request->event_schedule_list_id)
            ->first();
            
        $event_id = $event_schedule_list->event_id;
        $event_data = Event::find($event_id);
        $show_hide_time = (string)$event_data->show_hide_time.' minutes';
      
        if ($event_schedule_list->event_date == date('Y-m-d')) {
            foreach ($event_show_times as $event_show_time) {
                $date = new DateTime();
                $date->modify($show_hide_time);
                $formatted_date = $date->format('h:i A');
                $start_time = date('h:i A', strtotime($event_show_time->start_time));

                if (strtotime($formatted_date) < strtotime($start_time)) {
                    $show_data[] = $event_show_time;
                }
            }
        } else {
            foreach ($event_show_times as $event_show_time) {
                $show_data[] = $event_show_time;
            }
        }

        // Attach categories and calculate available seats
        $config_path = config_path('seat_availability.json');
        $thresholds = ['sold_out' => 0, 'few_left' => 20, 'filling_fast' => 50];
        if (file_exists($config_path)) {
            $loaded = json_decode(file_get_contents($config_path), true);
            if (is_array($loaded)) {
                $thresholds = array_merge($thresholds, $loaded);
            }
        }

        foreach ($show_data as $show) {
            $categories = DB::table('event_ticket_lists')
                ->where('event_id', $show->event_id)
                ->where('event_schedule_list_id', $show->event_schedule_list_id)
                ->where('event_show_time_id', $show->event_show_time_id)
                ->get();
                
            $categories_data = [];
            $total_show_seats = 0;
            $total_show_available = 0;
            foreach ($categories as $cat) {
                $ticket_type = DB::table('ticket_type')->where('id', $cat->ticket_type_id)->first();
                $cat_name = $ticket_type ? strtoupper($ticket_type->ticket_type_name) : 'UNKNOWN';
                $color = $ticket_type ? $ticket_type->color : '#cbd5e1';
                
                // Count active seats
                $total_seats = DB::table('event_seat')
                    ->where('event_id', $show->event_id)
                    ->where('event_schedule_list_id', $show->event_schedule_list_id)
                    ->where('event_show_time_id', $show->event_show_time_id)
                    ->where('event_ticket_type_id', $cat->ticket_type_id)
                    ->where('is_visible', 'YES')
                    ->where('is_removed', 'NO')
                    ->where('is_damaged', 'NO')
                    ->where('is_reserved', 'NO')
                    ->where('is_labeled', 'NO')
                    ->count();
                    
              
                $booked_seats = DB::table('event_seat')
                ->where('event_id', $show->event_id)
                ->where('event_schedule_list_id', $show->event_schedule_list_id)
                ->where('event_show_time_id', $show->event_show_time_id)
                ->where('event_ticket_type_id', $cat->ticket_type_id)
                ->where(function ($query) {
                    $query->where('is_damaged', 'YES')
                        ->orWhere('is_reserved_for_customer', 'YES')
                        ->orWhere('is_reserved', 'YES')
                        ->where('is_labeled', 'YES')
                        ->orWhere(function ($q) {
                            $q->whereNotNull('booking_id')
                              ->where('booking_id', '!=', '');
                        });
                })
                ->count();
                
                
                    
                $available_seats = $total_seats - $booked_seats;
                $percent = $total_seats > 0 ? ($available_seats / $total_seats) * 100 : 0;
                if ($total_seats == 0 || $available_seats <= $thresholds['sold_out']) {
                    $status = 'Sold Out';
                    $status_class = 'sold-out';
                } elseif ($percent <= $thresholds['few_left']) {
                    $status = 'Few Left';
                    $status_class = 'few-left';
                } elseif ($percent <= $thresholds['filling_fast']) {
                    $status = 'Filling Fast';
                    $status_class = 'filling-fast';
                } else {
                    $status = 'Available';
                    $status_class = 'available';
                }
                
                $categories_data[] = [
                    'ticket_type_id' => $cat->ticket_type_id,
                    'category_name' => $cat_name,
                    'color' => $color,
                    'status' => $status,
                    'status_class' => $status_class,
                    'total_seats'=>$total_seats,
                    'available_seats'=>$available_seats,
                ];
                
                
                //  $categories_data[] = [
                //     'ticket_type_id' => $cat->ticket_type_id,
                //     'category_name' => $cat_name,
                //     'color' => $color,
                //     'status' => $status,
                //     'status_class' => $status_class
                // ];
                
                $total_show_seats += $total_seats;
                $total_show_available += $available_seats;
            }
            
            $show->categories = $categories_data;
        }

        return response()->json(['event_show_times' => $show_data]);
    }






    public function book_ticket_next(Request $request)
    {
        if (Session::has('user_id')) {
            $user_id_temp = Session::get('user_id');
            $user_id_temp = simple_crypt($user_id_temp, 'd');
        } else {
            $user_id_temp = date('dmyhis') . random_int(111111, 99999999);
            Session::put('user_id', simple_crypt($user_id_temp)); // this alone won't write to session
        }

        $data = [];
        $event_show_times = EventShowSchedule::where(['id' => $request->show_time_id, 'customer_booking' => 'ALLOWED'])
            ->orderBy('start_time', 'ASC')
            ->first();
        // dd($event_show_times);
        $e_id = $event_show_times->event_id;
        $es_id = $request->show_time_id;
        $esd_id = $request->show_date_id;
        $est_id = $event_show_times->event_show_time_id;

        $events = Event::where('status', 'ACTIVE')
            ->where('id', $e_id)
            ->first();

        $venue_id = $events->venue_id;
        
        $venues = Venue::where('status', 'ACTIVE')
            ->where('id', $venue_id)
            ->first();

        $layouts_data = EventTicket::where('status', 'ACTIVE')
            ->where('event_id', $e_id)
            ->where('event_schedule_list_id', $esd_id)
            ->where('event_show_time_id', $est_id)
            ->first();
            
        $layout_id = $layouts_data->layout_id;

        $layouts = Layout::where('status', 'ACTIVE')
            ->where('id', $layout_id)
            ->get();


        $event_ticket_lists = EventTicketList::where('event_id', $e_id)
            ->where('event_schedule_list_id', $esd_id)
            ->where('event_show_time_id', $est_id)
            ->get();

        foreach($event_ticket_lists as $ets)
        {
            $ticket_type_id = $ets->ticket_type_id;
            $ets->ticket_type_data= getTicketType($ticket_type_id);
        }


        $payment_methods = PaymentMethod::where('status', 'ACTIVE')->get();

        $data['event_seats'] = EventSeat::where(['event_id' => $e_id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id, 'layout_id' => $layout_id])->get();

        $a = EventSeat::where(['event_id' => $e_id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id, 'layout_id' => $layout_id])->get();

        $data['e_id'] = $e_id;
        $data['es_id'] = $es_id;
        $data['esd_id'] = $esd_id;
        $data['est_id'] = $est_id;
        $data['venue_id'] = $venue_id;
        $data['layout_id'] = $layout_id;
        $data['user_id_temp'] = $user_id_temp;
        $data['event_ticket_lists'] = $event_ticket_lists;

        $e_data=EventTicket::where(['event_id' => $e_id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id, 'layout_id' => $layout_id])->first();
        $data['skip_label'] = $e_data->skip_label;


        $event_schedule_lists = DB::table('event_schedule_list')
            ->where('event_id', 1)
            ->whereDate('event_date', '>=', date('Y-m-d'))
            ->take(10)
            ->get();

        $event_show_times = EventShowSchedule::where(['event_schedule_list_id' => $esd_id, 'customer_booking' => 'ALLOWED'])
            ->orderBy('start_time', 'ASC')
            ->get();

        $event_schedule_list = DB::table('event_schedule_list')
            ->where('status', 'ACTIVE')
            ->where('id', $esd_id)
            ->first();
            
        $show_hide_time = (string)$events->show_hide_time.' minutes';
            
            
        if ($event_schedule_list->event_date == date('Y-m-d')) {
            foreach ($event_show_times as $event_show_time) {
                
                
                $date = new DateTime();
                $date->modify($show_hide_time);
                $formatted_date = $date->format('h:i A');
                $start_time = date('h:i A', strtotime($event_show_time->start_time));

                if (strtotime($formatted_date) < strtotime($start_time)) {
                    $show_data[] = $event_show_time;
                }
            }
        } else {
            foreach ($event_show_times as $event_show_time) {
                $date = new DateTime();
                $date->modify($show_hide_time);
                $formatted_date = $date->format('h:i A');
                $end_time = date('h:i A', strtotime($event_show_time->end_time));
                $show_data[] = $event_show_time;
            }
        }

        $event_show_times = $show_data;

        $setting_data = getSetting(1);
        $convenience_fee = $setting_data->convenience_fee;
        $ticket_hold_time = $setting_data->ticket_hold_time;
        $date = new DateTime();
        $date->modify('-' . $ticket_hold_time . ' minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $customer_cart = CustomerCart::selectRaw('seat_id')
            ->where('user_id', '!=', $user_id_temp)
            ->where('is_hold_for_booking', 'YES')
            ->where('hold_on', '>=', $formatted_date)
            ->get();

        $seat_arr = [];
        foreach ($customer_cart as $single) {
            $seat_arr[] = $single->seat_id;
        }

        $data['customer_cart'] = $seat_arr;

        return view('home.book_ticket_next', compact('events', 'venues', 'layouts', 'payment_methods', 'event_schedule_lists', 'event_show_times'), $data);
    }


    public function add_to_cart(Request $request)
    {
        if (Session::has('user_id')) {
            $user_id = Session::get('user_id');
            $user_id = simple_crypt($user_id, 'd');
        } else {
            echo 'User ID Not Found in Session';
            exit();
        }
        
        $utmSource = null;
        $utmMedium = null;
        $utmCampaign = null;
        $utmContent = null;
        
        if (Cookie::has('utm_source')) {
            $utmSource = Cookie::get('utm_source');
        }
        
        if (Cookie::has('utm_medium')) {
            $utmMedium = Cookie::get('utm_medium');
        }
        
        if (Cookie::has('utm_campaign')) {
            $utmCampaign = Cookie::get('utm_campaign');
        }
        
        if (Cookie::has('utm_content')) {
            $utmContent = Cookie::get('utm_content');
        }
    
        $data = [];
        $id = $request->event_seat_id;
        $discount = $request->discount;
        $event_schedule_list_id = simple_crypt($request->event_schedule_list_id, 'd');
        $event_show_time_id = simple_crypt($request->event_show_time_id, 'd');
        // $user_id = Auth::user()->id;
        $event_seat = EventSeat::where(['id' => $id])->first();

        $cart_count_temp = Cart::where('seat_id', $id)->count();
        if($cart_count_temp>0)
        {
            $response = [
            'status' => 'error',
            'message' => 'Seat already choosen by someone else',
            ];
        }
        else
        {
            $cart_other_ticket_check = CustomerCart::where('user_id', $user_id)
            ->where('ticket_type_id', '!=', $event_seat->event_ticket_type_id)
            ->count();
            if ($cart_other_ticket_check > 0) {
                $response = [
                    'status' => 'error',
                    'message' => 'Seat already choosen by someone',
                ];
            } else {

                if (isset($event_seat) && $event_seat->event_ticket_type_id != '' && $event_seat->booking_id == '') {
                    $cart_data = [
                        'seat_id' => $id,
                        'ticket_type_id' => $event_seat->event_ticket_type_id,
                        'quantity' => 1,
                        'rate' => $event_seat->base_price,
                        'discount' => 0,
                        'user_id' => $user_id,
                        'event_schedule_list_id' => $event_schedule_list_id,
                        'event_show_time_id' => $event_show_time_id,
                        'utm_source' => $utmSource,
                        'utm_medium' => $utmMedium,
                        'utm_campaign' => $utmCampaign,
                        'utm_content' => $utmContent
                    ];

                    $cart_count = CustomerCart::where('seat_id', $id)
                        ->where('user_id', $user_id)
                        ->count();
                    if ($cart_count == 0) {
                        $insert = CustomerCart::create($cart_data);

                        
                        if ($insert) {
                            $seat_ids = [];
                            $seat_ids = CustomerCart::where('user_id', $user_id)
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
                            $total_ticket_count = 0;
                            $cart_groups = CustomerCart::selectRaw('*, count(*) as total')
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
                                $total_ticket_count = $total_ticket_count + $qty;
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
                                'message' => 'Seat Added',
                                'data' => $data,
                                'total_ticket' => $total_ticket_count,
                                'grand_total' => $net_grand_total,
                                'seat_ids' => $seat_ids_str,
                            ];
                        }
                    } else {
                        $delete = CustomerCart::where('seat_id', $id)
                        ->where('user_id', $user_id)
                        ->delete();
                        if ($delete) {
                            $seat_ids = [];
                            $seat_ids = CustomerCart::where('user_id', $user_id)
                                ->where('status', 'ACTIVE')
                                ->where('user_id', $user_id)
                                ->pluck('seat_id')
                                ->toArray();
                            if (!empty($seat_ids)) {
                                $seat_ids_str = simple_crypt(implode(',', $seat_ids));
                            } else {
                                $seat_ids_str = '';
                            }

                            $grand_total = 0;
                            $net_grand_total = 0;
                            $total_ticket_count = 0;
                            $cart_groups = CustomerCart::selectRaw('*, count(*) as total')
                                ->where('user_id', $user_id)
                                ->groupBy('ticket_type_id')
                                ->get();
                            foreach ($cart_groups as $key => $cart_item) {
                                $ticket_type_id = $cart_item->ticket_type_id;
                                $qty = $cart_item->total;
                                $rate = $cart_item->rate;
                                $discount = $cart_item->discount;
                                $total_amount = ($rate - $discount) * $qty;
                                $total_ticket_count = $total_ticket_count + $qty;
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
                                'message' => 'Seat Deleted',
                                'data' => $data,
                                'total_ticket' => $total_ticket_count,
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
                        'message' => 'Please Unavailable for Booking',
                    ];
                }
            }
        }
       
        return json_encode($response);
    }
    public function clear_cart(Request $request)
    {
        $user_id_temp = Session::get('user_id');
        $user_id = simple_crypt($user_id_temp, 'd');

        $seat_ids = $request->seat_ids;
        $seat_ids = simple_crypt($seat_ids, 'd');
        $seat_ids_arr = explode(',', $seat_ids);
        $delete = CustomerCart::whereIn('seat_id', $seat_ids_arr)
        ->where('user_id', $user_id)
        ->delete();
        if ($delete) {
            $response = [
                'status' => 'success',
                'message' => 'Successfully deleted.',
            ];
            return json_encode($response);
        }
    }

    public function seat_reserve_clear()
    {
        $user_id_temp = Session::get('user_id');

        $user_id_temp = simple_crypt($user_id_temp, 'd');

        $delete = CustomerCart::where('user_id', $user_id_temp)->delete();
        $response = [
            'status' => 'success',
            'message' => 'Successfully deleted.',
        ];
        return json_encode($response);
    }

    public function customer_payment(Request $request)
    {
        if (Session::has('user_id')) {
            $user_id = Session::get('user_id');
            $user_id = simple_crypt($user_id, 'd');
        } else {
            return redirect()->route('book_ticket');
        }
        $customer_cart = CustomerCart::where('user_id', $user_id)->get();
        $count = CustomerCart::where('user_id', $user_id)->count();

        foreach($customer_cart as $single)
        {
            $event_schedule_list_id = $single->event_schedule_list_id;
        }

        $event_schedule_list_data = EventScheduleList::where('id', $event_schedule_list_id)->first();
        $event_id = $event_schedule_list_data->event_id;
        $event_data = Event::find($event_id);
        $venue_id = $event_data->venue_id;

        $venues = Venue::where('status', 'ACTIVE')
            ->where('id', $venue_id)
            ->first();

        $data['venue_name'] =  ucwords($venues->name);
        $city_data = getCity($venues->city_id);
        $city_name = strtoupper($city_data->name);
        $data['city_name'] =  $city_name;


        if ($count == 0) {
            return redirect()->route('book_ticket');
        } else {
            return view('home.payment', compact('customer_cart'), $data);
        }
    }

    public function payment_process(Request $request)
    {


        $user_id = Session::get('user_id');
        $user_id = simple_crypt($user_id, 'd');

        $data = [];
        $data['user_id'] = $user_id;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['mobile'] = $request->phone;
        $data['find_us'] = $request->find_us;
        $data['state'] = $request->state;
        

        /*********SEAT LOCKING START HERE*********************/
        $setting_data = getSetting(1);

        $convenience_fee = $setting_data->convenience_fee;
        $ticket_hold_time = $setting_data->ticket_hold_time;

        $date = new DateTime();
        $date->modify('-' . $ticket_hold_time . ' minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $cart_check = CustomerCart::selectRaw('seat_id')
            ->where('user_id', '!=', $user_id)
            ->where('is_hold_for_booking', 'YES')
            ->where('hold_on', '>=', $formatted_date)
            ->get();

        $choosen_seat_by_someone = [];
        foreach ($cart_check as $single_cart) {
            $choosen_seat_by_someone[] = $single_cart->seat_id;
        }

        $cart_check_2 = CustomerCart::selectRaw('count(*) as total_choosen')
            ->where('user_id', $user_id)
            ->whereIn('seat_id', $choosen_seat_by_someone)
            ->first();

        if (!empty($cart_check_2['total_choosen']) && $cart_check_2['total_choosen'] > 0) {
            return back()->with('error', 'One or more tickets are Unavailable for Booking, Please choose another seats');
            exit();
        }
        $customer_cart = CustomerCart::where('user_id', $user_id)->get();
        $is_hold_for_booking = CustomerCart::where('user_id', $user_id)->update(['is_hold_for_booking' => 'YES', 'hold_on' => date('Y-m-d H:i:s')]);
        /*********SEAT LOCKING END HERE*********************/


        /*********SEAT BOOKED LOCKING HERE*********************/
        $cart_check = CustomerCart::selectRaw('seat_id')
            ->where('user_id', '=', $user_id)
            ->get();

        $choosen_seat_by_you = [];
        foreach ($cart_check as $single_cart) {
            $choosen_seat_by_you[] = $single_cart->seat_id;
        }

        $cart_check_2 = BookingDetail::selectRaw('count(*) as total_choosen')
            ->whereIn('seat_id', $choosen_seat_by_you)
            ->first();

        if (!empty($cart_check_2['total_choosen']) && $cart_check_2['total_choosen'] > 0) {
            return back()->with('error', 'One or more tickets are Unavailable for Booking, Please choose another seats');
            exit();
        }
        /*********SEAT BOOKED END HERE*********************/



        $cart_total = CustomerCart::selectRaw('sum(rate) as amount')
            ->where('user_id', $user_id)
            ->groupBy('ticket_type_id')
            ->first();
        $data['amount'] = $cart_total->amount + ($cart_total->amount * $convenience_fee) / 100;
        $data['amount'] = round($data['amount']);

        $txnid = date('dmyhis') . random_int(11111, 99999);

        $data['txnid'] = $txnid;
        $data['productinfo'] = 'OP Sharma Magic Show Ticket';

        Session::put('txnid', simple_crypt($txnid));

        if (env('PAYU_MODE') == 'LIVE') {
            $PAYU_URL = env('PAYU_URL_LIVE');
            $PAYU_KEY = env('PAYU_KEY_LIVE');
            $PAYU_SALT = env('PAYU_SALT_LIVE');
        } else {
            $PAYU_URL = env('PAYU_URL_TEST');
            $PAYU_KEY = env('PAYU_KEY_TEST');
            $PAYU_SALT = env('PAYU_SALT_TEST');
        }

        $text = $PAYU_KEY . '|' . $data['txnid'] . '|' . $data['amount'] . '|' . $data['productinfo'] . '|' . $data['name'] . '|' . $data['email'] . '|||||||||||' . $PAYU_SALT;

        $data['hash'] = hash('sha512', $text);

        Session::put('hash', $data['hash']);

        $customer_cart = CustomerCart::where('user_id', $user_id)->get();

        $customer_cart_temp = CustomerCart::where('user_id', $user_id)
            ->select(DB::raw('event_schedule_list_id, event_show_time_id, ticket_type_id,  SUM(quantity) as total_ticket_quantity'))
            ->groupBy('customer_cart.user_id')
            ->first();

        $event_schedule_list_data = EventScheduleList::where('id', $customer_cart_temp->event_schedule_list_id)->first();

        $data['event_id'] = $event_schedule_list_data->event_id;
        $data['event_schedule_list_id'] = $customer_cart_temp->event_schedule_list_id;
        $data['event_show_time_id'] = $customer_cart_temp->event_show_time_id;
        $data['ticket_type_id'] = $customer_cart_temp->ticket_type_id;
        $data['quantity'] = $customer_cart_temp->total_ticket_quantity;


        /****************** FINDING SEAT NO FOR LATER TRANSACTION *****************/
        $seat_ids=[];
        $cart_seats = CustomerCart::where('user_id', $user_id)->get();
        foreach ($cart_seats as $cart_item)
        {
            $seat_id = $cart_item->seat_id;
            $seat_ids[]=$seat_id;
            $seat_name = fetch_seat_no($seat_id);
            $row_no = $seat_name->row_no;
            // $layout_row_label = getLayout($seat_name->layout_id)->layout_row_label;
            // $layout_row_label = explode(',', $layout_row_label);
            // $row_name = $layout_row_label[$row_no - 1];
            $seat_no_arr[] = $seat_name->label. $seat_name->name;
        }
        $data['seat_details'] = implode(', ', $seat_no_arr);
        $data['seat_ids'] = implode(', ', $seat_ids);
        /****************** FINDING SEAT NO FOR LATER TRANSACTION *****************/

        $insert = PaymentTransaction::create($data);

        $data['PAYU_KEY'] = $PAYU_KEY;
        $data['PAYU_URL'] = $PAYU_URL;
        $data['user_id_txn'] = simple_crypt($user_id);

        return view('home.payment_process', compact('customer_cart'), $data);
    }

    public function payment_success(Request $request, $id)
    {
        DB::beginTransaction();

        /* PG DATA CAPTURED */
        $pg_response = $request->all();

        $mihpayid = $pg_response['mihpayid'];
        $mode = $pg_response['mode'];
        $status = $pg_response['status'];
        $unmappedstatus = $pg_response['unmappedstatus'];
        $key = $pg_response['key'];
        $txnid = $pg_response['txnid'];
        $amount = $pg_response['amount'];
        $discount = 0;
        $net_amount_debit = $pg_response['net_amount_debit'];
        $addedon = $pg_response['addedon'];
        $productinfo = $pg_response['productinfo'];
        $firstname = $pg_response['firstname'];
        $lastname = $pg_response['lastname'];
        $address1 = $pg_response['address1'];
        $address2 = $pg_response['address2'];
        $city = $pg_response['city'];
        $state = $pg_response['state'];
        $country = $pg_response['country'];
        $zipcode = $pg_response['zipcode'];
        $email = $pg_response['email'];
        $phone = $pg_response['phone'];

        $udf1 = $pg_response['udf1'];
        $udf2 = $pg_response['udf2'];
        $udf3 = $pg_response['udf3'];
        $udf4 = $pg_response['udf4'];
        $udf5 = $pg_response['udf5'];
        $udf6 = $pg_response['udf6'];
        $udf7 = $pg_response['udf7'];
        $udf8 = $pg_response['udf8'];
        $udf9 = $pg_response['udf9'];
        $udf10 = $pg_response['udf10'];

        $hash = $pg_response['hash'];

        $field1 = $pg_response['field1'];
        $field2 = $pg_response['field2'];
        $field3 = $pg_response['field3'];
        $field4 = $pg_response['field4'];
        $field5 = $pg_response['field5'];
        $field6 = $pg_response['field6'];
        $field7 = $pg_response['field7'];
        $field8 = $pg_response['field8'];
        $field9 = $pg_response['field9'];

        // $payment_source=$pg_response['payment_source'];
        // $meCode=$pg_response['meCode'];
        // $PG_TYPE=$pg_response['PG_TYPE'];
        $bank_ref_num = $pg_response['bank_ref_num'];
        $bankcode = $pg_response['bankcode'];
        $error = $pg_response['error'];
        $error_Message = $pg_response['error_Message'];

        /* CUSTOMER DATA PREVIOUSLY POSTED TO PG*/
        $user_id = $id;
        $user_id = simple_crypt($user_id, 'd');

        if (!isset($user_id)) {
            echo 'User ID not found in session';
            exit();
        } else {
            // echo $user_id;
        }

        // $url = "https://test.payu.in/merchant/postservice?form=2-H";
        // $req = req_init($url);
        // req_setopt($req, CURLOPT_URL, $url);
        // req_setopt($req, CURLOPT_POST, true);
        // req_setopt($req, CURLOPT_RETURNTRANSFER, true);
        // $headers = array( "Content-Type: application/x-www-form-urlencoded");
        // req_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        // $data = "key=CmGmg38v&command=verify_payment&var1=".$mihpayid."&hash=".$hash;

        // req_setopt($curl, CURLOPT_POSTFIELDS, $data);
        // $resp = req_exec($req);
        // req_close($req);
        // var_dump($resp);

        if ($status == 'success') {
            $carts = CustomerCart::where('user_id', $user_id)->get();
            $cart_single = CustomerCart::where('user_id', $user_id)->first();

            $seat_ids_arr = [];
            foreach ($carts as $key => $cart_item) {
                $seat_id = $cart_item->seat_id;
                $ticket_type_id = $cart_item->ticket_type_id;
                $seat_ids_arr[] = $seat_id;
            }

            $seat_ids = implode(',', $seat_ids_arr);

            $seat_data = EventSeat::where('id', $seat_ids_arr[0])->first();

            $event_id = $seat_data->event_id;

            $event_schedule_id = getEventScheduleByEventID($event_id)[0]->id;

            $event_schedule_list_id = $seat_data->event_schedule_list_id;
            $event_show_time_id = $seat_data->event_show_time_id;

            $event_data = getEvent($event_id);

            $venue_id = $event_data->venue_id;

            $layout_id = $seat_data->layout_id;

            $mobile_no = $phone;
            $customer_name = $firstname;
            $email = $email;
            $coupon_code = '';
            $discount = $discount;
            $payment_method_id = 8;

            $qty = 0;
            $total_discount = 0;
            $grand_total = 0;
            $net_grand_total = 0;

            $seat_ids_array = explode(',', $seat_ids);
            $carts = CustomerCart::whereIn('seat_id', $seat_ids_array)
            ->where('user_id', $user_id)
            ->get();
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

            $setting_data = getSetting(1);
            $convenience_fee = $setting_data->convenience_fee;

            $grand_total = $grand_total + ($grand_total * $convenience_fee) / 100;
            $grand_total = round($grand_total);
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
                $booking_id_str=random_strings(6);
                //bookings
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
                // $booking->ip = $ip;
                $booking->ip =  $request->ip();
                $booking->discount = $total_discount;
                $booking->grand_total = $grand_total;
                $booking->booking_code = unique_id_generate();
                $booking->booking_date = date('Y-m-d');
                $booking->booking_time = date('H:i:s A');
                $booking->customer_id = $customer->id;
                $booking->booking_id_str = $booking_id_str;
                
                
        
                $booking->utm_source = $cart_single->utm_source;
                $booking->utm_medium = $cart_single->utm_medium;
                $booking->utm_campaign = $cart_single->utm_campaign;
                $booking->utm_content = $cart_single->utm_content;
                
                
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
            
            
            
                
                // $booking->vendor_id = $user_id;
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
                    $booking_detail->discount = $discount;
                    $booking_detail->seat_no = $event_seat->seatno;
                    $booking_detail->row_id = $event_seat->row_no;
                    $booking_detail->col_id = $event_seat->col_no;
                    $booking_detail->save();

                    $carts = CustomerCart::where('seat_id', $seat_ids_arr)
                    ->where('user_id', $user_id)
                    ->first();
                    $discount = $carts->discount;
                    EventSeat::where(['id' => $seat_ids_arr])->update(['total_discount' => $discount, 'payment_method_id' => $payment_method_id, 'booking_id' => $booking->id, 'booking_time' => date('Y-m-d H:i:s')]);
                    EventSeat::where(['id' => $seat_ids_arr])->decrement('total_ticket', 1);
                }

                //booking_payments
                $booking_payment = new BookingPayment();
                $booking_payment->booking_id = $booking->id;
                $booking_payment->payment_method_id = $payment_method_id;
                $booking_payment->reference_no = $txnid;
                $booking_payment->amount = $grand_total;
                $booking_payment->discount = $total_discount;

                $payable_amount = $grand_total - $total_discount;
                $booking_payment->note = 'Payable Amount: ' . $payable_amount;
                $booking_payment->save();

                //clear cart
                CustomerCart::where('user_id', $user_id)->delete();

                PaymentTransaction::where(['txnid' => $txnid])->update([
                    'pg_txn' => $mihpayid,
                    'bank_ref_num' => $bank_ref_num,
                    'booking_id' => $booking->id,
                    'status' => 'success',
                    'customer_id' =>  $customer->id,
                    'note' => json_encode($pg_response),
                ]);

                DB::commit();
                Session::put('hash', '');
                Session::put('txnid', '');
                
                // Session::put('utm_source', '');
                // Session::put('utm_medium', '');
                // Session::put('utm_campaign', '');
                // Session::put('utm_content', '');

                return redirect()->route('ticket_booked', $booking_id_str);
            } catch (Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Some problems occurred, please try again!');
            }
        }
    }

    public function raz_customer_payment(Request $request)
    {
        $user_id = Session::get('user_id');
        $user_id = simple_crypt($user_id, 'd');
        $data = [];
        $data['user_id'] = $user_id;
        $data['name'] = $request->Name;
        $data['email'] = $request->Email;
        $data['mobile'] = $request->Mobile;
       
        
        /*********SEAT LOCKING START HERE*********************/
        $setting_data = getSetting(1);

        $convenience_fee = $setting_data->convenience_fee;
        $ticket_hold_time = $setting_data->ticket_hold_time;

        $date = new DateTime();
        $date->modify('-' . $ticket_hold_time . ' minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $cart_check = CustomerCart::selectRaw('seat_id')
            ->where('user_id', '!=', $user_id)
            ->where('is_hold_for_booking', 'YES')
            ->where('hold_on', '>=', $formatted_date)
            ->get();

        $choosen_seat_by_someone = [];
        foreach ($cart_check as $single_cart) {
            $choosen_seat_by_someone[] = $single_cart->seat_id;
        }

        $cart_check_2 = CustomerCart::selectRaw('count(*) as total_choosen')
            ->where('user_id', $user_id)
            ->whereIn('seat_id', $choosen_seat_by_someone)
            ->first();


        $customer_cart = CustomerCart::where('user_id', $user_id)->first();

        $data['event_id'] = $customer_cart->event_id;
        $data['show_date_id'] = $customer_cart->event_schedule_list_id;
        $event_show_times = EventShowSchedule::where(['event_schedule_list_id' => $customer_cart->event_schedule_list_id, 'event_show_time_id' => $customer_cart->event_show_time_id, 'customer_booking' => 'ALLOWED'])
            ->first();
        $data['show_time_id'] = $event_show_times->id;


        if (!empty($cart_check_2['total_choosen']) && $cart_check_2['total_choosen'] > 0) {
            // return back()->with('error', 'One or more tickets are Unavailable for Booking, Please choose another seats');
            $data['Hold'] = true;
            $data['message'] = 'One or more tickets are Unavailable for Booking, Please choose another seats';
            return $data;
            exit();
        }
        $is_hold_for_booking = CustomerCart::where('user_id', $user_id)->update(['is_hold_for_booking' => 'YES', 'hold_on' => date('Y-m-d H:i:s')]);
        /*********SEAT LOCKING END HERE*********************/



        /*********SEAT BOOKED LOCKING HERE*********************/
        $cart_check = CustomerCart::selectRaw('seat_id')
            ->where('user_id', '=', $user_id)
            ->get();

        $choosen_seat_by_you = [];
        foreach ($cart_check as $single_cart) {
            $choosen_seat_by_you[] = $single_cart->seat_id;
        }

        $cart_check_2 = BookingDetail::selectRaw('count(*) as total_choosen')
            ->whereIn('seat_id', $choosen_seat_by_you)
            ->first();

        if (!empty($cart_check_2['total_choosen']) && $cart_check_2['total_choosen'] > 0) {
            $data['Hold'] = true;
            $data['message'] = 'One or more tickets are Unavailable for Booking, Please choose another seats';
            return $data;
            exit();
        }
        /*********SEAT BOOKED END HERE*********************/



        $customer_cart_temp = CustomerCart::where('user_id', $user_id)
            ->select(DB::raw('event_schedule_list_id, event_show_time_id, ticket_type_id,  SUM(quantity) as total_ticket_quantity'))
            ->groupBy('customer_cart.user_id')
            ->first();

        $event_schedule_list_data = EventScheduleList::where('id', $customer_cart_temp->event_schedule_list_id)->first();

        $data['event_id'] = $event_schedule_list_data->event_id;
        $data['event_schedule_list_id'] = $customer_cart_temp->event_schedule_list_id;
        $data['event_show_time_id'] = $customer_cart_temp->event_show_time_id;
        $data['ticket_type_id'] = $customer_cart_temp->ticket_type_id;
        $data['quantity'] = $customer_cart_temp->total_ticket_quantity;

        $cart_total = CustomerCart::selectRaw('sum(rate) as amount')
            ->where('user_id', $user_id)
            ->groupBy('ticket_type_id')
            ->first();

        $setting_data = getSetting(1);
        $convenience_fee = $setting_data->convenience_fee;

        $data['amount'] = round($cart_total->amount + ($cart_total->amount * $convenience_fee) / 100, 2);

        // $txnid = 'order_' . date('dmyhis') . random_int(11111, 99999);
        // $data['txnid'] = $txnid;

        $data['productinfo'] = 'Magic Show Ticket';
        $RAZPAY_KEY = env('RAZPAY_KEY_LIVE');
        $amount = $data['amount'] * 100;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.razorpay.com/v1/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{ "amount": ' . $amount . ',  "currency": "INR"}',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: Basic cnpwX2xpdmVfd3Q3SWRhWkZNcGlSbTI6WklNSWRnQWgzZjRzUGZHUTVtWGV6Y05q'],
        ]);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output, true);
        $rz_order_id = $output['id'];
        $data['txnid'] = $rz_order_id;
        $data['payment_gateway'] = 'RAZORPAY';
        unset($data['show_date_id']);
        unset($data['show_time_id']);

        /****************** FINDING SEAT NO FOR LATER TRANSACTION *****************/
          $seat_ids=[];
        $cart_seats = CustomerCart::where('user_id', $user_id)->get();
        foreach ($cart_seats as $cart_item)
        {
            $seat_id = $cart_item->seat_id;
             $seat_ids[]=$seat_id;
            // $event_schedule_list_id = $cart_item->event_schedule_list_id;
            // $event_show_time_id = $cart_item->event_show_time_id;
            $seat_name = fetch_seat_no($seat_id);
            $row_no = $seat_name->row_no;
            // $layout_row_label = getLayout($seat_name->layout_id)->layout_row_label;
            // $layout_row_label = explode(',', $layout_row_label);
            // $row_name = $layout_row_label[$row_no - 1];
            $seat_no_arr[] = $seat_name->label . $seat_name->name;
        }
        $data['seat_details'] = implode(', ', $seat_no_arr);
        $data['seat_ids'] = implode(', ', $seat_ids);
        /****************** FINDING SEAT NO FOR LATER TRANSACTION *****************/
        $data['find_us'] = $request->find_us;
        $data['state'] = $request->state;
        $insert = PaymentTransaction::create($data);

        $data['RAZPAY_KEY'] = $RAZPAY_KEY;
        $data['rz_order_id'] = $rz_order_id;

        unset($data['payment_gateway']);
        unset($data['hash']);
        unset($data['user_id']);
        unset($data['event_id']);
       
        unset($data['event_schedule_list_id']);
        unset($data['event_show_time_id']);
        unset($data['ticket_type_id']);
        $data['Success'] = true;
        return $data;
    }

    public function raz_customer_payment_success(Request $request)
    {
        $user_id = Session::get('user_id');
        $user_id = simple_crypt($user_id, 'd');
        DB::beginTransaction();
        /* PG DATA CAPTURED */
        // $pg_response = $request->all();
        $pg_response = '';
        $RAZPAY_SECRET = env('RAZPAY_SECRET_LIVE');
        // $razorpay_payment_id = $request->payment_id;
        $razorpay_order_id = $request->order_id;
        $razorpay_signature = $request->signature;
        $txnid = $razorpay_order_id;

        // $generated_signature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $RAZPAY_SECRET);

        $status = 'failed';
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.razorpay.com/v1/orders/'.$razorpay_order_id.'/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: Basic cnpwX2xpdmVfd3Q3SWRhWkZNcGlSbTI6WklNSWRnQWgzZjRzUGZHUTVtWGV6Y05q'],
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output, true);
        $payment_data=$output['items'];
        foreach($payment_data as $pdata)
        {
          $payment_status=$pdata['status'];
          if($payment_status=='captured')
          {
            $razorpay_payment_id=$pdata['id'];
            $mode = 'Razorpay';
            $status = 'success';
            $transaction = PaymentTransaction::where('user_id', $user_id)
                ->where('txnid', $txnid)
                ->first();
            $mobile = $transaction->mobile;
            $email = $transaction->email;
            $name = $transaction->name;
            $quantity = $transaction->quantity;
            $amount = $transaction->amount;
            $ticket_type_id_fetch = $transaction->ticket_type_id;
            $discount = $transaction->discount;
          }
        }

        $bank_ref_num = $razorpay_payment_id;

        if (!isset($user_id)) {
            echo 'User ID not found in session';
            exit();
        } else {
            // echo $user_id;
        }

        $carts = CustomerCart::where('user_id', $user_id)->get();
        $cart_single = CustomerCart::where('user_id', $user_id)->first();

        $seat_ids_arr = [];
        foreach ($carts as $key => $cart_item)
        {
            $seat_id = $cart_item->seat_id;
            $ticket_type_id = $cart_item->ticket_type_id;
            $seat_ids_arr[] = $seat_id;
        }

        if($status == 'success' && count($seat_ids_arr) == $quantity && $ticket_type_id == $ticket_type_id_fetch)
        {
            $seat_ids = implode(',', $seat_ids_arr);
            $seat_data = EventSeat::where('id', $seat_ids_arr[0])->first();
            $event_id = $seat_data->event_id;
            $event_schedule_id = getEventScheduleByEventID($event_id)[0]->id;
            $event_schedule_list_id = $seat_data->event_schedule_list_id;
            $event_show_time_id = $seat_data->event_show_time_id;
            $event_data = getEvent($event_id);
            $venue_id = $event_data->venue_id;
            $layout_id = $seat_data->layout_id;
            $mobile_no = $mobile;
            $customer_name = $name;
            $email = $email;
            $coupon_code = '';
            $discount = $discount;
            $payment_method_id = 8;
            $qty = 0;
            $total_discount = 0;
            $grand_total = 0;
            $net_grand_total = 0;
            $seat_ids_array = explode(',', $seat_ids);
            $carts = CustomerCart::whereIn('seat_id', $seat_ids_array)
            ->where('user_id', $user_id)
            ->get();
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
            $setting_data = getSetting(1);
            $convenience_fee = $setting_data->convenience_fee;
            $grand_total = $grand_total + ($grand_total * $convenience_fee) / 100;
            $grand_total = round($grand_total);
            try {
                $customer_query = Customer::where(['mobile_no' => $mobile_no, 'status' => 'ACTIVE']);
                if ($customer_query->count() == 0)
                {
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

                $booking_id_str=random_strings(6);
                //bookings
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
                $booking->paid_amount = $grand_total - $total_discount;
                $booking->total_quantity = $qty;
                // $booking->ip = $ip;
                 $booking->ip =  $request->ip();
                $booking->discount = $total_discount;
                $booking->grand_total = $grand_total;
                $booking->booking_code = unique_id_generate();
                $booking->booking_date = date('Y-m-d');
                $booking->booking_time = date('H:i:s A');
                $booking->customer_id = $customer->id;
                $booking->booking_id_str = $booking_id_str;
                
                $booking->utm_source = $cart_single->utm_source;
                $booking->utm_medium = $cart_single->utm_medium;
                $booking->utm_campaign = $cart_single->utm_campaign;
                $booking->utm_content = $cart_single->utm_content;
                
                
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
                
                
                // $booking->vendor_id = $user_id;
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
                    $booking_detail->discount = $discount;
                    $booking_detail->seat_no = $event_seat->seatno;
                    $booking_detail->row_id = $event_seat->row_no;
                    $booking_detail->col_id = $event_seat->col_no;
                    $booking_detail->save();

                    $carts = CustomerCart::where('seat_id', $seat_ids_arr)
                    ->where('user_id', $user_id)
                    ->first();
                    $discount = $carts->discount;
                    EventSeat::where(['id' => $seat_ids_arr])->update(['total_discount' => $discount, 'payment_method_id' => $payment_method_id, 'booking_id' => $booking->id, 'booking_time' => date('Y-m-d H:i:s')]);
                    EventSeat::where(['id' => $seat_ids_arr])->decrement('total_ticket', 1);
                }

                //booking_payments
                $booking_payment = new BookingPayment();
                $booking_payment->booking_id = $booking->id;
                $booking_payment->payment_method_id = $payment_method_id;
                $booking_payment->reference_no = $txnid;
                $booking_payment->amount = $grand_total;
                $booking_payment->discount = $total_discount;

                $payable_amount = $grand_total - $total_discount;
                $booking_payment->note = 'Payable Amount: ' . $payable_amount;
                $booking_payment->save();

                //clear cart
                CustomerCart::where('user_id', $user_id)->delete();

                PaymentTransaction::where(['txnid' => $txnid])->update([
                    'booking_id' => $booking->id,
                    'customer_id' => $customer->id,
                    'pg_txn' => $razorpay_payment_id,
                    'hash' => $razorpay_signature,
                    'status' => 'success',
                    'note' => json_encode($pg_response),
                ]);

                DB::commit();
                Session::put('hash', '');
                Session::put('txnid', '');

                $response = [];
                $response['Success'] = true;
                $response['id'] = $booking->id;
                $response['message'] = 'Ticket Booked Succesfully';
                $response['print_url'] = route('ticket_booked', $booking_id_str);
                return $response;
            } catch (Exception $e) {
                DB::rollBack();
                $response['Success'] = false;
                $response['id'] = '';
                return $response;
            }
        }
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'mobile_no' => 'required',
            //'customer_name'=>'required',
            'payment_method_id' => 'required',
            'seat_ids' => 'required', 
        ]);
        $name = $request->name;
        $email = $request->email;
        $mobile = $request->mobile;
    }

    public function ticket_booked(Request $request, $id)
    {
        $booking = Booking::where('booking_id_str', $id)->first();
        $booking_id=$booking->id;
        $payment_details = PaymentTransaction::where('booking_id', $booking_id)->first();
        $booking_details = BookingDetail::where('booking_id', $booking_id)->get();
        $booking_payment = BookingPayment::where('booking_id', $booking_id)->first();
        $customer_details = Customer::where('id', $booking->customer_id)->first();

        $data = array();
        $data['ipAddress']= $request->ip();
        
        if ($request->has('mticket') && $request->has('mticket') == true) {
            return view('home.m-ticket', compact('booking', 'booking_details', 'booking_payment', 'payment_details', 'customer_details'), $data);
         }
         else
         {
            return view('home.payment_success', compact('booking', 'booking_details', 'booking_payment', 'payment_details', 'customer_details'), $data);
         }

       
    }

    public function payment_fail(Request $request, $id)
    {
        $pg_response = $request->all();
        $txnid = $pg_response['txnid'];
        $mihpayid = $pg_response['mihpayid'];
        $bank_ref_num = $pg_response['bank_ref_num'];
        $user_id = $id;
        $user_id = simple_crypt($user_id, 'd');

        CustomerCart::where('user_id', $user_id)->delete();

        PaymentTransaction::where('txnid' , $txnid)
        ->whereNull('status')
        ->update([
            'pg_txn' => $mihpayid,
            'bank_ref_num' => $bank_ref_num,
            'status' => 'failed',
            'note' => json_encode($pg_response),
        ]);
         
        return view('home.payment_fail', $pg_response);
    }

    public function payment_fail_rz(Request $request)
    {
        $pg_response = $request->all();
        $user_id = Session::get('user_id');
        $user_id = simple_crypt($user_id, 'd');

        $txnid = $request->txnid;
        $note = json_encode($pg_response);

        // CustomerCart::where('user_id', $user_id)->delete();

        $payment = PaymentTransaction::where(['txnid' => $txnid])->whereNull('status')->update([
            'status' => 'failed',
            'note' => $note,
        ]);
        if ($payment) {
            $response['Failed'] = true;
            $response['url'] = route('payment_fail_print', simple_crypt($txnid));
            return $response;
        }
    }

    public function payment_fail_print($id)
    {
        $pg_response = [];
        $txnid = simple_crypt($id, 'd');
        $payment_data = PaymentTransaction::where('txnid', $txnid)->first();
        $pg_response['status'] = $payment_data->status;
        $pg_response['txnid'] = $payment_data->txnid;
        $pg_response['bank_ref_num'] = $payment_data->bank_ref_num;
        $pg_response['mihpayid'] = $payment_data->pg_txn;
        $pg_response['firstname'] = $payment_data->name;
        $pg_response['email'] = $payment_data->email;
        $pg_response['phone'] = $payment_data->mobile;
        $pg_response['error_Message'] = $payment_data->note;
        $pg_response['addedon'] = date('d-M-Y h:i:s A', strtotime($payment_data->updated_at));
        return view('home.payment_fail', $pg_response);
    }

    public function feedback_sent_to_customer()
    {
        
        $currentTime = date('H:i');
        if ($currentTime < '10:00' || $currentTime >= '21:00') {
            return; // stop execution
        }
        
        $date = new DateTime();
        $date->modify('-1 day');
        $endDate = $date->format('Y-m-d');
      
        $events = Event::all();
        $events = Event::orderBy('created_at', 'desc')->take(3)->get();
        $eventId = '';
        foreach ($events as $event) {
            $eventId = $event->id;
            $event_schedule_lists = EventScheduleList::where('event_id', $eventId)
                ->where('event_date', '<=', $endDate) 
                ->pluck('id');

            $bookings = Booking::where('event_id', $eventId)
                ->whereIn('event_schedule_list_id', $event_schedule_lists)
                ->where('is_feedback_sent', 'NO')
                ->with('customer')
                ->take(50)
                ->get();
            
            foreach ($bookings as $booking)
            {
                if($booking->customer->mobile_no && $booking->customer_id != 6)
                {
                    $data['mobile']=$booking->customer->mobile_no;
                    $data['booking_id']= $id = simple_crypt($booking->id);
                    echo $response = send_feedback_whatsapp($data);
                    if($response == 'SENT')
                    {
                        $customer = $booking->update(['is_feedback_sent' => 'YES']);
                    }
                    else
                    {
                        $customer = $booking->update(['is_feedback_sent' => 'ERROR']);
                    }
                }
                else
                {
                    $customer = $booking->update(['is_feedback_sent' => 'INVALID_NO']);
                }
            }
        }
    }

    public function customer_feedback($id)
    {
        $pg_response = [];
        $id_new = simple_crypt($id, 'd');
        $pg_response['txnid'] = $id;
        $booking = Booking::whereNull('deleted_at')->find($id_new);
        if (!$booking) {
            abort(404);
        }
        return view('home.customer_feedback', $pg_response, compact('booking'));
    }
    
    

    public function store_customer_feedback(Request $request, $id)
    {
        $id = simple_crypt($id, 'd');
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }

        if (!is_null($booking->feedback_value)) {
            return response()->json(['success' => false, 'message' => 'You have already submitted feedback']);
        }

        $text = $request->input('text');
        $val = $request->input('val');
        if ($val == 5) {
            $val = 'VERY_GOOD';
        } elseif ($val == 4) {
            $val = 'GOOD';
        } elseif ($val == 3) {
            $val = 'AVERAGE';
        } elseif ($val == 2) {
            $val = 'POOR';
        } elseif ($val == 1) {
            $val = 'VERY_POOR';
        } else {
            $val = '';
        }

        $booking->update([
            'feedback_comment' => $text,
            'feedback_value' => $val,
        ]);

        return response()->json(['success' => true, 'message' => 'Feedback submitted successfully']);
    }
    
    
    public function general_feedback()
    {
        $pg_response = [];
        return view('home.general_feedback');
    }


    public function store_general_feedback(Request $request)
    {
        $text = $request->input('text');
        $val = $request->input('val');
        if ($val == 5) {
            $val = 'VERY_GOOD';
        } elseif ($val == 4) {
            $val = 'GOOD';
        } elseif ($val == 3) {
            $val = 'AVERAGE';
        } elseif ($val == 2) {
            $val = 'POOR';
        } elseif ($val == 1) {
            $val = 'VERY_POOR';
        } else {
            $val = '';
        }
        
        $ipAddress =  $request->ip();
       


        $feedback = new GeneralFeedback();
        $feedback->text = $text;
        $feedback->feedback = $val;
        $feedback->browser = $request->browser;
        $feedback->platform = $request->platform;
        $feedback->device = $request->device;
         $feedback->mobile = $request->mobile;
        $feedback->ip_address = $ipAddress;
        $feedback->save();
    
    
        return response()->json(['success' => true, 'message' => 'General Feedback submitted successfully']);
    }
    

    public function payment_confirm_mail()
    {
        $data = [
            'title' => 'Saurabh Verma',
            'body' => 'Booking Confirmed',
        ];
        $response = Mail::to('talk2billionbyte@gmail.com')->send(new MyMail($data));
        return 'Successfully send' . $response;
    }

    public function remove_hold_transaction()
    {
        $setting_data = getSetting(1);
        $ticket_hold_time = $setting_data->ticket_hold_time + 1;
        // SELECT id FROM customer_cart WHERE  is_hold_for_booking='YES' AND hold_on >= ;

        $date = new DateTime();
        $date->modify('-' . $ticket_hold_time . ' minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $a=CustomerCart::where('is_hold_for_booking', 'YES')
            ->where('hold_on', '<', $formatted_date)
            ->delete();
    }

    public function payumoney_webhook(Request $request)
    {
        /* WEBHOOK DATA CAPTURED */
        // $pg_get =$request->getContent();
        // parse_str($pg_get, $pg_response);

        $pg_response = $request->all();

        if(count($pg_response)==0)
        {
            echo 'No data Received for PayU';
        }
        else
        {
            $customerName = $pg_response['customerName'];
            $additionalCharges = $pg_response['additionalCharges'];
            $paymentMode = $pg_response['paymentMode'];
            $hash = $pg_response['hash'];
            $status = $pg_response['status'];
            $error_Message = $pg_response['error_Message'];
            $paymentId = $pg_response['paymentId'];
            $productInfo = $pg_response['productInfo'];
            $customerEmail = $pg_response['customerEmail'];
            $customerPhone = $pg_response['customerPhone'];
            $merchantTransactionId = $pg_response['merchantTransactionId'];
            $amount = $pg_response['amount'];
            $udf1 = 'PAYU MONEY';
            $udf2 = $pg_response['udf2'];
            $udf3 = $pg_response['udf3'];
            $udf4 = $pg_response['udf4'];
            $udf5 = $pg_response['udf5'];
           
            $PaymentLogs = PaymentLogs::where(['merchantTransactionId' => $merchantTransactionId, 'paymentId' => $paymentId]);
            if ($PaymentLogs->count() == 0)
            {
                $log = new PaymentLogs();
                $log->status = $status;
                $log->customerName = $customerName;
                $log->customerEmail = $customerEmail;
                $log->customerPhone = $customerPhone;
                $log->paymentId = $paymentId;
                $log->merchantTransactionId = $merchantTransactionId;
                $log->paymentMode = $paymentMode;
                $log->amount = $amount;
                $log->additionalCharges = $additionalCharges;
                $log->hash = $hash;
                $log->error_Message = $error_Message;
                $log->productInfo = $productInfo;
                $log->udf1 = $udf1;
                $log->udf2 = $udf2;
                $log->udf3 = $udf3;
                $log->udf4 = $udf4;
                $log->udf5 = $udf5;
                $log->save();
                echo "Data Saved Successfully";
            }
        }
    }

    public function razorpay_webhook(Request $request)
    {
        DB::beginTransaction();

        /* WEBHOOK DATA CAPTURED */
        $pg_response = $request->all();

        // print_r($pg_response);
        // print_r($pg_response['payload']['payment']['entity']['id']);
        // exit;
        if(count($pg_response)==0)
        {
            echo 'No data Received';
        }
        else
        {
            $event = $pg_response['event'];
            $pg_response=$pg_response['payload']['payment']['entity'];
         
            if($event=='payment.captured')
            {
                $status='SUCCESS';
            }
            else
            {
                $status='FAILED';
            }

            $customerEmail = $pg_response['email'];
            $customerPhone = $pg_response['contact'];
            $paymentId = $pg_response['id'];
            $merchantTransactionId = $pg_response['order_id'];
            $paymentMode = $pg_response['method'];
            $amount = round($pg_response['amount']/100);
            $error_Message = $pg_response['error_code'];
            $productInfo = 'OP Sharma Magic Show Ticket';

            try
            {
                $PaymentLogs = PaymentLogs::where(['paymentId' => $paymentId]);
                if ($PaymentLogs->count() == 0)
                {
                    $log = new PaymentLogs();
                    $log->status = $status;
                    $log->customerEmail = $customerEmail;
                    $log->customerPhone = $customerPhone;
                    $log->paymentId = $paymentId;
                    $log->merchantTransactionId = $merchantTransactionId;
                    $log->paymentMode = $paymentMode;
                    $log->amount = $amount;
                    $log->error_Message = $error_Message;
                    $log->productInfo = $productInfo;
                    $log->udf1 = 'RAZORPAY';
                    $log->save();
                    echo "Data Saved Successfully";
                    DB::commit();
                }
            } catch (Exception $e) {
                DB::rollBack();
            }
        }
    }
    
    public function pending_payu_ticket_booking_cron()
    {
        $setting_data = getSetting(1);
        $gst_waiver_rate = $setting_data->gst_waiver_rate;
        $ticket_hold_time = $setting_data->ticket_hold_time - 9;
        $date = new DateTime();
        $date->modify('-' . $ticket_hold_time . ' minutes');
        
          $formatted_date = $date->format('Y-m-d H:i:s');

        echo "<br>";
        $pending_tickets = PaymentTransaction::where(function ($query) {
            $query->where('status', 'failed')
                  ->orWhere('status', '=', NULL);
        })
        ->whereNull('booking_id')
        ->where('updated_at', '<', $formatted_date)
        ->where('cron_checked', 0)
        ->whereNull('payment_gateway');
       $pendig_count=$pending_tickets->count();


        if($pendig_count>0)
        {
            $all_data=$pending_tickets->get();
            foreach($all_data as $data)
            {
                $txnid=$data->txnid;
                $d=verify_payu_payment($data->txnid);
                $d=json_decode($d);
              
                $d=$d->transaction_details;
                if($d->{$txnid}->status=='success')
                {
                   echo $pendig_count.' Ticket Found for processing<bR>';
                    $seat_ids =  $data->seat_ids;
                    $seat_ids = explode(',', $data->seat_ids);
                    $actual_count=count($seat_ids);
                  echo  $available_count = EventSeat::whereIn('id', $seat_ids)->whereNull('booking_id')->count();
                    if($actual_count==$available_count)
                    {
                         DB::beginTransaction();
                        echo 'Booked Ticket for Customer<br>';
                   
                        $seat_ids_arr = $seat_ids;

                        $seat_ids = implode(',', $seat_ids_arr);
                        
                        $seat_data = EventSeat::where('id', $seat_ids_arr[0])->first();
                        
                        $event_id = $seat_data->event_id;
                        
                        $event_schedule_id = getEventScheduleByEventID($event_id)[0]->id;
                        
                        $event_schedule_list_id = $seat_data->event_schedule_list_id;
                        $event_show_time_id = $seat_data->event_show_time_id;
                        
                        $event_data = getEvent($event_id);
                        
                        $venue_id = $event_data->venue_id;
                        
                        $layout_id = $seat_data->layout_id;
                        
                        $mobile_no = $data->mobile;
                        $customer_name = $data->name;
                        $email = $data->email;
                        $coupon_code = '';
                        $discount = $data->discount;
                        $payment_method_id = 8;
                        
                        $qty = 0;
                        $total_discount = 0;
                        $grand_total = 0;
                        $net_grand_total = 0;
                        
                        $seat_ids_array = explode(',', $seat_ids);
                        
                        $setting_data = getSetting(1);
                        $convenience_fee = $setting_data->convenience_fee;

                        $grand_total=$data->amount;
                        $qty =$data->quantity;
                        $grand_total = $grand_total + ($grand_total * $convenience_fee) / 100;
                        $grand_total = round($grand_total);

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
                    
                        $booking_id_str=random_strings(6);
                        //bookings
                        $booking = new Booking();
                        $booking->event_id = $event_id;
                        $booking->event_schedule_id = $event_schedule_id;
                        $booking->event_schedule_list_id = $event_schedule_list_id;
                        $booking->event_show_time_id = $event_show_time_id;
                        $booking->venue_id = $venue_id;
                        $booking->layout_id = $layout_id;
                        $booking->payment_method_id = $payment_method_id;
                        $booking->booking_amount = $grand_total;
                        $booking->paid_amount = $grand_total - $total_discount;
                        $booking->total_quantity = $qty;
                        $booking->discount = $total_discount;
                        $booking->grand_total = $grand_total;
                        
                        
                        $paid_amount = ($grand_total - $total_discount);
                        $per_ticket_paid = $paid_amount / $qty;
                        $is_gst_applicable = $per_ticket_paid > $gst_waiver_rate;
                        
                        if ($is_gst_applicable) {
                            $per_ticket_taxable = round($per_ticket_paid / 1.18, 2);
                            $per_ticket_gst     = round($per_ticket_paid - $per_ticket_taxable, 2);
                            $taxable_amount = round($per_ticket_taxable * $qty, 2);
                            $gst_amount     = round($per_ticket_gst * $qty, 2);
                        } else {
                            $taxable_amount = 0.00;
                            $gst_amount     = 0.00;
                        }
                        
                        
                        $booking->is_gst_applicable = $is_gst_applicable;
                        $booking->taxable_amount = $taxable_amount;
                        $booking->gst_amount = $gst_amount;
                        
                        $booking->booking_code = unique_id_generate();
                        $booking->booking_date = date('Y-m-d');
                        $booking->booking_time = date('H:i:s A');
                        $booking->customer_id = $customer->id;
                        $booking->booking_id_str = $booking_id_str;
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
                            $booking_detail->discount = $discount;
                            $booking_detail->seat_no = $event_seat->seatno;
                            $booking_detail->row_id = $event_seat->row_no;
                            $booking_detail->col_id = $event_seat->col_no;
                            $booking_detail->save();
                    
                            $discount = $data->discount;
                            EventSeat::where(['id' => $seat_ids_arr])->update(['total_discount' => $discount, 'payment_method_id' => $payment_method_id, 'booking_id' => $booking->id, 'booking_time' => date('Y-m-d H:i:s')]);
                            EventSeat::where(['id' => $seat_ids_arr])->decrement('total_ticket', 1);
                        }
                    
                        //booking_payments
                        $booking_payment = new BookingPayment();
                        $booking_payment->booking_id = $booking->id;
                        $booking_payment->payment_method_id = $payment_method_id;
                        $booking_payment->reference_no = $txnid;
                        $booking_payment->amount = $grand_total;
                        $booking_payment->discount = $total_discount;
                    
                        $payable_amount = $grand_total - $total_discount;
                        $booking_payment->note = 'Payable Amount: ' . $payable_amount;
                        $booking_payment->save();
                    
                         PaymentTransaction::where('txnid', $data->txnid)->update([
                            'cron_checked' => 1,
                            'booking_id' => $booking->id,
                            'customer_id' => $customer->id,
                            'pg_txn' => $d->{$txnid}->mihpayid,
                            'bank_ref_num' => $d->{$txnid}->bank_ref_num,
                            'status' =>  'success',
                            'booked_by_cron' =>'YES'
                        ]);



                        $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                        $event_date = date('D d M Y', strtotime($event_date));

                        $event_show_time = getEventShowTime($booking->event_show_time_id);
                        $event_show_time = $event_show_time->start_time;

                        $venue = getVenue($booking->venue_id);
                        $venue = $venue->name;
                        
                        if (getTicketType($booking_detail->ticket_type_id)) {
                            $ticket_type_name = getTicketType($booking_detail->ticket_type_id)->ticket_type_name;
                        } else {
                            $ticket_type_name = '';
                        }
        
                        

                        if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW') {
                            $seat_no_message = '';
                        } else {
                            $seat_no_message = ' -  Seat Number not allotted';
                        }
                        

                        $booking_id=$booking->id;
                        $payment_details = PaymentTransaction::where('booking_id', $booking_id)->first();
                        $booking_details = BookingDetail::where('booking_id', $booking_id)->get();
                        $booking_payment = BookingPayment::where('booking_id', $booking_id)->first();
                        $customer_details = Customer::where('id', $booking->customer_id)->first();

                        $seat_no_arr = [];
                        $show_name = false;

                        if($booking_details)
                        {
                            foreach ($booking_details as $key => $booking_detail)
                            {
                                $payment_method_name = fetch_payment_method($booking_payment->payment_method_id);
                                $seat_name = fetch_seat_no($booking_detail->seat_id);
                                $row_no = $seat_name->row_no;
                                $base_price = $seat_name->base_price;
                                $total_discount = $seat_name->total_discount;
                                // $layout_row_label = getLayout($seat_name->layout_id)->layout_row_label;
                                // $layout_row_label = explode(',', $layout_row_label);
                                // $row_name = $layout_row_label[$row_no - 1];

                                if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW') {
                                    $show_name = true;
                                }
                                $seat_no_arr[] = $seat_name->label . $seat_name->name;
                            }
                        }

                        if ($show_name == true) {
                            echo $seat_no = implode(', ', $seat_no_arr) . ' - ';
                        } else {
                            $seat_no = '';
                        }

                        $data = [];
                        $data['status'] = 'SUCCESS';
                        $data['booking_id'] = $booking->id;
                        $data['amount'] = $payment_details['amount'];
                        $data['tickets'] = $seat_no . count($seat_no_arr) . ' Ticket(s)' . ' (' . $ticket_type_name . ')' . $seat_no_message;
                        $data['show_name'] = $event_date . ' ' . $event_show_time;
                        $data['txnid'] = $payment_details['txnid'];
                        $data['venue'] = $venue;
                        $data['bank_ref_num'] = $payment_details['bank_ref_num'];
                        $data['pg_txn'] = $payment_details['pg_txn'];
                        $data['name'] = $customer_name;
                        $data['email'] = $email;
                        $data['mobile'] = trim($mobile_no);
                        $data['booking_id_str'] = $booking->booking_id_str;
                        $data['updated_at'] = $event_date = date('D d M Y h:i:s A', strtotime($booking['updated_at']));
                        $res = send_whatsapp($data);
                        if ($res == 'SENT') {
                            update_whatsapp_sent($booking_id);
                        }

                        DB::commit();
                        
                        echo  "Booking ID: ". $booking->id;
                        echo "<br>";
                    }
                }
                else
                {
                    PaymentTransaction::where('txnid', $data->txnid)->update(['cron_checked' => 1]);  
                }
            }
        }
        else
        {
            echo 'No Ticket Found in System for Processing';
        }
    }
    
    public function pending_razorpay_ticket_booking_cron()
    {
        $setting_data = getSetting(1);
        $ticket_hold_time = $setting_data->ticket_hold_time - 9;
        $gst_waiver_rate = $setting_data->gst_waiver_rate;
        
        $date = new DateTime();
        $date->modify('-' . $ticket_hold_time . ' minutes');
        
        $formatted_date = $date->format('Y-m-d H:i:s');
       

        $pending_tickets = PaymentTransaction::where(function ($query) {
            $query->where('status', 'failed')
                  ->orWhere('status', '=', NULL);
        })
        ->whereNull('booking_id')
         ->where('updated_at', '<', $formatted_date)
        ->where('cron_checked', 0)
        ->where('payment_gateway', 'RAZORPAY')
        ->orderBy('updated_at', 'desc'); // Order by the latest updated_at

        
        // $sql = $pending_tickets->toSql();
        // $bindings = $pending_tickets->getBindings();
        // dd(vsprintf(str_replace('?', '%s', $sql), array_map(function ($binding) {
        //     return is_numeric($binding) ? $binding : "'".str_replace("'", "''", $binding)."'";
        // }, $bindings)));

        $pendig_count=$pending_tickets->count();
        
        if($pendig_count>0)
        {
            $all_data=$pending_tickets->limit(10)->get();
            
            foreach($all_data as $data)
            {
                echo $id = $data->id;
                echo "<br>";
                $txnid=$data->txnid;
                // $txnid = 'order_PLvNxFLlLyeEL1';
                $d=verify_razorpay_payment($txnid);
                $d=json_decode($d);
                // print_r($d);
                
                if($d->status == true || $d->status == 1)
                {
                    $pendig_count.' Ticket Found for processing<bR>';
                    $seat_ids =  $data->seat_ids;
                    $seat_ids = explode(',', $data->seat_ids);
                    $actual_count=count($seat_ids);
                    $available_count = EventSeat::whereIn('id', $seat_ids)->whereNull('booking_id')->count();
                    if($actual_count==$available_count)
                    {
                         DB::beginTransaction();
                        echo 'Now, Booking Ticket for Customer';
                        $seat_ids_arr = $seat_ids;

                        $seat_ids = implode(',', $seat_ids_arr);
                        
                        $seat_data = EventSeat::where('id', $seat_ids_arr[0])->first();
                        
                        $event_id = $seat_data->event_id;
                        
                        $event_schedule_id = getEventScheduleByEventID($event_id)[0]->id;
                        
                        $event_schedule_list_id = $seat_data->event_schedule_list_id;
                        $event_show_time_id = $seat_data->event_show_time_id;
                        
                        $event_data = getEvent($event_id);
                        
                        $venue_id = $event_data->venue_id;
                        
                        $layout_id = $seat_data->layout_id;
                        
                        $mobile_no = $data->mobile;
                        $customer_name = $data->name;
                        $email = $data->email;
                        $coupon_code = '';
                        $discount = $data->discount;
                        $payment_method_id = 8;
                        
                        $qty = 0;
                        $total_discount = 0;
                        $grand_total = 0;
                        $net_grand_total = 0;
                        
                        $seat_ids_array = explode(',', $seat_ids);
                        
                        $setting_data = getSetting(1);
                        $convenience_fee = $setting_data->convenience_fee;

                        $grand_total=$data->amount;
                        $qty =$data->quantity;
                        $grand_total = $grand_total + ($grand_total * $convenience_fee) / 100;
                        $grand_total = round($grand_total);

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
                    
                        $booking_id_str=random_strings(6);
                        //bookings
                        $booking = new Booking();
                        $booking->event_id = $event_id;
                        $booking->event_schedule_id = $event_schedule_id;
                        $booking->event_schedule_list_id = $event_schedule_list_id;
                        $booking->event_show_time_id = $event_show_time_id;
                        $booking->venue_id = $venue_id;
                        $booking->layout_id = $layout_id;
                        $booking->payment_method_id = $payment_method_id;
                        $booking->booking_amount = $grand_total;
                        $booking->paid_amount = $grand_total - $total_discount;
                        $booking->total_quantity = $qty;
                        $booking->discount = $total_discount;
                        $booking->grand_total = $grand_total;
                        
                        
                        $paid_amount = ($grand_total - $total_discount);
                        $per_ticket_paid = $paid_amount / $qty;
                        $is_gst_applicable = $per_ticket_paid > $gst_waiver_rate;
                        
                        if ($is_gst_applicable) {
                            $per_ticket_taxable = round($per_ticket_paid / 1.18, 2);
                            $per_ticket_gst     = round($per_ticket_paid - $per_ticket_taxable, 2);
                            $taxable_amount = round($per_ticket_taxable * $qty, 2);
                            $gst_amount     = round($per_ticket_gst * $qty, 2);
                        } else {
                            $taxable_amount = 0.00;
                            $gst_amount     = 0.00;
                        }
                        
                        
                        $booking->is_gst_applicable = $is_gst_applicable;
                        $booking->taxable_amount = $taxable_amount;
                        $booking->gst_amount = $gst_amount;
                        
                        
                        $booking->booking_code = unique_id_generate();
                        $booking->booking_date = date('Y-m-d');
                        $booking->booking_time = date('H:i:s A');
                        $booking->customer_id = $customer->id;
                        $booking->booking_id_str = $booking_id_str;
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
                            $booking_detail->discount = $discount;
                            $booking_detail->seat_no = $event_seat->seatno;
                            $booking_detail->row_id = $event_seat->row_no;
                            $booking_detail->col_id = $event_seat->col_no;
                            $booking_detail->save();
                    
                            $discount = $data->discount;
                            EventSeat::where(['id' => $seat_ids_arr])->update(['total_discount' => $discount, 'payment_method_id' => $payment_method_id, 'booking_id' => $booking->id, 'booking_time' => date('Y-m-d H:i:s')]);
                            EventSeat::where(['id' => $seat_ids_arr])->decrement('total_ticket', 1);
                        }
                    
                        //booking_payments
                        $booking_payment = new BookingPayment();
                        $booking_payment->booking_id = $booking->id;
                        $booking_payment->payment_method_id = $payment_method_id;
                        $booking_payment->reference_no = $txnid;
                        $booking_payment->amount = $grand_total;
                        $booking_payment->discount = $total_discount;
                    
                        $payable_amount = $grand_total - $total_discount;
                        $booking_payment->note = 'Payable Amount: ' . $payable_amount;
                        $booking_payment->save();
                    


                        PaymentTransaction::where('txnid', $data->txnid)->update([
                            'cron_checked' => 1,
                            'booking_id' => $booking->id,
                            'customer_id' => $customer->id,
                            'pg_txn' => $d->pg_txn,
                            'status' =>  'success',
                            'booked_by_cron' =>'YES'
                        ]);


                        $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                        $event_date = date('D d M Y', strtotime($event_date));

                        $event_show_time = getEventShowTime($booking->event_show_time_id);
                        $event_show_time = $event_show_time->start_time;

                        $venue = getVenue($booking->venue_id);
                        $venue = $venue->name;
                        
                        if (getTicketType($booking_detail->ticket_type_id)) {
                            $ticket_type_name = getTicketType($booking_detail->ticket_type_id)->ticket_type_name;
                        } else {
                            $ticket_type_name = '';
                        }
        
                        

                        if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW') {
                            $seat_no_message = '';
                        } else {
                            $seat_no_message = ' -  Seat Number not allotted';
                        }
                        

                        $booking_id=$booking->id;
                        $payment_details = PaymentTransaction::where('booking_id', $booking_id)->first();
                        $booking_details = BookingDetail::where('booking_id', $booking_id)->get();
                        $booking_payment = BookingPayment::where('booking_id', $booking_id)->first();
                        $customer_details = Customer::where('id', $booking->customer_id)->first();

                        $seat_no_arr = [];
                        $show_name = false;

                        if($booking_details)
                        {
                            foreach ($booking_details as $key => $booking_detail)
                            {
                                $payment_method_name = fetch_payment_method($booking_payment->payment_method_id);
                                $seat_name = fetch_seat_no($booking_detail->seat_id);
                                $row_no = $seat_name->row_no;
                                $base_price = $seat_name->base_price;
                                $total_discount = $seat_name->total_discount;
                                // $layout_row_label = getLayout($seat_name->layout_id)->layout_row_label;
                                // $layout_row_label = explode(',', $layout_row_label);
                                // $row_name = $layout_row_label[$row_no - 1];
                                if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW') {
                                    $show_name = true;
                                }
                                $seat_no_arr[] = $seat_name->label . $seat_name->name;
                            }
                        }

                        if ($show_name == true) {
                            echo $seat_no = implode(', ', $seat_no_arr) . ' - ';
                        } else {
                            $seat_no = '';
                        }

                        $data = [];
                        $data['status'] = 'SUCCESS';
                        $data['booking_id'] = $booking->id;
                        $data['amount'] = $payment_details['amount'];
                        $data['tickets'] = $seat_no . count($seat_no_arr) . ' Ticket(s)' . ' (' . $ticket_type_name . ')' . $seat_no_message;
                        $data['show_name'] = $event_date . ' ' . $event_show_time;
                        $data['txnid'] = $payment_details['txnid'];
                        $data['venue'] = $venue;
                        $data['bank_ref_num'] = $payment_details['bank_ref_num'];
                        $data['pg_txn'] = $payment_details['pg_txn'];
                        $data['name'] = $customer_name;
                        $data['email'] = $email;
                        $data['mobile'] = trim($mobile_no);
                        $data['booking_id_str'] = $booking->booking_id_str;
                        $data['updated_at'] = $event_date = date('D d M Y h:i:s A', strtotime($booking['updated_at']));
                        $res = send_whatsapp($data);
                        if ($res == 'SENT') {
                            update_whatsapp_sent($booking_id);
                        }

                        DB::commit();
                    }
                }
                else
                {
                    PaymentTransaction::where('txnid', $data->txnid)->update(['cron_checked' => 1]);  
                }
            }
        }
        else
        {
            echo 'No Ticket Found in System for Processing';
        }
    }
    
    public function api_check_alert()
    {
        $setting_data = getSetting(1);
        $gst_waiver_rate = $setting_data->gst_waiver_rate;
        
        // Process in chunks (better for large data sets)
        Booking::whereRaw('(paid_amount / total_quantity) > 500')
            ->where('taxable_amount', 0)
            ->chunk(100, function ($bookings) use ($gst_waiver_rate) {
            foreach ($bookings as $booking) {

                $total_quantity = $booking->total_quantity;
                $grand_total    = $booking->grand_total;
                $total_discount = $booking->total_discount;
                
                if ($total_quantity <= 0) {
                    continue; // avoid division by zero
                }
                
                // Prefer DB paid_amount if valid, otherwise recalc
                $paid_amount = $booking->paid_amount ?: ($grand_total - $total_discount);
                $per_ticket_paid = $paid_amount / $total_quantity;
                $is_gst_applicable = $per_ticket_paid > $gst_waiver_rate;
                
                if ($is_gst_applicable) {
                    $per_ticket_taxable = round($per_ticket_paid / 1.18, 2);
                    $per_ticket_gst     = round($per_ticket_paid - $per_ticket_taxable, 2);
                    $taxable_amount = round($per_ticket_taxable * $total_quantity, 2);
                    $gst_amount     = round($per_ticket_gst * $total_quantity, 2);
                } else {
                    $taxable_amount = 0.00;
                    $gst_amount     = 0.00;
                }
                
                // // Update only necessary fields
                $booking->update([
                    'is_gst_applicable' => $is_gst_applicable,
                    'taxable_amount'    => $taxable_amount,
                    'gst_amount'        => $gst_amount,
                ]);
            }
        });
            
        $setting_data = getSetting(1);
        $booking_id_for_check = $setting_data->booking_id_for_check;
        $mail_check = $setting_data->mail_check;
        $whatsapp_check = $setting_data->whatsapp_check;
        $sms_check = $setting_data->sms_check;
        $res = Booking::where(['id' => $booking_id_for_check])->update(['is_whatsapp_sent' => 'NO', 'is_email_sent' => 'NO']);
        $booking = Booking::where(['id' => $booking_id_for_check])->first();
        $booking_id_str = $booking->booking_id_str;
        echo "SMS => SENT"; echo "<br>";
        echo "Whatsapp => SENT"; echo "<br>";
        echo "Email => SENT"; echo "<br>";
        $url = "https://magicianopsharma.co.in/book_ticket/ticket_booked/".$booking_id_str;
        file_get_contents($url);
    }
    
    
    public function cgst_sgst_fix()
    {
        $gstPercent = 18;
        $cgstPercent = $gstPercent / 2;
        $sgstPercent = $gstPercent / 2;
    
        Booking::with(['event', 'paymentTransaction'])
            ->where('is_gst_applicable', true)
            ->whereNull('cgst_value')
            ->whereNull('sgst_value')
            ->whereNull('igst_value')
            ->chunk(30, function ($bookings) use ($cgstPercent, $sgstPercent) {
                foreach ($bookings as $booking) {
    
                    $eventState = optional($booking->event)->state;
                    $paymentState = optional($booking->paymentTransaction)->state;
                    $isInterState = $eventState && $paymentState && $eventState !== $paymentState;
    
                    $taxable = $booking->taxable_amount;
    
                    if ($isInterState) {
                        $igstValue = round($taxable * ($cgstPercent + $sgstPercent) / 100, 2);
                        $booking->update([
                            'igst_percent' => $cgstPercent + $sgstPercent,
                            'igst_value'   => $igstValue,
                            'cgst_value'   => 0,
                            'sgst_value'   => 0,
                            'gst_amount'   => $igstValue,
                        ]);
                    } else {
                        $cgstValue = round($taxable * $cgstPercent / 100, 2);
                        $sgstValue = round($taxable * $sgstPercent / 100, 2);
                        $booking->update([
                            'cgst_percent' => $cgstPercent,
                            'sgst_percent' => $sgstPercent,
                            'cgst_value'   => $cgstValue,
                            'sgst_value'   => $sgstValue,
                            'igst_value'   => 0,
                            'gst_amount'   => $cgstValue + $sgstValue,
                        ]);
                    }
                }
            });
    
        return "✅ GST values calculated and updated successfully.";
    }
}