<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Venue;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $venues = Venue::all();
        
        return view('auth.user.venue.index',compact('venues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = \App\Models\State::where('status','ACTIVE')->get();
        return view('auth.user.venue.add',compact('states'));
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
            'state_id'=>'required',
            'city_id'=>'required',
            'pincode_id'=>'required',
            'name'=>'required',
            'contact_person_name'=>'required',
            'contact_no'=>'required|numeric',
        ]);

        $venue = new Venue([
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'pincode_id' => $request->pincode_id,
            'name' => $request->name,
            'address' => $request->address,
            'map' => $request->map,
            'capacity' => $request->capacity,
            'contact_person_name' => $request->contact_person_name,
            'contact_no' => $request->contact_no,
            'parking' => $request->parking,
            'type' => $request->type,
        ]);
        $venue->save();
        return redirect('/venue')->with('success', 'Venue successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venue = Venue::where('id', $id)->first();
        
        return view('auth.user.venue.show',compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $states = \App\Models\State::where('status','ACTIVE')->get();
        $venue = Venue::where('id', $id)->first();
        
        return view('auth.user.venue.edit',compact('venue','states'));
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
        $venue = Venue::where('id', $id)->first();

        $request->validate([
            'state_id'=>'required',
            'city_id'=>'required',
            'pincode_id'=>'required',
            'name'=>'required',
            'contact_person_name'=>'required',
            'contact_no'=>'required|numeric',
        ]);
        
        $venue->state_id = $request->state_id;
        $venue->city_id = $request->city_id;
        $venue->pincode_id = $request->pincode_id;
        $venue->name = $request->name;
        $venue->address = $request->address;
        $venue->map = $request->map;
        $venue->capacity = $request->capacity;
        $venue->contact_person_name = $request->contact_person_name;
        $venue->contact_no = $request->contact_no;
        $venue->parking = $request->parking;
        $venue->type = $request->type;
        $venue->status = $request->status;

        $venue->save();

        return redirect('/venue')->with('success', 'Venue successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Venue::where('id', $id)->delete();
        
        return redirect('/venue')->with('success', 'Venue successfully deleted!');
    }
}