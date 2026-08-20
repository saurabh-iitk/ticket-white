@extends('layouts.dashboard')

@section('title', 'Show Schedule')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Show Schedule</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_show_time.index') }}">Show Schedule</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">


        <form action="show_time_schedule" method="GET">

        <div class="row">
            <div class="col-md-3" >
                <div class="form-group">
                    <label for="for">Event</label>
                    <select class="form-control" name="e_id" id="event_id" autofocus="true" onchange="get_event_schedule_by_event_id(this.value);" >
                        <option value="">Select Event</option>
                        @foreach($events as $key => $event)
                        <option value="{{$event->id}}">{{$event->event_title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3" >
                <div class="form-group">
                    <label for="for">Event Schedule</label>
                    <select class="form-control" name="es_id" id="event_schedule_id" onchange="get_event_schedule_list_by_event_schedule_id(this.value);">
                        <option value="">Select Event Schedule</option>
                    </select>
                </div>
            </div>

           

            <div class="col-md-3">
                <div class="form-group">
                    <label for="for">Venue</label>
                    <select class="form-control" name="venue_id" id="venue_id">
                        <option value="">Select Venue</option>
                        @foreach($venues as $key => $venue)
                        <option value="{{$venue->id}}" >{{$venue->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3" >
                <div class="form-group">
                    <label for="for">Layout</label>
                    <select class="form-control" name="layout_id" id="layout_id">
                        <option value="">Select Layout</option>
                        @foreach($layouts as $key => $layout)
                        <option value="{{$layout->id}}">{{$layout->layout_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


             <div class="col-md-12">
                <div class="form-group">
                    <label for="for" style="margin-top: 16px;float:right;"></label>
                    <input type="submit" class="btn btn-primary pl-4 pr-4" value="Find All Shows" />
                </div>
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
<!-- Data table plugin-->
<script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/confirm_delete.js') }}"></script>
<script>
//get event schedule by event id
function get_event_schedule_by_event_id(event_id)
{
if(event_id!='' && event_id>0)
{
    var data = {_token:'{{ csrf_token() }}' , event_id:event_id};
    $.ajax({
        type : 'POST',
        url: '{{ route("event_schedules.get_event_schedule_by_event_id") }}',
        data: data,
        dataType : 'json',
        success:function(response)
        {
            $('#event_schedule_id').empty();
            $('#event_schedule_id').append('<option value="">Select Event Schedule</option>');

            $('#event_schedule_list_id').empty();
            $('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');

            $.each(response, function(key,value){
                $('#event_schedule_id').append('<option value="'+ value.id +'">'+ value.start_date+' - '+value.end_date+'</option>');
            });
        }
    });
}
else
{
    $('#event_schedule_id').empty();
    $('#event_schedule_id').append('<option value="">Select Event Schedule</option>');
    
    $('#event_schedule_list_id').empty();
    $('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');

    $('#event_show_time_id').empty();
    $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');
}
}


$('#userTable').DataTable({
    'columnDefs': [ {
        'targets': [1],
        'orderable': false
    }]
});
</script>
@endsection