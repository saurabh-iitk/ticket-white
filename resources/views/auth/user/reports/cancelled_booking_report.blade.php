@extends('layouts.dashboard')

@section('title', 'Cancelled Booking Report')

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
            <h1><i class="fa fa-bar-chart"></i>Cancelled Booking Report</h1>
        </div>
    </div>

    <!-- include search -->
    <form action="{{ url($form_url) }}" method="GET">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                            <label for="for">Event <span class="required">*</span></label>
                            <select class="form-control" name="event_id" id="event_id" autofocus="true" onchange="get_event_schedule_by_event_id(this.value);">
                                <?php 
                                foreach($events as $key => $event){
                                ?>
                                <option value="<?php echo $event->id; ?>" <?php if($event->id==$event_id) {echo 'selected';}?>><?php echo $event->event_title; ?></option>
                                <?php 
                            }?>
                            </select>
                        </div>
                        </div>


                      
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="for" style="margin-top: 42px;"></label>
                                <input type="submit" class="btn btn-primary pl-4 pr-4" name="Filter" value="Filter" />
                                <a href="{{ route($reset_url) }}" class="btn btn-info pl-4 pr-4" style="margin-left: 5px;">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <!-- include search -->

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
                    <h4 style="color:red">Note: Please Choose Event & click on Filter</h4><br>
                     @endif
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Trans. Date</th>
                                <th>Event</th>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Mobile No</th>
                                <th style="width:70px">Show Date</th>
                                <th style="width:70px">Show Time</th>
                                <th style="width:100px">Ticket(s)</th>
                                <th style="width:70px">Seat(s)</th>
                                <th>Total Amount</th>
                                <th>Total Discount</th>
                                <th>Total Paid</th>
                                <th>Paid By</th>
                                <th>Booked By</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            $user_data=array();

                            $all_users=getUser();

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
                                <td><?php 

                                $customer_id=$booking->customer_id; 
                                $customer_data=getCustomer($customer_id);

                                if($customer_data->mobile_no =='0000000000')
                                {
                                    $customer_data->mobile_no ='N/A';
                                }

                                    echo date('D d-M-Y h:i A', strtotime ($booking->created_at)); ?></td>


                                <td>@if(getEvent($booking->event_id)){{ getEvent($booking->event_id)->event_title }}@endif</td>

                                  <td>{{ $customer_data->customer_name }}</td>
                                  <td>{{ $customer_data->email }}</td>
                                  <td>{{ $customer_data->mobile_no }}</td>


                                <td style="width:70px">
                                    <?php 
                                    $booking->encrypt_id=simple_crypt($booking->id); 
                                    $schedule_list_data=getEventScheduleList($booking->event_schedule_list_id);

                                    if($schedule_list_data)
                                    {
                                        $event_date=$schedule_list_data->event_date; 
                                        echo date('D d-M-Y', strtotime ($event_date));
                                    }
                                    ?>
                                </td>

                                <td style="width: 70px">@if(getEventShowTime($booking->event_show_time_id))
                                    {{ getEventShowTime($booking->event_show_time_id)->start_time.' - '.getEventShowTime($booking->event_show_time_id)->end_time }}
                                    @endif
                                </td>

                                <td style="width:100px">
                                <?php 
                                $booking_details_data=fetch_booking_details_data_deleted($booking->id); 
                                foreach ($booking_details_data as $single_data) {
                                    echo $single_data->ticket_type_name.' : '.$single_data->total_ticket.' Ticket(s) <br>';
                                }
                                $seat_arr=array();
                                $seat_data=fetch_all_seat_by_booking_id($booking->id); 
                                foreach ($seat_data as $single_data) {
                                    $row_no = $single_data->row_no;
                                    // $layout_row_label = getLayout($single_data->layout_id)->layout_row_label; 
                                    // $layout_row_label=explode(',', $layout_row_label);
                                    // $row_name=$layout_row_label[$row_no-1];
                                    $seat_arr[]=$single_data->label.$single_data->name;
                                }

                                echo implode(', ', $seat_arr);
                                ?></td>
                                <td>{{ $booking->seat_details }}</td>
                                  <td>{{ $booking->grand_total }}</td>
                                <td>{{ $booking->discount }}</td>
                                <td>{{ $booking->grand_total-$booking->discount }}</td>
                                <td>
                                <?php 
                                $payment_method_id=fetch_booking_payments_data_deleted($booking->id)->payment_method_id; 
                                echo $payment_method_name=$pm_data_final[$payment_method_id]->name; 
                                ?>
                                </td>

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
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/confirm_delete.js') }}"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


<script>
    $('#userTable').DataTable( {
            dom: 'Blfrti',
                "bPaginate": false,
                "bSort": false,
            buttons: [
                'excel',  'print'
            ]
        });
</script>

<script>
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
                    $('#event_schedule_id').append('<option value="">All Event Schedule</option>');

                    $('#event_schedule_list_id').empty();
                    $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">All Event Show Time</option>');

                    $.each(response, function(key, value) {
                        $('#event_schedule_id').append('<option value="' + value.id + '">' + value.start_date + ' - ' + value.end_date + '</option>');
                    });
                }
            });
        } else {
            $('#event_schedule_id').empty();
            $('#event_schedule_id').append('<option value="">All Event Schedule</option>');

            $('#event_schedule_list_id').empty();
            $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">All Event Show Time</option>');
        }
    }

    //get event shedule list by event shedule id
    function get_event_schedule_list_by_event_schedule_id(event_schedule_id) {
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
                        $('#event_schedule_list_id').append('<option value="' + value.id + '">' + value.event_date + '</option>');
                    });

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">All Event Show Time</option>');

                    $.each(response.event_show_times, function(key, value) {
                        $('#event_show_time_id').append('<option value="' + value.id + '">' + value.start_time + ' - ' + value.end_time + '</option>');
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

</script>
@endsection