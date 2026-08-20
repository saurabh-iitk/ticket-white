@extends('layouts.dashboard')
@section('title', 'Scan Show Wise Report')
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
            <h1><i class="fa fa-bar-chart"></i> Scan Summary Show Wise Report</h1>
        </div>
    </div>


    <!-- include search -->
    <form action="{{ url($form_url) }}" method="GET">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-2">
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


                        <div class="col-md-2" style="display: none;">
                            <div class="form-group">
                                <label for="for">Event Schedule <span class="required">*</span></label>
                                <select class="form-control" name="es_id" id="event_schedule_id" onchange="get_event_schedule_list_by_event_schedule_id(this.value);">
                                </select>
                            </div>
                        </div>




                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="for">Event Show Time <span class="required">*</span></label>
                                <select class="form-control" name="event_show_time_id" id="event_show_time_id" style="width:100%;">
                                </select>
                            </div>
                        </div>



                       @if($is_admin == 1)
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="for">User</label>
                                <select class="form-control" name="u_id" id="user_id">
                                    <option value="">All User</option>
                                    
                                    
                                    @if(isset($users_data))
                                     @foreach($users_data as $user)
                                    <option value="{{$user->id}}" <?php echo ($u_id != null && $u_id == $user->id) ? 'selected' : '';?>>{{$user->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @else
                        <!-- <input type="hidden" name="u_id" value="{{ \Auth::user()->id }}"> -->
                        @endif

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

                    <?php if(isset($event_id)) {
                    
                     $all_payment_methods=getAllPaymentMethod();
                     
                     ?>
                   

                    <table class="table table-hover table-bordered table-striped" id="show_date_table3" style="overflow:scroll;width: 100%;">
                        <thead>
                            <tr  style="background-color:#4ec5ed;">
                                <th class="text-center" colspan="<?php $cols = count($all_payment_methods)+2;  echo $cols;?>">Ticket Count Summary</th>
                            </tr> 
                            <tr style="background-color:#c9eaf5">
                                <th class="text-center">Show Date</th>
                                <?php
                               
                                $t_sale=array();
                                $t_scan_sale=array();
                                $t_discount=array();
                                $n_total=array();

                                $payment_method_data=array();
                                $all_payment_methods=getAllPaymentMethod();
                                foreach($all_payment_methods as  $single_data){
                                    $temp_arr=array();
                                    $temp_arr['id']=$single_data->id;
                                    $temp_arr['name']=$single_data->name;
                                    $temp_arr['method_type']=$single_data->method_type;
                                    $payment_method_data[]=$temp_arr;
                                    ?>
                                        <th class="text-center">{{ $single_data->name }}</th>
                                <?php 
                                      }
                                ?>
                                <th class="text-center">Total Ticket </th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php 
                                    $event_data=array();
                                     foreach($sale_sum_data as $single_data)
                                     {
                                        
                                        $temp_arr=array();
                                        $temp_arr['id']=$single_data->id;
                                        $temp_arr['name']=$single_data->name;
                                        $temp_arr['total_ticket_quantity']=$single_data->total_ticket_quantity;
                                        $temp_arr['scanned_ticket_quantity']=$single_data->scanned_ticket_quantity;
                                        $event_data[$single_data->event_show][]=$temp_arr;
                                     }

                                    foreach($event_data as $date => $single_data)
                                    {
                                    ?>
                                    <tr>
                                        <th class="text-center">{{ $date }}</th>
                                        <?php 
                                        $total_amount_arr=array();
                                        $total_scan_amount_arr=array();
                                        $paid_amount_arr=array();
                                        $net_amount_arr=array();
                                        $discount_arr=array();
                                        $cash_arr=array();
                                        $upi_arr=array();

                                        
                                        foreach($payment_method_data as  $single_method)
                                        {
                                            $method_found=false;
                                            foreach ($single_data as  $single_summary)
                                            {
                                                if($single_summary['id']==$single_method['id'])
                                                {
                                                   
                                                    $method_found=true;
                                                    $total_amount=$single_summary['total_ticket_quantity'];
                                                    $scanned_ticket_quantity = $single_summary['scanned_ticket_quantity'];
                                                    $total_amount_arr[]=$total_amount;
                                                    $total_scan_amount_arr[]=$scanned_ticket_quantity;
                                                    
                                                    $total_amount=number_format($total_amount);
                                                    echo '<td class="text-center">'.$scanned_ticket_quantity.'/'.$total_amount.'</td>';

                                                    if($single_method['id']==2 || $single_method['id']==4)
                                                    {
                                                         $cash_arr[]=$single_summary['total_ticket_quantity'];
                                                    }

                                                    if($single_method['id']==1 || $single_method['id']==5)
                                                    {
                                                         $upi_arr[]=$single_summary['total_ticket_quantity'];
                                                    }
                                                }
                                                else
                                                {
                                                    // echo '<td class="text-center">0</td>';
                                                }
                                            }
                                            if(!$method_found)
                                            {
                                                echo '<td class="text-center">0/0</td>';
                                            }
                                        }


                                        $total_amount_arr=array_sum($total_amount_arr);
                                        $t_sale[]=$total_amount_arr;
                                        $total_amount_arr=number_format($total_amount_arr);
                                        
                                        
                                        $total_scan_amount_arr=array_sum($total_scan_amount_arr);
                                        $t_scan_sale[]=$total_scan_amount_arr;
                                        $total_scan_amount_arr=number_format($total_scan_amount_arr);
                                        
                                        echo '<th class="text-center">'.$total_scan_amount_arr.'/'.$total_amount_arr.'</th>';
                                        ?>
                                    </tr>
                            <?php } ?>



                            <?php 
                                $t_sale=array();
                                $t_scan_sale=array();
                                echo '<tr><th class="text-center">Total</th>';

                                foreach($all_payment_methods as $ttype)
                                {
                                    $method_found=false;
                                    foreach($ticket_sum_total as $single_total)
                                    {
                                        if($single_total['id']==$ttype['id'])
                                        {
                                            $method_found=true;
                                            $total_ticket_quantity=$single_total->total_ticket_quantity;
                                            $scanned_ticket_quantity=$single_total->scanned_ticket_quantity;
                                            echo '<th class="text-center">'.number_format($scanned_ticket_quantity).'/'.number_format($total_ticket_quantity).'</th>';
                                            $t_sale[]=$total_ticket_quantity;
                                            $t_scan_sale[]=$scanned_ticket_quantity;
                                        }
                                    }
                                    if(!$method_found)
                                    {
                                        echo '<td class="text-center">0/0</td>';
                                    }
                                }
                                echo '<th class="text-center">'.number_format(array_sum($t_scan_sale)).'/'.number_format(array_sum($t_sale)).'</th></tr>';
                            ?>


                        </tbody>
                    </table>

                    <br><br><hr>

                    <table class="table table-hover table-bordered table-striped" id="show_date_table3" style="overflow:scroll;width: 100%;">
                        <thead>
                            <tr  style="background-color:#4ec5ed;">
                                <th class="text-center" colspan="9">Ticket Type Summary</th>
                            </tr> 
                            <tr style="background-color:#c9eaf5">
                                <th class="text-center">Show Date</th>
                                <?php
                                $ticket_type_data=array();
                                $all_ticket_type=getTicketTypeByEventID($event_id);
                                foreach($all_ticket_type as  $single_data)
                                {
                                    $single_data->ticket_type_name;
                                    $temp_arr=array();
                                    $temp_arr['id']=$single_data->id;
                                    $temp_arr['name']=$single_data->ticket_type_name;
                                    $ticket_type_data[]=$temp_arr;
                                    ?>
                                        <th class="text-center">{{ $single_data->ticket_type_name }}</th>
                                <?php } ?>
                                <th class="text-center">Total Ticket </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $event_data=array();
                             foreach($ticket_count as $single_data)
                             {
                                $temp_arr=array();
                                $temp_arr['id']=$single_data->id;
                                $temp_arr['name']=$single_data->name;
                                $temp_arr['total']=$single_data->total_ticket_quantity;
                                $temp_arr['event_show_time_id']=$single_data->event_show_time_id;
                                $temp_arr['event_schedule_list_id']=$single_data->event_schedule_list_id;
                                $temp_arr['scanned_ticket_quantity']=$single_data->scanned_ticket_quantity;
                                $event_data[$single_data->event_show][]=$temp_arr;
                             }
                            foreach($event_data as $date => $single_data)
                            {
                                $event_show_time_id=$event_data[$date][0]['event_show_time_id'];
                                $event_schedule_list_id=$event_data[$date][0]['event_schedule_list_id'];
                            ?>
                            <tr>
                                <th class="text-center">{{ $date }}</th>
                                <?php 
                                $total_amount_arr=array();
                                $total_amount_scan_arr=array();
                                 
                                 
                                $paid_amount_arr=array();
                                $net_amount_arr=array();
                                $discount_arr=array();

                                
                                foreach($ticket_type_data as  $single_method)
                                {
                                    $method_found=false;
                                    foreach ($single_data as  $single_summary)
                                    {
                                        if($single_summary['id']==$single_method['id'])
                                        {
                                            
                                            
                                            $method_found=true;
                                            $total_amount=$single_summary['total'];
                                            $scanned_ticket_quantity=$single_summary['scanned_ticket_quantity'];
                                            $total_amount_arr[]=$total_amount;
                                            $total_amount_scan_arr[]=$scanned_ticket_quantity;
                                            
                                            $total_amount=number_format($total_amount);
echo '<td style="cursor:pointer; text-decoration:underline" class="text-center"  
onclick="show_showtime_details('.$event_schedule_list_id.','.$event_show_time_id.','.$single_method["id"].')" >'.$scanned_ticket_quantity.'/'.$total_amount.'</td>';
                                        }
                                    }
                                    if(!$method_found)
                                    {
                                        echo '<td class="text-center">0/0</td>';
                                    }
                                }
                                
                                
                                $total_amount_scan_arr=array_sum($total_amount_scan_arr);
                                $t_scan_sale[]=$total_amount_scan_arr;
                                $total_amount_scan_arr=number_format($total_amount_scan_arr);
                                
                                
                                
                                $total_amount_arr=array_sum($total_amount_arr);
                                $t_sale[]=$total_amount_arr;
                                $total_amount_arr=number_format($total_amount_arr);
                                
                                
                                echo '<th class="text-center">'.$total_amount_scan_arr.'/'.$total_amount_arr.'</th>';
                                ?>
                            </tr>
                            <?php
                            } 
                            ?>
                            <?php 
                                $t_sale=array();
                                $t_scan_sale=array();
                                echo '<tr><th class="text-center">Total</th>';

                                foreach($all_ticket_type as $ttype)
                                {
                                    $method_found=false;
                                    foreach($ticket_sum_count as $single_total)
                                    {
                                        if($single_total['id']==$ttype['id'])
                                        {
                                            $method_found=true;
                                            $total_ticket_quantity=$single_total->total_ticket_quantity;
                                            $scanned_ticket_quantity=$single_total->scanned_ticket_quantity;
                                            echo '<th class="text-center">'.number_format($scanned_ticket_quantity).'/'.number_format($total_ticket_quantity).'</th>';
                                            $t_sale[]=$total_ticket_quantity;
                                            $t_scan_sale[]=$scanned_ticket_quantity;
                                        }
                                    }
                                    if(!$method_found)
                                    {
                                        echo '<td class="text-center">0</td>';
                                    }
                                }
                                echo '<th class="text-center">'.number_format(array_sum($t_scan_sale)).'/'.number_format(array_sum($t_sale)).'</th></tr>';
                            ?>
                            </tr>
                        </tbody>
                    </table>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection


<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ticket Type Summary Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
"></script>



<script>

$(document).ready(function() {
    $('#body').addClass('sidenav-toggled');
});

        $('.table').DataTable( {
            dom: 'Blfrtip',
                "bPaginate": false,
                "bSort": false,
            buttons: [
                'excel',  'print'
            ]
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

                    $('#event_schedule_list_id').empty();

                    $('#event_show_time_id').empty();

                    $.each(response, function(key,value){
                        $('#event_schedule_id').append('<option value="'+ value.id +'">'+ value.start_date+' - '+value.end_date+'</option>');
                    });
                }
            });
        }
        else
        {
            $('#event_schedule_id').empty();
        }
    }

    //get event schedule list by event shedule id
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
                    $.each(response.event_schedule_lists, function(key,value){
                        $('#event_schedule_list_id').append('<option value="'+ value.id +'">'+ value.event_date+'</option>');
                    });

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">All Event Show Time</option>');
                    $.each(response.event_show_times, function(key,value){
                        $('#event_show_time_id').append('<option value="'+ value.id +'">'+ value.start_time+' - '+value.end_time+'</option>');
                    });
                    <?php 
                    if(isset($event_show_time_id_get) && !empty($event_show_time_id_get)){?>
                    $('#event_show_time_id').val('<?php echo $event_show_time_id_get;?>');
                    <?php }?>
                }
            });
        }
        else
        {
            $('#event_schedule_list_id').empty();

            $('#event_show_time_id').empty();
        }
    }


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

            $('#event_show_time_id').empty();

            $.each(response, function(key, value) {
                $('#event_schedule_id').append('<option value="' + value.id + '">' + value.start_date + ' - ' + value.end_date + '</option>');
            });
        }
    });
    }
    else
    {
        $('#event_schedule_id').empty();
        $('#event_schedule_list_id').empty();
        $('#event_show_time_id').empty();
    }
}

$('document').ready(function () {
var event_id= $('select#event_id option:selected').val();
get_event_schedule_by_event_id(event_id);

setTimeout(function () {
        var event_schedule_id= $('select#event_schedule_id option:selected').val();
        get_event_schedule_list_by_event_schedule_id(event_schedule_id);
    }, 2000);
});

function show_showtime_details(event_schedule_list_id, event_show_time_id, ticket_type_id)
{

       $('#exampleModal').modal('show');
    var data = {
        _token: '{{ csrf_token() }}',
        event_schedule_list_id: event_schedule_list_id,
        event_show_time_id: event_show_time_id,
        ticket_type_id: ticket_type_id
    };

    $.ajax({
        type: 'POST',
        url: '{{ route("scan_summary_show_wise_ajax") }}',
        data: data,
        success: function(response) {
            $('#exampleModal').modal('show');
            $('.modal-body').html(response);
        }
    });
}
</script>
@endsection