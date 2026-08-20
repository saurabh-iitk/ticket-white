@extends('layouts.dashboard')

@section('title', 'Show/Event Show Time')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Show Event Show Time</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_show_time.index') }}">Event Show Time</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event</label>
                                <input type="text" class="form-control" value="{{ getEvent($event_show_time->event_id)->event_title }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Schedule</label>
                                <input type="text" class="form-control" value="{{ getEventSchedule($event_show_time->event_schedule_id)->start_date.' - '.getEventSchedule($event_show_time->event_schedule_id)->end_date }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Start Time</label>
                                <input type="text" class="form-control" value="{{ $event_show_time->start_time }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">End Time</label>
                                <input type="text" class="form-control" value="{{ $event_show_time->end_time }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Status</label>
                                <input type="text" class="form-control" value="{{ $event_show_time->status }}" disabled="true" />
                            </div>
                        </div>
                        

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Allow Online Booking</label>
                                <input type="text" class="form-control" value="{{ $event_show_time->allow_online_booking }}" disabled="true" />
                            </div>
                        </div>
                        

                        


                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('event_show_time.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection