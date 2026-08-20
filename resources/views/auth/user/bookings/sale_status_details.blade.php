@extends('layouts.dashboard')

@section('title', 'Sale Status')

@section('css')
<!-- <link href="{{ asset('css/bootstrap-responsive.css') }}" rel="stylesheet"> -->
<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="ico/favicon.png">
<style>
td.removedCheckbox {
    display: none !important;
}

#venue .rows {
    width: 30px;
    float: left;
    empty-cells: show;
    margin-left: 0px;
    margin-top: 6px;
}

table.rows tbody tr {
    height: 2.87rem;
    background: #ccffe2;
    text-align: center;
}

@media screen and (max-width: 1800px) and (min-width: 1600px) {
      table.rows tbody tr {
        height: 2.89rem;
        background: #ccffe2;
    }
}
@media screen and (max-width: 1900px) and (min-width: 1801px) {
    table.rows tbody tr {
    height: 2.9rem;
    background: #ccffe2;
    }
}

@media screen and (max-width: 3800px) and (min-width: 1901px) {
    table.rows tbody tr {
        height: 2.92rem;
        background: #ccffe2;
    }
}



.seat_row tr:hover
{
    background-color: #edf1f4 !important;
 
}


tr:hover {
    background-color: #edf1f4;
}

.wingRowTop {
border-collapse: collapse;
border-spacing: 0px;
position: absolute;
margin-top: -37px;
}

.wingRowBottom {
position: absolute;
border-collapse: collapse;
border-spacing: 0px;
}

#seatmap {
position: relative;
}

#seatmap table {
border-collapse: separate;
border-spacing: 3px;
margin:  0 auto;

}

#venue {
/*width: 800px;*/
height: auto;
background: #fff;
z-index: 1;
}



/*#venue .rows {
width: 30px;
float: left;
empty-cells: show;
margin-left: 0px;
margin-top: 4px;
}

#venue .rows td {
text-align: center;
line-height: 44px;
background: #ccffe2;
margin: 0;
padding: 0;
}*/

.radio-toolbar input[type="radio"] {
/*position: fixed; 
width: 0; */
}

.radio-toolbar label {
background-color: #009688;
color: #fff;
padding: 3px 5px;
font-family: sans-serif, Arial;
font-size: 14px;
border: 1px solid #444;
border-radius: 4px;
}

.radio-toolbar input[type="radio"]:focus+label {
border: 1px solid #444;
}

.radio-toolbar label:hover {
/*background-color: #dfd;*/
}

.table_seat {
padding: 0px !important;
border: 2px solid black !important;
text-align: center;
}

.seat_row td {
    min-width: 42px;
    height: 2.87rem;
    border: solid 1px #666;
    border-radius: 7px 7px 0px 0px;
    text-align: center;
    cursor: pointer;
}

.seat_row td.row {
background-color: transparent;
border: none;
font-weight: bold;
padding-right: 7px;
}

/*.seat_row td.seatAvailable    { background-color: #01B213; color: #fff; }*/
.seat_row td.seatAvailable {
border: 1px solid #01710c;
color: #fff;
}

.seat_row td.seatUnavailable {
    background-color: #ddd;
    color: #8b8a8a;
    visibility: visible;
    opacity: 1;
}

.seat_row td.ExtraPay {
background-color: navy;
color: #fff
}

.seat_row td.LargeSeat {
/*width: 23px; */
}

.seat_row td.noSeatGalley {
background-color: transparent;
border: none;
width: 10px;
height: 10px;
}

.seat_row td.noSeatStorage {
background-color: #0085c1 !important;
color: white !important;
}

.seat_row td.noSeatLavatory {
background-color: #aaa;
}

.seat_row td.bookSeat {
background-color: #d7d7d7;
border: 1px solid #b1acac;
}

.seat_row tr:first-child td {
height: 15px;
border: none;
border-radius: 0;
}

.sidebar-mini.sidenav-toggled .app-content {
margin-left: 20px !important;
}

.seat_row th.seatAvailable {
border: 1px solid #01710c;
color: #fff;
}

.seat_row th.seatUnavailable {
    background-color: #ddd;
    color: #8b8a8a;
    visibility: visible;
    opacity: 1;
}

.seat_row th.noSeatStorage {
background-color: #0085c1 !important;
color: white !important;
}

