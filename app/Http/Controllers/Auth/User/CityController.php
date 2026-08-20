<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        
        return view('auth.user.city.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::where('status','ACTIVE')->pluck('name','id');
        return view('auth.user.city.add',compact('states'));
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
            'name'=>'required'
        ]);

        City::create([
            'state_id' => $request->state_id,
            'name' => $request->name
        ]);

        return redirect('/city')->with('success', 'City successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::where('id', $id)->first();
        
        return view('auth.user.city.show',compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $states = State::where('status','ACTIVE')->pluck('name','id');
        $city = City::where('id', $id)->first();
        
        return view('auth.user.city.edit',compact('city','states'));
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
        $city = City::where('id', $id)->first();

        $request->validate([
            'state_id'=>'required',
            'name'=>'required'
        ]);
        
        $city->state_id = $request->state_id;
        $city->name = $request->name;
        $city->status = $request->status;

        $city->save();

        return redirect('/city')->with('success', 'City successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        City::where('id', $id)->delete();
        
        return redirect('/city')->with('success', 'City successfully deleted!');
    }
}