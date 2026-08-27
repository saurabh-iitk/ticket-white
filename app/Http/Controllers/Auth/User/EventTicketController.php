<?php
namespace App\Http\Controllers\Auth\User;

use App\Models\EventTicket;
use App\Models\EventTicketList;
use App\Models\Cart;
use App\Models\Event;
use App\Models\Layout;
use App\Models\TicketType;
use App\Models\EventSeat;
use App\Models\EventShowSchedule;
use App\Models\EventScheduleList;
use App\Models\EventShowTime;
use App\Models\LayoutDetail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];

        $events = Event::where('status', 'ACTIVE')
            ->orderBy('id', 'DESC')
            ->get();

        if (isset($request->e_id) && $request->e_id != null) {
            $data['e_id'] = $request->e_id;
            $event_tickets = EventTicket::where('event_id', $request->e_id)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $data['e_id'] = '';
            $event_tickets = EventTicket::all();
        }
        return view('auth.user.event_ticket.index', compact('event_tickets', 'events'), $data);
    }

    public function create()
    {
        $events = Event::get()->sortByDesc('created_at');
        $ticket_types = TicketType::where('status', 'ACTIVE')->get();
        // $layouts = Layout::where('status','ACTIVE')->where('default_layout','YES')->get();
        $layouts = Layout::where('status', 'ACTIVE')->get();

        $event_schedule_lists = collect([]);
        $event_show_times = collect([]);
        $event_ticket = EventTicket::where('status', 'ACTIVE')
            ->latest('id')
            ->first();
        $event_ticket_temp = EventTicket::where('status', 'ACTIVE')->get();

        foreach ($event_ticket_temp as $event_ticket_single) {
            $list_id_temp[] = $event_ticket_single->event_schedule_list_id;
            $show_id_temp[] = $event_ticket_single->event_show_time_id;
        }

        if(isset($list_id_temp))
        {
            $list_id_temp = implode(',', $list_id_temp);
        }
        else
        {
              $list_id_temp = '';
        }

        if(isset($show_id_temp))
        {
            $show_id_temp = implode(',', $show_id_temp);
        }
        else
        {
            $show_id_temp ='';
        }

        if ($event_ticket) {
            $event_schedule_list_id_array = explode(',', $list_id_temp);
            $event_show_time_id_array = explode(',', $show_id_temp);

            $event_schedule_lists = EventScheduleList::whereIn('id', $event_schedule_list_id_array)->get();
            $event_show_times = EventShowTime::whereIn('id', $event_show_time_id_array)->get();

            foreach ($event_schedule_lists as $event_schedule_list) {
                $event_schedule_list->event_date = date('D jS F, Y', strtotime($event_schedule_list->event_date));
            }
        }

        return view('auth.user.event_ticket.add', compact('events', 'ticket_types', 'layouts', 'event_ticket', 'event_schedule_lists', 'event_show_times'));
    }

    public function store(Request $request)
    {
        $rules = [
            'event_id' => 'required',
            'event_schedule_id' => 'required',
            'layout_id' => 'required',
            'seating_plan' => 'required',
        ];

        if ($request->seating_plan == 'import') {
            $rules['schedule_list_id'] = ['required'];
            $rules['show_time_id'] = ['required'];
        }

        $request->validate($rules);

        //Begin Transaction
        DB::beginTransaction();
        try {
            $event_ticket = new EventTicket();
            $event_show_schedule = new EventShowSchedule();

            $event_ticket->event_id = $request->event_id;
            $event_ticket->event_schedule_id = $request->event_schedule_id;

            $event_ticket->event_schedule_list_id = null;
            if ($request->has('event_schedule_list_id')) {
                $event_ticket->event_schedule_list_id = implode(',', $request->event_schedule_list_id);
            }

            $event_ticket->event_show_time_id = null;
            if ($request->has('event_show_time_id')) {
                $event_ticket->event_show_time_id = implode(',', $request->event_show_time_id);
            }

           

            
            if ($request->has('event_schedule_list_id') && $request->has('event_show_time_id')) {
                foreach ($request->event_schedule_list_id as $event_schedule_list_id) {
                    foreach ($request->event_show_time_id as $event_show_time_id) {
                        if (!show_time_data_exist_in_db($event_schedule_list_id, $event_show_time_id, $request->event_id)) {
                            $start_time = show_time_in_db($event_show_time_id, $request->event_id)->start_time ?? null;
                            $end_time = show_time_in_db($event_show_time_id, $request->event_id)->end_time ?? null;

                            $event_show_schedule = [
                                'event_schedule_list_id' => $event_schedule_list_id,
                                'event_show_time_id' => $event_show_time_id,
                                'event_id' => $request->event_id,
                                'start_time' => $start_time,
                                'end_time' => $end_time
                            ];
                            EventShowSchedule::create($event_show_schedule);
                        }
                    }
                }
            }

            $event_ticket->layout_id = $request->layout_id;

            if($request->seating_plan =='import')
            {
               $et_data=EventTicket::where(['event_id' => $request->event_id, 'event_schedule_list_id' => $request->schedule_list_id, 'event_show_time_id' => $request->show_time_id])->first();

                $skip_label=$et_data->skip_label;
                $event_ticket->skip_label = $skip_label;
            }
            else
            {
                $skip_label=getLayout($request->layout_id)->layout_skip_label;
                $event_ticket->skip_label = $skip_label;
            }


            if ($event_ticket->save()) {
                $event_ticket_list_array = [];
                if ($request->seating_plan == 'import') {
                    $event_ticket_lists = EventTicketList::where(['event_schedule_list_id' => $request->schedule_list_id, 'event_show_time_id' => $request->show_time_id])->get();
                    for ($i = 0; $i < count($request->event_schedule_list_id); $i++) {
                        for ($j = 0; $j < count($request->event_show_time_id); $j++) {
                            foreach ($event_ticket_lists as $index_key => $event_ticket_list) {
                                $event_ticket_list_array[] = [
                                    'event_id' => $request->event_id,
                                    'event_schedule_list_id' => $request->event_schedule_list_id[$i],
                                    'event_show_time_id' => $request->event_show_time_id[$j],
                                    'event_ticket_id' => $event_ticket->id,
                                    'ticket_type_id' => $event_ticket_list->ticket_type_id,
                                    'total_ticket' => $event_ticket_list->total_ticket,
                                    'base_price' => $event_ticket_list->base_price,
                                    'total_discount' => $event_ticket_list->total_discount,
                                    'discounted_amount' => $event_ticket_list->discounted_amount,
                                    'final_price' => $event_ticket_list->final_price
                                ];
                            }
                        }
                    }
                } else {
                    for ($i = 0; $i < count($request->event_schedule_list_id); $i++) {
                        for ($j = 0; $j < count($request->event_show_time_id); $j++) {
                            $ticket_type_ids = $request->ticket_type_id;
                            foreach (range(1, sizeOf($ticket_type_ids)) as $index) {
                                $index_key = $index - 1;
                                if (!empty($ticket_type_ids[$index_key])) {
                                    $event_ticket_list_array[] = [
                                        'event_id' => $request->event_id,
                                        'event_schedule_list_id' => $request->event_schedule_list_id[$i],
                                        'event_show_time_id' => $request->event_show_time_id[$j],
                                        'event_ticket_id' => $event_ticket->id,
                                        'ticket_type_id' => $ticket_type_ids[$index_key],
                                        'total_ticket' => $request->total_ticket[$index_key],
                                        'base_price' => $request->base_price[$index_key],
                                        'total_discount' => $request->total_discount[$index_key],
                                        'discounted_amount' => $request->discounted_amount[$index_key],
                                        'final_price' => $request->final_price[$index_key]
                                    ];
                                }
                            }
                        }
                    }
                }

                if (!empty($event_ticket_list_array)) {
                    EventTicketList::insert($event_ticket_list_array);
                }

                if ($request->has('layout_id')) {
                    $event_seat_array = [];
                    if ($request->seating_plan == 'import') {
                        $event_seats = EventSeat::where(['event_schedule_list_id' => $request->schedule_list_id, 'event_show_time_id' => $request->show_time_id])->get();
                        for ($i = 0; $i < count($request->event_schedule_list_id); $i++) {
                            for ($j = 0; $j < count($request->event_show_time_id); $j++) {
                                foreach ($event_seats as $key => $event_seat) {
                                    $event_seat_array[] = [
                                        'event_id' => $request->event_id,
                                        'event_schedule_list_id' => $request->event_schedule_list_id[$i],
                                        'event_show_time_id' => $request->event_show_time_id[$j],
                                        'event_ticket_id' => $event_ticket->id,
                                        'event_ticket_type_id' => $event_seat->event_ticket_type_id,
                                        'total_ticket' => $event_seat->total_ticket,
                                        'base_price' => $event_seat->base_price,
                                        'total_discount' => $event_seat->total_discount,
                                        'layout_id' => $event_seat->layout_id,
                                        'row_no' => $event_seat->row_no,
                                        'col_no' => $event_seat->col_no,
                                        'name' => $event_seat->name,
                                        'label' => $event_seat->label,
                                        'seatno' => $event_seat->seatno,
                                        'is_reserved' => $event_seat->is_reserved,
                                        'is_damaged' => $event_seat->is_damaged,
                                        'is_visible' => $event_seat->is_visible,
                                        'is_removed' => $event_seat->is_removed,
                                        'is_labeled' => $event_seat->is_labeled,
                                        'is_grouping_allowed' => $event_seat->is_grouping_allowed,
                                        'is_complimentary' => $event_seat->is_complimentary,
                                        'is_vendor_book_allowed' => $event_seat->is_vendor_book_allowed,
                                        'is_discount_allowed' => $event_seat->is_discount_allowed,
                                        'is_online_book_allowed' => $event_seat->is_online_book_allowed,
                                        'created_at' => date('Y-m-d H:i:s'),
                                    ];
                                }
                            }
                        }
                    } else {
                        $layout_details = LayoutDetail::where('layout_id', $request->layout_id)->get();
                        for ($i = 0; $i < count($request->event_schedule_list_id); $i++) {
                            for ($j = 0; $j < count($request->event_show_time_id); $j++) {
                                foreach ($layout_details as $key => $layout_detail) {
                                    $event_seat_array[] = [
                                        'event_id' => $request->event_id,
                                        'event_schedule_list_id' => $request->event_schedule_list_id[$i],
                                        'event_show_time_id' => $request->event_show_time_id[$j],
                                        'event_ticket_id' => $event_ticket->id,
                                        'layout_id' => $layout_detail->layout_id,
                                        'row_no' => $layout_detail->row_no,
                                        'col_no' => $layout_detail->col_no,
                                        'name' => $layout_detail->name,
                                        'label' => $layout_detail->label,
                                        'seatno' => $layout_detail->seatno,
                                        'is_damaged' => $layout_detail->is_damaged,
                                        'is_reserved' => $layout_detail->is_reserved,
                                        'is_visible' => $layout_detail->is_visible,
                                        'is_removed' => $layout_detail->is_removed,
                                        'is_labeled' => $layout_detail->is_labeled,
                                        'created_at' => date('Y-m-d H:i:s'),
                                    ];
                                }
                            }
                        }
                    }
                    if (!empty($event_seat_array)) {
                        $event_seats = array_chunk($event_seat_array, 1000, true);
                        foreach ($event_seats as $key => $event_seat) {
                            $insert_id = EventSeat::insert($event_seat);
                        }
                    }
                }

                DB::commit();
                return redirect('/event_ticket')->with('success', 'Event Ticket successfully added!');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/event_ticket')->with('error', 'Some problems occurred, please try again!');
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
        $event_ticket = EventTicket::where('id', $id)->first();

        return view('auth.user.event_ticket.show', compact('event_ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $events = Event::where('status', 'ACTIVE')->get();
        $ticket_types = TicketType::where('status', 'ACTIVE')->get();
        $layouts = Layout::where('status', 'ACTIVE')
            ->where('default_layout', 'YES')
            ->get();
        $event_ticket = EventTicket::where('id', $id)->first();

        return view('auth.user.event_ticket.edit', compact('event_ticket', 'events', 'ticket_types', 'layouts'));
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
        $event_ticket = EventTicket::where('id', $id)->first();

        $request->validate([
            'event_id' => 'required',
            'event_schedule_id' => 'required',
            'layout_id' => 'required',
        ]);

        //Begin Transaction
        DB::beginTransaction();
        try {
            $event_ticket->event_id = $request->event_id;
            $event_ticket->event_schedule_id = $request->event_schedule_id;

            $event_ticket->event_schedule_list_id = null;
            if ($request->has('event_schedule_list_id')) {
                $event_ticket->event_schedule_list_id = implode(',', $request->event_schedule_list_id);
            }

            $event_ticket->event_show_time_id = null;
            if ($request->has('event_show_time_id')) {
                $event_ticket->event_show_time_id = implode(',', $request->event_show_time_id);
            }

            $event_ticket->layout_id = $request->layout_id;
            $event_ticket->status = $request->status;

            if ($event_ticket->save()) {
                $event_ticket_list_array = [];
                for ($i = 0; $i < count($request->event_schedule_list_id); $i++) {
                    for ($j = 0; $j < count($request->event_show_time_id); $j++) {
                        $ticket_type_ids = $request->ticket_type_id;
                        foreach (range(1, sizeOf($ticket_type_ids)) as $index) {
                            $index_key = $index - 1;
                            if (!empty($ticket_type_ids[$index_key])) {
                                if ($index_key == 0) {
                                    //Delete previous record  in  permissions table
                                    EventTicketList::where('event_ticket_id', $id)->delete();
                                }
                                $event_ticket_list_array[] = [
                                    'event_id' => $request->event_id,
                                    'event_schedule_list_id' => $request->event_schedule_list_id[$i],
                                    'event_show_time_id' => $request->event_show_time_id[$j],
                                    'event_ticket_id' => $event_ticket->id,
                                    'ticket_type_id' => $ticket_type_ids[$index_key],
                                    'total_ticket' => $request->total_ticket[$index_key],
                                    'base_price' => $request->base_price[$index_key],
                                    'total_discount' => $request->total_discount[$index_key],
                                    'discounted_amount' => $request->discounted_amount[$index_key],
                                    'final_price' => $request->final_price[$index_key],
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];
                            }
                        }
                    }
                }
                if (!empty($event_ticket_list_array)) {
                    EventTicketList::insert($event_ticket_list_array);
                }

                if ($request->has('layout_id')) {
                    $event_seat_array = [];
                    for ($i = 0; $i < count($request->event_schedule_list_id); $i++) {
                        for ($j = 0; $j < count($request->event_show_time_id); $j++) {
                            $layout_details = LayoutDetail::where('layout_id', $request->layout_id)->get();
                            foreach ($layout_details as $key => $layout_detail) {
                                $event_seat_array[] = [
                                    'event_id' => $request->event_id,
                                    'event_schedule_list_id' => $request->event_schedule_list_id[$i],
                                    'event_show_time_id' => $request->event_show_time_id[$j],
                                    'event_ticket_id' => $event_ticket->id,
                                    'layout_id' => $layout_detail->layout_id,
                                    'row_no' => $layout_detail->row_no,
                                    'col_no' => $layout_detail->col_no,
                                    'name' => $layout_detail->name,
                                    'seatno' => $layout_detail->seatno,
                                    'is_reserved' => $layout_detail->is_reserved,
                                    'is_visible' => $layout_detail->is_visible,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ];
                            }
                        }
                    }
                    if (!empty($event_seat_array)) {
                        $event_seats = array_chunk($event_seat_array, 1000, true);
                        foreach ($event_seats as $key => $event_seat) {
                            EventSeat::insert($event_seat);
                        }
                    }
                }

                DB::commit();
                return redirect('/event_ticket')->with('success', 'Event Ticket successfully updated!');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Some problems occurred, please try again!');
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
        $event_tickets = EventTicket::find($id);
        if ($event_tickets) {
            
            $event_show_time_id =  $event_tickets->event_show_time_id;
            $event_id =  $event_tickets->event_id;
            $event_schedule_list_id =  $event_tickets->event_schedule_list_id;
            $layout_id =  $event_tickets->layout_id;
            $event_tickets->delete();
            EventTicketList::where('event_ticket_id', $id)->delete();
            EventShowSchedule::where('event_id', $event_id)->where('event_schedule_list_id', $event_schedule_list_id)->where('event_show_time_id', $event_show_time_id)->delete();
            EventSeat::where(['event_ticket_id' => $id, 'layout_id' => $layout_id])->delete();
            return redirect('/event_ticket')->with('success', 'Event Ticket successfully deleted!');
        } else {
            return redirect('/event_ticket')->with('error', 'Some problems occurred, please try again!');
        }
    }

    public function delete_event_ticket_lists($id)
    {
        $event_ticket = EventTicket::find($id);
        if ($event_ticket) {
            EventTicketList::where('event_ticket_id', $id)->delete();
            EventSeat::where(['event_ticket_id' => $id, 'layout_id' => $event_ticket->layout_id])->delete();
            return back()->with('success', 'Event Ticket List successfully deleted!');
        } else {
            return back()->with('error', 'Some problems occurred, please try again!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function layout_mapping(Request $request, $id)
    {
        $event_ticket = EventTicket::where('id', $id)->first();
        $layout_id = $event_ticket->layout_id;

        $layout = Layout::where('status', 'ACTIVE')
            ->where('id', $layout_id)
            ->get();
        if ($request->get('esd_id') !== null && $request->get('est_id') !== null) {
            $es_id = $request->get('es_id');
            $esd_id = $request->get('esd_id');
            $est_id = $request->get('est_id');
            $event_ticket_lists = EventTicketList::where(['event_ticket_id' => $event_ticket->id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id])->get();
            return view('auth.user.event_ticket.show_layout_mapping', compact('event_ticket', 'es_id', 'esd_id', 'est_id', 'event_ticket_lists', 'layout'));
        } else {
            return view('auth.user.event_ticket.search_layout_mapping', compact('event_ticket', 'layout'));
        }
    }

    public function layout_mapping_canvas(Request $request, $id)
    {
        $event_ticket = EventTicket::where('id', $id)->first();
        $layout_id = $event_ticket->layout_id;

        $layout = Layout::where('status', 'ACTIVE')
            ->where('id', $layout_id)
            ->get();
        
        $layout_objects = config('layout_objects.objects', []);

        if ($request->get('esd_id') !== null && $request->get('est_id') !== null) {
            $es_id = $request->get('es_id');
            $esd_id = $request->get('esd_id');
            $est_id = $request->get('est_id');
            $event_ticket_lists = EventTicketList::where(['event_ticket_id' => $event_ticket->id, 'event_schedule_list_id' => $esd_id, 'event_show_time_id' => $est_id])->get();
            return view('auth.user.event_ticket.show_layout_mapping_canvas', compact('event_ticket', 'es_id', 'esd_id', 'est_id', 'event_ticket_lists', 'layout', 'layout_objects'));
        } else {
            return view('auth.user.event_ticket.search_layout_mapping_canvas', compact('event_ticket', 'layout'));
        }
    }

    public function save_layout_designer(Request $request)
    {
        $layout_id = $request->input('layout_id');
        $markers = $request->input('markers');
        $seat_updates = $request->input('seat_updates');

        // 1. Save Markers
        $layout = Layout::where('id', $layout_id)->first();
        if ($layout) {
            $layout->markers = is_array($markers) ? json_encode($markers) : $markers;
            $layout->save();
        } else {
            return response()->json(['status' => 'error', 'message' => 'Layout not found.'], 404);
        }

        // 2. Batch Update Seats
        if (is_array($seat_updates) && count($seat_updates) > 0) {
            $event_ticket_id = $request->input('event_ticket_id');
            $esd_id = $request->input('event_schedule_list_id');
            $est_id = $request->input('event_show_time_id');

            // Pre-load ticket lists
            $ticket_lists = EventTicketList::where([
                'event_ticket_id' => $event_ticket_id,
                'event_schedule_list_id' => $esd_id,
                'event_show_time_id' => $est_id
            ])->get()->keyBy('ticket_type_id');

            foreach ($seat_updates as $update) {
                $seat_id = $update['id'];
                $update_type = $update['type']; // 'status' or 'class'
                $value = $update['value'];

                $seat = EventSeat::where('id', $seat_id)->first();
                if ($seat) {
                    if ($update_type === 'clear_status') {
                        $seat->is_visible = 'YES';
                        $seat->is_damaged = 'NO';
                        $seat->is_reserved = 'NO';
                        $seat->event_ticket_type_id = null;
                        $seat->total_ticket = 0;
                        $seat->base_price = 0;
                        $seat->total_discount = 0;
                        $seat->save();
                    } elseif ($update_type === 'status') {
                        if ($value === 'show') {
                            $seat->is_visible = 'YES';
                        } elseif ($value === 'hide') {
                            $seat->is_visible = 'NO';
                        } elseif ($value === 'damaged') {
                            $seat->is_damaged = 'YES';
                        } elseif ($value === 'undamaged') {
                            $seat->is_damaged = 'NO';
                        } elseif ($value === 'reserve') {
                            $seat->is_reserved = 'YES';
                        } elseif ($value === 'unreserve') {
                            $seat->is_reserved = 'NO';
                        }
                        $seat->save();
                    } elseif ($update_type === 'class') {
                        $ticket_type_id = intval($value);
                        
                        if ($ticket_type_id > 0) {
                            $ticket_list = $ticket_lists->get($ticket_type_id);
                            if ($ticket_list) {
                                $seat->event_ticket_type_id = $ticket_type_id;
                                $seat->total_ticket = $ticket_list->total_ticket;
                                $seat->base_price = $ticket_list->base_price;
                                $seat->total_discount = $ticket_list->total_discount;
                            } else {
                                $seat->event_ticket_type_id = $ticket_type_id;
                                $seat->total_ticket = 0;
                                $seat->base_price = 0;
                                $seat->total_discount = 0;
                            }
                        } else {
                            // Reset ticket type (Available Seat)
                            $seat->event_ticket_type_id = null;
                            $seat->total_ticket = 0;
                            $seat->base_price = 0;
                            $seat->total_discount = 0;
                        }
                        $seat->save();
                    }
                }
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Layout and seating updates saved successfully.']);
    }

    public function update_event_seat(Request $request)
    {
        if (isset($request->action) && $request->action == 'hide') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_visible' => 'YES']);
            }
        }
        if (isset($request->action) && $request->action == 'show') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_visible' => 'NO']);
            }
        }

        if (isset($request->action) && $request->action == 'reserve') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_reserved' => 'YES']);
            }
        }
        if (isset($request->action) && $request->action == 'unreserve') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_reserved' => 'NO']);
            }
        }

        if (isset($request->action) && $request->action == 'damage') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_damaged' => 'YES']);
            }
        }
        if (isset($request->action) && $request->action == 'undamage') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_damaged' => 'NO']);
            }
        }

        if (isset($request->event_ticket_type_id) && $request->event_ticket_type_id != 0) {
            if (isset($request->ids)) {
                $ids = $request->ids;
                $event_schedule_list_id = $request->event_schedule_list_id;
                $event_show_time_id = $request->event_show_time_id;
                $event_ticket_id = $request->event_ticket_id;
                $event_ticket_type_id = $request->event_ticket_type_id;

                $event_ticket_list = EventTicketList::where(['event_schedule_list_id' => $event_schedule_list_id, 'event_show_time_id' => $event_show_time_id, 'event_ticket_id' => $event_ticket_id, 'ticket_type_id' => $event_ticket_type_id])->first();
                if (!empty($event_ticket_list)) {
                    $total_ticket = $event_ticket_list->total_ticket;
                    $base_price = $event_ticket_list->base_price;
                    $total_discount = $event_ticket_list->total_discount;
                } else {
                    $total_ticket = 0;
                    $base_price = 0;
                    $total_discount = 0;
                }

                $seat_data = [
                    'event_ticket_type_id' => $event_ticket_type_id,
                    'total_ticket' => $total_ticket,
                    'base_price' => $base_price,
                    'total_discount' => $total_discount,
                ];
                EventSeat::whereIn('id', $ids)->update($seat_data);
            }
        }
    }

    public function update_event_seat_from_booking(Request $request)
    {
        if (isset($request->action) && $request->action == 'hide') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_visible' => 'YES']);
            }
        }
        if (isset($request->action) && $request->action == 'show') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_visible' => 'NO']);
            }
        }

        if (isset($request->action) && $request->action == 'reserve') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_reserved' => 'YES']);
            }
        }
        if (isset($request->action) && $request->action == 'unreserve') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_reserved' => 'NO']);
            }
        }

        if (isset($request->action) && $request->action == 'reserve_customer') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_reserved_for_customer' => 'YES']);
            }
        }
        if (isset($request->action) && $request->action == 'unreserve_customer') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_reserved_for_customer' => 'NO']);
            }
        }


        if (isset($request->action) && $request->action == 'damage') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_damaged' => 'YES']);
            }
        }
        if (isset($request->action) && $request->action == 'undamage') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_damaged' => 'NO']);
            }
        }
        
        
        if (isset($request->action) && $request->action == 'removed') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_removed' => 'YES']);
            }
        }
        if (isset($request->action) && $request->action == 'unremoved') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_removed' => 'NO']);
            }
        }

        if (isset($request->action) && $request->action == 'labeled') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_labeled' => 'YES']);
            }
        }
        if (isset($request->action) && $request->action == 'unlabeled') {
            if (isset($request->ids)) {
                $ids = $request->ids;
                EventSeat::whereIn('id', $ids)->update(['is_labeled' => 'NO']);
            }
        }
        
        

        if (isset($request->event_ticket_type_id) && $request->event_ticket_type_id!=0)
        {
            if (isset($request->ids)) {
                $ids = $request->ids;
                $event_schedule_list_id = $request->event_schedule_list_id;
                $event_show_time_id = $request->event_show_time_id;
                $event_ticket_id = $request->event_ticket_id;
                $event_ticket_type_id = $request->event_ticket_type_id;

                $event_ticket_list = EventTicketList::where([
                    'event_schedule_list_id' => $event_schedule_list_id,
                    'event_show_time_id' => $event_show_time_id,
                    'ticket_type_id' => $event_ticket_type_id,
                ])->first();

                if (!empty($event_ticket_list)) {
                    $total_ticket = $event_ticket_list->total_ticket;
                    $base_price = $event_ticket_list->base_price;
                    $total_discount = $event_ticket_list->total_discount;
                } else {
                    $total_ticket = 0;
                    $base_price = 0;
                    $total_discount = 0;
                }

                $seat_data = [
                    'event_ticket_type_id' => $event_ticket_type_id,
                    'total_ticket' => $total_ticket,
                    'base_price' => $base_price,
                    'total_discount' => $total_discount,
                ];
                EventSeat::whereIn('id', $ids)->update($seat_data);
                Cart::whereIn('seat_id', $ids)->delete();
            }
        }
        $uid = \Auth::user()->id;
        Cart::where('user_id', $uid)->delete();
    }
    
    public function check_for_duplicate_mapping(Request $request)
    {
        $data = [];
        $event_id  = $request->event_id;
        $event_schedule_list_id  = $request->event_schedule_list_id;
        $event_show_time_id  = $request->event_show_time_id ;
        $count = EventShowSchedule::where([
            'event_id' => $event_id,
            'event_schedule_list_id' => $event_schedule_list_id,
            'event_show_time_id' => $event_show_time_id
            ])->count();
        
        $data['count'] = $count;
        return json_encode($data);
    }
}
