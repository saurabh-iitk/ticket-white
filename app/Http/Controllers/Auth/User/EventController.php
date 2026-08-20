<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\Event;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        
        return view('auth.user.event.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = \App\Models\State::where('status','ACTIVE')->get();
        $organizers = \App\Models\Organizer::where('status','ACTIVE')->get();
        return view('auth.user.event.add',compact('states','organizers'));
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
            'state'=>'required',
            'event_state'=>'required',
            'city_id'=>'required',
            'venue_id'=>'required',
            'sub_venue_id'=>'required',
            'organizer_id'=>'required',
            'event_title'=>'required',
            'gst_name'=>'required',
            'gst_no'=>'required',
            'invoice_prefix'=>'required',
            'gst_address'=>'required',
            'show_hide_time'=>'required',
        ]);


      
        if($request->hasFile('event_banner'))
        {
            $file = $request->file('event_banner');
            $file_name=pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            $extension = $file->extension() ?: 'png';
            $picture = $file_name . uniqid() . '.' . $extension;
            $destinationPath = public_path() . '/uploads/events/banner';
            $file->move($destinationPath, $picture);
        }
        else
        {
            $picture='';
        }

        if($request->hasFile('event_video'))
        {
            $file = $request->file('event_video');
            $file_name=pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            $extension = $file->extension() ?: 'mp4';
            $video = $file_name . uniqid() . '.' . $extension;
            $destinationPath = public_path() . '/uploads/events/video';
            $file->move($destinationPath, $video);
        }
        else
        {
            $video='';
        }

        $event = new Event([
            'state' => $request->state,
            'event_state' => $request->event_state,
            'gst_address' => $request->gst_address,
            'gst_name' => $request->gst_name,
            'gst_no' => $request->gst_no,
            'invoice_prefix' => $request->invoice_prefix,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'venue_id' => $request->venue_id,
            'sub_venue_id' => $request->sub_venue_id,
            'organizer_id' => $request->organizer_id,
            'event_title' => $request->event_title,
            'event_description' => $request->event_description,
            'event_banner' => $picture,
            'event_video' => $video,
            'event_category' => $request->event_category,
            'event_type' => $request->event_type,
            'recurring_type' => $request->recurring_type,
            'is_published' => $request->is_published,
            'show_hide_time' => $request->show_hide_time,
        ]);
        $event->save();
        return redirect('/event')->with('success', 'Event successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::where('id', $id)->first();
        
        return view('auth.user.event.show',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $states = \App\Models\State::where('status','ACTIVE')->get();
        $organizers = \App\Models\Organizer::where('status','ACTIVE')->get();
        $event = Event::where('id', $id)->first();
        
        return view('auth.user.event.edit',compact('event','states','organizers'));
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
        $event = Event::where('id', $id)->first();

        $request->validate([
            'state_id'=>'required',
            'event_state'=>'required',
            'state'=>'required',
            'city_id'=>'required',
            'venue_id'=>'required',
            'sub_venue_id'=>'required',
            'organizer_id'=>'required',
            'event_title'=>'required',
            'gst_name'=>'required',
            'gst_no'=>'required',
            'invoice_prefix'=>'required',
            'gst_address'=>'required',
            'show_hide_time'=>'required',
            
        ]);

        if($request->hasFile('event_banner')) 
        {
            $file = $request->file('event_banner');
            $file_name=pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            $extension = $file->extension() ?: 'png';
            $picture = $file_name . uniqid() . '.' . $extension;
            $destinationPath = public_path() . '/uploads/events/banner';
            $file->move($destinationPath, $picture);
            $image_path = $destinationPath.'/'.$event->event_banner;
            if($event->event_banner)
            {
                delete_image_from_server($image_path);
            }
            $event->event_banner = $picture;
        }

        if($request->hasFile('event_video')) 
        {
            $file = $request->file('event_video');
            $file_name=pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            $extension = $file->extension() ?: 'mp4';
            $video = $file_name . uniqid() . '.' . $extension;
            $destinationPath = public_path() . '/uploads/events/video';
            $file->move($destinationPath, $video);
            $video_path = $destinationPath.'/'.$event->event_video;
            if($event->event_video)
            {
                delete_image_from_server($video_path);
            }
            $event->event_video = $video;
        }
        
        $event->gst_name = $request->gst_name;
        $event->event_state = $request->event_state;
        $event->state = $request->state;
        $event->gst_address = $request->gst_address;
        $event->gst_no = $request->gst_no;
        $event->invoice_prefix = $request->invoice_prefix;
        $event->state_id = $request->state_id;
        $event->city_id = $request->city_id;
        $event->venue_id = $request->venue_id;
        $event->sub_venue_id = $request->sub_venue_id;
        $event->organizer_id = $request->organizer_id;
        $event->event_title = $request->event_title;
        $event->event_description = $request->event_description;
        $event->event_category = $request->event_category;
        $event->event_type = $request->event_type;
        $event->recurring_type = $request->recurring_type;
        $event->is_published = $request->is_published;
        $event->status = $request->status;
        $event->show_hide_time = $request->show_hide_time;
        
        $event->save();
        return redirect('/event')->with('success', 'Event successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Event::where('id', $id)->delete();
        
        return redirect('/event')->with('success', 'Event successfully deleted!');
    }
}