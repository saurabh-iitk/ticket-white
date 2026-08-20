<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Pincode;
use App\Models\State;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pincodes = Pincode::all();
        
        return view('auth.user.pincode.index',compact('pincodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::where('status','ACTIVE')->get();
        return view('auth.user.pincode.add',compact('states'));
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
            'pincode'=>'required',
        ]);

        Pincode::create([
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode
        ]);

        return redirect('/pincode')->with('success', 'Pincode successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pincode = Pincode::where('id', $id)->first();
        
        return view('auth.user.pincode.show',compact('pincode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $states = State::where('status','ACTIVE')->get();
        $pincode = Pincode::where('id', $id)->first();
        
        return view('auth.user.pincode.edit',compact('pincode','states'));
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
        $pincode = Pincode::where('id', $id)->first();

        $request->validate([
            'state_id'=>'required',
            'city_id'=>'required',
            'pincode'=>'required',
        ]);
        
        $pincode->state_id = $request->state_id;
        $pincode->city_id = $request->city_id;
        $pincode->pincode = $request->pincode;
        $pincode->status = $request->status;

        $pincode->save();

        return redirect('/pincode')->with('success', 'Pincode successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pincode::where('id', $id)->delete();
        
        return redirect('/pincode')->with('success', 'Pincode successfully deleted!');
    }
}