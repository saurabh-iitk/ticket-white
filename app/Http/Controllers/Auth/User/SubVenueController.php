<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\SubVenue;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubVenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_venues = SubVenue::all();
        
        return view('auth.user.sub_venue.index',compact('sub_venues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $venues = \App\Models\Venue::where('status','ACTIVE')->pluck('name','id');
        return view('auth.user.sub_venue.add',compact('venues'));
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
            'venue_id'=>'required',
            'name'=>'required',
        ]);

        $sub_venue = new SubVenue([
            'venue_id' => $request->venue_id,
            'name' => $request->name,
            'status' => $request->status,
        ]);
        $sub_venue->save();
        return redirect('/sub_venue')->with('success', 'SubVenue successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sub_venue = SubVenue::where('id', $id)->first();
        
        return view('auth.user.sub_venue.show',compact('sub_venue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venues = \App\Models\Venue::where('status','ACTIVE')->pluck('name','id');
        $sub_venue = SubVenue::where('id', $id)->first();
        
        return view('auth.user.sub_venue.edit',compact('sub_venue','venues'));
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
        $sub_venue = SubVenue::where('id', $id)->first();

        $request->validate([
            'venue_id'=>'required',
            'name'=>'required',
        ]);
        
        $sub_venue->venue_id = $request->venue_id;
        $sub_venue->name = $request->name;
        $sub_venue->status = $request->status;

        $sub_venue->save();

        return redirect('/sub_venue')->with('success', 'SubVenue successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubVenue::where('id', $id)->delete();
        
        return redirect('/sub_venue')->with('success', 'SubVenue successfully deleted!');
    }
}