<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Layout;
use App\Models\LayoutDetail;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $layouts = Layout::all();  
        return view('auth.user.seat_layouts.index',compact('layouts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=0)
    {     
        $layouts = Layout::all();
    	$events = Event::where('status','ACTIVE')->get();
    	$venues = Venue::where('status','ACTIVE')->get();
        if($id != 0)
        {
            $layout = Layout::where('id', $id)->first();
            return view('auth.user.seat_layouts.add_detail',compact('events','venues','layout'));
        }
        else
        {
            return view('auth.user.seat_layouts.add',compact('events','venues','layouts'));
        } 
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
            'venue_id'=>'required',
            'sub_venue_id'=>'required',
            'layout_name'=>'required'
        ]);

        $default_layout = 'NO';
        if($request->has('default_layout')){
            $default_layout = $request->default_layout;
        }

        $layout = new Layout([
            'venue_id' => $request->venue_id,
            'sub_venue_id' => $request->sub_venue_id,
            'layout_name' => $request->layout_name,
            'default_layout' => $default_layout
        ]);
        
        $layout->save();
      
        if($request->has('default_layout') && $request->default_layout == 'YES'){
            $default_layout = Layout::where('default_layout', 'YES')->where('id', '!=', $layout->id)->first();
            if($default_layout) {
                $default_layout->default_layout = 'NO';
                $default_layout->save();   
            }
        }

        if($layout->id)
        {
            return redirect('/layout/create/'.$layout->id)->with('success', 'Layout successfully added!');
        }
        else
        {
            return redirect('/layout/create')->with('error', 'Some problems occurred. Please, try again!');
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $layout = Layout::where('id', $id)->first();

        $request->validate([
            'venue_id'=>'required',
            'sub_venue_id'=>'required',
            'layout_name'=>'required',
        ]);

        $default_layout = 'NO';
        if($request->has('default_layout')){
            $default_layout = $request->default_layout;
        }

        $layout->venue_id = $request->venue_id;
        $layout->sub_venue_id = $request->sub_venue_id;
        $layout->layout_name = $request->layout_name;
        $layout->default_layout = $default_layout;
      
        $layout->save();
      
        if($request->has('default_layout') && $request->default_layout == 'YES'){
            $default_layout = Layout::where('default_layout', 'YES')->where('id', '!=', $id)->first();
            if($default_layout) {
                $default_layout->default_layout = 'NO';
                $default_layout->save();
            }
        }

        if($layout->id)
        {
            return redirect('/layout/create/'.$layout->id)->with('success', 'Layout successfully updated!');
        }
        else
        {
            return redirect()->back()->with('error', 'Some problems occurred. Please, try again!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Layout::where('id', $id)->delete();
        LayoutDetail::where('layout_id', $id)->delete();
        
        return redirect('/layout/create')->with('success', 'Layout successfully deleted!');
    }

    /**
     * Create Seat the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_seat(Request $request, $id)
    {
        $layout = Layout::where('id', $id)->first();

        $request->validate([
            'rows'=>'required',
            'cols'=>'required',
            'label_cols'=>'required',
        ]);

        $data = [];
        $rows = $request->rows;
        $cols = $request->cols;
        $label_cols = $request->label_cols;
        $cols = $cols + $label_cols;

        for($i=1; $i<=$rows; $i++)
        {
            for($j=1; $j<=$cols; $j++)
            {
                $data[] = [
                    'layout_id' => $id,
                    'row_no' => $i,
                    'col_no' => $j,
                    'seatno' => $i.$j,
                ];
            }
        }

        if(!empty($data))
        {
            LayoutDetail::insert($data);
            return redirect()->back()->with('success', 'Layout successfully added!');
        }
        else
        {
            return redirect()->back()->with('error', 'Some problems occurred. Please, try again!');
        }
    }

    public function update_layout(Request $request)
    {
        if(isset($request->action) && $request->action == 'hide')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_visible'=>'YES']);
            }
        }
        if(isset($request->action) && $request->action == 'show')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_visible'=>'NO']);
            }
        }

        if(isset($request->action) && $request->action == 'reserve')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_reserved'=>'YES']);
            }
        }
        if(isset($request->action) && $request->action == 'unreserve')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_reserved'=>'NO']);
            }
        }


         if(isset($request->action) && $request->action == 'damaged')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_damaged'=>'YES']);
            }
        }
        if(isset($request->action) && $request->action == 'undamaged')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_damaged'=>'NO']);
            }
        }
        
        if(isset($request->action) && $request->action == 'removed')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_removed'=>'YES']);
            }
        }
        
        if(isset($request->action) && $request->action == 'unremoved')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_removed'=>'NO']);
            }
        }

        if(isset($request->action) && $request->action == 'labeled')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_labeled'=>'YES']);
            }
        }
        
        if(isset($request->action) && $request->action == 'unlabeled')
        {
            if(isset($request->ids))
            {
                $ids = $request->ids;
                LayoutDetail::whereIn('id',$ids)->update(['is_labeled'=>'NO']);
            }
        }


    }
  
  
  
  public function seat_name_regenerate($id=0)
  {
     $layouts = Layout::all();
    	$events = Event::where('status','ACTIVE')->get();
    	$venues = Venue::where('status','ACTIVE')->get();
        if($id != 0)
        {
            $layout = Layout::where('id', $id)->first();
            return view('auth.user.seat_layouts.seat_name_regenerate',compact('events','venues','layout'));
        }
        else
        {
            return view('auth.user.seat_layouts.add',compact('events','venues','layouts'));
        }
  }
  
  //update seat name
    public function update_seat_name(Request $request)
    {
        $seat_id = $request->id;
        $seat_name = $request->name;
        LayoutDetail::where('id', $seat_id)->update(['name' => $seat_name]);  
        $data = LayoutDetail::where('id', $seat_id)->first();
        if($data->is_labeled == 'YES')
        {
            $row_no = $data->row_no;
            $layout_id = $data->layout_id;
            LayoutDetail::where('row_no', $row_no)
            ->where('layout_id', $layout_id)
            ->update(['label' => $seat_name]);  

            LayoutDetail::where('row_no', $row_no)
            ->where('layout_id', $layout_id)
            ->where('is_labeled', 'YES')
            ->update(['name' => $seat_name]);  
        }
    }


    public function update_stage_direction(Request $request)
    {
      $layout_id = $request->id;
      $stage_direction = $request->direction;
      Layout::where('id',$layout_id)->update(['stage_direction' => $stage_direction]);  
    }
    
    public function layout_row_label(Request $request, $id)
    {
     
      $row_label = $request->layout_row_label;
      $skip_label = $request->layout_skip_label;
      Layout::where('id',$id)->update(['layout_row_label' => $row_label, 'layout_skip_label' => $skip_label]);  
      return redirect()->back()->with('success', 'Row Label Name Updated!!');
    }
}