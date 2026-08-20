@extends('layouts.dashboard')

@section('title', 'Add/Event Schedule')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Add Event Schedule</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_schedule.index') }}">Event Schedules</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-5">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('event_schedule') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="for">Event <span class="required">*</span></label>
                            <select class="form-control" name="event_id" id="event_id" autofocus="true">
                                <option value="">Select Event</option>
                                @foreach($events as $key => $event)
                                <option value="{{$event->id}}">{{$event->event_title}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="for">Start Date <span class="required">*</span></label>
                            <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Start Date" autofocus="true" autocomplete="off" />
                        </div>
                        
                        <div class="form-group">
                            <label for="for">End Date <span class="required">*</span></label>
                            <input type="text" class="form-control" name="end_date" id="end_date" placeholder="End Date" autofocus="true" autocomplete="off"/>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('event_schedule.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="{{ asset('js/plugins/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@endsection