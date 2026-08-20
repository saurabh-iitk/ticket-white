<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Company;
use App\Models\State;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        
        return view('auth.user.company.index',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::where('status','ACTIVE')->get();
        return view('auth.user.company.add',compact('states'));
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
            'name'=>'required',
            'pincode'=>'required|numeric',
            'email'=>'required',
        ]);

        if($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $file_name=pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            //$extension=pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
            $extension = $file->extension() ?: 'png';
            $picture = $file_name . uniqid() . '.' . $extension;
            $destinationPath = public_path() . '/uploads/logo';
            $file->move($destinationPath, $picture);
        }
        else
        {
            $picture='';
        }

        Company::create([
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'name' => $request->name,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'email' => $request->email,
            'website' => $request->website,
            'contact_person' => $request->contact_person,
            'gst_no' => $request->gst_no,
            'registered_address' => $request->registered_address,
            'category' => $request->category,
            'helpline' => $request->helpline,
            'logo' => $picture,
            'description' => $request->description
        ]);

        return redirect('/company')->with('success', 'Company successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::where('id', $id)->first();
        
        return view('auth.user.company.show',compact('company'));
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
        $company = Company::where('id', $id)->first();
        
        return view('auth.user.company.edit',compact('company','states'));
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
        $company = Company::where('id', $id)->first();

        $request->validate([
            'state_id'=>'required',
            'city_id'=>'required',
            'name'=>'required',
            'pincode'=>'required|numeric',
            'email'=>'required',
        ]);

        if($request->hasFile('logo')) 
        {
            $file = $request->file('logo');
            $file_name=pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            //$extension=pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
            $extension = $file->extension() ?: 'png';
            $picture = $file_name . uniqid() . '.' . $extension;
            $destinationPath = public_path() . '/uploads/logo';
            $file->move($destinationPath, $picture);

            //delete old image if exists
            $image_path = $destinationPath.'/'.$company->logo;
            if($company->logo)
            {
                delete_image_from_server($image_path);
            }
            $company->logo = $picture;
        }
        
        $company->state_id = $request->state_id;
        $company->city_id = $request->city_id;
        $company->name = $request->name;
        $company->address = $request->address;
        $company->pincode = $request->pincode;
        $company->email = $request->email;
        $company->website = $request->website;
        $company->contact_person = $request->contact_person;
        $company->gst_no = $request->gst_no;
        $company->registered_address = $request->registered_address;
        $company->category = $request->category;
        $company->helpline = $request->helpline;
        $company->description = $request->description;
        $company->status = $request->status;

        $company->save();

        return redirect('/company')->with('success', 'Company successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::where('id', $id)->delete();
        
        return redirect('/company')->with('success', 'Company successfully deleted!');
    }
}