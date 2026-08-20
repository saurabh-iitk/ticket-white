<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Booking;
use App\Models\City;
use App\Models\Pincode;
use App\Models\Venue;
use App\Models\SubVenue;
use App\Models\EventSchedule;
use App\Models\EventScheduleList;
use App\Models\TicketType;
use App\Models\EventTicket;
use App\Models\EventTicketList;
use App\Models\EventShowTime;
use App\Models\EventShowSchedule;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // function get city by state id
    public function get_city_by_state_id(Request $request)
    {
        $cities = City::where(['state_id' => $request->state_id, 'status' => 'ACTIVE'])->pluck('name', 'id');
        return json_encode($cities);
    }

    // function get pincode by city id
    public function get_pincode_by_city_id(Request $request)
    {
        $pincodes = Pincode::where(['city_id' => $request->city_id, 'status' => 'ACTIVE'])->pluck('pincode', 'id');
        return json_encode($pincodes);
    }

    // function get venue by city id
    public function get_venue_by_city_id(Request $request)
    {
        $venues = Venue::where(['city_id' => $request->city_id, 'status' => 'ACTIVE'])->pluck('name', 'id');
        return json_encode($venues);
    }

    // function get sub venue by venue id
    public function get_sub_venue_by_venue_id(Request $request)
    {
        $sub_venues = SubVenue::where(['venue_id' => $request->venue_id, 'status' => 'ACTIVE'])->pluck('name', 'id');
        return json_encode($sub_venues);
    }

    // function get event schedule by event id
    public function get_event_schedule_by_event_id(Request $request)
    {
        $event_schedules = EventSchedule::where(['event_id' => $request->event_id, 'status' => 'ACTIVE'])->get();

        foreach ($event_schedules as $event_schedule) {
          $event_schedule->start_date=date('D jS F, Y', strtotime($event_schedule->start_date));
          $event_schedule->end_date=date('D jS F, Y', strtotime($event_schedule->end_date));
        }
        return json_encode($event_schedules);
    }


    // function get ticket type by event id
    public function get_ticket_type_by_event_id(Request $request)
    {
        $ticket_types = \App\Models\TicketType::where(['event_id' => $request->event_id, 'status' => 'ACTIVE'])->get();
        return json_encode($ticket_types);
    }

    // function get event schedule list by event shedule id
    public function get_event_schedule_list_by_event_schedule_id(Request $request)
    {
        $data = [];
    
        if (in_array('admin_action', Session::get('permissions')->toArray()))
        {
            $event_schedule_lists = EventScheduleList::where(['event_schedule_id' => $request->event_schedule_id, 'status' => 'ACTIVE'])->get();
            $event_show_times = EventShowTime::where(['event_schedule_id' => $request->event_schedule_id, 'status' => 'ACTIVE'])->get();
            foreach ($event_schedule_lists as $event_schedule_list)
            {
                $event_schedule_list->event_date=date('D jS F, Y', strtotime($event_schedule_list->event_date));
            }
        }
        else
        {
            $date = today()->format('Y-m-d');
            $event_schedule_lists = EventScheduleList::where(['event_schedule_id' => $request->event_schedule_id, 'status' => 'ACTIVE'])
            ->where('event_date', '>=', $date)
            ->get();

            $event_show_times = EventShowTime::where(['event_schedule_id' => $request->event_schedule_id, 'status' => 'ACTIVE'])->get();
            foreach ($event_schedule_lists as $event_schedule_list)
            {
                $event_schedule_list->event_date=date('D jS F, Y', strtotime($event_schedule_list->event_date));
            }
        }
       

        $data['event_schedule_lists'] = $event_schedule_lists;
        $data['event_show_times'] = $event_show_times;
        return json_encode($data);
    }


     public function get_event_schedule_list_by_event_schedule_id_unmapped(Request $request)
    {
        $data = [];
        
        $date = today()->format('Y-m-d');
        $event_schedule_lists = EventScheduleList::where(['event_schedule_id' => $request->event_schedule_id, 'status' => 'ACTIVE'])
        ->where('event_date', '>=', $date)
        ->get();

        $event_show_times = EventShowTime::where(['event_schedule_id' => $request->event_schedule_id, 'status' => 'ACTIVE'])->get();
        foreach ($event_schedule_lists as $event_schedule_list)
        {
            $event_schedule_list->event_date=date('D jS F, Y', strtotime($event_schedule_list->event_date));
        }
        $data['event_schedule_lists'] = $event_schedule_lists;
        $data['event_show_times'] = $event_show_times;
        return json_encode($data);
    }


     public function event_schedule_import_data(Request $request)
    {
        $event_id=$request->event_id;

        $event_ticket_temp = EventTicket::where('status','ACTIVE')
        ->where('event_id', $event_id)
        ->get();
        
        foreach ($event_ticket_temp as $event_ticket_single) {
            $list_id_temp[] = $event_ticket_single->event_schedule_list_id;
            $show_id_temp[] = $event_ticket_single->event_show_time_id;
        }

        $list_id_temp = implode(',', $list_id_temp);
        $show_id_temp = implode(',', $show_id_temp);

        
        $event_schedule_list_id_array = explode(',', $list_id_temp);
        $event_show_time_id_array = explode(',', $show_id_temp);

        $event_schedule_lists = EventScheduleList::whereIn('id', $event_schedule_list_id_array)->get();
        $event_show_times = EventShowTime::whereIn('id', $event_show_time_id_array)->get();

        foreach ($event_schedule_lists as $event_schedule_list)
        {
            $event_schedule_list->event_date=date('D jS F, Y', strtotime($event_schedule_list->event_date));
        }

        $data['event_schedule_lists'] = $event_schedule_lists;
        $data['event_show_times'] = $event_show_times;
        return json_encode($data);
    }



    public function event_schedule_import_data_show(Request $request)
    {
        $event_id=$request->event_id;
        $schedule_list_id=$request->schedule_list_id;

        $event_ticket_temp = EventTicket::where('status','ACTIVE')
        ->where('event_id', $event_id)
        ->get();

        $event_show_times = EventShowSchedule::where('event_schedule_list_id', $schedule_list_id)
        ->where('event_id', $event_id)
        ->get();

        $data['event_show_times'] = $event_show_times;
        return json_encode($data);
    }


    public function event_ticket_data(Request $request)
    {
        $event_id=$request->event_id;
        $ticket_type_id=$request->ticket_type_id;

        $event_ticket= TicketType::where('status','ACTIVE')
        ->where('event_id', $event_id)
        ->get();

        $data['event_ticket'] = $event_ticket;
        return json_encode($data);
    }


    // function get event schedule list by event shedule id
    // public function get_event_schedule_list_by_event_schedule_id_unmapped(Request $request)
    // {
    //     $data = [];

    //     $event_schedule_lists = EventScheduleList::where(['event_schedule_id' => $request->event_schedule_id, 'status' => 'ACTIVE'])->get();
    //     $event_show_times = EventShowTime::where(['event_schedule_id' => $request->event_schedule_id, 'status' => 'ACTIVE'])->get();
    //     foreach ($event_schedule_lists as $event_schedule_list)
    //     {
    //         $event_schedule_list->event_date=date('D jS F, Y', strtotime($event_schedule_list->event_date));
    //     }


    //    $event_show_times = EventShowSchedule::where(['event_schedule_list_id' => $request->event_schedule_list_id])
    //     ->whereRaw('event_show_time_id NOT IN (SELECT DISTINCT(event_show_time_id) FROM event_ticket_lists WHERE event_schedule_list_id=?)', [$request->event_schedule_list_id])
    //     ->get();

    //     $data['event_schedule_lists'] = $event_schedule_lists;
    //     $data['event_show_times'] = $event_show_times;
    //     return json_encode($data);
    // }



    // function get event schedule time list by event shedule date id
    public function get_event_schedule_time_by_event_schedule_date(Request $request)
    {
        $data = [];
        $event_show_times = EventShowSchedule::where(['event_schedule_list_id' => $request->event_schedule_list_id, 'vendor_booking' => 'ALLOWED'])->get();

        $data['event_show_times'] = $event_show_times;
        return json_encode($data);
    }

    // function get event schedule time list by event shedule date id for booking
    public function get_event_schedule_time_by_event_schedule_date_booking(Request $request)
    {
        $data = [];
        $event_show_times = EventShowSchedule::where(['event_schedule_list_id' => $request->event_schedule_list_id, 'customer_booking' => 'ALLOWED'])->get();
        $data['event_show_times'] = $event_show_times;
        return json_encode($data);
    }


