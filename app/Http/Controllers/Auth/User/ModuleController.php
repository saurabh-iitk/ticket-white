<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Module;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::all();
        
        return view('auth.user.module.index',compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('auth.user.module.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       Module::create([
           'name' => $request->name,
           'display_name' => $request->display_name
       ]);
       
       return redirect('/module');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module = Module::with('permissions')->where('id', $id)->first();
        
        return view('auth.user.module.show',compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $module = Module::with('permissions')->where('id', $id)->first();
       
       return view('auth.user.module.edit',compact('module'));
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
       $request->validate([
           'name' => 'required'
       ]);
       
       $module = Module::where('id', $id)->first();
       
       $module->name = $request->name;
       $module->display_name = $request->display_name;
       $module->save();
        
       $permissions = $request->input_array_name;
       
       //Delete previous record  in  permissions table
       Permission::where('module_id', $id)->delete();
       
       foreach (range(1, sizeOf($permissions)) as $index)
       {
           if(!empty($permissions[$index - 1])){
           Permission::create([
               'module_id' => $id,
               'name' => $permissions[$index - 1],
               'display_name' => $request->input_array_display_name[$index - 1]
           ]);
           }
       }
        
        return redirect('/module');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        Module::where('id', $id)->delete();
//        
//        return redirect('/module');
    }
}