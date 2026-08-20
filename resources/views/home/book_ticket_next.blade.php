<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{env('APP_NAME')}}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" >
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link  href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>
    <link  href="{{asset('assets/stage/stage.css')}}" rel="stylesheet">
    <link rel="icon" type="{{asset('assets/image/x-icon')}}" href="{{asset('assets/stage/logo.png')}}">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >-->
    
    @include('includes.analytics')
    <style>


        body {
            overflow-x: hidden;
        }
            
            
        .ticket_type_outer::-webkit-scrollbar {
          display: none;
        }
        
        /* Hide scrollbar for IE, Edge and Firefox */
        .ticket_type_outer {
          -ms-overflow-style: none;  /* IE and Edge */
          scrollbar-width: none;  /* Firefox */
        }

            .book-btns {
    display: flex;
    justify-content: center;
    gap: 10px;
    align-items: center;
    height: 100%;
}


        .zoom_info_mobile {
            display: none; /* Hidden by default */
            bottom: 7%;
        }
        
        .zoom_box {
            display: none; /* Hidden by default */
        }
        
        /*#final_pay */
        /*{*/
        /*    position:fixed;*/
        /*}*/
        
        
            
        @media only screen and (max-width: 768px) {
            .zoom_info_mobile {
                display: block; /* Visible on mobile */
                bottom: 80px;
                right:6%;
            }
            #final_pay 
            {
                position:relative;
                left :0 !important;
            }
            
            
            .tick {
                display: inline-block;
                width: 14px;
                height: 14px;
                margin-right: 3px;
                margin-left: 7px;
                border-radius: 20px;
                flex-direction: row;
            }


          
            .ticket_type_outer {
                display: flex;
                overflow-x: auto;
                scroll-behavior: smooth;
                height: 25px;
                white-space: nowrap;
                width:100%;
            
             
            }
            
            .ticket_type {
                display: inline-block;
                width:45%;
                padding:0px 6px;
            }
    
            
            /*#zoomOuter*/
            /*{*/
            /*    float:left;*/
            /*}*/

        }
        
        /* Show on desktop, hide on mobile and laptop */
        .zoom_info {
            display: none; /* Hidden by default */
        }
        
        @media only screen and (min-width: 1024px) {
            .zoom_info {
                display: block; /* Visible on desktop/laptop */
            }
            
            .zoom_box {
                display: block; /* Hidden by default */
            }
        }


        .overlay-summary {
            background: white;
            position: fixed;
            height: 100%;
            width: 100%;
            z-index: +999;
            top: 0;
            text-align: center;
            padding: 16%;
        }

        #header,
        footer {
            display: none;
        }
        
        
        .progress_sec {
            background-color: #fff;
            padding: 3px 0 8px;
            position: relative;
            overflow: hidden;
            
            max-width: 600px;
            margin: 3px auto 5px auto;
            border-radius: 5px;
            transform: translatey(13px);
            }

            .progress-bar {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                position: relative;
                gap: 0;
                padding: 0 16px;
                min-height: 52px;
            }

            .progress-bar .step {
                position: relative;
                z-index: 3;
                width: 100%;
                max-width: 120px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                gap: 4px;
                text-align: center;
                padding: 0;
            }

            .progress-bar .step .circle {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                border: 2px solid #e5e8f2;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 17px;
                font-weight: normal !important;
                margin-top: 10px;
                margin-bottom: 0;
                position: relative;
                line-height: 10px;
            }

            .progress-bar .step .circle span {
                display: block;
                width: auto !important;
                height: auto !important;
                background: transparent !important;
                border-radius: 0 !important;
            }

            .progress-bar .step.completed .circle {
                background: #234a9f;
                border-color: #234a9f;
                color: #fff;
            }

            .progress-bar .step.active .circle {
                background: #234a9f;
                border-color: #234a9f;
                color: #fff;
            }

            .progress-bar .step:not(.completed):not(.active) .circle {
                background: #eff3fb;
                border-color: #dce4f4;
                color: #7b84a1;
            }

            .progress-bar .step:not(:last-child)::after, .progress-bar .step:not(:first-child)::before {
                content: '';
                position: absolute;
                top: 26px;
                height: 4px;
                border-radius: 999px;
                z-index: 1;
            }

            .progress-bar .step:not(:last-child)::after {
                left: calc(42% + 35px);
                right: -100px;
            }

            .progress-bar .step:not(:first-child)::before {
                left: -156px;
                right: calc(53% + 19px);
                background: #eff3fb;
            }

            .progress-bar .step.completed::after, .progress-bar .step.active::before {
                background: linear-gradient(90deg, #1b49d9 0%, #234a9f 100%);
            }

            .progress-bar .step .label {
                font-size: 13px;
                font-weight: 500;
                color: #10214b;
            }

            .progress-bar .step.completed .label, .progress-bar .step.active .label {
                color: #234a9f;
            }

            .progress-bar .step .label {
                margin-top: 4px;
            }

            .progress-bar .step .label span {
                display: block;
                margin-top: 4px;
                color: #7b84a1;
                font-size: 12px;
                font-weight: 600;
            }

            .progress-bar .step .label.active {
                color: #234a9f;
            }

            @media (max-width: 720px) {
                .progress-bar {
                    padding: 0 8px;
                    min-height: 90px;
                }

                .progress-bar .step {
                    max-width: 90px;
                }
            }
            
            

        @media only screen and (max-width: 600px) {
            .container-fluid {
                margin-bottom: 100px;
                padding-bottom: 100px;
            }
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
        }

        #venue {
            width: auto;
            height: auto;
            background: white;
            z-index: 1;
            margin-left: -33px;
        }


        .focus_payment {
            border: 2px solid green;
            min-width: 905px;
            height: 75px;
            margin-bottom: 20px;
        }

        #venue .rows {
            width: 25px;
            float: left;
            empty-cells: show;
            margin-left: 30px;
            margin-top: 6px;
        }

        #venue .rows td {
            text-align: center;
    line-height: 27px;
    background: #2085ff;
    color: white;
    font-size: 13px;
    padding: 1px 8px;
    border-radius: 10px 10px;
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
            font-size: 10px;
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
            min-width: 25px;
            height: 25px;
            border: solid 1px #666;
            border-radius: 14px;
            text-align: center;
            cursor: pointer;

            background: white;
        }

        .seat_row td.row {
            background-color: transparent;
            border: none;
            font-weight: bold;
            padding-right: 7px;
        }

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
            text-align: center !important;
            border: 1px solid #808080;
            color: #817c7c;
            background: #bdbaba;
        }

        .seat_row td.DamagedSeat {
            text-align: center !important;
            border: 1px solid #808080;
            color: #817c7c;
            background: #bdbaba;

        }

        .seat_row td.ReservedSeat {
            text-align: center !important;
            border: 1px solid #808080;
            color: #817c7c;
            background: #bdbaba;
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
            text-align: center !important;
            border: 2px solid #ebebeb;
            color: #c4c4c4;
            background: #ebebeb;
        }


        .seat_row td.royal {
            border-color: #3851d1;
            color: #3851d1;
            font-weight: 600;
        }

        .seat_row td.gold {
            border-color: #14e01c;
            color: #14e01c;
            font-weight: 600;
        }

        .seat_row td.silver {
            border-color: #d92020;
            color: #d92020;
            font-weight: 600;
        }

        .seat_row th.royal {
            border-color: #3851d1;
            color: #3851d1;
            font-weight: 600;
        }

        .seat_row th.gold {
            border-color: #14e01c;
            color: #14e01c;
            font-weight: 600;
        }

        .seat_row th.silver {
            border-color: #d92020;
            color: #d92020;
            font-weight: 600;
        }

        .hiddenCheckbox input {
            opacity: 0;
            transform: scale(1.7);
            font-size: 10px;
        }


        .hiddenCheckbox div {
            font-size: 10px;
            line-height: 10px;
        }


        .hiddenVisibility {
            visibility: hidden;
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

        header#sm_header {
            display: none !important;
        }


        header#hd_header {
            display: block !important;
        }



        @media only screen and (max-width: 1280px) {
            header#sm_header {
                display: block !important;
            }

            header#hd_header {
                display: none !important;
            }

            #tile_body {
                float: none;
            }

            .legend_list {
                margin-top: 90px !important;
            }


        }

        @media only screen and (min-width: 468px) {


        }



        @media only screen and (min-width: 512px) {


            /*#final_pay {*/
            /*    margin: 13px -50px !important;*/
            /*}*/

            .legend_list {
                margin-top: 10px !important;
            }

        }

     

        .tooltip-text {
            visibility: hidden;
            position: absolute;
            z-index: 2;
            width: 100px;
            color: white;
            font-size: 12px;
            background-color: #073366;
            border-radius: 10px;
            padding: 10px 15px 10px 15px;
        }

        .tooltip-text::before {
            content: "";
            position: absolute;
            transform: rotate(45deg);
            background-color: #073366;
            padding: 5px;
            z-index: 1;
        }

        .hover-text:hover .tooltip-text {
            visibility: visible;
        }

        #top {
            top: -80px;
            left: -50%;
        }

        #top::before {
            top: 80%;
            left: 45%;
        }

        #bottom {
            top: 25px;
            left: -50%;
        }

        #bottom::before {
            top: -5%;
            left: 45%;
        }

        #left {
            top: -8px;
            right: 120%;
        }

        #left::before {
            top: 35%;
            left: 94%;
        }

        #right {
            top: -8px;
            left: 120%;
        }

        #right::before {
            top: 35%;
            left: -2%;
        }

        .hover-text {
            position: relative;
            font-family: Avenir;
            text-align: center;
        }


        .overflow-auto {
            overflow-y: hidden !important;
        }


        td.seat_label
        {
            text-align: center;
            line-height: 27px;
            color: #2085ff !important;
            font-size: 13px;
            padding: 0px;
            border-radius: 10px 10px;
            border:none;
            font-weight: bold;
        }

      
        .seat_row td.LabeledSeat, .seat_row td.LabeledSeat input {
            color: #fff;
            border: 0px;
            visibility: visible;
            opacity: 1;
        }

        .seat_row td.LabeledSeat {
            color: #000;
            border: 0;
            visibility: visible;
            opacity: 1;
            font-size: 20px;
            font-weight: bold;
        }

        .seat_row td.LabeledSeat div {
        margin-top:2px !important;
        font-size:15px !important
        }
        th.removedSeat {
            border:2px dashed black;
            color:black;
        }

        td.removedCheckbox {
        display:none
        }



