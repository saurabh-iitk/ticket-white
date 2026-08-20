@extends('layouts.dashboard')
@section('title', 'Sale Summary Report')
@section('css')
@endsection

@section('content')
<style>
    table,
    th,
    td, thead {
       border: 2px solid black !important;
      padding: 2px !important;
    }
</style>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-bar-chart"></i>Sale Summary Report</h1>
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
                    <table class="table table-hover table-bordered" id="userTable">
                       <thead style="background-color:#a8a8a8;" width="100">
                           <th colspan="3" class="text-center">Payment Mode</th>
                       </thead>
                        <thead style="background-color:#a8a8a8;">
                            <tr>
                                <th width="100">S.No.</th>
                                <th width="600">Payment Type</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
                            $net_total = 0;
                            $grand_total = 0;
                            ?>
                            @if($bookings)
                                <?php 
	                                foreach($bookings as $key => $booking):
	                                $total_amount = $booking->total_amount;
	                                $net_total = $net_total+$total_amount;
	                                $grand_total = number_format($net_total,2);
                                ?>
                                   
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                    	
                                        <td>@if(getPaymentMethod($booking->payment_method_id)){{ getPaymentMethod($booking->payment_method_id)->name }}@endif</td>
										
										<td class="text-right">{{ $total_amount }}</td>
                                       
                                    </tr>
                                <?php 
                            		endforeach; 
                            	?>
                            @endif
                        </tbody>
                        <tfoot>
                        	<tr>
                                <th colspan="2" class="text-right">Grand Total</th>
                                <td class="text-right">{{ $grand_total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                  
                  <!--- no. of ticket sale -->
                   <table class="table table-hover table-bordered" id="userTable">
                       <thead style="background-color:#a8a8a8;">
                           <th colspan="3" class="text-center">No. Of Ticket Sale</th>
                       </thead>
                        <thead style="background-color:#a8a8a8;">
                            <tr>
                                <th width="100">S.No.</th>
                                <th width="600">Ticket Type Name</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
                            $total_quantity= 0;
                            ?>
                            @if($tickets)
                                <?php                         
	                                foreach($tickets as $key => $ticket):	                             
                                ?>
                                   
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                    	
                                        <td>@if(getTicketType($ticket->ticket_type_id)){{ getTicketType($ticket->ticket_type_id)->ticket_type_name }}@endif</td>
									
										<td class="text-right">
                                          <?php 
                                          if(getTicketQuantity($ticket->ticket_type_id)){
                                            //$total_quan = getTicketQuantity($ticket->ticket_type_id)->totalQuantity;
                                             echo $total_quan=$ticket->total_quantity;
                                             $total_quantity = $total_quantity + $total_quan;
                                          }
                                          ?>
                                         </td>
                                    </tr>
                                <?php 
                            		endforeach; 
                            	?>
                            @endif
                        </tbody>
                        <tfoot>
                        	<tr>
                                <th colspan="2" class="text-right">Grand Total</th>
                                <td class="text-right">{{ $total_quantity }}</td>
                            </tr>
                        </tfoot>
                    </table>
                  <!--- total sale --->
                    <table class="table table-hover table-bordered" id="userTable">
                       <thead style="background-color:#a8a8a8;">
                           <th colspan="3" class="text-center">Total Sales</th>
                       </thead>
                        <thead style="background-color:#a8a8a8;">
                            <tr>
                                <th width="100">S.No.</th>
                                <th width="600">Ticket Type Name</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
                            $totalAmount= 0;
                            $total_amount=0;
                            ?>
                            @if($tickets)
                                <?php                         
	                                foreach($tickets as $key => $ticket):	                             
                                ?>
                                   
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                    	
                                        <td>@if(getTicketType($ticket->ticket_type_id)){{ getTicketType($ticket->ticket_type_id)->ticket_type_name }}@endif</td>
									
										<td class="text-right">
                                          <?php 
                                          if(getTicketAmount($ticket->ticket_type_id)){
                                            //$total_amount = getTicketAmount($ticket->ticket_type_id)->totalPrice;
                                            
                                            echo $total_amount= $ticket->total_ticket_price; 
                                          
                                             $totalAmount = $totalAmount + $total_amount;
                                          }
                                          ?>
                                         </td>
                                    </tr>
                                <?php 
                            		endforeach; 
                            	?>
                            @endif
                        </tbody>
                        <tfoot>
                        	<tr>
                                <th colspan="2" class="text-right">Grand Total</th>
                                <td class="text-right">{{ number_format($totalAmount,2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                  <!--- ticket by mode -->
                    <table class="table table-hover table-bordered" id="userTable" style="display:none" >
                       <thead style="background-color:#a8a8a8;">
                           <th colspan="3" class="text-center">Ticket By Mode</th>
                       </thead>
                        <thead style="background-color:#a8a8a8;">
                            <tr>
                                <th width="100">S.No.</th>
                                <th width="600">PayMode</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
                            $complementry_grand_total = 0;
                            $full_amount=0;
                            ?>
                            @if($payments_complementry)
                                <?php 
	                                foreach($payments_complementry as $key => $payment):
                                ?>                                  
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                    	
                                        <td><?php echo $payment->method_type; ?></td>
										
										<td class="text-right">
                                        <?php 
                                  
                                          if(getPaymentMethodAmount($payment->payment_method_id)){
                                            $total_amount = getPaymentMethodAmount($payment->payment_method_id)->total_amount;
                                         
                                            echo $total_amount= $payment->totalAmount; 
                                             $complementry_grand_total = $complementry_grand_total + $total_amount;
                                          }
                                          ?>
                                        </td>
                                    </tr>
                                <?php 
                            		endforeach; 
                            	?>
                            @endif
                        
                        </tbody>
                        <tfoot>
                        	<tr>
                                <th colspan="2" class="text-right">Grand Total</th>
                                <td class="text-right">
                                  <?Php $fullAmount = $complementry_grand_total + $full_amount; ?>
                                  
                                  {{ number_format($fullAmount, 2) }}</td>
                            </tr>
                        </tfoot>
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
                    $('#event_schedule_id').append('<option value="">All Event Schedule</option>');

                    $('#event_schedule_list_id').empty();
                    $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">All Event Show Time</option>');

                    $.each(response, function(key,value){
                        $('#event_schedule_id').append('<option value="'+ value.id +'">'+ value.start_date+' - '+value.end_date+'</option>');
                    });
                }
            });
        }
        else
        {
            $('#event_schedule_id').empty();
            $('#event_schedule_id').append('<option value="">All Event Schedule</option>');
            
            $('#event_schedule_list_id').empty();
            $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">All Event Show Time</option>');
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
                url : '{{ route('event_schedules.get_event_schedule_list_by_event_schedule_id') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#event_schedule_list_id').empty();
                    $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');
                    $.each(response.event_schedule_lists, function(key,value){
                        $('#event_schedule_list_id').append('<option value="'+ value.id +'">'+ value.event_date+'</option>');
                    });

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">All Event Show Time</option>');

                    $.each(response.event_show_times, function(key,value){
                        $('#event_show_time_id').append('<option value="'+ value.id +'">'+ value.start_time+' - '+value.end_time+'</option>');
                    });
                }
            });
        }
        else
        {
            $('#event_schedule_list_id').empty();
            $('#event_schedule_list_id').append('<option value="">All Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">All Event Show Time</option>');
        }
    }
</script>
@endsection