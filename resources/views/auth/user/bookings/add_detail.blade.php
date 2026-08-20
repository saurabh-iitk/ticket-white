@extends('layouts.dashboard')

@section('title', 'Add/Booking')

@section('css')
<!-- <link href="{{ asset('css/bootstrap-responsive.css') }}" rel="stylesheet"> -->
<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="ico/favicon.png">

<?php 
$reserve_unreserve=\Auth::user()->reserve_unreserve;
$res_unres_dmg_hide=\Auth::user()->res_unres_dmg_hide;
$remove_unremoved=\Auth::user()->remove_unremoved;
?>
<style>



<?php 
if($res_unres_dmg_hide =='ALLOWED' || $reserve_unreserve =='ALLOWED' )
{
    echo ".customer_reserve{background: #e0f5ff;color: #2196f3 !important;border-color: #2196f3 !important;}";
} 
?>

.swal2-validation-message {
    font-weight: bold !important;
    color: #f00 !important;
}



.swal2-icon.swal2-success .swal2-success-ring
{

    border: .25em solid rgb(165 220 134 / 93%) !important
}
.highlighted
{
    font-weight: bold;
    font-size: 22px;
}
.darkcolor
{
    color: #000000;
    background: #e3e2e2;
    border: 1px solid #0dce8a;
}

.alertcolor
{
    border: 1px solid red;
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
margin:0 auto;
}

#venue {
/*width: 800px;*/
height: auto;
background: #fff;
z-index: 1;
}


.focus_payment 
{
    border: 2px solid green;
    min-width: 905px;
    height: 75px;
    margin-bottom: 20px;
}

#venue .rows {
width: 34px;
float: left;
empty-cells: show;
margin-left: 30px;
margin-top: 6px;
}

#venue .rows td {
text-align: center;
line-height: 44px;
background: #ccffe2;
}

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
min-width: 38px;
height: 46px;
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


.seat_row td {
    line-height: 0px;
}


.seat_row td.seatUnavailable {
    background-color: #ddd;
    color: #8b8a8a;
    visibility: visible;
    opacity: 1;
}

.seat_row td.labeledSeat, .seat_row td.labeledSeat input {
    /* background: yellowgreen; */
    color: #fff;
    border: 0px;
    visibility: visible;
    opacity: 1;
}

.seat_row td.labeledSeat {
    /* background: yellowgreen; */
    color: #000;
    border: 0;
    visibility: visible;
    opacity: 1;
    font-size: 20px;
    font-weight: bold;
}



.seat_row td.seatUnavailableCustomer {
    background-color: rgb(119, 232, 242);
    color: #8b8a8a;
    visibility: visible;
    opacity: 1;
}

th.removedSeat {
    border:2px dashed black;
    color:black;
}

.seat_row td.removedSeat {
    background-color: rgb(119, 232, 242);
    color: #8b8a8a;
    visibility: visible;
    opacity: 1;
}

