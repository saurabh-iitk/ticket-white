@extends('layouts.dashboard')

@section('title', 'Payment Gateway Transaction Report')

@section('css')

@endsection

@section('content')
    <style>
        .table th,
        .table td {
            padding: 4px !important;
        }

            table,   table td, table th {
            font-size: 12px;
            padding: 5px;
            border: 1px solid black; 
            text-align: center;
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-bar-chart"></i> Payment Gateway Transaction Report</h1>
            </div>
        </div>

{{date('D-m-y h:i:s A')}}
        <!-- include search -->
        <!-- include search -->

        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <!-- include message -->
                        @include('../../partials/message')
                        <!-- include message -->
                        <div class="tile">
                            <div class="tile-body">
                                <form action="{{ url('reports/pg_transaction_report') }}" method="GET">
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="for">Event</label>
                                            <select class="form-control" name="e_id" id="event_id" autofocus="true"
                                                style="width:300px">
                                                @if (isset($events))
                                                    @foreach ($events as $key => $event)
                                                        <option value="{{ $event->id }}" <?php echo $e_id != null && $e_id == $event->id ? 'selected' : ''; ?>>
                                                            {{ $event->event_title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
    
    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="for">From</label>
                                             <input type="date" name="start_date" class="form-control" min="2022-01-01" max="2030-12-31" value="<?php echo $start_date;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="for">To</label>
                                            <input type="date" name="end_date" class="form-control" min="2022-01-01" max="2030-12-31" value="<?php echo $end_date;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="for" style="margin-top: 42px;"></label>
                                            <input type="submit" class="btn btn-primary pl-4 pr-4 pull-righ" name="Filter" value="Filter" />
                                              <a href="{{ URL::to('reports/pg_transaction_report') }}"
                                                            class="btn btn-info pl-4 pr-4 pull-right"
                                                            style="margin-top: 26px;">Reset</a>
                                          
                                        </div>
                                    </div>
                                    
                                

                                    <div class="col-sm-3 col-md-5 mt-4 pull-right">
                                        @if (in_array('reports/pg_transaction_report', Session::get('permissions')->toArray()))
                                            <div class="row">
                                                <div class="col-md-12 pb-4 text-right">
                                                    <a href="{{ URL::to('reports/pg_transaction_report') }}"
                                                        class="btn btn-info pl-5 pr-5">Add</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


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
                                    <th>Show DateTime</th>
                                    <th style="width:100px">Ticket Type</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Amount</th>
                                    <th>Source</th>
                                    <th>SW Transaction ID</th>
                                    <th>PG Transaction ID</th>
                                    <th>Status</th>
                                    <th>Payment </th>
                                    <th>Entrytime</th>
                                    <!-- <th width="180px">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $net_total = 0;
                                $grand_total = 0;
                                $i = 0;
                                ?>
                                @if ($payment_transactions)
                                    <?php 
	                                foreach($payment_transactions as $payment_transaction)
                                    {

                                        $amount = number_format($payment_transaction->amount, 2);
	                                    $discount = number_format($payment_transaction->discount, 2);

                                        $event_name=$payment_transaction->event_name;
                                        $event_show=$payment_transaction->event_show;
                                        $ticket_type_name=$payment_transaction->ticket_type_name;
                                        $quantity=$payment_transaction->quantity;
                                        $email=$payment_transaction->email;
                                        $name=$payment_transaction->name;
                                        $mobile=$payment_transaction->mobile;
                                        $find_us=$payment_transaction->find_us;
                                        $txnid=$payment_transaction->txnid;
                                        $pg_txn=$payment_transaction->pg_txn;
                                        $status=$payment_transaction->status;
                                        $booking_id=$payment_transaction->booking_id;
                                        $seat_details=$payment_transaction->seat_details;
                                        $booked_by_cron=$payment_transaction->booked_by_cron;
                                        $seat_details='( '.$seat_details.' )';

                                        $note=$payment_transaction->note;
                                        if(!empty($note))
                                        {
                                            $note=json_decode($note, true);
                                            if(!empty($note['status']))
                                            {
                                                $pg_status=$note['status'];
                                            }
                                            else
                                            {
                                                $pg_status=$payment_transaction->status;
                                            }
                                        }
                                        else 
                                        {
                                            $pg_status=$payment_transaction->status;
                                        }

                                        $created_at=date('d-m-y h:i:s A', strtotime($payment_transaction->created_at));


                                    ?>
                                    <tr <?php if($booked_by_cron=='YES') {echo 'style="background:#dee4e3"'; }?>>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $event_name }}</td>
                                        <td>{{ $event_show }}</td>
                                        <td style="width:100px">{{ $ticket_type_name }} - {{ $quantity }} <Br>                                        {{$seat_details}}
                                        <td>{{ $name }}</td>
                                        <td>{{ $email }}</td>
                                        <td onclick="fetch_payment_logs('{{ $mobile }}', '{{ $email }}')" style=" color: #460ddf;cursor:pointer ">{{ $mobile }}</td>
                                        <td>{{ $amount }}</td>
                                          <td>{{ $find_us }}</td>
                                        
                                        <td>{{ $txnid }}</td>
                                        <td>{{ $pg_txn }}</td>
                                        <td>{{ $status }}</td>
                                        <td>{{ $pg_status }}</td>
                                        <td>{{ $created_at }}</td>
                                    </tr>
                                    <?php 
                                $i++;
                            		} 
                            	?>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content" style=" width: 217%; left: -57%;" >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment Logs</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
          Please Wait...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
        </div>
      </div>
    </div>
</div>


@section('js')
    <!-- Data table plugin-->
    <script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


    <script>
        $('#userTable').DataTable( {
     //       order: [[12, 'desc']],
                dom: 'Blfrtip',
                    "bPaginate": true,
                    
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
                    url: '{{ route('event_schedules.get_event_schedule_by_event_id') }}',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        $('#event_schedule_id').empty();
                        $('#event_schedule_id').append('<option value="">All Event Schedule</option>');

                        $('#event_schedule_list_id').empty();
                        $('#event_schedule_list_id').append(
                            '<option value="">All Event Schedule Date</option>');

                        $('#event_show_time_id').empty();
                        $('#event_show_time_id').append('<option value="">All Event Show Time</option>');

                        $.each(response, function(key, value) {
                            $('#event_schedule_id').append('<option value="' + value.id + '">' + value
                                .start_date + ' - ' + value.end_date + '</option>');
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
                    url: '{{ route('event_schedules.get_event_schedule_list_by_event_schedule_id') }}',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        $('#event_schedule_list_id').empty();
                        $('#event_schedule_list_id').append(
                            '<option value="">All Event Schedule Date</option>');
                        $.each(response.event_schedule_lists, function(key, value) {
                            $('#event_schedule_list_id').append('<option value="' + value.id + '">' +
                                value.event_date + '</option>');
                        });

                        $('#event_show_time_id').empty();
                        $('#event_show_time_id').append('<option value="">All Event Show Time</option>');

                        $.each(response.event_show_times, function(key, value) {
                            $('#event_show_time_id').append('<option value="' + value.id + '">' + value
                                .start_time + ' - ' + value.end_time + '</option>');
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



        function fetch_payment_logs(mobile_no, email_id)
        {
            $('#exampleModal').modal('show');
            var data = {
                _token: '{{ csrf_token() }}',
                mobile_no: mobile_no,
                email_id: email_id
            };

            $.ajax({
                type: 'POST',
                url: '{{ route("payment_logs_ajax") }}',
                data: data,
                success: function(response) {
                    $('#exampleModal').modal('show');
                    $('.modal-body').html(response);
                }
            });
        }
        $('#body').addClass('sidenav-toggled');
    </script>
@endsection
