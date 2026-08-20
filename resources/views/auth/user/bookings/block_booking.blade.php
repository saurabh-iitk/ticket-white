@extends('layouts.dashboard')

@section('title', 'Add/Booking')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Block Booking</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('booking.index') }}">Bookings</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">

            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
           <!--  <div class="tile">
                <div class="tile-body">
                  
                </div>
            </div> -->
          <!--- data table -->
                    <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <!-- <a href="{{ URL::to('booking/create') }}" class="btn btn-info pl-5 pr-5">Add</a> -->
                        </div>
                    </div>
             <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                              	<th>Event</th>
                                <th>Show Date</th>
                                <th>Show Time</th>
                                <th width="180px">Vendor Booking</th>
                               <th width="180px">Customer Booking</th>
                               <th width="180px">All Booking</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if($event_schedule_list)
                                @foreach($event_schedule_list as $key => $list)
                                    <tr>
                                    	<td>{{ $key+1 }}</td>
                                       <td>@if(getEvent($list->event_id)){{ getEvent($list->event_id)->event_title }}@endif</td>
                                       <td>@if(get_Event_date($list->event_schedule_list_id)){{ 
                                         get_Event_date($list->event_schedule_list_id)->event_date
                                         }}@endif
                                         <?php
                                         
                                         //strtotime(date('D-M-y'), get_Event_date($list->event_schedule_list_id)->event_date)
                                         ?>
                                      
                                      </td>

                                      <td>{{$list->start_time }} - {{$list->end_time}}</td>
                                      <td>
                                        
                                        <?php if($list->vendor_booking == 'ALLOWED'){ ?>
                                        <a href="{{route('bookings.vendor_block_booking', [$list->id,$list->vendor_booking])}}" class="btn btn-primary pl-4 pr-4" onclick="return confirm('Are you sure ?'); "> Blocked</a>
                                        <?php } else{?>
                                        <a href="{{route('bookings.vendor_block_booking', [$list->id,$list->vendor_booking])}}" class="btn btn-danger pl-4 pr-4" onclick="return confirm('Are you sure ?'); "> Unblocked</a>
                                        <?php } ?>
                                      </td>
                                       <td>
                                        <?php if($list->customer_booking == 'ALLOWED'){ ?>
                                        <a href="{{route('bookings.customer_block_booking', [$list->id,$list->customer_booking])}}" class="btn btn-primary pl-4 pr-4" onclick="return confirm('Are you sure ?'); "> Blocked</a>
                                        <?php } else{?>
                                        <a href="{{route('bookings.customer_block_booking', [$list->id,$list->customer_booking])}}" class="btn btn-danger pl-4 pr-4" onclick="return confirm('Are you sure ?'); "> Unblocked</a>
                                        <?php } ?>
                                      </td>
                                       <td>
                                         <?php if($list->customer_booking == 'ALLOWED' or $list->vendor_booking == 'ALLOWED' or $list->booking == 'ALLOWED'){ ?>
                                        <a href="{{route('bookings.all_block_booking', [$list->id])}}" class="btn btn-primary pl-4 pr-4" onclick="return confirm('Are you sure ?'); "> Blocked</a>
                                        <?php } else{?>
                                        <a href="{{route('bookings.all_unblock_booking', [$list->id])}}" class="btn btn-danger pl-4 pr-4" onclick="return confirm('Are you sure ?'); "> Unblocked</a>
                                        <?php } ?>
                                      </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
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
<script>
$('#userTable').DataTable({
    'columnDefs': [ {
        'targets': [1],
        'orderable': false
    }]
});
</script>
<script type="text/javascript">
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

    //get event shedule list by event shedule id
    function get_event_schedule_list_by_event_schedule_id(event_schedule_id) 
    {
        if(event_schedule_id!='' && event_schedule_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', event_schedule_id:event_schedule_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('event_schedules.get_event_schedule_list_block') }}',
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
     //get event shedule time list by event shedule date id
    function get_event_schedule_time_by_event_schedule_date(event_schedule_list_id) {
        if (event_schedule_list_id != '' && event_schedule_list_id > 0) {
            var data = {
                _token: '{{ csrf_token() }}',
                event_schedule_list_id: event_schedule_list_id
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('event_schedules.get_event_schedule_time_by_event_schedule_date') }}',
                data: data,
                dataType: 'json',
                success: function(response) {
                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');

                    $.each(response.event_show_times, function(key, value) {
                        $('#event_show_time_id').append('<option value="' + value.event_show_time_id + '">' + value.start_time + ' - ' + value.end_time + '</option>');
                    });
                }
            });
        } else {

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');
        }
    }
</script>
@endsection