.seat_row td.unremovedSeat {
    background-color: rgb(119, 232, 242);
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

 .seat_row td.DamagedSeat  {text-align: center !important; border: 2px solid #5f5b5b; color: #5f5b5b; background: #ebebeb; }

.seat_row td.ReservedSeat  { border: 3px solid #5f5b5b; color: #5f5b5b; }


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

.seat_row th.seatUnavailableCustomer {
    background-color: rgb(119, 232, 242);
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

div#seat_mapping_row {
    margin: 0 auto;
    text-align: center;
    align-items: center;
    line-height: 40px;
    FONT-SIZE: 24PX;
    padding-left: 24px;
    display:none;
}

#seat_mapping_row_top
{
     display:none;
}

div#seat_mapping_row input[type="radio"], div#seat_mapping_row input[type="checkbox"]{
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0;
    transform: scale(2);
    margin: 4px;
}



/* .seat_row table 
{
    margin: 0 auto !important;
    width: 98% !important;
}
 */



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
opacity: 0.1;
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

<?php

if($seat_arrangement == true && $remove_unremoved=='ALLOWED')
{
   
    echo ' .hiddenCheckbox input,  .removedCheckbox input { transform: scale(2.7)}';
    echo ' .hiddenCheckbox input[type="text"] { display:none}';
    echo ' .removedCheckbox div{display: block !important; color:black !important}';
    echo ' .removedCheckbox input[type="text"]{display: none;}';
    echo ' .hiddenCheckbox input[type="checkbox"], .removedCheckbox input[type="checkbox"]{opacity: 0}';
    echo ' .seat_row td {line-height: 10px;}';
    echo ' .seat_row td.labeledSeat input {background: yellowgreen;color: #fff;border: 0px;visibility: visible; opacity: 0;}';
    echo ' td span{display:none;}';
}
else if($renaming == true && $res_unres_dmg_hide=='ALLOWED')
{
    echo ' .hiddenCheckbox input[type="text"] { opacity: 1; font-size: 12px; transform: scale(1.5); margin: 4px; width: 26px !important; text-align: center; height: 40px;  border:none; color:inherit}';
    echo ' .hiddenCheckbox div{display: none !important;}';
    echo ' .hiddenCheckbox input[type="checkbox"]{display: none;}';
    echo ' td.hiddenCheckbox  {border: none;}';
    echo ' td.removedCheckbox  {display: none;}';
    echo ' .seat_row td.ReservedSeat {border: none;}';
    echo ' .hiddenCheckbox input,  .removedCheckbox input { transform: scale(2.7)}';
    echo ' .removedCheckbox input[type="checkbox"]{opacity: 0}';
    echo ' .seat_row td.labeledSeat input {background: yellowgreen;color: #fff;border: 0px;visibility: visible; opacity: 1;}';
    echo ' .LabeledSeat{border: 2px solid #000000 !important;background: greenyellow;}';
    echo ' .LabeledSeat input{background: greenyellow;}';
    echo '  td span{z-index: +99; position:relative; color:initial; width: 30px;padding-top: 5px; display:none}';
    echo ' .seat_row td {border: 1px solid black; color: #d92020; font-weight: 600; width: 60px; line-height: 13px;  padding:5px;}';


}
else
{
    echo ' .hiddenCheckbox input[type="text"] { opacity:0;display:none}';
    echo ' .seat_row td.labeledSeat input {background: yellowgreen;color: #fff;border: 0px;visibility: visible; opacity: 0}';
    echo ' .removedCheckbox input { display:none; border:none !important}';
    echo ' .removedCheckbox {display: none !important;}';
    echo ' .removedCheckbox div {display: none !important;}';
    echo ' td span{display:none;}';
}
?>

</style>
@endsection

@section('content')
<main class="app-content">
<div class="app-title">
<div>
<h1><i class="fa fa-pie-chart"></i> Add Booking</h1>
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
<div class="tile">
    <div class="tile-body">

        <form action="{{ route('booking.create') }}" method="GET" id="create_form">
        <div class="row">
            <div class="col-md-1" >
                <div class="form-group">
                    <label for="for">Event</label>
                    <select class="form-control" name="e_id" id="event_id" autofocus="true" onchange="get_event_schedule_by_event_id(this.value);" readonly>
                        <option value="">Select Event</option>
                        @foreach($events as $key => $event)
                        <option value="{{$event->id}}" <?php if ($event->id == $e_id) {
                                                            echo 'selected';
                                                        } ?>>{{$event->event_title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2" >
                <div class="form-group">
                    <label for="for">Event Schedule</label>
                    <select class="form-control" name="es_id" id="event_schedule_id" onchange="get_event_schedule_list_by_event_schedule_id(this.value);" readonly>
                        <option value="">Select Event Schedule</option>
                        @foreach(getEventScheduleByEventID($e_id) as $key => $event_schedule)
                        <option value="{{$event_schedule->id}}" <?php if ($event_schedule->id == $es_id) {
                                                                    echo 'selected';
                                                                } ?>>{{$event_schedule->start_date.' - '.$event_schedule->end_date}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="for">Event Schedule Date</label>
                    <select class="form-control" name="esd_id" id="event_schedule_list_id" style="width:100%;" onchange="get_event_schedule_time_by_event_schedule_date(this.value);" >
                        <option value="">Select Event Schedule Date</option>
                        @foreach(getEventScheduleListByEventScheduleID($es_id) as $key => $event_schedule_list)
                        <option value="{{$event_schedule_list->id}}" <?php if ($event_schedule_list->id == $esd_id) {
                                                                            echo 'selected';} ?>><?php echo $event_schedule_list->event_date; ?></option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="for">Event Show Time</label>
                    <select class="form-control" name="est_id" id="event_show_time_id" style="width:100%;" onchange="get_layout_by_show_time()">
                        <option value="">Select Event Show Time</option>
                        @foreach(getEventShowTimeByEventScheduleID($es_id) as $key => $event_show_time)
                        <option value="{{$event_show_time->id}}" <?php if ($event_show_time->id == $est_id) {
                                                                        echo 'selected';
                                                                    } ?>>{{$event_show_time->start_time.' - '.$event_show_time->end_time}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2" >
                <div class="form-group">
                    <label for="for">Venue</label>
                    <select class="form-control" name="venue_id" id="venue_id" readonly>
                        <option value="">Select Venue</option>
                        @foreach($venues as $key => $venue)
                        <option value="{{$venue->id}}" <?php if ($venue->id == $venue_id) {
                                                            echo 'selected';
                                                        } ?>>{{$venue->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2" >
                <div class="form-group">
                    <label for="for">Layout</label>
                    <select class="form-control" name="layout_id" id="layout_id" readonly>
                        <option value="">Select Layout</option>
                        @foreach($layouts as $key => $layout)
                        <option value="{{$layout->id}}" <?php if ($layout->id == $layout_id) {
                                                            echo 'selected';
                                                        } ?>>{{$layout->layout_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label for="for" style="opacity:0">Back</label>
                    <a href="{{ route('booking.create') }}" class="btn btn-info pl-4 pr-4">Back</a>
                </div>
            </div>

            
            <div class="offset-2 col-md-8">
                <table class="seat_row" style="margin-top: 20px;">
                    <tr>
                        <!-- <th style="text-transform: uppercase;">Legends</th> -->


                        <!-- <th class="seatAvailable" style="color: #01710c;text-transform: uppercase;padding:3px;">Available Seat</th> -->
                        <th class="seatUnavailableCustomer" style="color: white;text-transform: uppercase;padding:3px;">Reserved (Cus.)</th>
                        <th class="seatUnavailable" style="color: white;text-transform: uppercase;padding:3px;">Reserved</th>
                        <th class="noSeatStorage" style="color: white;text-transform: uppercase;padding:3px;">Selected</th>
                        <th class="bookSeat" style="color: black;text-transform: uppercase;padding:3px;">Booked</th>
                        <?php if($user_with_role_data->is_admin == 1){ ?>
                        <th class="removedSeat" style="color: black;text-transform: uppercase;padding:3px;">Removed</th>
                        <th class="labeledSeat" style="background: greenyellow;color:black; border:1px solid black; text-transform: uppercase;padding:3px;">Labeled</th>
                         <?php } ?>
                         
                        @foreach($color_array as $class => $bgcolor)
                        <th class="{{ $class }}" style="color: {{ $bgcolor }}; border: 1px solid {{ $bgcolor}}; text-transform: uppercase;padding:3px;">{{ $class }}</th>
                        @endforeach
                    </tr>
                </table>
            </div>
        </div>
        </form>

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
        <div class="row">
            <span id="message"></span>

            <div class="col-md-6">
                <form action="{{ route('booking.save') }}" method="POST" id="booking_form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="for">Mobile No. <span class="required"></span></label>
                            <input type="text" class="form-control" maxlength="10" name="mobile_no" id="mobile_no" placeholder="Mobile No." onchange="fetch_customer(this.value);" value="{{ old('mobile_no') }}" />
                        </div>
                    </div>
                    <input type="hidden" name="send_whatsapp" id="send_whatsapp" >
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="for">Customer Name <span class="required"></span></label>
                            <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Customer Name" value="{{ old('customer_name') }}" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="for">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}" />
                        </div>
                    </div>

                    <div class="col-md-6" style="display:none;">
                        <div class="form-group">
                            <label for="for">Coupon Code</label>
                            <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Coupon Code" value="{{ old('coupon_code') }}" />
                        </div>
                    </div>
                    <div class="col-md-6" style="display:none">
                        <div class="form-group">
                            <label for="for">Discount</label>
                            <input type="number" class="form-control" name="discount" id="discount" placeholder="Discount" value="{{ old('discount') }}" />
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="for">BookMyShow / District / Website ID</label>
                            <input type="text" class="form-control" name="bms_id" id="bms_id" placeholder="BookMyShow / District / Website ID" onkeyup="fetch_bms_id_exist('bms_id')"/>
                        </div>
                    </div>

                    <div class="col-md-6 hide_complementary"  style="display:none">
                        <div class="form-group">
                            <label for="for">Issued by <span class="required">*</span></label>
                            <input type="text" class="form-control" name="issued_by" id="issued_by" placeholder="Issued by" value="{{ old('issued_by') }}" />
                        </div>
                    </div>

                     <div class="col-md-6 hide_complementary" style="display:none">
                        <div class="form-group">
                            <label for="for">Guest Designation <span class="required">*</span></label>
                            <input type="text" class="form-control" name="guest_designation" id="guest_designation" placeholder="Guest Designation"  value="{{ old('guest_designation') }}" />
                        </div>
                    </div>

                    <div class="col-md-12 text-center" id="payment_methods">
                        <div class="form-group">
                            <label for="for" class="text-left">Payment Method <span class="required">*</span></label>
                            <?php 
                            $payment_method_not_allowed=$user_data->payment_method_not_allowed;
                            $payment_method_not_allowed=explode(",", $payment_method_not_allowed);
                            ?>
                            <div class="radio-toolbar" style="width:1200px">
                                <?php 
                                foreach($payment_methods as $key => $payment_method)
                                {

                                    if(!in_array($payment_method->id, $payment_method_not_allowed)) {
                                        ?>
                                <input type="radio" style=" transform: scale(2.3); margin-right: 10px; margin-left: 15px; z-index:+9999 "  class="btn" name="payment_method_id" onchange="check_for_pg(this.value, '<?php echo strtolower($payment_method->name);?>')" id="payment_method_id" value="<?php echo $payment_method->id; ?>" 
                                    <?php if ($payment_method->id == old('payment_method_id')) { echo 'selected';} 
                                ?> >

                                <label for="" ><?php echo $payment_method->name;?></label>

                                &nbsp;&nbsp;
                                <?php } } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6" style="max-height: 150px;overflow-y: scroll; font-size:20px">
                <div>
                    <table class="table table-hover table-bordered" class="table_seat" id="main_ticket_table">
                        <thead class="table_seat" style="border: 2px solid black !important;">
                            <tr class="table_seat" style="border: 2px solid black !important;">
                                <th class="table_seat text-center">Ticket Type</th>
                                <th class="table_seat">Quantity</th>
                                <th class="table_seat">Rate</th>
                                <th class="table_seat">Discount</th>
                                <th class="table_seat">Total</th>
                            </tr>
                        </thead>

                        <tbody id="booking_detail">
                            <?php
                            $user_id = \Auth::user()->id;

                            $seat_ids = [];
                            $seat_ids = \App\Models\Cart::where('user_id', $user_id)->where('status', 'ACTIVE')->pluck('seat_id')->toArray();
                            if (!empty($seat_ids)) {
                                $seat_ids_str = simple_crypt(implode(',', $seat_ids));
                            } else {
                                $seat_ids_str = '';
                            }

                            $grand_total = 0;
                            $net_grand_total = 0;
                            $net_total_discount = 0;
                            $cart_groups = \App\Models\Cart::selectRaw('*, count(*) as total')->where('user_id', $user_id)->groupBy('ticket_type_id')->get();
                            if (count($cart_groups) > 0) {
                                foreach ($cart_groups as $key => $cart_item) {
                                    $cart_ticket_type_id = $cart_item->ticket_type_id;
                                    $qty = $cart_item->total;
                                    $rate = $cart_item->rate;
                                    $discount = $cart_item->discount;
                                    $total_discount = $cart_item->discount * $qty;
                                    $net_total_discount = number_format($total_discount, 2);
                                    $total_amount = ($rate - $discount) * $qty;
                                    $grand_total = $grand_total + $total_amount;
                                    $net_grand_total = number_format($grand_total, 2);
                            ?>
                                    <tr class="table_seat">
                                        <td class="table_seat">@if(getTicketType($cart_ticket_type_id)){{ getTicketType($cart_ticket_type_id)->ticket_type_name }}@endif</td>
                                        <td class="table_seat seat_qty">{{ $qty }}</td>
                                        <td class="table_seat">{{ $rate }}</td>
                                        <td class="table_seat">{{ $net_total_discount }}</td>
                                        <td class="table_seat">{{ number_format($total_amount,2) }}</td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr class="table_seat">
                                    <td colspan="5" class="text-center table_seat">No seats selected</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr class="table_seat">
                                <th colspan="4" class="text-right table_seat"> Grand Total &nbsp;</th>
                                <th class="text-center table_seat"><span id="grand-total">{{ $net_grand_total }}</span></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <input type="hidden" name="seat_ids" id="seat_ids" value="{{ $seat_ids_str }}">
                <input type="hidden" name="event_id" value="{{ $e_id != '' ? simple_crypt($e_id) : '' }}">
                <input type="hidden" name="event_schedule_id" value="{{ $es_id != '' ? simple_crypt($es_id) : '' }}">
                <input type="hidden" name="event_schedule_list_id" value="{{ $esd_id != '' ? simple_crypt($esd_id) : '' }}">
                <input type="hidden" name="event_show_time_id" value="{{ $est_id != '' ? simple_crypt($est_id) : '' }}">
                <input type="hidden" name="venue_id" value="{{ $venue_id != '' ? simple_crypt($venue_id) : '' }}">
                <input type="hidden" name="layout_id" value="{{ $layout_id != '' ? simple_crypt($layout_id) : '' }}">
           
            </div>
            </div>

                <div class="row">
                    <div class="col-md-12 text-center" >
                        <input type="hidden" value="<?php echo simple_crypt(Request::fullUrl());?>" name="current_url">
                        <input type="submit" id="book" class="btn btn-primary pl-4 pr-4"  value="Book" />
                        &nbsp;
                        <a href="javascript:void(0)" onclick="clear_cart();" class="btn btn-danger pl-4 pr-4">Clear Seats</a>

                        <?php if($res_unres_dmg_hide =='ALLOWED'){ ?>
                        <a href="javascript:void(0)" id="rename_seat" onclick="redirect_rename_seat();" class="btn btn-warning pl-4 pr-4"> Turn On Seat Renaming</a>
                        <?php } ?>

                        <?php if($remove_unremoved =='ALLOWED'){ ?>
                        <a href="javascript:void(0)" id="seat_arrangement" onclick="redirect_seat_arrangement();" class="btn  pl-4 pr-4" style="background: yellowgreen">
                            Turn on Seat Arrangement</a>
                        <?php } ?>
                        
                        <?php if($remove_unremoved =='ALLOWED' || $res_unres_dmg_hide =='ALLOWED'|| $reserve_unreserve =='ALLOWED'){ ?>
                        <a href="javascript:void(0)"  onclick="toggle_seat_mapping();" class="btn  pl-4 pr-4" style="background: black; color:white">Layout Action</a>
                        <?php } ?>
                         
                         
                       <div class="skip_label"> <label for="layout_skip_label" style=" margin: 0 auto; padding: 0; line-height: 55px; font-size: 20px; ">Skip Label</label>
                       <input type="text" name="layout_skip_label" id="layout_skip_label" onchange="layout_label_rename(this.value)" placeholder="Example A,B,C..." class="form-control" value="{{$skip_label}}" style=" width: 28%; margin: 11px; align-items: center; float: right; "></div>
                    </div>
                </div>
            </form>
        <div id="success_rename" style="color:green"></div>

<?php 



if($res_unres_dmg_hide=='ALLOWED' || $reserve_unreserve =='ALLOWED'){
?>
                    <hr id="seat_mapping_row_top">
                    <div class="row mt-4" id="seat_mapping_row">
                        <div class="col-md-12" id="sidebar">
                        <?php if($res_unres_dmg_hide =='ALLOWED'){ ?>
                        <input type="radio"  name="hide_show" value="OFF"> Hide &nbsp;&nbsp;
                        <input type="radio"  name="hide_show" value="ON"> Show &nbsp;&nbsp;
                        <input type="radio"   name="hide_show" value="DAMAGED"> Damaged &nbsp;&nbsp;
                        <input type="radio"  name="hide_show" value="UNDAMAGED"> UnDamaged &nbsp;&nbsp;
                         <input type="radio"  name="hide_show" value="RESERVE_CUSTOMER"> Reserve For Cus. &nbsp;&nbsp;
                        <input type="radio"  name="hide_show" value="UNRESERVE_CUSTOMER"> UnReserve For Cus. &nbsp;&nbsp;
                        <?php } ?>

                        <?php if($res_unres_dmg_hide =='ALLOWED' || $reserve_unreserve =='ALLOWED' ){ ?>
                        <input type="radio"  name="hide_show" value="RESERVE"> Reserve &nbsp;&nbsp;
                        <input type="radio"  name="hide_show" value="UNRESERVE"> UnReserve &nbsp;&nbsp;
                
                        <?php } ?>
                        
                       
                        <?php if($remove_unremoved =='ALLOWED' ){ ?>
                            <input type="radio"  name="hide_show" value="REMOVED"> Removed &nbsp;&nbsp;
                            <input type="radio"  name="hide_show" value="UNREMOVED"> UnRemoved &nbsp;&nbsp;
                            <input type="radio"  name="hide_show" value="LABELED"> Labeled &nbsp;&nbsp;
                            <input type="radio"  name="hide_show" value="UNLABELED"> UnLabeled &nbsp;&nbsp;
                        <?php } 


                        if($res_unres_dmg_hide =='ALLOWED'){ ?>
                            @foreach($ticket_type_array as $tkt_type_id => $tkt_type_name)
                            <tr>
                                <input type="radio" id="event_ticket_type_id" name="hide_show" value="{{ $tkt_type_id }}"> {{ $tkt_type_name }} &nbsp;&nbsp;
                            </tr>
                            @endforeach
                        <?php } ?>


                            <input type="button" name="action" id="action" class="btn btn-sm btn-success" value="Save Action" onclick="save_action();">
                        </div>
                          <?php if($res_unres_dmg_hide =='ALLOWED' ){ ?>
                                <input type="checkbox" id="label_rename"> &nbsp;&nbsp;Label Seat
                         <?php } ?>
                    </div>
                    

<?PHP } ?>

        <hr id="seat_mapping_row_bottom">
        <input type="hidden" id="choosen_payment_method">
        <input type="hidden" id="choosen_payment_method_id">
        <div class="row mt-4 grabbable">
            <div class="col-md-12" id="main_area">
            <input type="checkbox" id="multiple"> Multi Select
          
                <div id="seatmap">
                    <div id="venue">
                        <?php 
                    $layout_data=getLayout($layout->id);
                    
                    if($layout_data->stage_direction=='UP'){?>
                    <table>
                        <tr>
                            <td style="background-color:#242424; text-align:center;color:White;width: 100%; text-transform:uppercase; height:40px">ALL EYES THIS WAY PLEASE<td></tr>
                    </table>
                    <?PHP } ?>


                        <table class="rows ">

                            <?php
                          
                            $layout_row_label = explode(',', $layout_data->layout_row_label);
                            $skip_label = explode(',', $skip_label);

                         
                            // for ($i = 0; $i < count($layout_row_label); $i++) {
                            //     if (isset($layout_row_label[$i])) {
                            //         if(in_array($layout_row_label[$i], $skip_label ))
                            //         {
                            //             echo "<tr><td style='visibility:hidden'>" . $layout_row_label[$i] . "</td></tr>";
                            //         }
                            //         else
                            //         {
                            //             echo "<tr><td>" . $layout_row_label[$i] . "</td></tr>";
                            //         }
                            //     }
                            // }

                            $conditions = array(
                               
                            );

                            $conditions=[];
                            $conditions[]= array('event_id', $event_id);
                            $conditions[]= array('event_schedule_list_id', $event_schedule_list_id);
                            $conditions[]= array('event_show_time_id', $event_show_time_id);
                            $conditions[]= array('layout_id', $layout_id);
                            $seat_master_array=[];

                            $all_seat_data=$event_seats;

                            
                            foreach($all_seat_data as $single_seat)
                            {
                                $seat_master_array[$single_seat->id]=$single_seat;
                            }

                            $seat_cart_master_array=[];
                            $all_cart_seat_data=fetch_all_cart_seat($user_id);
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

                            for ($i = 1; $i <= $row_no; $i++)
                            {
                                $random_class_td=Str::random(8);
                                echo "<tr>";
                                for ($j = 1; $j <= $col_no; $j++)
                                {

                                    // dd($seat_id_data);
                                    // exit;
                                    $seat_id = $seat_id_data[$i][$j];
                                    $seat_details = $seat_master_array[$seat_id];
                                    // $seat_details = fetch_layout_seat_name($seat_id);
                                    $seat_name = $seat_details->name;
                                    $label = $seat_details->label;
                                    if($seat_arrangement == true)
                                    {
                                        $seat_name = '<div style="margin-top:-8px; text-align:center">'.$seat_name.'</div>';

                                    }
                                    else
                                    {
                                        $seat_name = '<div style="margin-top:-14px; text-align:center">'.$seat_name.'</div>';
                                    }

                                    $ij_visibility = ($seat_details->is_visible=='YES' ? TRUE : FALSE );
                                    $ij_removed = ($seat_details->is_removed=='YES' ? TRUE : FALSE );
                                    $ij_labeled = ($seat_details->is_labeled=='YES' ? TRUE : FALSE );
                                    
                                    if($ij_labeled)
                                    {
                                        $ij_labeled_class = 'LabeledSeat';
                                        $seat_name = '<div style="margin-top:-14px; text-align:center">'.$label.'</div>';
                                    }
                                    else
                                    {
                                        $ij_labeled_class = '';
                                    }


                                    $is_reserved_for_customer = ($seat_details->is_reserved_for_customer=='YES' ? TRUE : FALSE );
                                    if($is_reserved_for_customer)
                                    {
                                        $is_reserved_for_customer='customer_reserve';
                                    }
                                    else
                                    {
                                        $is_reserved_for_customer='';
                                    }

                                    $rename_html="<input type='text' onchange='seat_rename(this.value, this.name)' style='width:32px'  name='$seat_id' value='$seat_details->name'>";

                                    if($ij_removed)
                                    {
                                        echo "<td title=" . $seat_id . " class='removedCheckbox removedVisibility ".$random_class_td. "'><input type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
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
                                
                                                        $hold_flag=false;
                                                        if(in_array($seat_id, $customer_cart))
                                                        {
                                                            $hold_flag=true;
                                                        }
                                
                                
                                                        if ($seat_id == $cart_seat_id) {
                                                            //show selected seat
                                                            echo "<td title=" . $seat_id . " class='".$seat_class. "  ".$random_class_td. " hiddenCheckbox noSeatStorage'><input title='" . $seat_class . "' type='checkbox' value=" . $seat_id . " class='noSeatStorage' checked>" . $seat_name  .$rename_html."</td>";
                                                        } else {
                                                            if ($book_id != '') {
                                                                //show booked seat
                                                                echo "<td title=" . $seat_id . " class='bookSeat hiddenCheckbox  ".$random_class_td. "'><input title='".$seat_class. "' type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                                                            } else {
                                
                                                                if($hold_flag==false)
                                                                {
                                                                    
                                                                    if($ij_labeled==false)
                                                                    {
                                                                        echo "<td title=" . $seat_id . " class='".$seat_class. "   hiddenCheckbox " . $is_reserved_for_customer . " ".$random_class_td. " ' ><span>".$label."</span> <input title='" . $seat_class . "' type='checkbox' value=" . $seat_id . ">" . $seat_name  .$rename_html. "</td>";
                                                                    }
                                                                    else
                                                                    {
                                                                        echo "<td title=" . $seat_id . " class='$ij_labeled_class labeledSeat  hiddenCheckbox " . $is_reserved_for_customer . " ".$random_class_td. " ' ><input title='" . $seat_class . "' type='checkbox' value=" . $seat_id . ">" . $seat_name  .$rename_html. "</td>";
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    echo "<td title=" . $seat_id . " class='hold_seat hiddenCheckbox  ".$random_class_td. "' style='background:orange'><input title='".$seat_class. "' type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo "<td title=" . $seat_id . " class='seatAvailable hiddenCheckbox ".$random_class_td."text-dark'><input type='checkbox' value=" . $seat_id . ">" . $seat_name . $rename_html."</td>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "<td title=" . $seat_id . " class='ReservedSeat hiddenCheckbox ".$random_class_td. "'><input type='checkbox' value=" . $seat_id . " >" . $seat_name .$rename_html. "</td>";
                                                }
                                            }
                                            else
                                            {
                                                echo "<td title=" . $seat_id . " class='DamagedSeat hiddenCheckbox ".$random_class_td. "'><input type='checkbox' value=" . $seat_id . ">" . $seat_name .$rename_html. "</td>";
                                            }
                                                
                                        } 
                                        else
                                        {
                                            echo "<td title=" . $seat_id . " class='hiddenCheckbox hiddenVisibility ".$random_class_td. "'><input type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
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
        <td style="background-color:#242424; text-align:center;color:White;width: 100%; text-transform:uppercase;height:40px">ALL EYES THIS WAY PLEASE<td></tr>
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
        <div class="col-md-12 text-right">
            <a href="{{ route('booking.create') }}"   class="btn btn-info pl-4 pr-4">Back</a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script type="text/javascript">

    function titleCase(str) {
  str = str.toLowerCase().split(' ');
  for (var i = 0; i < str.length; i++) {
    str[i] = str[i].charAt(0).toUpperCase() + str[i].slice(1); 
  }
  return str.join(' ');
}

function toggle_seat_mapping()
{
    $('#seat_mapping_row').toggle();
    $('#seat_mapping_row_top').toggle();
}


function fillMobileNo(value)
{
    $('#mobile_no').val(value);    
}

function fillName(value)
{
    $('#customer_name').val(titleCase(value));
}


function fillIssuedBy(value)
{
    $('#issued_by').val(titleCase(value));
}


function fillDesignation(value)
{
    $('#guest_designation').val(titleCase(value));
}

function fillBookingId(value)
{
    $('#bms_id').val(value.toUpperCase());
    $('#bms_id_popup').val(value.toUpperCase());
    fetch_bms_id_exist('bms_id_popup');
}


$('#customer_name').on('input', function(evt) {
  $(this).val(function(_, val) {
    return titleCase(val);
  });
});

$('#email').on('input', function(evt) {
  $(this).val(function(_, val) {
    return val.toLowerCase();
  });
});


// $('#bms_id_popup').on('input', function(evt) {
//   $(this).val(function(_, val) {
//     return val.toUpperCase();
//   });
// });




$('#booking_form').on('submit', function(e){
    e.preventDefault();
    let form = $(this);

    <?php
    $setting=getSetting(1);
    $mobile_mandatory=$setting->mobile_mandatory;
    ?>

    var mobile_mandatory = '<?php echo $mobile_mandatory; ?>';



    if ($("input[name='payment_method_id']:checked").length ==0)
    {
        $('#message').html('No Payment Method selected').addClass('message-error');
        $('#message').show();
        $('#payment_methods').show();
        $('#payment_methods').addClass('focus_payment');
        setTimeout(function() { $('#payment_methods').removeClass('focus_payment'); $('#message').fadeOut(500); },1000);
        return false;
    }

    var grand= $('#grand-total').text();
    var qty_sum = 0;
    $('.seat_qty').each(function(){
        qty_sum += parseInt($(this).text());  // Or this.innerHTML, this.innerText
    });


    var qty_sum = 0;
        $('.seat_qty').each(function(){
        qty_sum += parseInt($(this).text());  // Or this.innerHTML, this.innerText
    });

    if (qty_sum ==0)
    {
        $('#message').html('Please Select Seat First').addClass('message-error');
        $('#message').show();
        setTimeout(function() {$('#message').fadeOut(500); },1000);
        return false;
    }


    var discount_check=false;
    $(".discount_input").each(function() {
        if($(this).val()==0 && $(this).prop('disabled')==false)
        {
            $('#message').html('Discount can not be 0').addClass('message-error');
            $('#message').show();
            setTimeout(function() {$('#message').fadeOut(500); },1000);
            discount_check=true;
        }
    });

    if(discount_check)
    {
        return false;
    }
    else
    {                
        var show_date=$('select#event_schedule_list_id option:selected').text();
        var show_time=$('select#event_show_time_id option:selected').text();
        var show_time = show_time.split(" - ");
        show_time = show_time[0];
        var ticket_type=$('.seat_qty').parent('tr').find('td:first').text();
        var choosen_payment_method = $('#choosen_payment_method').val();
   
        if(choosen_payment_method=='COMPLIMENTARY')
        {
            var comp_html="<input class='form-control alertcolor' type='text'  placeholder='Enter Issued by Name' name='issued_by' onkeyup='fillIssuedBy(this.value)' ><br><input onkeyup='fillDesignation(this.value)'  class='form-control alertcolor ' type='text'  placeholder='Enter Guest Designation'><br>";
        }
        else
        {
            var comp_html='';
        }



        if(choosen_payment_method=='BOOK MY SHOW' || choosen_payment_method=='DISTRICT' || choosen_payment_method=='WEBSITE')
        {
            var bid_html="<input class='form-control alertcolor' type='text'  placeholder='BookMyShow / District / Website ID' id='bms_id_popup' onkeyup='fillBookingId(this.value)' onchange='fillBookingId(this.value)' onblur='fillBookingId(this.value)' ><br>";
        }
        else
        {
            var bid_html='';
        }


        Swal.fire({
            title: 'Booking Details',
            input: 'checkbox',
            icon: 'info',
            className: 'form-control',
            inputPlaceholder: 'Send SMS/WhatsApp?',
            html: "<b><input type='text' placeholder='Enter Customer Name'  onkeyup='fillName(this.value)'  class='form-control alertcolor swal_name'></b><br><b><input maxlength='10'  class='form-control alertcolor swal_mobile' onkeyup='fillMobileNo(this.value)' type='text' placeholder='Enter Mobile No.'></b><br>"+comp_html+""+bid_html+"<input maxlength='10' class='form-control darkcolor' type='text' value='Date: "+show_date+"'><br><input maxlength='10' class='form-control darkcolor' type='text' value='Time: "+show_time+"''><br><b><input maxlength='10' class='form-control darkcolor' type='text'   value='Total Ticket: "+ qty_sum+" ("+ticket_type+")'></b><br><input maxlength='10' class='form-control darkcolor' type='text'  value='Payment Method : "+choosen_payment_method+"'><br><input maxlength='10' class='form-control darkcolor highlighted' type='text'  value='Total Amount: Rs "+grand+"'>",  
            confirmButtonText: "Next",
            confirmButtonColor: "blue",   
            showCancelButton: true,  
            cancelButtonColor: "red",  
            didOpen: (value) => {
                $('.swal_name').val($('#customer_name').val());
                $('.swal_mobile').val($('#mobile_no').val());
            },
            preConfirm: (value) => {
                if (value) {
                    var mobile_no = $('#mobile_no').val();    
                    var customer_name =$('#customer_name').val();
                    if(mobile_no.length!=10)
                    {
                        Swal.showValidationMessage(
                            'Please Fill 10 Digit Mobile No.'
                        )
                    }
                    if(customer_name.length<3)
                    {
                        Swal.showValidationMessage(
                            'Please Fill Customer Name'
                        )
                    }
                    $('#send_whatsapp').val('YES');
                }
                else
                {

                    $('#send_whatsapp').val('NO');
                }

                var choosen_payment_method = $('#choosen_payment_method').val();
                var bms_id_popup =$('#bms_id_popup').val();
                if(choosen_payment_method=='BOOK MY SHOW' || choosen_payment_method=='DISTRICT')
                {
                    if(bms_id_popup.length<3)
                    {
                        Swal.showValidationMessage(
                            'Please Fill BookMyShow / District / Website ID'
                        )
                    }
                }


                var mobile_no = $('#mobile_no').val(); 
                if(mobile_mandatory=='YES' && choosen_payment_method!='BOOK MY SHOW' &&  choosen_payment_method!='DISTRICT')
                {
                    if(mobile_no.length!=10)
                    {
                        Swal.showValidationMessage(
                            'Please Fill Mobile No to Book Ticket.'
                        )
                    }
                }
            }

            }).then((result) => {
            if (result.isConfirmed)
            {
                var show_date=$('select#event_schedule_list_id option:selected').text();
                var show_time=$('select#event_show_time_id option:selected').text();
                var show_time = show_time.split(" - ");
                show_time = show_time[0];
                var mobile_no=$('#mobile_no').val();
                var customer_name=$('#customer_name').val();
                var guest_designation=$('#guest_designation').val();
                var issued_by=$('#issued_by').val();

                var choosen_payment_method = $('#choosen_payment_method').val();

                if(choosen_payment_method=='COMPLEMENTRY')
                {
                    var comp_html2="<input class='form-control darkcolor' type='text'  value='Issued By: "+ issued_by+"'  name='issued_by' ><br><input   class='form-control darkcolor ' type='text'  value='Guest Designation: "+ guest_designation+"'><br>";
                }
                else
                {
                    var comp_html2='';
                }


                $('#swal_showtime2').val($('#swal_showtime2').val());
                if(result.value)
                {
                    var mobile_no = $('#mobile_no').val();
                    if(mobile_no.length==10)
                    {
                        Swal.fire({
                            title: "Are you sure to Booking?",
                            html: "<b><input type='text' readonly  class='form-control darkcolor' value='"+ customer_name+"'></b><br><b><input maxlength='10' class='form-control darkcolor' type='text' value='"+ mobile_no+"'></b><br>"+comp_html2+"<input maxlength='10' class='form-control darkcolor' type='text' value='Date: "+show_date+"'><br><input maxlength='10' class='form-control darkcolor' type='text'  value='Time: "+show_time+"''><b><br><input maxlength='10' class='form-control darkcolor' type='text' value='Total Ticket: "+ qty_sum+" ("+ticket_type+")'></b><br><input maxlength='10' class='form-control darkcolor' type='text'  value='Payment Method : "+choosen_payment_method+"'><br><input maxlength='10' class='form-control darkcolor highlighted' type='text' value='Total Amount: Rs "+grand+"'>",  
                            type: "success",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: "red",                                                          
                            confirmButtonText: "Book Now",
                            cancelButtonText: "Cancel",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        }).then((result) => {
                            if (result.isConfirmed)
                            {
                                form.submit();
                            }
                        });
                    }
                }
                else
                {
                    Swal.fire({
                        title: "Are you sure to Booking?",
                        text: "Total Ticket: "+ qty_sum+", Final Amount: Rs. "+grand+"",
                        html: "<b><input type='text' readonly  class='form-control darkcolor' value='"+ customer_name+"'></b><br><b><input maxlength='10' class='form-control darkcolor' type='text' value='"+ mobile_no+"'></b><br>"+comp_html2+"<input maxlength='10' class='form-control darkcolor' type='text' value='Date: "+show_date+"'><br><input maxlength='10' class='form-control darkcolor' type='text'  value='Time: "+show_time+"''><b><br><input maxlength='10' class='form-control darkcolor' type='text'  value='Total Ticket: "+ qty_sum+" ("+ticket_type+")'></b><br><input maxlength='10' class='form-control darkcolor' type='text'  value='Payment Method : "+choosen_payment_method+"'><br><input maxlength='10' class='form-control darkcolor highlighted' type='text' value='Total Amount: Rs "+grand+"'>",  
                        type: "success",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: "red",                                                          
                        confirmButtonText: "Book Now",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    }).then((result) => {
                        if (result.isConfirmed)
                        {
                            form.submit();
                        }
                    });            
                }
            }
            else
            {
                console.log(`modal was dismissed by ${result.dismiss}`)
            }
        });

        // swal({
        //     title: "Are you sure to Booking?",
        //     text: "Total Ticket: "+ qty_sum+", Final Amount: Rs. "+grand+"",
        //     type: "success",
        //     showCancelButton: true,
        //     confirmButtonColor: "red",                                                          
        //     confirmButtonText: "Book Now",
        //     cancelButtonText: "Cancel",
        //     closeOnConfirm: true,
        //     closeOnCancel: true
        //     },
        //     function(isConfirm) {
        //         if (isConfirm) {
        //             form.submit();
        //         }
        //     }
        // );
    }
});

// $('#book').click(function (e) {
    
//     e.preventDefault();
//     return swal({
//             title: "Are you sure?",
//             text: "You can not change this",
//             type: "warning",
//             showCancelButton: true,
//             confirmButtonText: "Yes, Book it!",
//             cancelButtonText: "No, Modify it",
//             closeOnConfirm: true, //false
//             closeOnCancel: true //false
//         }, function(isConfirm) {
//             return true;
//         });

// })

get_event_schedule_time_by_event_schedule_date({{$esd_id}});


var est_id={{$est_id}};



 setTimeout( function(){ 
    $('#event_show_time_id').val(est_id);
  }  , 1000 );

  
 //get event shedule time list by event shedule date id
 function get_event_schedule_time_by_event_schedule_date(event_schedule_list_id) {
        //console.log(event_schedule_list_id);
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
            $('#event_schedule_id').append('<option value="">Select Event Schedule</option>');

            $('#event_schedule_list_id').empty();
            $('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');

            var est_id={{$est_id}};
            $.each(response, function(key, value) {
                if(est_id==value.id)
                {
                    $('#event_schedule_id').append('<option value="' + value.id + '" selected>' + value.start_date + ' - ' + value.end_date + '</option>');
                }
                else
                {
                    $('#event_schedule_id').append('<option value="' + value.id + '">' + value.start_date + ' - ' + value.end_date + '</option>');
                }
            });
        }
    });
    } else {
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
            event_schedule_id: event_schedule_id,
            user_id: <?php  echo  $user_id = \Auth::user()->id; ?>,
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
    
    setTimeout(function(){  $('#create_form').submit(); }, 1000); // delay form submit by 2 sec
}

var is_admin=<?php echo $user_with_role_data->is_admin; ?>;

if(!is_admin)
{
    // $('#seat_mapping_row').html('');
    // $('#seat_mapping_row_top').hide();
    // $('#seat_mapping_row_bottom').hide();
}


$('input[type=checkbox]').change(function() {
    var id = $(this).val(); // this gives me null
    var check_status = $(this).is(':checked');
    var parent_class=$(this).parent().prop( "class" );
    var is_admin=<?php echo $user_with_role_data->is_admin; ?>;
    
    if($('#label_rename').is(":checked")==false)
    {
        if((parent_class.indexOf('labeledSeat') != -1))
        {
            $('#message').html('This is Label').addClass('message-error');
            $('#message').show();
            $('input[type=checkbox][value='+id+']').prop('checked', false); // Unchecks it
            return false;
        }
    }

    if(is_admin)
    {
        if (id != null && check_status == true)
        {
            $(this).parent().addClass('noSeatStorage');
            $(this).addClass('noSeatStorage');
            add_to_cart(id);
        }
        else
        {
            $(this).removeClass('noSeatStorage');
            $(this).parent().removeClass('noSeatStorage');
            add_to_cart(id);
        }
    }
    else
    {   

        if((parent_class.indexOf('hold_seat') != -1))
        {
                $('#message').html('Seat is Hold').addClass('message-error');
                $('#message').show();
                return false;
        }


        if((parent_class.indexOf('DamagedSeat') != -1))
        {
             $('#message').html('This is Damaged Seat, Booking Not Allowed').addClass('message-error');
              $('#message').show();
        }
        <?php 

        $reserve_unreserve=\Auth::user()->reserve_unreserve;
        $res_unres_dmg_hide=\Auth::user()->res_unres_dmg_hide;
        $remove_unremoved=\Auth::user()->remove_unremoved;


if($reserve_unreserve =='NOT_ALLOWED' && $res_unres_dmg_hide=='NOT_ALLOWED')
{
?>
        else if (parent_class.indexOf('ReservedSeat') != -1)
        {
             $('#message').html('This is Reserved Seat, Unresrve to book').addClass('message-error');
              $('#message').show();
        }
<?PHP } ?>
        else
        {
            if (id != null && check_status == true)
            {
                $(this).parent().addClass('noSeatStorage');
                $(this).addClass('noSeatStorage');
                add_to_cart(id);
            }
            else
            {
                $(this).removeClass('noSeatStorage');
                $(this).parent().removeClass('noSeatStorage');
                add_to_cart(id);
            }
        }
    }
    
});

function add_to_cart(event_seat_id) {
    var discount = $('#discount').val();
    var event_schedule_list_id = $('#event_schedule_list_id').val();
    var event_show_time_id = $('#event_show_time_id').val();
    if (event_seat_id != "") {
    var data = {
        _token: '{{ csrf_token() }}',
        event_seat_id: event_seat_id,
        discount: discount,
        event_schedule_list_id: event_schedule_list_id,
        event_show_time_id: event_show_time_id
    };

    $.ajax({
        type: 'POST',
        url: '{{ route("booking.add_to_cart") }}',
        data: data,
        dataType: 'json',
        success: function(response) {
            // console.log(response);
            if (response.status == 'error') {
                //show msg
                $('#message').html('').removeClass('message-success');
                $('#message').html(response.message).addClass('message-error');
                $('#message').show();

                $('td[title="'+event_seat_id+'"]').removeClass('noSeatStorage');
                $('input[value="'+event_seat_id+'"]').removeClass('noSeatStorage');

                setTimeout(function() {
                    $('#message').html('').removeClass('message-success');
                    $('#message').hide();
                }, 2000);
            } else {
                var html = "";
                if (response.status == 'success' && response.data.length > 0) {
                    $.each(response.data, function(key, value) {
                        html += '<tr>'; //start row

                        html += '<td class="table_seat" id="cart-type-'+value.ticket_type_id+'">' + value.ticket_type_name + '</td>';

                        html += '<td class="table_seat seat_qty" id="cart-qty-'+value.ticket_type_id+'">' + value.qty + '</td>';

                        html += '<td class="table_seat" id="cart-rate-'+value.ticket_type_id+'">' + value.rate + '</td>';

                        html += '<td class="table_seat"><input disabled="disabled" type="number" class="form-control discount_input" name="discount[]" id="discount" onchange="updateCartDiscount('+value.ticket_type_id+', this.value)" placeholder="Type Discount" value="'+value.discount+'" style="width: 100%;text-align: center;color:green"></td>';

                        html += '<td class="table_seat cart-total" id="cart-total-'+value.ticket_type_id+'">' + value.total + '</td>';

                        html += '</tr>'; //end row
                    });

                    if($('#multiple').is(":checked")==false)
                    {
                        //show msg
                        $('#message').html('').removeClass('message-error');
                        $('#message').html(response.message).addClass('message-success');
                        $('#message').show();

                        setTimeout(function() {
                            $('#message').html('').removeClass('message-success');
                            $('#message').hide();
                        }, 2000);
                    }

                    
                } else {
                    html += '<tr>'; //start row
                    html += '<td colspan="5" class="text-center">No seats selected</td>';
                    html += '</tr>'; //end row
                    if($('#multiple').is(":checked")==false)
                    {
                        //show msg
                        $('#message').html('').removeClass('message-error');
                        $('#message').html(response.message).addClass('message-success');
                        $('#message').show();

                        setTimeout(function() {
                            $('#message').html('').removeClass('message-success');
                            $('#message').hide();
                        }, 2000);
                    }
                }
                $("#booking_detail").html(html);
                $("#grand-total").html(response.grand_total);
                $("#seat_ids").val(response.seat_ids);
            }
        }
    });
    }
}

function updateCartDiscount(ticket_type_id, value) {
    if(value != "") {
        var data = {
            _token: '{{ csrf_token() }}',
            ticket_type_id: ticket_type_id,
            discount: value,
        };

        $.ajax({
            type: 'POST',
            url: '{{ route("booking.update_cart_discount") }}',
            data: data,
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                var cartQty = parseInt($('#cart-qty-'+ticket_type_id).text());
                var cartRate = parseFloat($('#cart-rate-'+ticket_type_id).text());

                var updatedTotal = (cartRate - value) * cartQty;
                $('#cart-total-'+ticket_type_id).text(updatedTotal);

                var gTotal = 0
                $('.cart-total').each(function () {
                    gTotal = gTotal + parseFloat($(this).text());
                });

                $('#grand-total').text(gTotal);

                //show msg
                $('#message').html('').removeClass('message-error');
                $('#message').html(response.message).addClass('message-success');
                $('#message').show();

                setTimeout(function() {
                    $('#message').html('').removeClass('message-success');
                    $('#message').hide();
                }, 2000);
            }
        });
    }
}


function fetch_bms_id_exist(id)
{
    $('#message').hide();

    
    var bms_id = $("#"+id).val();
    var data = {
            _token: '{{ csrf_token() }}',
            bms_id: bms_id
        };
    
    $.ajax({
        type: 'POST',
        url: '{{ route("booking.fetch_bms_id_exist") }}',
        data: data,
        dataType: 'json',
        success: function(response) {
            if(response.is_exist=='YES')
            {
                $('#message').html('').removeClass('message-success');
                $('#message').html(response.message).addClass('message-error');
                $('#message').show();
                $("#"+id).focus();
                return false;
            }
            else
            {
                $('#message').hide();
            }
        }
    });
}

function clear_cart() {
var seat_ids = $("#seat_ids").val();
if (seat_ids != "") {
    Swal.fire({
    title: "Are you sure?",
    text: "You will not be able to recover this record!",
    type: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
    closeOnConfirm: true, //false
    closeOnCancel: true //false
}).then((isConfirm) => {
    if (isConfirm) {
        var data = {
            _token: '{{ csrf_token() }}',
            seat_ids: seat_ids
        };

        $.ajax({
            type: 'POST',
            url: '{{ route("booking.clear_cart") }}',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    window.location.reload();
                }
            }
        });
    }
});
} else {
alert('No seats selected.');
}
}

function fetch_customer(mobile_no) {
if (mobile_no != "") {
var data = {
    _token: '{{ csrf_token() }}',
    mobile_no: mobile_no
};

$.ajax({
    type: 'POST',
    url: '{{ route("booking.get_customer_by_mobile_no") }}',
    data: data,
    dataType: 'json',
    success: function(response) {
        if (response !== null) {
            $("#customer_name").val(response.customer_name);
            $("#email").val(response.email);
            $("#coupon_code").val(response.coupon_code);
        } else {
            $("#customer_name").val('');
            $("#email").val('');
            $("#coupon_code").val('');
        }
    }
});
} else {
$("#customer_name").val('');
$("#email").val('');
$("#coupon_code").val('');
}
}
</script>
<script>
$(document).ready(function() {
// $('#sidebar_hide').css('display', 'none');
});
$(document).ready(function() {
$('#body').addClass('sidenav-toggled');
});



function seat_rename(seat_name,seat_id) {
    //alert(seat_id);
    var id = seat_id;
    var name = seat_name;
    var data = {_token:'{{ csrf_token() }}', id:id, name: name};
     $.ajax({
            url: '{{ route('booking.update_event_seat_name') }}',
            type: 'POST',
            data: data,
            success: function(data) {
              //console.log(data);
            $('#success_rename').show().html('Seat Name Updated Successfully').fadeOut(700);
            }
        });
  }


function clear_discount_from_cart()
{
    var data = {
            _token: '{{ csrf_token() }}',
            user_id: <?php  echo  $user_id = \Auth::user()->id; ?>,
        };
        $.ajax({
            url: '{{ route('bookings.clear_discount_from_cart') }}',
            type: 'POST',
            data: data,
            success: function(data) {
                window.location=window.location.href;
                console.log('cls');
            }
        });
  }



  function redirect_rename_seat()
  {
    var loc = window.location.href;
    if(loc.indexOf('&renaming=true')>0)
    {
        loc= loc.replace("&renaming=true", "");
        window.location=loc;
    }
    else
    {
        window.location=loc+'&renaming=true';
    }
  }

  function redirect_seat_arrangement()
  {
    var loc = window.location.href;
    if(loc.indexOf('&seat_arrangement=true')>0)
    {
        loc= loc.replace("&seat_arrangement=true", "");
        window.location=loc;
    }
    else
    {
        window.location=loc+'&seat_arrangement=true';
    }
  }



    var loc =window.location.href;
    if(loc.indexOf('&renaming=true')>0)
    {
        $('#rename_seat').text('Turn Off Seat Renaming');
        $('.skip_label').show();
    }
    else
    {
        $('#rename_seat').text('Turn On Seat Renaming');
        $('.skip_label').hide();
    }

    if(loc.indexOf('&seat_arrangement=true')>0)
    {
        $('#seat_arrangement').text('Turn Off Seat Arrangement');
    }
    else
    {
        $('#seat_arrangement').text('Turn On Seat Arrangement');
    }




if($('input[name="payment_method_id"]:checked').val()=='discount cash')
{
    $('.discount_input').prop("disabled", false);
    $('.discount_input').prop("required", true);
}
else if ($('input[name="payment_method_id"]:checked').val()=='discount upi')
{
    $('.discount_input').prop("disabled", false);
    $('.discount_input').prop("required", true);

}
else
{
    $('.discount_input').prop("disabled", true);
    $('.discount_input').prop("required", false);
    $('.discount_input').val(0);
}





function check_for_pg(id, name)
{
    if(name=='discount cash')
    {
        $('.discount_input').prop("disabled", false);
        $('.discount_input').prop("required", true);
    }
    else if (name=='discount upi')
    {
        $('.discount_input').prop("disabled", false);
        $('.discount_input').prop("required", true);
    }
    else
    {
        $('.discount_input').prop("disabled", true);
        $('.discount_input').prop("required", false);
       
        var sum = 0;
        $('.discount_input').each(function() {
            sum += Number($(this).val());
        });
        $('.discount_input').val(0);
        if(sum>0)
        {
            clear_discount_from_cart();
        }
    }
    $('#choosen_payment_method').val(name.toUpperCase());
    if(name.toUpperCase()=='COMPLIMENTARY')
    {
        $('.hide_complementary').fadeIn();
    }
    else
    {
        $('.hide_complementary').fadeOut();
    }
   
}


function save_action()
    {
        var hide_show=$('input[name="hide_show"]:checked').val();
        if(hide_show=='ON')
        {
            var action='hide';
        }
        if(hide_show=='OFF')
        {
            var action='show';
        }
        if(hide_show=='RESERVE')
        {
            var action='reserve';
        }
        if(hide_show=='UNRESERVE')
        {
            var action='unreserve';
        }
        if(hide_show=='DAMAGED')
        {
            var action='damage';
        }
        if(hide_show=='UNDAMAGED')
        {
            var action='undamage';
        }

        if(hide_show=='RESERVE_CUSTOMER')
        {
            var action='reserve_customer';
        }
        if(hide_show=='UNRESERVE_CUSTOMER')
        {
            var action='unreserve_customer';
        }

    
        
        if(hide_show=='REMOVED')
        {
            var action='removed';
        }
        if(hide_show=='UNREMOVED')
        {
            var action='unremoved';
        }

        if(hide_show=='LABELED')
        {
            var action='labeled';
        }
        if(hide_show=='UNLABELED')
        {
            var action='unlabeled';
        }
        

        if(hide_show=='ON' || hide_show=='OFF' || hide_show=='RESERVE' || hide_show=='RESERVE_CUSTOMER' || hide_show=='UNRESERVE_CUSTOMER' || hide_show=='UNRESERVE'|| hide_show=='DAMAGED' || hide_show=='UNDAMAGED' || hide_show=='REMOVED' || hide_show=='UNREMOVED'|| hide_show=='LABELED' || hide_show=='UNLABELED') {
            var event_ticket_type_id = 0;
        } else {
            var event_ticket_type_id = hide_show;
        }

        var seat = [];
        $("input:checkbox[class=noSeatStorage]:checked").each(function () {
            var seat_id=$(this).val();
            seat.push(seat_id);
        });


         var data = {
            _token:'{{ csrf_token() }}',
            action:action,
            event_ticket_type_id:event_ticket_type_id,
            ids: seat,
            event_schedule_list_id:'{{ $esd_id }}',
            event_show_time_id:'{{ $est_id }}',
            event_ticket_id:''
            };

        $.ajax({
            url: '{{ route('event_ticket.update_event_seat_from_booking') }}',
            type: 'POST',
            data: data,
            success: function(data) {
                window.location.reload();
            }
        });

      
    }


    $('td').on('click', function () {
        var arr= $(this).prop('class');

        c=arr.split(" ").pop();

        d=arr.split(" ").at(-2);

        if(c.length==8)
        {
            if($('#multiple').is(":checked"))
            {
                //LabeledSeat
                if($('td.'+c).hasClass('noSeatStorage'))
                {
                    $('td.'+c).removeClass('noSeatStorage');
                    $('td.'+c).find('input:checkbox').removeClass('noSeatStorage');
                    $(this).find('input:checkbox').click();
                    $('td.'+c).find('input:checkbox').click();
                }
                else
                {
                    $('td.'+c).addClass('noSeatStorage');
                    // $('td.'+c).find('input:checkbox').removeClass('noSeatStorage');
                    $(this).find('input:checkbox').click();
                    $('td.'+c).find('input:checkbox').click();
                }
            }
        }

        if(d.length==8)
        {
            if($('#multiple').is(":checked"))
            {
                if($('td.'+d).hasClass('noSeatStorage'))
                {
                    $('td.'+d).removeClass('noSeatStorage');
                    $('td.'+d).find('input:checkbox').removeClass('noSeatStorage');
                    $(this).find('input:checkbox').click();
                    $('td.'+d).find('input:checkbox').click();
                }
                else
                {
                    $('td.'+d).addClass('noSeatStorage');
                    // $('td.'+d).find('input:checkbox').removeClass('noSeatStorage');
                    $(this).find('input:checkbox').click();
                    $('td.'+d).find('input:checkbox').click();
                }
            }
        }
    });

  
    function layout_label_rename(skip_label)
    {
        var data = {_token:'{{ csrf_token() }}', id: <?php echo "'".$event_ticket_id."'"; ?>, skip_label: skip_label};
        $.ajax({
            url: '{{ route('booking.update_event_label_name') }}',
            type: 'POST',
            data: data,
            success: function(data) {
            }
        });
    }

    // $( ".grabbable td" ).draggable();

</script>


<style>
    <?php if($user_with_role_data->is_admin!=1){?>

            .hiddenVisibility
            {
                visibility:  hidden !important;
            }
    <?php }


    ?>


</style>        
@endsection