<?php
$color_array = [];
$price_array = [];
$class_array = [];
$ticket_type_array = [];
$ticket_type_data_array = [];


if (count($event_seats) > 0) :
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
?>

        .btn-primary {
            background: #073366 !important;
            border: #073366;
        }

        .temporary_hold {
            background: orange !important;
        }

        time_box.change_date {
            border: none !important;
            font-size: 12px;
        }

        time_box.change_date p {
            color:brown !important;
        }

        .stage_outer .time_box.change_date:hover
        {
            background : white !important;
        }

        .stage_outer .time_box.active
        {
            background-color: #2196F3 !important;
            color: white !important;
        }

    </style>

</head>

<body style="overflow: hidden;">
    <?php 
        $event_data=getEvent($e_id);
        $event_title=ucwords($event_data->event_title);
        $city_data=getCity($event_data->city_id);
        $city_name=ucfirst($city_data->name);
        $venue_data=getVenue($event_data->venue_id);
        $venue_name=ucfirst($venue_data->name);
        $event_schedule_data=getEventScheduleList($esd_id);
        $event_date=$event_schedule_data->event_date;
        $event_date=date('D, d M Y', strtotime($event_date));
    ?>
    <header>
        <div class="logo">
            <a href="{{ route('index') }}"><img src="{{asset('assets/stage/logo.png')}}" alt="ops logo" style="height: auto;width: 90px;position: absolute;margin-top: -2px;object-fit: cover;">
            </a>
        </div>
        <div class="header">
            <div class="hder_icon" onclick="javascript:history.go(-1)" style="cursor:pointer"><img src="{{asset('assets/venue/left.png')}}" alt=""></div>
            <div class="header-title"><?php echo env('APP_NAME')?></div>
            <div class="header-icons">
                <div class="icon"><a href="{{ route('index') }}"><img src="{{asset('assets/stage/close.png')}}" alt="" style="width: 24px;height: 24px;"></a></div>
            </div>
        </div>
    </header>
    <!-- progress bar -->
    <?php
    $user_id = $user_id_temp;
    $seat_ids = [];
    $seat_ids = \App\Models\CustomerCart::where('user_id', $user_id)->where('status', 'ACTIVE')->pluck('seat_id')->toArray();
    if (!empty($seat_ids))
    {
        $seat_ids_str = simple_crypt(implode(',', $seat_ids));
    }
    else
    {
        $seat_ids_str = '';
    }

    $grand_total = 0;
    $net_grand_total = 0;
    $net_total_discount = 0;
    $total_ticket = 0;
    $cart_groups = \App\Models\CustomerCart::selectRaw('*, count(*) as total')->where('user_id', $user_id)->groupBy('ticket_type_id')->get();
    // dd($cart_groups);
    if (count($cart_groups) > 0) 
    {
        foreach ($cart_groups as $key => $cart_item)
        {
            $cart_ticket_type_id = $cart_item->ticket_type_id;
            $qty = $cart_item->total;
            $rate = $cart_item->rate;
            $discount = $cart_item->discount;
            $total_discount = $cart_item->discount * $qty;
            $total_ticket=$total_ticket+$qty;
            $net_total_discount = number_format($total_discount, 2);
            $total_amount = ($rate - $discount) * $qty;
            $grand_total = $grand_total + $total_amount;
            $net_grand_total = number_format($grand_total, 2);
        }
    }
   ?>
   <section class="progress_sec">
        <div class="progress-bar">
           
            <div class="step completed">
                <div class="circle"><span><i class="bi bi-check-lg"></i></span></div>
                <div class="label">Venue</div>
            </div>
            <div class="step completed">
                <div class="circle"><span><i class="bi bi-check-lg"></i></span></div>
                <div class="label">Date & Time</div>
            </div>
            <div class="step active">
                <div class="circle"><span>3</span></div>
                <div class="label">Seats</div>
            </div>
        </div>
    </section>


    <!-- stage -->
    <section class="venue_stage" style="margin-bottom: 130px;">
        <div class="stage_outer">
            <h4 style="text-align: center;margin-top: 10px;margin-bottom: 5px;background: #d0386f;color: white;"> <marquee style="line-height: 23px;    margin-top: 4px;"> 3 वर्ष और उससे अधिक आयु के बच्चे का पूरा टिकट लगेगा (Full Ticket for Children above 3 years) | Silver and Balcony seats do not have any seat number.</marquee></h4>
            <div class="time_top">

                <?php  
                foreach ($event_show_times as $single_show) 
                {?>
                <form class="card" method="post" action="{{ route('book_ticket_next') }}" id="book_ticket_next_{{$single_show->id}}">
                    @csrf
                    <input type="hidden" id="show_date_id" name="show_date_id" value="{{$esd_id}}">
                    <input type="hidden" id="show_time_id" name="show_time_id" value="{{$single_show->id}}">

                    <?php if($es_id==$single_show->id) { ?>
                        <div class="time_box active" onclick="change_show({{$single_show->id}})"  ><p>{{$single_show->start_time}}</p></div>
                    <?php }else {?>
                        <div class="time_box" onclick="change_show({{$single_show->id}})"  ><p>{{$single_show->start_time}}</p></div>
                    <?php }?>
                </form>
                <?php }?>
               

                <div class="time_box change_date" style="border:none">
                    <a href="{{ route('book_ticket')}}?event_id={{$single_show->event_id}}"><p style="color:brown; margin-top:-4px; font-size:12px; text-decoration:underline">Change Date</p></a>
                </div>
            </div>
        </div>
        <div class="ticket_type_outer">
            <?php 
            foreach($event_ticket_lists as $ets)
            {
                $tt_data=$ets->ticket_type_data;
                $ticket_type_name=$tt_data->ticket_type_name;
                $tt_color=$tt_data->color;
            ?>
            <div class="ticket_type">
                <div class="tick tick_1" style="background-color: <?php echo $tt_color; ?>;"></div>

                <?php
                
                    echo ' ₹ ';
                    echo round($ets->base_price);
                    echo ' ('.strtoupper($ticket_type_name).')';
                ?>
            </div>
            <?php } ?>

          
            <div class="ticket_type">
                <div class="tick tick_4">
                </div> UNAVAILABLE
            </div>

        </div>

        <span id="message"></span>
                
        <div class="zoom_info" style="width: 60px;position: fixed;right: 10%;bottom: 24%;z-index: +9999999;background: #3e6eea; width: 204px;color: white;padding: 16px;font-size: 14px;" >
        The layout can be zoomed in/out
        </div>
        
           <img  class='zoom_info_mobile'  style="position: fixed;left: 28%; z-index: 9999999;width: 100px; bottom:130px;padding: 16px;font-size: 17px;text-align: center;"  src="{{ asset('pinch.png') }}" > 
        
        <div class="zoom_info_mobile" style="position: fixed;left: 7%; z-index: 9999999;background: rgb(62, 110, 234);width: 290px;color: white;padding: 16px;font-size: 17px;text-align: center;" >Use Pinch action to Zoom In / Zoom Out the Layout
        </div>

        <div class="zoom_box" style=" width: 60px; position: fixed; right: 50px; bottom: 20%; z-index: +9999999;" >
                <button  id="zoomIn" class="btn" style="background: #868686;padding:5px; width:50px; text-align:center;font-size:30px ">+</button>
                <button  id="zoomOut" class="btn" style="background: #868686;padding:5px; margin-top: 4px;width:50px; text-align:center;font-size:30px">-</button>
        </div>
        <section style="overflow: hidden;user-select: none;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;width:auto" id="zoomOuter">
            <div class="chair_parent_outer chair_zoom_auto" id="zoomableElement" >
                <div class="chair-outer draggable_text" style=" transition: transform 0.1s ease 0s, left 0.1s ease 0s, top 0.1s ease 0s;overflow:hidden">
                    <div class="tile" id="tile_body">
                        <div class="tile-body">
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
            
                            $setting_data = getSetting(1);
                            $ticket_hold_time = $setting_data->ticket_hold_time;
                            $date = new DateTime;
                            $date->modify('-'.$ticket_hold_time.' minutes');
                            $current_time = $date->format('Y-m-d H:i:s');
                            ?>
            
                @if(count($event_seats) > 0)
                            <div class="row">
                             
                                <div class="col-md-6">
                                    <form action="{{ url('booking') }}" method="POST" id="booking_form">
                                        @csrf
                                
                                        
                                    <?php
                                    $user_id = $user_id_temp;
                                    $seat_ids = [];
                                    $seat_ids = \App\Models\CustomerCart::where('user_id', $user_id)->where('status', 'ACTIVE')->pluck('seat_id')->toArray();
                                    if (!empty($seat_ids))
                                    {
                                        $seat_ids_str = simple_crypt(implode(',', $seat_ids));
                                    }
                                    else
                                    {
                                        $seat_ids_str = '';
                                    }
            
                                    $grand_total = 0;
                                    $net_grand_total = 0;
                                    $net_total_discount = 0;
                                    $total_ticket = 0;
                                    $cart_groups = \App\Models\CustomerCart::selectRaw('*, count(*) as total')->where('user_id', $user_id)->groupBy('ticket_type_id')->get();
                                    if (count($cart_groups) > 0) 
                                    {
                                        foreach ($cart_groups as $key => $cart_item)
                                        {
                                            $cart_ticket_type_id = $cart_item->ticket_type_id;
                                            $qty = $cart_item->total;
                                            $rate = $cart_item->rate;
                                            $discount = $cart_item->discount;
                                            $total_discount = $cart_item->discount * $qty;
                                            $total_ticket=$total_ticket+$qty;
                                            $net_total_discount = number_format($total_discount, 2);
                                            $total_amount = ($rate - $discount) * $qty;
                                            $grand_total = $grand_total + $total_amount;
                                            $net_grand_total = number_format($grand_total, 2);
                                        }
                                    }
                                   ?>
                                    <input type="hidden" name="seat_ids" id="seat_ids" value="{{ $seat_ids_str }}">
                                    <input type="hidden" name="event_id" value="{{ $e_id != '' ? simple_crypt($e_id) : '' }}">
                                    <input type="hidden" name="event_schedule_id" value="{{ $es_id != '' ? simple_crypt($es_id) : '' }}">
                                    <input type="hidden" name="event_schedule_list_id" value="{{ $esd_id != '' ? simple_crypt($esd_id) : '' }}">
                                    <input type="hidden" name="event_show_time_id" value="{{ $est_id != '' ? simple_crypt($est_id) : '' }}">
                                    <input type="hidden" name="venue_id" value="{{ $venue_id != '' ? simple_crypt($venue_id) : '' }}">
                                    <input type="hidden" name="layout_id" value="{{ $layout_id != '' ? simple_crypt($layout_id) : '' }}">
                                    <input type="hidden" name="uit" value="{{ $user_id_temp != '' ? simple_crypt($user_id_temp) : '' }}">
                                    </form>
                                </div>
                            </div>
                    <div class="row" style="">
                        <div class="col-md-12" id="main_area">
                            <div id="seatmap" style="display:none"> 
                                <div id="venue" style="display:flex">
                                        @foreach($layouts as $key => $layout)
                                        @endforeach
                                            <?php 
                                            $layout_data=getLayout($layout->id);
                                            if($layout_data->stage_direction=='UP'){?>
                                            <table>
                                            <tr>
                                            <td style="background-color:#073366; text-align:center;color:White;width: 100%; text-transform:uppercase;">ALL EYES THIS WAY PLEASE<td></tr>
                                            </table>
                                            <?PHP } ?>

                                            <table class="seat_row " >

                                                <?php
                                                $condition=[];
                                                $condition['event_id']=$event_id;
                                                $condition['event_schedule_list_id']=$event_schedule_list_id;
                                                $condition['event_show_time_id']=$event_show_time_id;
                                                $condition['layout_id']=$layout_id;
                                               
                                                $seat_master_array=[];
                                                $all_seat_data=fetch_all_seat_data($condition);
            
            
                                                $cart_master_array=[];
            
                                                $all_cart_data=fetch_all_cart_seat(0);
            
                                                foreach($all_cart_data as $single_seat)
                                                {
                                                    $cart_master_array[]=$single_seat->seat_id;
                                                }
            
                                                foreach($all_seat_data as $single_seat)
                                                {
                                                    $seat_master_array[$single_seat->id]=$single_seat;
                                                }
                                                
            
                                                $seat_cart_master_array=[];
                                                $all_cart_seat_data=fetch_all_customer_cart_seat($user_id_temp);
            
                                                $current_show_cart_seat=fetch_current_show_cart_seat($condition);
            
                                                $current_show_master_array[0]=0;
                                                foreach($current_show_cart_seat as $single_cart_seat)
                                                {
                                                    $current_show_master_array[$single_cart_seat->seat_id]=$single_cart_seat;
                                                }
            
            
                                                $seat_cart_master_array[0]=0;
                                                foreach($all_cart_seat_data as $single_cart_seat)
                                                {
                                                    $seat_cart_master_array[$single_cart_seat->seat_id]=$single_cart_seat;
                                                }
                                                ?>
                                            </table>
                                            <div class="seat_row overflow-hidden"> 
                                                <table>
                                                    <!-- Making blank space for labels -->
                                                    <tr class="wingRowTop" style="visibility: hidden;">
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
                                                            echo "<tr>";
                                                            for ($j = 1; $j <= $col_no; $j++)
                                                            {
            
                                                                $seat_id = $seat_id_data[$i][$j];
                                                                $seat_details = $seat_master_array[$seat_id];
                                                                $seat_name = $seat_details->name;
                                                                $label = $seat_details->label;
                                                                $base_price = $seat_details->base_price;
                                                                $seat_name = '<div style="margin-top:-22px; text-align:center">'.$seat_name.'</div>';
            
                                                                $ij_visibility = ($seat_details->is_visible=='YES' ? TRUE : FALSE );
            
                                                                $is_reserved_for_customer = ($seat_details->is_reserved_for_customer=='YES' ? TRUE : FALSE );
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

                                                                if($ij_removed)
                                                                {
                                                                    echo "<td title=" . $seat_id . " class='removedCheckbox removedVisibility'><input type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                                                                }
                                                                else
                                                                {
                                                                    if (!empty($ij_visibility))
                                                                    {
                                                                        $ij_damaged = ($seat_details->is_damaged=='YES' ? TRUE : FALSE );
                
                                                                        if (!$ij_damaged)
                                                                        {
                                                                            $ij_reserved = ($seat_details->is_reserved=='YES' ? TRUE : FALSE );
                                                                            if (!$ij_reserved && !$is_reserved_for_customer)
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
                
                                                                                $hold_flag=false;
                                                                                if(in_array($seat_id, $customer_cart))
                                                                                {
                                                                                    $hold_flag=true;
                                                                                }
                
                                                                                if(count($cart_master_array) >0)
                                                                                {
                                                                                    if(in_array($seat_id, $cart_master_array))
                                                                                    {
                                                                                    
                                                                                        $hold_flag=true;
                                                                                    }
                                                                                }
                                                                                
                                                                                
                
                                                                                if ($tt_data->event_ticket_type_id)
                                                                                {
                                                                                    $tt_id = $tt_data->event_ticket_type_id;
                                                                                    $seat_class = $class_array[$tt_id];
                                                                                    $book_id = $tt_data->booking_id;
                
                                                                                    if ($seat_id == $cart_seat_id) {
                                                                                        //show selected seat
                                                                                        echo "<td title=" . $seat_id . " class='" . $seat_class . " hiddenCheckbox noSeatStorage'><input title='" . $seat_class . "' type='checkbox' value=" . $seat_id . " class='noSeatStorage' checked>" . $seat_name . "</td>";
                                                                                    } else {
                                                                                        if ($book_id != '') {
                                                                                            //show booked seat
                                                                                            echo "<td title=" . $seat_id . " class='bookSeat hiddenCheckbox'><input title='" . $seat_class . "' type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                                                                                        } else {
                
                                                                                            if($hold_flag==false)
                                                                                            {

                                                                                                if($ij_labeled==true)
                                                                                                {
                                                                                                    echo "<td title=" . $seat_id . " class='LabeledSeat  hiddenCheckbox'>" . $seat_name ."</td>";
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    echo "<td title=" . $seat_id . " class='" . $seat_class . "  hiddenCheckbox hover-text'>
                                                                                                    <span class='tooltip-text' id='top'>" . strtoupper($seat_class) .'<br> (₹ '. $base_price .")</span>
                                                                                                    <input title='" . $seat_class . "' type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                                                                                                }
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                echo "<td title=" . $seat_id . " class='hiddenCheckbox bookSeat'>
                                                                                                <span class='tooltip-text' id='top'>" . strtoupper($seat_class) .'<br> (₹ '. $base_price .")</span>
                                                                                                <input title='" . $seat_class . "' type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo "<td title=" . $seat_id . " class='seatAvailable hiddenCheckbox text-dark'><input type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                echo "<td title=" . $seat_id . " class='ReservedSeat hiddenCheckbox'><input type='checkbox' value=" . $seat_id . " >" . $seat_name . "</td>";
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            echo "<td title=" . $seat_id . " class='DamagedSeat hiddenCheckbox'><input type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                                                                        }
                                                                            
                                                                    } 
                                                                    else
                                                                    {
                                                                        echo "<td title=" . $seat_id . " class='hiddenCheckbox hiddenVisibility'><input type='checkbox' value=" . $seat_id . ">" . $seat_name . "</td>";
                                                                    }
                                                                }
                                                            }
                                                            echo "</tr>";
                                                            $char++;
                                                        }
                                                    ?>
                                                </table>
                                                
                                            </div>

                                       

                                </div>
                                <table style="z-index: +99;width: 70%;margin: 27px auto;HEIGHT: 120PX;COLOR: BLACK;">
                                    <tbody><tr>
                                        <td style="COLOR: BLACK;border: 1px solid #000000;text-align:center;color: BLACK;FONT-SIZE: 50PX;text-transform:uppercase;WIDTH: 100%;">STAGE</td><td>
                                    </td></tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                  

                </div>
            </div>
        </section>
       
       
         <div class="row" style="color: black;background: #daf0ff;z-index: 9999;width:100%;height: 73px;font-size: 22px;bottom: 0px;position: fixed;border-top: 1px solid #9ebaef; display: flex; justify-content: center; align-items: center; <?php if($total_ticket==0) { echo 'display:none'; }?>" id="pay_btn_div" >
      
            <div class="book-btns">
                <button class="btn btn-primary transition-3d-hover" id="final_pay" 
                style="height: 40px;line-height: 16px;text-wrap:nowrap">
                    Pay ₹ {{$net_grand_total}} for {{$total_ticket}} seats
                </button>
                
                <button class="btn btn-danger transition-3d-hover" id="cancel_btn" 
                onclick="cancel_ticket_redirect()" 
                style="background-color:#d1386f;height: 40px;line-height: 16px;width: auto">
                    Cancel
                </button>
            </div>
        </div>




            <div class="overlay-summary" style="display: none;">
                <!-- <img  id='loader_img' src="{{ asset('home/image/loader.gif') }}" > -->
                <div class="row">
                    <div class="col-md-8" id="booking_detail">
                        
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>

        <script type="text/javascript">

        function isMobileDevice() {
            return /Mobi|Android/i.test(navigator.userAgent);
        }

        var elem = document.getElementById('zoomableElement');
        var zoomin_button = document.getElementById('zoomIn');
        var zoomout_button = document.getElementById('zoomOut');



        window.addEventListener("DOMContentLoaded", (event) => {
            var zoomSpeed = 0.2; // Adjust this value to control zoom speed

            function customZoom(event) {
                event.preventDefault(); // Prevent default scroll behavior
                
                // Calculate zoom direction and amount
                const delta = Math.sign(event.deltaY);
                const scaleFactor = delta > 0 ? 1 / (1 + zoomSpeed) : 1 + zoomSpeed;
                
                // Get current scale
                const currentScale = panzoom.getScale();
                
                // Calculate new scale
                const newScale = Math.max(0.30, Math.min(1.8, currentScale * scaleFactor));
                
                // Apply zoom
                panzoom.zoom(newScale, { animate: true });
            }

            if (isMobileDevice())
            {
               
                var panzoom = Panzoom(elem, {
                    minScale: 0.30,
                    maxScale: 1.8,
                    startX: -410,
                    startY: -381,
                    duration: 700,
                    easing: 'ease-in-out',
                    pinchAndPan: true,
                });
                panzoom.pan(1, 1);
                panzoom.zoom(0.35, { animate: true });
                zoomin_button.addEventListener('click', panzoom.zoomIn);
                zoomout_button.addEventListener('click', panzoom.zoomOut);
                elem.parentElement.addEventListener('wheel', panzoom.zoomWithWheel);
                $('#seatmap').fadeIn("1000");
            }
            else
            {
               var starx= $(window).height()-$('#seatmap').height();
               starx=parseInt(starx)*-1;
               
                var panzoom = Panzoom(elem, {
                    minScale: 0.30,
                    maxScale: 1.8,
                    startX: -400,
                    startY: -281,
                    duration: 700,
                    step: 0.6,
                    easing: 'ease-in-out',
                    pinchAndPan: true,
                });

                panzoom.pan(1, 1);
                panzoom.zoom(0.35, { animate: true });
                zoomin_button.addEventListener('click', panzoom.zoomIn);
                zoomout_button.addEventListener('click', panzoom.zoomOut);
                elem.parentElement.addEventListener('wheel', customZoom);
                $('#seatmap').fadeIn("1000");
            }
        });
       



        </script>

        </div>



    </section>


    <style>



        .zoom {
            width: 30px;
            display: flex;
            height: 45%;
            flex-direction: column;
            justify-content: end;
            align-items: end;
            position: fixed;
            right: 20%;
            bottom: 100px;
            /* Position the element 100px above the bottom of the viewport */

        }


        .container {
            background-color: #d4eaf6;
            height: 60px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            bottom: 0;
        }

        .btn {
        
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-pay {
            background-color: #073263;
        }

        .btn-cancel {
            background-color: #eb4c77;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>


<script>
    $('input[type=checkbox]').change(function() {
    var id = $(this).val(); // this gives me null
    var check_status = $(this).is(':checked');

    var parent_class=$(this).parent().prop( "class" );
    var current_class=$(this).prop( "class" );
        
    if((parent_class.indexOf('DamagedSeat') != -1))
    {
        return false;
    }
    else if (parent_class.indexOf('ReservedSeat') != -1)
    {
        return false;
    }
    else if (parent_class.indexOf('bookSeat') != -1)
    {
        return false;
    }
    else if (parent_class.indexOf('temporary_hold') != -1)
    {
        return false;
    }
    else
    {
        add_to_cart(id, check_status);
    }
});

function add_to_cart(event_seat_id,  check_status) {
    
   
    var discount = $('#discount').val();
    var event_schedule_list_id = $('input[name="event_schedule_list_id"]').val();
    var event_show_time_id = $('input[name="event_show_time_id"]').val();
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
        url: '{{ route("customer_add_to_cart") }}',
        data: data,
        dataType: 'json',
        success: function(response) {
            // console.log(response);
            if (response.status == 'error')
            {
                $('#message').html('').removeClass('message-success');
                $('#message').html(response.message).addClass('message-error');
                $('#message').show();

                setTimeout(function() {
                    $('#message').html('').removeClass('message-success');
                    $('#message').hide();
                }, 4000);
            }
            else
            {
                var html = "";
                if (response.status == 'success' && response.data.length > 0)
                {
                    $.each(response.data, function(key, value)
                    {
                        html += '<tr>'; //start row

                        html += '<td class="table_seat" id="cart-type-'+value.ticket_type_id+'">' + value.ticket_type_name + '</td>';

                        html += '<td class="table_seat seat_qty" id="cart-qty-'+value.ticket_type_id+'">' + value.qty + '</td>';

                        html += '<td class="table_seat" id="cart-rate-'+value.ticket_type_id+'">' + value.rate + '</td>';

                        html += '<td class="table_seat cart-total" id="cart-total-'+value.ticket_type_id+'">' + value.total + '</td>';

                        html += '</tr>'; //end row
                    });
                     
                    if(response.action=='deleted')
                    {
                        $('input[value="'+event_seat_id+'"]').removeClass('noSeatStorage');
                        $('input[value="'+event_seat_id+'"]').parent().removeClass('noSeatStorage');

                        $('#message').html('').removeClass('message-success');
                        $('#message').html(response.message).addClass('message-error');
                        $('#message').show();

                        setTimeout(function() {
                            $('#message').html('').removeClass('message-error');
                            $('#message').hide();
                        }, 4000);

                    }
                    else if(response.action=='added')
                    {
                        
                        
                        
    
                        $('input[value="'+event_seat_id+'"]').addClass('noSeatStorage');
                        $('input[value="'+event_seat_id+'"]').parent().addClass('noSeatStorage');

                        $('#message').html('').removeClass('message-error');
                        $('#message').html(response.message).addClass('message-success');
                        $('#message').show();

                        setTimeout(function() {
                            $('#message').html('').removeClass('message-success');
                            $('#message').hide();
                        }, 4000);
                        
                        
                        const seatType = $('input').filter(`[value="${event_seat_id}"]`).attr('title').toUpperCase();
                        const seatTypeText = $('td').filter(`[title="${event_seat_id}"]`).find('span').text();
                        const priceMatch = seatTypeText.match(/₹\s*(\d+(\.\d{1,2})?)/);
                        
                        var seatValue = 0;
                        if (priceMatch) {
                            seatValue = priceMatch[1];
                        }

                        posthog.capture('Seat Added', {
                            seat_type: seatType,
                            seat_value: seatValue
                        });
                        console.log('Seat Added');
                        
                    }

                    
                }
                else
                {
                    html += '<tr>'; //start row
                    html += '<td colspan="4" class="text-center">No seats selected</td>';
                    html += '</tr>'; //end row


                    if(response.action=='deleted')
                    {
                        $('input[value="'+event_seat_id+'"]').removeClass('noSeatStorage');
                        $('input[value="'+event_seat_id+'"]').parent().removeClass('noSeatStorage');

                        $('#message').html('').removeClass('message-success');
                        $('#message').html(response.message).addClass('message-error');
                        $('#message').show();

                        setTimeout(function() {
                            $('#message').html('').removeClass('message-error');
                            $('#message').hide();
                        }, 4000);
                        }
                    else if(response.action=='added')
                    {
                        $('input[value="'+event_seat_id+'"]').addClass('noSeatStorage');
                        $('input[value="'+event_seat_id+'"]').parent().addClass('noSeatStorage');

                        $('#message').html('').removeClass('message-error');
                        $('#message').html(response.message).addClass('message-success');
                        $('#message').show();

                        setTimeout(function() {
                            $('#message').html('').removeClass('message-success');
                            $('#message').hide();
                        }, 4000);
                        
                        const seatType = $('input').filter(`[value="${event_seat_id}"]`).attr('title').toUpperCase();
                        const seatTypeText = $('td').filter(`[title="${event_seat_id}"]`).find('span').text();
                        const priceMatch = seatTypeText.match(/₹\s*(\d+(\.\d{1,2})?)/);
                        
                        var seatValue = 0;
                        if (priceMatch) {
                            seatValue = priceMatch[1];
                        }

                        posthog.capture('Seat Added', {
                            seat_type: seatType,
                            seat_value: seatValue
                        });
                        console.log('Seat Added');
                    }
                }

                $("#booking_detail").html(html);
                $("#grand-total").html(response.grand_total);
                $("#seat_ids").val(response.seat_ids);

                if(response.total_ticket>0)
                {
                    $('.seat_count').html(response.total_ticket+' Seats');
                    $('#pay_btn_div').fadeIn('fast');
                    $('.container-fluid').css('padding-bottom', '50px');
                    $('#final_pay').text('Pay ₹ '+response.grand_total+' for '+response.total_ticket+' seats');
                }
                else
                {
                    $('.seat_count').html('0 Seats');
                    $('#pay_btn_div').fadeOut('fast');
                    $('.container-fluid').css('padding-bottom', '0px');

                }
            }
        }
    });
    }
}

<?php if($total_ticket>0) { ?>
$('.container-fluid').css('padding-bottom', '50px');
<?php } ?>

function change_show(id)
{
    $('.seatmap').html('<i class="fa fa-spin fa-10x fa-spinner" style="text-align:center; margin:0 auto;"></i>');
            $('.seatmap').css('width', '100%')
            .css('height', '100%')
            .css('background', 'white')
            .css('text-align','center')
            .css('margin-top','80px');

    var data = {  _token: '{{ csrf_token() }}'};
    $.ajax({
        type: 'POST',
        url: '{{ route("seat_reserve_clear") }}',
        data: data,
        dataType: 'json',
        beforeSend: function ()
        {
           
            
        },
        success: function(response)
        {
            if (response.status == 'success' )
            {
                $('#book_ticket_next_'+id).submit();
            }
        }
    });
}

function show_booking_summary()
{
    $('.overlay-summary').fadeIn();

}

$('#final_pay').on('click', function () {
    
    const seatDetails = [];

    // Loop through each row in the #booking_detail div
    $('#booking_detail tr').each(function() {
        const seatType = $(this).find('.table_seat').eq(0).text(); // Get seat type (GOLD)
        const seatQty = $(this).find('.seat_qty').text(); // Get seat quantity (9)
        const seatRate = $(this).find('.table_seat').eq(2).text(); // Get seat rate (250.00)
        const seatTotal = $(this).find('.cart-total').text(); // Get seat total (2,250.00)

        // Store the details in the seatDetails array
        seatDetails.push({
            seat_type: seatType,
            seat_qty: seatQty,
            seat_rate: seatRate,
            seat_total: seatTotal
        });
    });
    
    posthog.capture('Proceed to Payment', {
        total_seat_details: seatDetails, // Add all seat details to the event
        total_amount: seatDetails.reduce((acc, seat) => acc + parseFloat(seat.seat_total.replace(',', '')), 0) // Calculate the total amount
    });
        
        
    $(this).html('<i class="fa fa-spin fa-spinner"></i> Please Wait..').attr('disabled', true);
    // RZ_Payment();
    window.location.href='{{ route("customer_payment") }}';
});



function cancel_ticket_redirect()
{

    var data = {  _token: '{{ csrf_token() }}'};
    $.ajax({
        type: 'POST',
        url: '{{ route("seat_reserve_clear") }}',
        data: data,
        dataType: 'json',
        beforeSend: function ()
        {
            $('.seatmap').css('text-align','center').css('margin-top','80px').html('<i class="fa fa-spin fa-10x fa-spinner" style="text-align:center; margin:0 auto;"></i>')
        },
        success: function(response)
        {
            window.location.href='{{route("index")}}';
        }
    });

}

var zoomHeight= $(window).height();
var zoomWidth = $(window).width();



$('#zoomOuter').css('height', zoomHeight);
// $('#pay_btn_div').css('width', zoomWidth);


// $('#pay_btn_div').css('position', 'absoulte');

function reportWindowSize() {
    var innerHeight = window.innerHeight;
  var innerWidth = window.innerWidth;
  var pay_btn_div=180;
  var pay_btn_div_width=(innerWidth-pay_btn_div)/2;
//   $('#final_pay').css('left', parseInt(pay_btn_div_width-60));
//   $('#cancel_btn').css('left', parseInt(pay_btn_div_width+150));
   if(innerWidth<372)
    {
        $('#show_time_header').css('font-size', '12px');
        $('.change_show_btn').css('font-size', '10px');
    }

    if(innerWidth<335)
    {
        $('#show_time_header').css('font-size', '10px');
        $('.change_show_btn').css('font-size', '8px');

    }

    if(innerWidth>372)
    {
        $('#show_time_header').css('font-size', '12px');
        $('.change_show_btn').css('font-size', '11px');

    }
  
}


window.addEventListener('resize', reportWindowSize);


// let innerHeight = window.innerHeight;
// let innerWidth = window.innerWidth;
// let pay_btn_div=180;
// let pay_btn_div_width=(innerWidth-pay_btn_div)/2;
// $('#final_pay').css('left', parseInt(pay_btn_div_width-60));
// $('#cancel_btn').css('left', parseInt(pay_btn_div_width+150));

if(innerWidth<372)
{
    $('#show_time_header').css('font-size', '12px');
    $('.change_show_btn').css('font-size', '10px');
    $('#legend_box').css('padding-bottom', '40px');
}

if(innerWidth<335)
{
    $('#show_time_header').css('font-size', '10px');
    $('.change_show_btn').css('font-size', '8px');
}

if(innerWidth>372)
{
    $('#show_time_header').css('font-size', '12px');
    $('.change_show_btn').css('font-size', '11px');

}

if(innerWidth<576)
{
    $('#legend_box').css('padding-bottom', '40px');
}

setTimeout(function() {$('#zoomIn').click();}, 400);
setTimeout(function() {$('.zoom_info').hide(); $('.zoom_info_mobile').hide();}, 10000);
</script>
</body>
</html>