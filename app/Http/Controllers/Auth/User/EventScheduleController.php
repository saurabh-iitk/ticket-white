<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\EventScheduleList;
use App\Models\EventShowSchedule;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
       
        $events = Event::where('status','ACTIVE')->orderBy('id', 'DESC')->get();


        if(isset($request->id) && $request->id!=null)
        {
            $data['e_id'] = $request->id;
            $event_schedules = EventSchedule::where('event_id', $request->id)->orderBy('id', 'DESC')->get();
        }
        else
        {
            $data['e_id'] = '';
            $event_schedules = EventSchedule::all();
        }

        return view('auth.user.event_schedule.index', compact('event_schedules', 'events'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = \App\Models\Event::where('status', 'ACTIVE')->get();
        return view('auth.user.event_schedule.add', compact('events'));
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
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $event_id = $request->event_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $dates = getDatesFromRange($start_date, $end_date);

        $event_schedule = new EventSchedule([
            'event_id' => $event_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
        $event_schedule->save();

        if ($event_schedule->id) {
            if (!empty($dates)) {
                foreach ($dates as $key => $date) {
                    $event_schedule_list_array = [
                        'event_id' => $event_id,
                        'event_schedule_id' => $event_schedule->id,
                        'event_date' => $date,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    EventScheduleList::insert($event_schedule_list_array);
                }
            }
            return redirect('/event_schedule')->with('success', 'Event Schedule successfully added!');
        } else {
            return redirect('/event_schedule')->with('error', 'Some problems occurred, please try again!');
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
        $event_schedule = EventSchedule::where('id', $id)->first();
        $event_schedule_lists = EventScheduleList::where('event_schedule_id', $id)->get();

        return view('auth.user.event_schedule.show', compact('event_schedule', 'event_schedule_lists'));
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
        $event_schedule = EventSchedule::where('id', $id)->first();

        return view('auth.user.event_schedule.edit', compact('event_schedule', 'events'));
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
        $event_schedule = EventSchedule::where('id', $id)->first();
    
        $request->validate([
            'event_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
    
        $event_id = $request->event_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $dates = getDatesFromRange($start_date, $end_date);
    
        $event_schedule->event_id = $event_id;
        $event_schedule->start_date = $start_date;
        $event_schedule->end_date = $end_date;
        $event_schedule->status = $request->status;
        $event_schedule->save();
    
        if ($event_schedule->id) {
            // Fetch existing dates
            $existing_dates = EventScheduleList::where('event_schedule_id', $id)->pluck('event_date')->toArray();
    
            foreach ($dates as $date) {
                // Only insert if the date doesn't already exist
                if (!in_array($date, $existing_dates)) {
                    EventScheduleList::create([
                        'event_id' => $event_id,
                        'event_schedule_id' => $event_schedule->id,
                        'event_date' => $date,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
    
            return redirect('/event_schedule')->with('success', 'Event Schedule successfully updated!');
        } else {
            return redirect('/event_schedule')->with('error', 'Some problems occurred, please try again!');
        }
    }


    // public function update(Request $request, $id)
    // {
    //     $event_schedule = EventSchedule::where('id', $id)->first();

    //     $request->validate([
    //         'event_id' => 'required',
    //         'start_date' => 'required',
    //         'end_date' => 'required',
    //     ]);

    //     $event_id = $request->event_id;
    //     $start_date = $request->start_date;
    //     $end_date = $request->end_date;
    //     $dates = getDatesFromRange($start_date, $end_date);

    //     $event_schedule->event_id = $event_id;
    //     $event_schedule->start_date = $start_date;
    //     $event_schedule->end_date = $end_date;
    //     $event_schedule->status = $request->status;

    //     $event_schedule->save();
    //     if ($event_schedule->id) {
    //         $event_schedule_lists = EventScheduleList::where('event_schedule_id', $id)->get();
    //         if (count($dates) == count($event_schedule_lists)) {
    //             if (!empty($dates)) {
    //                 $event_schedule_list_array = [];
    //                 foreach ($dates as $key2 => $date) {
    //                     $event_schedule_list_array[$key2] = [
    //                         'event_id' => $event_id,
    //                         'event_schedule_id' => $event_schedule->id,
    //                         'event_date' => $date,
    //                         'updated_at' => date('Y-m-d H:i:s'),
    //                     ];
    //                 }

    //                 foreach ($event_schedule_lists as $key3 => $event_schedule_list) {
    //                     EventScheduleList::where('id', $event_schedule_list->id)->update($event_schedule_list_array[$key3]);
    //                 }
    //             }
    //         } else {
    //             if (!empty($dates)) {
    //                 EventScheduleList::where('event_schedule_id', $id)->delete();

    //                 foreach ($dates as $key => $date) {
    //                     $event_schedule_list_array = [
    //                         'event_id' => $event_id,
    //                         'event_schedule_id' => $event_schedule->id,
    //                         'event_date' => $date,
    //                         'created_at' => date('Y-m-d H:i:s'),
    //                         'updated_at' => date('Y-m-d H:i:s'),
    //                     ];
    //                     EventScheduleList::insert($event_schedule_list_array);
    //                 }
    //             }
    //         }
    //         return redirect('/event_schedule')->with('success', 'Event Schedule successfully updated!');
    //     } else {
    //         return redirect('/event_schedule')->with('error', 'Some problems occurred, please try again!');
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EventSchedule::where('id', $id)->delete();
        EventScheduleList::where('event_schedule_id', $id)->delete();

        return redirect('/event_schedule')->with('success', 'Event Schedule successfully deleted!');
    }
}