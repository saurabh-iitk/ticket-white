<?php
namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();
        
        return view('auth.user.state.index',compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.user.state.add');
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

        State::create([
            'name' => $request->name
        ]);

        return redirect('/state')->with('success', 'State successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $state = State::where('id', $id)->first();
        
        return view('auth.user.state.show',compact('state'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = State::where('id', $id)->first();
        
        return view('auth.user.state.edit',compact('state'));
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
        $state = State::where('id', $id)->first();

        $request->validate([
            'name'=>'required'
        ]);
        
        $state->name = $request->name;
        $state->status = $request->status;

        $state->save();

        return redirect('/state')->with('success', 'State successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        State::where('id', $id)->delete();
        
        return redirect('/state')->with('success', 'State successfully deleted!');
    }
}