.seat_row th.bookSeat {
background-color: #d7d7d7;
border: 1px solid #b1acac;
}

.app-content
{
    margin-top: 0 !important;
    padding:  0px !important;
    background-color: white !important;
}
.tile
{
    padding-top: 1px !important;
        padding-bottom: 0px!important;
}
.app-title, .app-header {
    display: none;
}

<?php
$color_array = [];
$class_array = [];
$ticket_type_array = [];
$ticket_type_data_array = [];


if (count($event_seats) > 0) :
//     print_r($event_seats);
foreach ($event_seats as $key => $event_seat_list) :
$ticket_type_id = $event_seat_list->event_ticket_type_id;

    if ($ticket_type_id != "") :

            if (array_key_exists($ticket_type_id,$ticket_type_data_array))
            {
                $ticket_type_data= $ticket_type_data_array[$ticket_type_id];
            }
            else
            {
                $ticket_type_data=getTicketType($ticket_type_id);
                $ticket_type_data_array[$ticket_type_id]=$ticket_type_data;
            }

     if ($ticket_type_data):
        $ticket_type_name = $ticket_type_data->ticket_type_name;
        $ticket_type_name = explode(' ', $ticket_type_name);
        $ticket_type_name = strtolower($ticket_type_name[0]);
        $color_array[$ticket_type_name] = $ticket_type_data->color;



        $class_array[$ticket_type_id] = $ticket_type_name;
        $ticket_type_array[$ticket_type_data->id] = $ticket_type_data->ticket_type_name;
    endif;
endif;
endforeach;
endif;

foreach ($color_array as $class => $bgcolor) {
echo '.seat_row td.' . $class . '{border-color:' . $bgcolor . '; color:' . $bgcolor . ';font-weight: 600;}';
echo "\n";
}
foreach ($color_array as $class => $bgcolor) {
echo '.seat_row th.' . $class . '{border-color:' . $bgcolor . '; color:' . $bgcolor . '; font-weight: 600;}';
echo "\n";
}
?>.hiddenCheckbox input {
opacity: 0;
transform: scale(2.7);
}

.hiddenVisibility {
/*visibility: hidden;*/
opacity: 0;
}

.mt-40 {
margin-top: 40px;
}

.message-error {
position: fixed;
pointer-events: auto;
overflow: hidden;
margin: 0 0 6px;
padding: 15px 15px 15px 15px;
width: 300px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
border-radius: 3px;
background-position: 15px center;
background-repeat: no-repeat;
-moz-box-shadow: 0 0 12px #999;
-webkit-box-shadow: 0 0 12px #999;
box-shadow: 0 0 12px #999;
background-color: #bd362f;
color: #fff;
opacity: 8;
top: 15px;
right: 15px;
z-index: 999999;
}

