@extends('layouts.dashboard')

@section('title', 'Show/Event')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Show Event</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event.index') }}">Event</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">State</label>
                                <input type="text" class="form-control" value="{{ getState($event->state_id)->name }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">City</label>
                                <input type="text" class="form-control" value="{{ getCity($event->city_id)->name }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Venue</label>
                                <input type="text" class="form-control" value="{{ getVenue($event->venue_id)->name }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Sub Venue</label>
                                <input type="text" class="form-control" value="@if(getSubVenue($event->sub_venue_id)){{ getSubVenue($event->sub_venue_id)->name }}@endif" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Organizer</label>
                                <input type="text" class="form-control" value="{{ getOrganizer($event->organizer_id)->name }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Event Title</label>
                                <input type="text" class="form-control" value="{{ $event->event_title }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Description</label>
                                <input type="text" class="form-control" value="{{ $event->event_description }}" disabled="true" />
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Start Date</label>
                                <input type="text" class="form-control" value="{{ nice_date($event->start_date) }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">End Date</label>
                                <input type="text" class="form-control" value="{{ nice_date($event->end_date) }}" disabled="true" />
                            </div>
                        </div> -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Category</label>
                                <input type="text" class="form-control" value="{{ $event->event_category }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Type</label>
                                <input type="text" class="form-control" value="{{ $event->event_type }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Recurring Type</label>
                                <input type="text" class="form-control" value="{{ $event->recurring_type }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Is Published</label>
                                <input type="text" class="form-control" value="{{ $event->is_published }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Status</label>
                                <input type="text" class="form-control" value="{{ $event->status }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Banner</label>
                                <input type="text" class="form-control" value="{{ $event->event_banner }}" disabled="true" />
                                @if($event->event_banner)
                                    <br>
                                    <img src="{!! url('/').'/uploads/events/banner/'.$event->event_banner !!}" alt="img" class="img-responsive" style="height:100px;width:100px;" />
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Video</label>
                                <input type="text" class="form-control" value="{{ $event->event_video }}" disabled="true" />
                                @if($event->event_video)
                                    <br>
                                    <video width="100" height="100" controls><source src="{!! url('/').'/uploads/events/video/'.$event->event_video !!}" type="video/mp4"></video>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('event.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection