<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Organizer;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizers = Organizer::all();
        
        return view('auth.user.organizer.index',compact('organizers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.user.organizer.add');
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
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'contact_person'=>'required',
        ]);

        $organizer = new Organizer([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'contact_person' => $request->contact_person,
            'website' => $request->website,
            'address' => $request->address,
        ]);
        $organizer->save();
        return redirect('/organizer')->with('success', 'Organizer successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organizer = Organizer::where('id', $id)->first();
        
        return view('auth.user.organizer.show',compact('organizer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organizer = Organizer::where('id', $id)->first();
        
        return view('auth.user.organizer.edit',compact('organizer'));
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
        $organizer = Organizer::where('id', $id)->first();

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'contact_person'=>'required',
        ]);
        
        $organizer->name = $request->name;
        $organizer->email = $request->email;
        $organizer->phone = $request->phone;
        $organizer->contact_person = $request->contact_person;
        $organizer->website = $request->website;
        $organizer->address = $request->address;
        $organizer->status = $request->status;

        $organizer->save();

        return redirect('/organizer')->with('success', 'Organizer successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Organizer::where('id', $id)->delete();
        
        return redirect('/organizer')->with('success', 'Organizer successfully deleted!');
    }
}