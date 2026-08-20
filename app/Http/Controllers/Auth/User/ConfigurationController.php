<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Configuration;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configurations = Configuration::all();
        
        return view('auth.user.configuration.index',compact('configurations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.user.configuration.add');
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
            'email'=>'required|email'
        ]);

        Configuration::create([
            'email' => $request->email
        ]);

        return redirect('/configuration')->with('success', 'Configuration successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $configuration = Configuration::where('id', $id)->first();
        
        return view('auth.user.configuration.show',compact('configuration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $configuration = Configuration::where('id', $id)->first();
        
        return view('auth.user.configuration.edit',compact('configuration'));
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
        $configuration = Configuration::where('id', $id)->first();
        
        $configuration->email = $request->email;
        $configuration->status = $request->status;

        $configuration->save();

        return redirect('/configuration')->with('success', 'Configuration successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Configuration::where('id', $id)->delete();
        
        return redirect('/configuration')->with('success', 'Configuration successfully deleted!');
    }
}