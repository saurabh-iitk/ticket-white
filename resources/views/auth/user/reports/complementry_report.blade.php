@extends('layouts.dashboard')

@section('title', 'Complementry Report')

@section('css')

@endsection

@section('content')

<style>
    table.dataTable,   table.dataTable td, table.dataTable th {
    font-size: 12px;
    padding: 5px;
    border: 1px solid;
    text-align: center;
}
</style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-bar-chart"></i> Complementry Report</h1>
        </div>
    </div>

   <div class="row">
    <div class="col-md-12">
        <!-- include message -->
        @include('../../partials/message')
        <!-- include message -->
        <div class="tile">
            <div class="tile-body">
                <?php
                    $events = \App\Models\Event::where('status','ACTIVE')->orderBy('id', 'DESC')->get();
                    $venues = \App\Models\Venue::where('status','ACTIVE')->get();
                    $layouts = \App\Models\Layout::where('status','ACTIVE')->get();
                    $users = \App\Models\User::where('status','ACTIVE')->get();

                    $e_id = request()->get('e_id');
                    $es_id = request()->get('es_id');
                    $esd_id = request()->get('esd_id');
                    $est_id = request()->get('est_id');
                    $venue_id = request()->get('venue_id');
                    $layout_id = request()->get('layout_id');
                    $u_id = request()->get('u_id');
                    $paid_by = request()->get('paid_by');
                    
                ?>
                <form action="{{ url($form_url) }}" method="GET">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Event</label>
                                <select class="form-control" name="e_id" id="event_id" autofocus="true" onchange="get_event_schedule_by_event_id(this.value);">
                                    @if(isset($events))
                                    @foreach($events as $key => $event)
                                    <option value="{{$event->id}}" <?php echo ($e_id != null && $e_id == $event->id) ? 'selected' : '';?>>{{$event->event_title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Event Schedule</label>
                                <select class="form-control" name="es_id" id="event_schedule_id" onchange="get_event_schedule_list_by_event_schedule_id(this.value);">
                                    @if($e_id != null)
                                    @foreach(getEventScheduleByEventID($e_id) as $key => $event_schedule)
                                    <option value="{{$event_schedule->id}}" <?php echo ($es_id != null && $es_id == $event_schedule->id) ? 'selected' : '';?>>
                                        <?php  
                                         echo date('D dS F, Y ', strtotime($event_schedule->start_date));
                                         echo " - ";
                                         echo date('D dS F, Y ', strtotime($event_schedule->end_date));
                                        ?>
                                        </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Event Schedule Date</label>
                                <select class="form-control" name="esd_id" id="event_schedule_list_id" style="width:100%;">
                                    <option value="">All Event Schedule Date</option>
                                    @if($es_id != null)
                                    @foreach(getEventScheduleListByEventScheduleID($es_id) as $key => $event_schedule_list)
                                    <option value="{{$event_schedule_list->id}}" <?php echo ($esd_id != null && $esd_id == $event_schedule_list->id) ? 'selected' : '';?>>
                                        <?php  echo date('D dS F, Y ', strtotime($event_schedule_list->event_date)) ;?></option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Event Show Time</label>
                                <select class="form-control" name="est_id" id="event_show_time_id" style="width:100%;" onchange="get_layout_by_show_time(this.value)">
                                    <option value="">All Event Show Time</option>
                                    @if($es_id != null)
                                    @foreach(getEventShowTimeByEventScheduleID($es_id) as $key => $event_show_time)
                                    <option value="{{$event_show_time->id}}" <?php echo ($est_id != null && $est_id == $event_show_time->id) ? 'selected' : '';?>>{{$event_show_time->start_time.' - '.$event_show_time->end_time}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3" style="display:none">
                            <div class="form-group">
                                <label for="for">Venue</label>
                                <select class="form-control" name="venue_id" id="venue_id">
                                    <option value="">All Venue</option>
                                    @if(isset($venues))
                                    @foreach($venues as $key => $venue)
                                    <option value="{{$venue->id}}" <?php echo ($venue_id != null && $venue_id == $venue->id) ? 'selected' : '';?>>{{$venue->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Layout</label>
                                <select class="form-control" name="layout_id" id="layout_id">
                                    <option value="">All Layout</option>
                                    @if(isset($layouts))
                                    @foreach($layouts as $key => $layout)
                                    <option value="{{$layout->id}}" <?php echo ($layout_id != null && $layout_id == $layout->id) ? 'selected' : '';?>>{{$layout->layout_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @if(\Auth::user()->role_id==1)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">User</label>
                                <select class="form-control" name="u_id" id="user_id">
                                    <option value="">All User</option>
                                    @if(isset($users))
                                    @foreach($users as $key => $user)
                                    <option value="{{$user->id}}" <?php echo ($u_id != null && $u_id == $user->id) ? 'selected' : '';?>>{{$user->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @else
                        <!-- <input type="hidden" name="u_id" value="{{ \Auth::user()->id }}"> -->
                        @endif

                         

                        




                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for" style="margin-top: 42px;"></label>
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Filter" />
                                <a href="{{ route($reset_url) }}" class="btn btn-info pl-4 pr-4" style="margin-left: 5px;">Reset</a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <!-- <a href="{{ URL::to('booking/create') }}" class="btn btn-info pl-5 pr-5">Add</a> -->
                        </div>
                    </div>
                    @if($count==1)
                    <br>
                    <h4 style="color:red">Note: Please Choose Event Schedule Date then click on Filter</h4><br>
                     @endif
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Trans. Date</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Email</th>
                                <th style="width:70px">Show Date</th>
                                <th style="width:70px">Show Time</th>
                                <th style="width:100px">Ticket(s)</th>
                                <th>Total Amount</th>
                                <th>Booked By</th>
                                <th>Issued By</th>
                                <th>Guest Designation</th>
                                <th style="width:80px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            $footer_total=array();
                            $footer_discount=array();
                            $footer_paid=array();
                            $footer_ticket=array();


                            $user_data=array();

                            $all_users=getUser();
                            $layout_master_data=array();
                            $event_schedule_master_data=array();
                            $event_show_time_master_data=array();

                            foreach ($all_users as $user) {
                                $user_data[$user->id]=$user->name;
                            }

                            $pm_data=getAllPaymentMethod(); 
                            $pm_data_final=array();
                            foreach($pm_data as $pm_single)
                            {   
                                $pm_data_final[$pm_single->id]=$pm_single;
                            }
                            ?>
                            @if($bookings && $count==2)
                            @foreach($bookings as $key => $booking)
                            <tr>

                                <td>{{ $booking->id }}</td>
                                <td><?php echo date('D d-M-Y h:i A', strtotime ($booking->created_at)); ?></td>

                                <?php 
                                $customer_id=$booking->customer_id; 
                                $customer_data=getCustomer($customer_id);

                                if($customer_data->customer_name =='Walk In Customer')
                                {
                                    $customer_name='N/A';
                                }
                                else
                                {
                                    $customer_name=$customer_data->customer_name;
                                }

                                if($customer_data->mobile_no =='0000000000')
                                {
                                    $mobile_no='N/A';
                                }
                                else
                                {
                                    $mobile_no=$customer_data->mobile_no;
                                }
                                 $email=$customer_data->email;

                                ?>

                                <td>{{ $customer_name }}</td>
                                <td>{{ $mobile_no }}</td>
                                <td>{{ $email }}</td>

                                <td style="width:70px">
                                    <?php 
                                    $booking->encrypt_id=simple_crypt($booking->id); 
                                    $esl_id=$booking->event_schedule_list_id;

                                    if(empty($event_schedule_master_data[$esl_id]))
                                    {
                                       $event_schedule_master_data[$esl_id]=getEventScheduleList($esl_id)->event_date;
                                    }
                                    
                                    $event_date =  $event_schedule_master_data[$esl_id]; 

                                    if($event_date)
                                    {
                                        echo date('D d-M-Y', strtotime ($event_date));
                                    }
                                    ?>
                                </td>




                                <td style="width: 70px">
                                    <?php 
                                    $est_id=$booking->event_show_time_id;
                                    if(empty($event_show_time_master_data[$est_id]))
                                    {
                                        $est_data_temp=getEventShowTime($est_id);
                                        $event_show_time_master_data[$est_id]= $est_data_temp->start_time.' - '.$est_data_temp->end_time ;
                                    }
                                    
                                    echo $event_show_time =  $event_show_time_master_data[$est_id]; 
                                    
                                    ?>
                                </td>


                                <td style="width:100px">
                                <?php 
                                $booking_details_data=fetch_booking_details_data($booking->id); 
                                foreach ($booking_details_data as $single_data) {
                                    echo $single_data->ticket_type_name.' : '.$single_data->total_ticket.' Ticket(s) <br>';
                                    $footer_ticket[]=$single_data->total_ticket;

                                }

                               

                                $seat_arr=array();
                                $seat_data=fetch_all_seat_by_booking_id($booking->id); 
                                foreach ($seat_data as $single_data) {
                                    $row_no = $single_data->row_no;

                                    $lid=$single_data->layout_id;
                                    if(empty($layout_master_data[$lid]))
                                    {
                                       $layout_master_data[$lid]=getLayout($lid)->layout_row_label;
                                    }

                                    // $layout_row_label =  $layout_master_data[$lid]; 
                                    // $layout_row_label=explode(',', $layout_row_label);
                                    // $row_name=$layout_row_label[$row_no-1];
                                    $seat_arr[]=$single_data->label.$single_data->name;
                                }

                                echo implode(', ', $seat_arr);

                                $footer_total[]=$booking->grand_total;
                                $footer_discount[]=$booking->discount;
                                $footer_paid[]=$booking->grand_total-$booking->discount;


                                ?></td>
                                <td>{{ $booking->grand_total }}</td>
                               
                                

                                 <td>
                                    <?php 
                                    if(isset($booking->vendor_id)  && $booking->vendor_id!=null)
                                    {
                                        $vendor_id=$booking->vendor_id;
                                        echo $user_data[$vendor_id];
                                    }
                                    else
                                    {
                                        echo 'Customer';
                                    }
                                   
                                    ?>
                                </td>
                                
                                
                                
                                
                                <td>
                                    <?php 
                                    echo $booking->issued_by;
                                    ?>
                                </td>
                                
                                 <td>
                                    <?php 
                                    echo $booking->guest_designation;
                                    ?>
                                </td>
                                

                                <!-- <td>{{ $booking->status }}</td> -->
                                <td class="text-center" style="width:80px">
                                    <a class="btn btn-info btn-sm" target="_blank" href="{{ route('reports.print_ticket',$booking->id) }}"><i class="fa fa-print"></i>  </a>
                                    <a class="btn btn-info btn-sm" target="_blank" href="{{ route('reports.booking_detail',$booking->id) }}" style="float:left"><i class="fa fa-eye"></i></a>

                                    

                                </td>
                            </tr>
                            @endforeach
                            @endif


                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align:right" colspan="7">Total</th>
                                <th>{{array_sum($footer_ticket)}}</th>
                                <th>{{array_sum($footer_total)}}</th>
                     
                            
                                <th colspan="4"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<?php 
// echo "<pre>";
// print_r($layout_master_data);
?>
@endsection

@section('js')
<!-- Data table plugin-->
<script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/confirm_delete.js') }}"></script>


<!-- Data table plugin-->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


<script>
    $('#userTable').DataTable( {
        
        dom: 'Blfrtip',
                "bPaginate": true,
                "bSort": true,
            buttons: [
                'excel',  'print'
            ]
        });
</script>

<script>

    $('document').ready(function () {
    var event_id= $('select#event_id option:selected').val();
    get_event_schedule_by_event_id(event_id);

    setTimeout(function () {
            var event_schedule_id= $('select#event_schedule_id option:selected').val();
            get_event_schedule_list_by_event_schedule_id(event_schedule_id);
        }, 2000);
    });
    

    //get event schedule by event id
    function get_event_schedule_by_event_id(event_id) {
        


        if (event_id != '' && event_id > 0) {
            var data = {
                _token: '{{ csrf_token() }}',
                event_id: event_id
            };

            $.ajax({
                type: 'POST',
                url: '{{ route("event_schedules.get_event_schedule_by_event_id") }}',
                data: data,
                dataType: 'json',
                success: function(response) {
                    $('#event_schedule_id').empty();

                    $('#event_schedule_list_id').empty();
                    $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">All Event Show Time</option>');

                    $.each(response, function(key, value) {
                       $('#event_schedule_id').append('<option value="' + value.id + '">' + value.start_date + ' - ' + value.end_date + '</option>');
                    });
                }
            });


            setTimeout(function () {
                var event_schedule_id= $('select#event_schedule_id option:selected').val();
                get_event_schedule_list_by_event_schedule_id(event_schedule_id);
            }, 500);


        } else {
            $('#event_schedule_id').empty();
            $('#event_schedule_list_id').empty();
            $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">All Event Show Time</option>');
        }
    }

    //get event shedule list by event shedule id
    function get_event_schedule_list_by_event_schedule_id(event_schedule_id) {

        var esd_id_get=<?php if(isset($esd_id)) { echo $esd_id ;} else {echo "''";} ?>;
        var est_id_get=<?php if(isset($est_id)) { echo $est_id ;} else {echo "''";} ?>;


        if (event_schedule_id != '' && event_schedule_id > 0) {
            var data = {
                _token: '{{ csrf_token() }}',
                event_schedule_id: event_schedule_id
            };

            $.ajax({
                type: 'POST',
                url: '{{ route("event_schedules.get_event_schedule_list_by_event_schedule_id") }}',
                data: data,
                dataType: 'json',
                success: function(response) {
                    $('#event_schedule_list_id').empty();
                    $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');
                    $.each(response.event_schedule_lists, function(key, value) {
                         if(value.id==esd_id_get)
                        {
                            $('#event_schedule_list_id').append('<option value="' + value.id + '" selected>' + value.event_date + '</option>');
                        }
                        else
                        {
                            $('#event_schedule_list_id').append('<option value="' + value.id + '">' + value.event_date + '</option>');
                        }
                    });

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">All Event Show Time</option>');

                    $.each(response.event_show_times, function(key, value) {
                        if(value.id==est_id_get)
                        {
                            $('#event_show_time_id').append('<option value="' + value.id + '" selected>' + value.start_time + ' - ' + value.end_time + '</option>');
                        }
                        else
                        {
                            $('#event_show_time_id').append('<option value="' + value.id + '">' + value.start_time + ' - ' + value.end_time + '</option>');
                        }
                    });
                }
            });
        } else {
            $('#event_schedule_list_id').empty();
            $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">All Event Show Time</option>');
        }
    }

$(document).ready(function() {
    // $('#sidebar_hide').css('display', 'none');
    $('#body').addClass('sidenav-toggled');

    

});


function get_layout_by_show_time()
    {
        var event_show_time_id=$('select#event_show_time_id option:selected').val();
        var event_schedule_list_id=$('select#event_schedule_list_id option:selected').val();
        var event_schedule_id=$('select#event_schedule_id option:selected').val();
        var event_id=$('select#event_id option:selected').val();


         //console.log(event_schedule_list_id);
        if (event_schedule_list_id != '' && event_schedule_list_id > 0) {
            var data = {
                _token: '{{ csrf_token() }}',
                event_schedule_list_id: event_schedule_list_id,
                event_show_time_id: event_show_time_id,
                event_schedule_id: event_schedule_id,
                event_id: event_id
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('event_ticket.get_layout_by_show_time_id') }}',
                data: data,
                dataType: 'json',
                success: function(response) {
                    $('#layout_id').empty();
                     $('#layout_id').append('<option value="' + response.layout.id + '">' + response.layout.layout_name +'</option>');
                     $('#venue_id').val(response.layout.venue_id);
                }
            });
        } else {

            $('#layout_id').empty();
        }
    }
</script>
@endsection