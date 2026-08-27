@extends('layouts.dashboard')

@section('title', 'Show/Event Ticket')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Show Event Ticket</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_ticket.index') }}">Event Ticket</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action=" {{ url('event_ticket/layout_mapping_canvas/' . $event_ticket->id) }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event</label>
                                <input type="text" class="form-control" value="{{ getEvent($event_ticket->event_id)->event_title }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Schedule</label>
                                <select class="form-control" name="es_id" id="event_schedule_id" onchange="get_event_schedule_list_by_event_schedule_id(this.value);">
                                    <option value="">Select Event Schedule</option>
                                    @foreach(getEventScheduleByEventID($event_ticket->event_id) as $key => $event_schedule)
                                    <option value="{{$event_schedule->id}}" <?php if($event_ticket->event_schedule_id==$event_schedule->id){ echo 'selected';} ?>>{{$event_schedule->start_date.' - '.$event_schedule->end_date}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Schedule Date</label>
                                <select class="form-control" name="esd_id" id="event_schedule_list_id" style="width:100%;">
                                    <option value="">Select Event Schedule Date</option>
                                    @foreach(getEventScheduleListByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_schedule_list)
                                        <option value="{{$event_schedule_list->id}}" <?php if($event_ticket->event_schedule_list_id != '' && in_array($event_schedule_list->id, explode(',',$event_ticket->event_schedule_list_id))){ echo 'selected';} ?>>{{$event_schedule_list->event_date}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Show Time</label>
                                <select class="form-control" name="est_id" id="event_show_time_id" style="width:100%;">
                                    <option value="">Select Event Show Time</option>
                                    @foreach(getEventShowTimeByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_show_time)
                                        <option value="{{$event_show_time->id}}" <?php if($event_ticket->event_show_time_id != '' && in_array($event_show_time->id, explode(',',$event_ticket->event_show_time_id))){ echo 'selected';} ?>>{{$event_show_time->start_time.' - '.$event_show_time->end_time}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for" style="margin-top: 42px;"></label>
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Go !" />
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
<script>
    //get event shedule list by event shedule id
    function get_event_schedule_list_by_event_schedule_id(event_schedule_id) 
    {
        if(event_schedule_id!='' && event_schedule_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', event_schedule_id:event_schedule_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('event_schedules.get_event_schedule_list_by_event_schedule_id') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#event_schedule_list_id').empty();
                    $('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');
                    $.each(response.event_schedule_lists, function(key,value){
                        $('#event_schedule_list_id').append('<option value="'+ value.id +'">'+ value.event_date+'</option>');
                    });

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');
                    $.each(response.event_show_times, function(key,value){
                        $('#event_show_time_id').append('<option value="'+ value.id +'">'+ value.start_time+' - '+value.end_time+'</option>');
                    });
                }
            });
        }
        else
        {
            $('#event_schedule_list_id').empty();
            $('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');
        }
    }
</script>
@endsection
