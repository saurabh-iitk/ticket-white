<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\EventShowTime;
use App\Models\EventSchedule;
use App\Models\EventScheduleList;
use App\Models\EventTicketList;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\EventSeat;


class EventShowTimeScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $event_show_times = EventShowTime::all();
    //     $events = \App\Models\Event::where('status','ACTIVE')->get();
    //     $venues = \App\Models\Venue::where('status', 'ACTIVE')->get();
    //     $layouts = \App\Models\Layout::where('status', 'ACTIVE')->where('default_layout', 'YES')->get();
    //     $payment_methods = \App\Models\PaymentMethod::where('status', 'ACTIVE')->get();
    //     return view('auth.user.event_show_time_schedule.index',compact('events','event_show_times','venues', 'layouts'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $events = \App\Models\Event::where('status', 'ACTIVE')->get();
        $user_data = User::where('id', $user_id)->first();
        $venues = \App\Models\Venue::where('status', 'ACTIVE')->get();
        $layouts = \App\Models\Layout::where('status', 'ACTIVE')
            // ->where('default_layout', 'YES')
            ->get();
        $payment_methods = \App\Models\PaymentMethod::where('status', 'ACTIVE')->get();
        $event_show_times = EventShowTime::all();


        if ($request->get('es_id') !== null && $request->get('es_id') !== null && $request->get('venue_id') !== null && $request->get('layout_id') !== null) {
            $e_id = $request->get('e_id');
            $es_id = $request->get('es_id');
            $venue_id = $request->get('venue_id');
            $layout_id = $request->get('layout_id');



            //            $data['event_schedule_data']=EventScheduleList::where(['event_id' => $e_id, 'event_schedule_list_id' => $es_id,  'layout_id' => $layout_id])->get();


            // $user_with_organization = User::where('id', $user_id)
            //     ->leftJoin('organizations', 'users.organization_id', '=', 'organizations.id')
            //     ->select('users.id','organizations.name')->first();


            $data['event_schedule_data'] = EventScheduleList::where(['event_schedule_list.event_id' => $e_id, 'event_schedule_list.event_schedule_id' => $es_id])
                ->leftJoin('event_show_schedule', 'event_schedule_list.id', '=', 'event_show_schedule.event_schedule_list_id')
                ->get();


            $data['event_seats'] = EventSeat::where(['event_id' => $e_id, 'event_schedule_list_id' => $es_id,  'layout_id' => $layout_id])->get();
            $data['e_id'] = $e_id;
            $data['es_id'] = $es_id;
            $data['venue_id'] = $venue_id;
            $data['layout_id'] = $layout_id;

            return view('auth.user.event_show_time_schedule.show', compact('events', 'venues', 'layouts', 'payment_methods', 'user_data', 'event_show_times',), $data);
        } else {
            return view('auth.user.event_show_time_schedule.index', compact('events', 'venues', 'layouts', 'event_show_times'));
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
        $request->validate([
            'event_id' => 'required',
            'event_schedule_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'allow_online_booking' => 'required',
        ]);

        $event_show_time = new EventShowTime([
            'event_id' => $request->event_id,
            'event_schedule_id' => $request->event_schedule_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'allow_online_booking' => $request->allow_online_booking,

        ]);
        $event_show_time->save();
        return redirect('/event_show_time')->with('success', 'Event Show Time successfully added!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $events = \App\Models\Event::where('status', 'ACTIVE')->get();
        $event_show_time = EventShowTime::where('id', $id)->first();

        return view('auth.user.event_show_time.edit', compact('event_show_time', 'events'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_event_ticket_rates(Request $request)
    {
        $id = $request->id;
        $base_price = $request->base_price;


        $event_ticket_data = EventTicketList::where('id', $id)->first();

        $event_schedule_list_id = $event_ticket_data->event_schedule_list_id;
        $event_show_time_id = $event_ticket_data->event_show_time_id;
        $event_ticket_id = $event_ticket_data->event_ticket_id;
        $ticket_type_id = $event_ticket_data->ticket_type_id;


        $event_ticket_update = EventSeat::where([
            'event_schedule_list_id' => $event_schedule_list_id,
            'event_show_time_id' => $event_show_time_id,
            'event_ticket_id' => $event_ticket_id,
            'event_ticket_type_id' => $ticket_type_id
        ])->update(['base_price' => $base_price]);


        $ticket_update = EventTicketList::where(['id' => $id])->update(['base_price' => $base_price]);


        if ($ticket_update && $event_ticket_update) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EventShowTime::where('id', $id)->delete();

        return redirect('/event_show_time')->with('success', 'Event Show Time successfully deleted!');
    }
}
