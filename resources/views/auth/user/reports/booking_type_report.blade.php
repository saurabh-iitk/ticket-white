@extends('layouts.dashboard')

@section('title', 'Booking Type Report')

@section('css')

@endsection

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-bar-chart"></i> Booking Type Report</h1>
            </div>
        </div>

        <!-- include search -->
        @include('auth/user/reports/search')
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
                        @if ($e_id)
                            <table class="table table-hover table-bordered" id="userTable">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>User Name</th>
                                        <th>Payment Type</th>
                                        <th>Total</th>
                                        <!-- <th width="180px">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $net_total = 0;
                                    $grand_total = 0;
                                    ?>
                                    @if ($bookings)
                                        <?php 
	                                foreach($bookings as $key => $booking):
	                                $total_amount = $booking->total_amount;
	                                $net_total = $net_total+$total_amount;
	                                $grand_total = number_format($net_total,2);
                                ?>
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if (getCustomer($booking->customer_id))
                                                    {{ getCustomer($booking->customer_id)->customer_name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (getPaymentMethod($booking->payment_method_id))
                                                    {{ getPaymentMethod($booking->payment_method_id)->name }}
                                                @endif
                                            </td>

                                            <td>{{ $total_amount }}</td>

                                            <!-- <td class="text-center">
                                                        <a class="btn btn-info btn-sm" href="{{ route('reports.booking_detail', $booking->id) }}">View Details</a>
                                                    </td> -->
                                        </tr>
                                        <?php 
                            		endforeach; 
                            	?>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Grand Total</th>
                                        <td>{{ $grand_total }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
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
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


<script>
    $('#userTable').DataTable( {
            dom: 'Blfrtip',
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
    </script>
@endsection
