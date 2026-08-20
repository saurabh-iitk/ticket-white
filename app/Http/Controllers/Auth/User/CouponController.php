<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        
        return view('auth.user.coupon.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coupon_categories = \App\Models\CouponCategory::where('status','ACTIVE')->get();
        return view('auth.user.coupon.add',compact('coupon_categories'));
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
            'category_id'=>'required',
            'coupon_code'=>'required',
        ]);

        $coupon = new Coupon([
            'category_id' => $request->category_id,
            'coupon_code' => $request->coupon_code,
            'is_used' => $request->is_used,
        ]);
        $coupon->save();
        return redirect('/coupon')->with('success', 'Coupon successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon = Coupon::where('id', $id)->first();
        
        return view('auth.user.coupon.show',compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon_categories = \App\Models\CouponCategory::where('status','ACTIVE')->get();
        $coupon = Coupon::where('id', $id)->first();
        
        return view('auth.user.coupon.edit',compact('coupon','coupon_categories'));
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
        $coupon = Coupon::where('id', $id)->first();
        
        $request->validate([
            'category_id'=>'required',
            'coupon_code'=>'required',
        ]);
        
        $coupon->category_id = $request->category_id;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->is_used = $request->is_used;
        $coupon->status = $request->status;

        $coupon->save();

        return redirect('/coupon')->with('success', 'Coupon successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupon::where('id', $id)->delete();
        
        return redirect('/coupon')->with('success', 'Coupon successfully deleted!');
    }
}