// function get event ticket by show time id
    public function get_tickets_by_show_time_id(Request $request)
    {
        $data = [];
        $event_tickets = EventTicketList::join('ticket_type', 'event_ticket_lists.ticket_type_id', '=', 'ticket_type.id')
        ->where(['event_show_time_id' => $request->event_show_time_id, 'event_schedule_list_id' => $request->event_schedule_list_id])
        ->get(['event_ticket_lists.*', 'ticket_type.ticket_type_name']);
        $data['event_tickets'] = $event_tickets;
        return json_encode($data);
    }
    


    // function get event schedule by event id
    public function get_event_show_time_by_event_id(Request $request)
    {
        $event_show_times = EventShowTime::where(['event_id' => $request->event_id, 'status' => 'ACTIVE'])->get();
        return json_encode($event_show_times);
    }

    // function get event schedule by event schedule id
    public function get_event_show_time_by_event_schedule_id(Request $request)
    {
        $event_show_times = EventShowTime::where(['event_schedule_id' => $request->event_schedule_id, 'status' => 'ACTIVE'])->get();
        return json_encode($event_show_times);
    }

    // function get customer by mobile no
    public function get_customer_by_mobile_no(Request $request)
    {
        $data = Customer::where(['mobile_no' => $request->mobile_no, 'status' => 'ACTIVE'])->first();
        return json_encode($data);
    }
    
    public function update_show_status(Request $request)
    {
        $event_schedule_list_id=$request->event_schedule_list_id;
        $event_show_time_id=$request->event_show_time_id;
        $user_type=$request->user_type;
        $status=$request->status;

       
        if($status=="false")
        {
            $allowed='ALLOWED';
        }

        if($status=="true")
        {
            $allowed='NOT_ALLOWED';
        }



        $update_array=array();

        if($user_type=='VENDOR')
        {
            if($allowed=='ALLOWED')
            {
                $update_array['vendor_booking']='NOT_ALLOWED';
            }
            if($allowed=='NOT_ALLOWED')
            {
                $update_array['vendor_booking']='ALLOWED';
            }
        }
        if($user_type=='CUSTOMER')
        {
            if($allowed=='ALLOWED')
            {
                $update_array['customer_booking']='NOT_ALLOWED';
            }
            if($allowed=='NOT_ALLOWED')
            {
                $update_array['customer_booking']='ALLOWED';
            }
        }


        $update_query=EventShowSchedule::where('event_schedule_list_id', $event_schedule_list_id)
        ->where('event_show_time_id', $event_show_time_id )
        ->update($update_array);


        $hide_date_array=array();
        $check_count = EventShowSchedule::where('event_schedule_list_id', $event_schedule_list_id)->where('customer_booking' , 'ALLOWED')->count();
        if ($check_count==0)
        {
            $hide_date_array['allow_online_booking']='NO';
            EventScheduleList::where('id', $event_schedule_list_id)->update($hide_date_array);
        }
        else
        {
            $hide_date_array['allow_online_booking']='YES';
            EventScheduleList::where('id', $event_schedule_list_id)
            ->update($hide_date_array);
        }


        $data=array();
        $data['show']='updated';
        $data['status']='success';
        return json_encode($data);
    }
    
    public function fetch_bms_id_exist(Request $request)
    {
        $data=array();
        if(isset($request->bms_id))
        {
            $is_exist = Booking::where(['bms_id' => $request->bms_id, 'status' => 'ACTIVE'])->count();
            if($is_exist==0)
            {
                $data['is_exist']='NO';
                $data['message']='';
            }
            else
            {
                $data['is_exist']='YES';
                $data['message']='BookMyShow /  Insider ID Already Exist';
            }
        }
        else
        {
            $data['is_exist']='NO';
            $data['message']='';
        }
        return json_encode($data);
    }
}
