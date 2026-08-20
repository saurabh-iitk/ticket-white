<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\CouponCategory;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupon_categories = CouponCategory::all();
        
        return view('auth.user.coupon_category.index',compact('coupon_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = \App\Models\Event::where('status','ACTIVE')->get();
        return view('auth.user.coupon_category.add',compact('events'));
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
            'event_id'=>'required',
            'name'=>'required',
            'valid_from'=>'required',
            'valid_till'=>'required',
        ]);

        $coupon_category = new CouponCategory([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'discount_value' => $request->discount_value,
            'discount_unit' => $request->discount_unit,
            'valid_from' => $request->valid_from,
            'valid_till' => $request->valid_till,
            'max_order_value' => $request->max_order_value,
            'max_discount_value' => $request->max_discount_value,
            'is_redeemable' => $request->is_redeemable,
        ]);
        $coupon_category->save();
        return redirect('/coupon_category')->with('success', 'Coupon Category successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon_category = CouponCategory::where('id', $id)->first();
        
        return view('auth.user.coupon_category.show',compact('coupon_category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $events = \App\Models\Event::where('status','ACTIVE')->get();
        $coupon_category = CouponCategory::where('id', $id)->first();
        
        return view('auth.user.coupon_category.edit',compact('coupon_category','events'));
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
        $coupon_category = CouponCategory::where('id', $id)->first();

        $request->validate([
            'event_id'=>'required',
            'name'=>'required',
            'valid_from'=>'required',
            'valid_till'=>'required',
        ]);
        
        $coupon_category->event_id = $request->event_id;
        $coupon_category->name = $request->name;
        $coupon_category->discount_value = $request->discount_value;
        $coupon_category->discount_unit = $request->discount_unit;
        $coupon_category->valid_from = $request->valid_from;
        $coupon_category->valid_till = $request->valid_till;
        $coupon_category->max_order_value = $request->max_order_value;
        $coupon_category->max_discount_value = $request->max_discount_value;
        $coupon_category->is_redeemable = $request->is_redeemable;
        $coupon_category->status = $request->status;

        $coupon_category->save();

        return redirect('/coupon_category')->with('success', 'Coupon Category successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CouponCategory::where('id', $id)->delete();
        
        return redirect('/coupon_category')->with('success', 'Coupon Category successfully deleted!');
    }
}