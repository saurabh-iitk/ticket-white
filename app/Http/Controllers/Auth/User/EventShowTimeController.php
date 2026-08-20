<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Event;
use App\Models\EventShowTime;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventShowTimeController extends Controller
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
            $event_show_times = EventShowTime::where('event_id', $request->e_id)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $data['e_id'] = '';
            $event_show_times = EventShowTime::all();
        }
        return view('auth.user.event_show_time.index', compact('event_show_times', 'events'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = \App\Models\Event::where('status', 'ACTIVE')->get();
        return view('auth.user.event_show_time.add', compact('events'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event_show_time = EventShowTime::where('id', $id)->first();

        return view('auth.user.event_show_time.show', compact('event_show_time'));
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
    public function update(Request $request, $id)
    {
        $event_show_time = EventShowTime::where('id', $id)->first();

        $request->validate([
            'event_id' => 'required',
            'event_schedule_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'allow_online_booking' => 'required',
        ]);

        $event_show_time->event_id = $request->event_id;
        $event_show_time->event_schedule_id = $request->event_schedule_id;
        $event_show_time->start_time = $request->start_time;
        $event_show_time->end_time = $request->end_time;
        $event_show_time->status = $request->status;
        $event_show_time->allow_online_booking = $request->allow_online_booking;

        $event_show_time->save();

        return redirect('/event_show_time')->with('success', 'Event Show Time successfully updated!');
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
