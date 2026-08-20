<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
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
            $ticket_types = TicketType::where('event_id', $request->e_id)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $data['e_id'] = '';
            $ticket_types = TicketType::all();
        }
        return view('auth.user.ticket_type.index', compact('ticket_types', 'events'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = \App\Models\Event::where('status', 'ACTIVE')->get();
        return view('auth.user.ticket_type.add', compact('events'));
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
            'ticket_type_name' => 'required',
        ]);
        if ($request->show_hide_seat_no == '') {
            $request->show_hide_seat_no = 'SHOW';
        }
        $ticket_type = new TicketType([
            'event_id' => $request->event_id,
            'ticket_type_name' => $request->ticket_type_name,
            'color' => $request->color,
            'show_hide_seat_no' => $request->show_hide_seat_no,
        ]);
        $ticket_type->save();
        return redirect('/ticket_type')->with('success', 'Ticket Type successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket_type = TicketType::where('id', $id)->first();

        return view('auth.user.ticket_type.show', compact('ticket_type'));
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
        $ticket_type = TicketType::where('id', $id)->first();

        return view('auth.user.ticket_type.edit', compact('ticket_type', 'events'));
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
        $ticket_type = TicketType::where('id', $id)->first();

        $request->validate([
            'event_id' => 'required',
            'ticket_type_name' => 'required',
        ]);

        $ticket_type->event_id = $request->event_id;
        $ticket_type->ticket_type_name = $request->ticket_type_name;
        $ticket_type->color = $request->color;
        $ticket_type->status = $request->status;
        $ticket_type->show_hide_seat_no = $request->show_hide_seat_no;
        if ($ticket_type->show_hide_seat_no == '') {
            $ticket_type->show_hide_seat_no = 'SHOW';
        }
        $ticket_type->save();

        return redirect('/ticket_type')->with('success', 'Ticket Type successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TicketType::where('id', $id)->delete();

        return redirect('/ticket_type')->with('success', 'Ticket Type successfully deleted!');
    }
}
