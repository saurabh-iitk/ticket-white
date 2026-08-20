<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\BookingPlatform;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingPlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking_platforms = BookingPlatform::all();
        
        return view('auth.user.booking_platform.index',compact('booking_platforms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.user.booking_platform.add');
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
            'name'=>'required'
        ]);

        BookingPlatform::create([
            'name' => $request->name
        ]);

        return redirect('/booking_platform')->with('success', 'Booking Platform successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking_platform = BookingPlatform::where('id', $id)->first();
        
        return view('auth.user.booking_platform.show',compact('booking_platform'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking_platform = BookingPlatform::where('id', $id)->first();
        
        return view('auth.user.booking_platform.edit',compact('booking_platform'));
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
        $booking_platform = BookingPlatform::where('id', $id)->first();

        $request->validate([
            'name'=>'required'
        ]);
        
        $booking_platform->name = $request->name;
        $booking_platform->status = $request->status;

        $booking_platform->save();

        return redirect('/booking_platform')->with('success', 'Booking Platform successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BookingPlatform::where('id', $id)->delete();
        
        return redirect('/booking_platform')->with('success', 'Booking Platform successfully deleted!');
    }
}