.message-success {
position: fixed;
pointer-events: auto;
overflow: hidden;
margin: 0 0 6px;
padding: 15px 15px 15px 15px;
width: 300px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
border-radius: 3px;
background-position: 15px center;
background-repeat: no-repeat;
-moz-box-shadow: 0 0 12px #999;
-webkit-box-shadow: 0 0 12px #999;
box-shadow: 0 0 12px #999;
background-color: #458045;
color: #fff;
opacity: 8;
top: 15px;
right: 15px;
z-index: 999999;
}
 .seat_row td.DamagedSeat  {text-align: center !important; border: 2px solid #5f5b5b; color: #5f5b5b; background: #ebebeb; }

table.legends td { text-transform: uppercase; font-weight: 400; text-align: center; border:2px solid; width:120px }  
table.legends td.DamagedSeat   { border-color: #5f5b5b; color: #5f5b5b; background: #ebebeb; }
table.legends td.ReservedSeat  { border: 2px solid #5f5b5b !important; color: #5f5b5b; }
table.legends td.seatAvailable { border-color: #01710c; color: #fff; }
table.legends td.noSeatStorage    { background-color: #0085c1 !important; color: white !important;}
.seat_row td.labeledSeat {color: #000;
    border: 0;
    visibility: visible;
    opacity: 1;
    font-size: 20px;
    font-weight: bold;}
</style>
@endsection

@section('content')
<main class="app-content">
<div class="app-title">
<div>
<h1><i class="fa fa-pie-chart"></i> Sale Status </h1>
</div>
<ul class="app-breadcrumb breadcrumb side">
<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
<li class="breadcrumb-item active"><a href="{{ route('booking.index') }}">Sale <Status></Status></a></li>
</ul>
</div>
<div class="row">
<div class="col-sm-12">
<!-- include message -->
@include('../../partials/message')
<!-- include message -->
<div class="tile">
    <div class="tile-body">

        <form action="{{ url('booking/create') }}" method="GET">
        <div class="row" style="margin-top: 30px;">

             <div class="col-sm-3">
                <h3>Realtime Sale Report</h3>
            </div>


            <div class="col-sm-3">
                <strong>Show Date : </strong>
                <h4>
                @foreach(getEventScheduleListByEventScheduleID($es_id) as $key => $event_schedule_list)
                <?php 
                if ($event_schedule_list->id == $esd_id)
                {
                    echo date('D, d-F-Y', strtotime($event_schedule_list->event_date)) ;
                }
                ?>
                @endforeach
                </h4>
            </div>

            <div class="col-sm-3">
                <strong>Show Time  </strong>
                <h4>
                @foreach(getEventShowTimeByEventScheduleID($es_id) as $key => $event_show_time)
                <?php 
                if ($event_show_time->id == $est_id)
                {
                    echo $event_show_time->start_time;
                    //' - '.$event_show_time->end_time;
                }
                ?>
                @endforeach
                </h4>
            </div>

            <div class="col-sm-2">
                <strong>Auto Refresh</strong><br>
                <input  type="checkbox" class="input-inline" id="autorefresh" onchange="refresh_check()">
            </div>


            @foreach($venues as $key => $venue)
            <?php if ($venue->id == $venue_id) {} ?>
            @endforeach


            @foreach($layouts as $key => $layout)
            <?php if ($layout->id == $layout_id) { } ?>
            @endforeach


          
        </div>
        </form>


   <hr>
    <table class="legends" style="width: 100%; margin-top: 20px;">
    <tr>
        <td class="ReservedSeat">Reserved</td>
        <td class="DamagedSeat">Damaged</td>
        <?php 

        $payment_methods=getAllPaymentMethod();
        $pg_color=array();
        foreach($payment_methods as $payment_method)
        {
            $pg_color[$payment_method->method_type]= $payment_method->color;
        }

        $pg_data=array();
        foreach($payment_methods as $payment_method)
        {
            $pg_data[$payment_method->id]= $payment_method->color;
        }

        ?>
        @foreach($pg_color as $method_type => $color)
        <td class="{{ $payment_method->color }}" style="color: white;background-color: {{$color }}; border-color: {{ $color }};">{{ $method_type }}</td>
        @endforeach


        @foreach($color_array as $class => $bgcolor)
        <td class="{{ $class }}" style="color: {{ $bgcolor }}; border-color:{{ $bgcolor}};">{{ $class }}</td>
        @endforeach
    </tr>
    </table>


        <hr>

        <?php
        $char = 'A';
        $alphas = array_merge(range('A', 'Z'), range('a', 'z'));
        $event_id = $e_id;
        $event_schedule_id = $es_id;
        $event_schedule_list_id = $esd_id;
        $event_show_time_id = $est_id;
        $venue_id = $venue_id;
        $layout_id = $layout_id;

        $data = DB::table('event_seat')
            ->where(['event_id' => $event_id, 'event_schedule_list_id' => $event_schedule_list_id, 'event_show_time_id' => $event_show_time_id, 'layout_id' => $layout_id])
            ->selectRaw('max(row_no) as row_no, max(col_no) as col_no')
            ->first();

        $row_no = $data->row_no;
        $col_no = $data->col_no;
        ?>

        @if(count($event_seats) > 0)

        <div class="row mt-4">
            <div class=" col-sm-12" id="main_area">
                <div id="seatmap">
                    <div id="venue">
    <?php 
 $layout_data=getLayout($layout->id);
 
if($layout_data->stage_direction=='UP'){?>
 <table>
    <tr>
        <td style="background-color:#242424; text-align:center;color:White;width: 100%; text-transform:uppercase;">ALL EYES THIS WAY PLEASE<td></tr>
</table>
<?PHP } ?>


                        <table class="rows" style="display:none">

                            <?php
                          
                            $layout_row_label = explode(',', $layout_data->layout_row_label);
                            for ($i = 0; $i < count($layout_row_label); $i++) {
                                if (isset($layout_row_label[$i])) {
                                  //  echo "<tr ><td>" . $layout_row_label[$i] . "</td></tr>";
                                }
                            }

                            $seat_master_array=[];
                            $all_seat_data=fetch_all_seat_data();
                            foreach($all_seat_data as $single_seat)
                            {
                                $seat_master_array[$single_seat->id]=$single_seat;
                            }
                            

                            $seat_cart_master_array=[];
                            $all_cart_seat_data=fetch_all_cart_seat();
                            $seat_cart_master_array[0]=0;
                            foreach($all_cart_seat_data as $single_cart_seat)
                            {
                                $seat_cart_master_array[$single_cart_seat->seat_id]=$single_cart_seat;
                            }
                            ?>
                        </table>

                        <div class="seat_row overflow-auto">
                            <table>
                                <!-- Making blank space for labels -->
                                <tr class="wingRowTop">
                                    <?php
                                    for ($i = 1; $i < $row_no; $i++) {
                                        echo "<td></td>";
                                    }
                                    ?>
                                </tr>

                                <tr>
                                    <!-- Making Labels for seat -->
                                    <?php
                                    for ($i = 1; $i <= $col_no; $i++) {
                                        //echo "<td class='noSeatGalley'>".$i."</td>";
                                    }
                                    ?>
                                </tr>

                                <!-- creating seat row and column here  -->
                                <?php

        $seat_id_data = find_booking_event($event_id, $event_schedule_list_id, $event_show_time_id, $layout_id);

                                for ($i = 1; $i <= $row_no; $i++) {
                                    echo "<tr>";
                                    for ($j = 1; $j <= $col_no; $j++) {


        $seat_id = $seat_id_data[$i][$j];

        $seat_details = $seat_master_array[$seat_id];


        $seat_name = $seat_details->name;
        $seat_name = '<div style="margin-top:-14px">'.$seat_name.'</div>';
        $label = $seat_details->label;
        $ij_visibility = ($seat_details->is_visible=='YES' ? TRUE : FALSE );
        $ij_removed = ($seat_details->is_removed=='YES' ? TRUE : FALSE );
        $ij_labeled = ($seat_details->is_labeled=='YES' ? TRUE : FALSE );
        $is_scanned = $seat_details->is_scanned;

        if($is_scanned == 1)
        {
            $seat_name = '<div style="margin-top:10px">'.$seat_name.'</div>';
        }
        
        if($ij_labeled)
        {
            $ij_labeled_class = 'LabeledSeat';
            $seat_name = '<div style="margin-top:-14px; text-align:center">'.$label.'</div>';
        }
        else
        {
            $ij_labeled_class = '';
        }

        if($ij_removed)
        {
            echo "<td title=" . $seat_id . " class='removedCheckbox removedVisibility'>" . $seat_name . "</td>";
        }
        else
        {
            if (!empty($ij_visibility))
            {

                $ij_damaged = ($seat_details->is_damaged=='YES' ? TRUE : FALSE );
                if (!$ij_damaged)
                {
                    $ij_reserved = ($seat_details->is_reserved=='YES' ? TRUE : FALSE );
                    if (!$ij_reserved)
                    {
                        $tt_data = $seat_details;
                        if(isset($seat_cart_master_array[$seat_id]))
                        {
                            $get_seat_id=$seat_cart_master_array[$seat_id];
                        }
                        else
                        {
                            $get_seat_id;
                        }
                        $cart_seat_id = (!empty($get_seat_id)) ? $get_seat_id->seat_id : '';
                        if ($tt_data->event_ticket_type_id)
                        {
                            $tt_id = $tt_data->event_ticket_type_id;
                            $seat_class = $class_array[$tt_id];
                            $book_id = $tt_data->booking_id;
                            $payment_method_id = $tt_data->payment_method_id;
                            if ($book_id != '')
                            {
                                $seat_color=$pg_data[$payment_method_id];
                                if($is_scanned == 1)
                                {
                                    echo "<td title=" . $seat_id . " style='color:white; background-color:" . $seat_color . "'  class='hiddenCheckbox'>" . $seat_name . "<span><i class='fa fa-user'></i></span></td>";
                                }else
                                {
                                    echo "<td title=" . $seat_id . " style='color:white; background-color:" . $seat_color . "'  class='hiddenCheckbox'>" . $seat_name . "</td>";
                                }
                            } 
                            else
                            {
                                if($ij_labeled==false)
                                {
                                    echo "<td title=" . $seat_id . " class='".$seat_class. "   hiddenCheckbox' >". $seat_name  . "</td>";
                                }
                                else
                                {
                                    echo "<td title=" . $seat_id . " class='labeledSeat  hiddenCheckbox' >" . $seat_name  . "</td>";
                                }
                                // echo "<td title=" . $seat_id . " class='" . $seat_class . "  hiddenCheckbox'><input title='" . $seat_class . "' type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                            }
                        }
                        else
                        {
                            echo "<td title=" . $seat_id . " class='seatAvailable hiddenCheckbox text-dark'><input type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";

                        }
                    }
                    else
                    {
                        echo "<td title=" . $seat_id . " class='seatUnavailable hiddenCheckbox hiddenVisibility'><input type='checkbox' value=" . $seat_id . " >" . $seat_name . "</td>";
                    }
                }
                else
                {
                    echo "<td title=" . $seat_id . " class='DamagedSeat hiddenCheckbox'><input type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                }
            }
            else
            {
                echo "<td title=" . $seat_id . " class='hiddenCheckbox hiddenVisibility'>" . $char . $j . "</td>";
            }
        }
    }
    echo "</tr>";


    $char++;
}
                                ?>
                            </table>

<?php 
if($layout_data->stage_direction=='DOWN'){?>
 <table>
    <tr>
        <td style="background-color:#242424; text-align:center;color:White;width: 100%; text-transform:uppercase;">ALL EYES THIS WAY PLEASE<td></tr>
</table>
<?PHP } ?>

                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <hr>

        {{--<div class="row mt-4">
        <div class="col-sm-12 text-right">
            <a href="{{ route('booking.create') }}" class="btn btn-info pl-4 pr-4">Back</a>
    </div>
</div>--}}
</div>
</div>
</div>
</div>
</main>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript">
//get event schedule by event id
function get_event_schedule_by_event_id(event_id)
{
    if (event_id != '' && event_id > 0)
    {
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
                $('#event_schedule_id').append('<option value="">Select Event Schedule</option>');

                $('#event_schedule_list_id').empty();
                $('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');

                $('#event_show_time_id').empty();
                $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');

                $.each(response, function(key, value) {
                    $('#event_schedule_id').append('<option value="' + value.id + '">' + value.start_date + ' - ' + value.end_date + '</option>');
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
    if (event_schedule_id != '' && event_schedule_id > 0)
    {
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
                $('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');
                $.each(response.event_schedule_lists, function(key, value) {
                    $('#event_schedule_list_id').append('<option value="' + value.id + '">' + value.event_date + '</option>');
                });

                $('#event_show_time_id').empty();
                $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');

                $.each(response.event_show_times, function(key, value) {
                    $('#event_show_time_id').append('<option value="' + value.id + '">' + value.start_time + ' - ' + value.end_time + '</option>');
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
$(document).ready(function() {
    $('#sidebar_hide').css('display', 'none');
    $('#body').addClass('sidenav-toggled');
});


function startRefresh() {
    $.get('', function(data) {
        $(document.body).html(data);   
        // $('#autorefresh').prop('checked', true);
    });
}

$(function() {
    if (localStorage.getItem('autorefresh')=='ON' )
    {
        $('#autorefresh').prop('checked', true);
        setTimeout(startRefresh,60000);
    }
});


function refresh_check()
{
    if ($('#autorefresh').is(":checked"))
    {
        localStorage.setItem('autorefresh', 'ON'); 
        window.location=window.location.href;
    }
    else
    {
        localStorage.setItem('autorefresh', 'OFF'); 
    }
}
px_ratio = window.devicePixelRatio || window.screen.availWidth / document.documentElement.clientWidth;

$(window).resize(function(){isZooming();});

function isZooming(){
    var newPx_ratio = window.devicePixelRatio || window.screen.availWidth / document.documentElement.clientWidth;
    if(newPx_ratio != px_ratio){
        px_ratio = newPx_ratio;
       // $('td').css('height', '2.87rem');
        return true;
    }else{
        console.log("just resizing");
        return false;
    }
}

</script>
@endsection