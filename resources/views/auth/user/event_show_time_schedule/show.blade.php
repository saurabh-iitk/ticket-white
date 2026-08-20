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
                
        <form action="{{ url('show_time_schedule') }}" method="GET">
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

<div id="message" style="display: none;text-align: center;font-size: 17px;color: white;background: green;padding: 2px;"></div>
            <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Date</th>
                                <th style="text-align:center;">Start Time</th>
                                <th style="text-align:center;">End Time</th>
                                <th style="text-align:center;">Vendor Booking</th>
                                <th style="text-align:center;">Customer Booking</th>
                                <th style="text-align:center;">Tickets Rate</th>
                                <th style="text-align:center;">Seating Plan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($event_schedule_data)
                                @foreach($event_schedule_data as $event_schedule_single)
                                    <tr>
                                        <?php 
                        $event_show_time_id=$event_schedule_single->event_show_time_id;
                        $event_schedule_list_id=$event_schedule_single->event_schedule_list_id;
                                       // dd($event_schedule_single); exit;
                                       ?>
                                        <td><?php echo date('D jS F, Y', strtotime($event_schedule_single->event_date)); ?></td>

                                        <td>{{ $event_schedule_single->start_time }}</td>
                                        <td>{{ $event_schedule_single->end_time }}</td>
                                        <td style="text-align: center;">

 <input type="checkbox" name="vendor_booking" id="show_time_vendor_<?php echo $event_schedule_list_id?><?php echo $event_show_time_id?>" onchange="update_show_status(<?php echo $event_schedule_list_id?>, <?php echo $event_show_time_id?>, 'VENDOR', this.id)" style="transform: scale(2.4);" <?php if($event_schedule_single->vendor_booking=='ALLOWED') {echo 'checked';}?> >
                                        </td>
                                        <td style="text-align: center;">

 <input type="checkbox" id="show_time_customer_<?php echo $event_schedule_list_id?><?php echo $event_show_time_id?>" name="customer_booking" onchange="update_show_status(<?php echo $event_schedule_list_id?>, <?php echo $event_show_time_id?>, 'CUSTOMER', this.id)"  style="transform: scale(2.4);" <?php if($event_schedule_single->customer_booking=='ALLOWED') {echo 'checked';}?>>

                                        </td>
                                        <td class="text-center">
<button type="button" class="btn btn-primary" data-toggle="modal" 
onclick="open_ticket_box(<?php echo $event_schedule_single->event_id; ?>,<?php echo $event_schedule_single->event_schedule_list_id; ?>,<?php echo $event_schedule_single->event_show_time_id; ?>)">Edit</button>
                                        </td>
                                         <td class="text-center">
                                            <a class="btn btn-primary" href="">Edit</a>
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




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Ticket Rates</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="success" class="text-success" style="text-align: left;margin-top: 18px;margin-left: 28px;"></div>
      <input type="hidden" id="eid">
      <input type="hidden" id="esl_id">
      <input type="hidden" id="est_id">
      <div class="modal-body" id="modal_data">
        Loading...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



@endsection

@section('js')
<!-- Data table plugin-->
<script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/confirm_delete.js') }}"></script>
<script>

    function open_ticket_box(eid, esl_id, est_id)
    {
        $('#eid').val(eid);
        $('#esl_id').val(esl_id);
        $('#est_id').val(est_id);
        $('#myModal').modal('show'); 

        var data = 
        {
            _token:'{{ csrf_token() }}' ,
            event_show_time_id:est_id,
            event_schedule_list_id:esl_id 
        };

        $.ajax({
            type : 'POST',
            url: '{{ route("event_tickets.get_tickets_by_show_time_id") }}',
            data: data,
            dataType : 'json',
            success:function(response)
            {   
                $('#modal_data').html('');

                response=response.event_tickets;
                $.each(response, function(key,value){

                $('#modal_data').append('<div class="col-md-12">'+value.ticket_type_name+'<input class="form-control" type="number" value="'+ value.base_price +'" onchange="save_changes('+ value.id +', this.value)"><br></div>');
                });
            }
        });



    }


    function save_changes(id, price) 
    {
        var data = 
        {
            _token:'{{ csrf_token() }}' ,
            id:id,
            base_price:price
        };

        $.ajax({
            type : 'POST',
            url: '{{ route("event_ticket_rates.update") }}',
            data: data,
            dataType : 'json',
            success:function(response)
            {
                if(response)
                {
                    $('#success').fadeIn('fast');
                    $('#success').html('Ticket Rate Updated Successfully');
                    $('#success').delay(2000).fadeOut('slow');
                }
                else
                {
                    $('#success').fadeIn('fast');
                    $('#success').html('Some Error in updation');
                    $('#success').delay(2000).fadeOut('slow');
                }
            }
        });
    }



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


function update_show_status (event_schedule_list_id, event_show_time_id, user_type, id) 
{
    
    var status=$('#'+id)[0].checked;

    var data = {_token:'{{ csrf_token() }}' , event_schedule_list_id:event_schedule_list_id , event_show_time_id:event_show_time_id , user_type:user_type, status:status};

    $.ajax({
        type : 'POST',
        url: '{{ route("event_schedules.update_show_status") }}',
        data: data,
        dataType : 'json',
        success:function(response)
        {
            if(response)
            {
                $('#message').fadeIn('fast');
                $('#message').html('Show Updated Successfully');
                $('#message').delay(2000).fadeOut('slow');
            }
            else
            {
                $('#message').fadeIn('fast');
                $('#message').html('Some Error in updation');
                $('#message').delay(2000).fadeOut('slow');
            }
        }
    });
}

$('#userTable').DataTable({
    'sorting':false,
    'columnDefs': [ {
        'targets': [1],
        'orderable': false
    }]
});
</script>
@endsection