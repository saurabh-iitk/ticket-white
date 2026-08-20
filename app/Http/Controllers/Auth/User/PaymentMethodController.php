<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_methods = PaymentMethod::all();
        
        return view('auth.user.payment_method.index',compact('payment_methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.user.payment_method.add');
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

        PaymentMethod::create([
            'name' => $request->name
        ]);

        return redirect('/payment_method')->with('success', 'Payment Method successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment_method = PaymentMethod::where('id', $id)->first();
        
        return view('auth.user.payment_method.show',compact('payment_method'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment_method = PaymentMethod::where('id', $id)->first();
        
        return view('auth.user.payment_method.edit',compact('payment_method'));
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
        $payment_method = PaymentMethod::where('id', $id)->first();
        
        $payment_method->name = $request->name;
        $payment_method->show_hide_price = $request->show_hide_price;
        if($payment_method->show_hide_price == ''){
           $payment_method->show_hide_price = 'SHOW';
        }
        $payment_method->status = $request->status;

        $payment_method->save();

        return redirect('/payment_method')->with('success', 'Payment Method successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PaymentMethod::where('id', $id)->delete();
        
        return redirect('/payment_method')->with('success', 'Payment Method successfully deleted!');
    }
}