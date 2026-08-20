@extends('layouts.dashboard')

@section('title', 'Add/Event Show Time')

@section('css')
<link rel="stylesheet" href="{{ asset('css/timepicker/bootstrap-timepicker.min.css') }}">
<style>
    .glyphicon {
        position: relative;
        top: 1px;
        display: inline-block;
        font-family: "Glyphicons Halflings";
        font-style: normal;
        font-weight: 400;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .glyphicon-chevron-up:before {
        content: "\e113";
    }
    .glyphicon-chevron-down:before {
        content: "\e114";
    }
    .fa {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .input-group .input-group-addon {
        border-radius: 0;
        border-color: #d2d6de;
        background-color: #fff;
    }
    .input-group-addon {
        padding: 9px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .fa-clock-o:before {
        content: "\f017";
    }
</style>
@endsection

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Add Event Show Time</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_show_time.index') }}">Event Show Times</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-5">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('event_show_time') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="for">Event <span class="required">*</span></label>
                            <select class="form-control" name="event_id" id="event_id" onchange="get_event_schedule_by_event_id(this.value);" autofocus="true">
                                <option value="">Select Event</option>
                                @foreach($events as $key => $event)
                                <option value="{{$event->id}}">{{$event->event_title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="for">Event Schedule <span class="required">*</span></label>
                            <select class="form-control" name="event_schedule_id" id="event_schedule_id">
                                <option value="">Select Event Schedule</option>
                            </select>
                        </div>
                        
                        <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <label for="for">Start Time <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker" name="start_time" id="start_time" placeholder="Start Time" autofocus="true" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bootstrap-timepicker">
                            <div class="form-group">
                                <label for="for">End Time <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker" name="end_time" id="end_time" placeholder="End Time" autofocus="true" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="role">Allow Online Booking</label>
                            <select class="form-control" name="allow_online_booking">
                                <option value="YES" selected="select">YES</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>


                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('event_show_time.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
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
<script src="{{ asset('js/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script>
//Timepicker
$('.timepicker').timepicker({
  showInputs: false
});
//get event schedule by event id
function get_event_schedule_by_event_id(event_id)
{
    if(event_id!='' && event_id>0)
    {
        var data = {_token:'{{ csrf_token() }}', event_id:event_id};

        $.ajax({
            type : 'POST',
            url : '{{ route('event_schedules.get_event_schedule_by_event_id') }}',
            data: data,
            dataType : 'json',
            success:function(response)
            {
                $('#event_schedule_id').empty();
                $('#event_schedule_id').append('<option value="">Select Event Schedule</option>');
                $.each(response, function(key,value){
                    $('#event_schedule_id').append('<option value="'+ value.id +'">'+ value.start_date+' - '+value.end_date +'</option>');
                });
            }
        });
    }
    else
    {
        $('#event_schedule_id').empty();
        $('#event_schedule_id').append('<option value="">Select Event Schedule</option>');
    }
}
</script>
@endsection