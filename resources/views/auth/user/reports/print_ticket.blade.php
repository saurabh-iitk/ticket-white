@extends('layouts.dashboard')

@section('title', 'Print Ticket')

@section('css')
    <style type="text/css" media="all">
        .rotate_layout {
            margin-top: 35px;
            margin-left: 15px;
        }

        .single_ticket {
            /* page-break-after: auto; */
        }

        .counting_label {
            background: black;
            color: white;
            font-weight: bold;
            font-size: 30px;
            margin-left: -20px;
            margin-right: -20px;
            text-align: center;
            padding-left: 40px;
        }
        
        .counting_label2 {
            background: black;
            color: white;
            font-weight: bold;
            font-size: 30px;
            margin-left: -20px;
            margin-right: -20px;
            text-align: center;
            padding-left: 140px;
        }

        .ticket_icon img {
            /* margin: 0 30px; */
            text-align: center !important;
            width: 260px;
        }

        .ticket_icon
            {
            text-align: center !important;
                
            }
            
        @media print {

            .ticket_icon
            {
            text-align: center !important;
                
            }
            .ticket_icon img {
                /* margin: 0 30px; */
                
                width: 260px;
            }

            .counting_label {
                background: black;
                color: white;
                font-weight: bold;
                font-size: 30px;
                margin-left: -20px;
                text-align: center;
                padding-left: 10px;
            }
            
            .counting_label2 {
                background: black;
                color: white;
                font-weight: bold;
                font-size: 30px;
                margin-left: -20px;
                margin-right: -20px;
                text-align: center;
                padding-left: 140px;
            }

            .single_ticket {
                /* page-break-after: auto; */
                margin: 0 auto;
            }

            .rotate_layout {
                /*  */
                /*margin-top: -10px;*/
                margin-top: 25px;
            }

            body {
                display: flex;
            }

            /*@page { margin: 0; }*/
            .no-print {
                display: none;
            }
        }

        .dashed {
            border: 1px dashed;
        }

        .border-left-dashed {
            border-left: 1px dashed;
        }

        .border-right-dashed {
            border-right: 1px dashed;
        }

        .dotted {
            border: 1px dotted;
        }

        .border-left-dotted {
            border-left: 1px dotted;
        }

        .border-right-dotted {
            border-right: 1px dotted;
        }

       
    </style>
@endsection

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <?php $current_url = Session::get('current_url'); ?>
                <h1><i class="fa fa-bar-chart"></i> Print Ticket</h1>
                <input type="button" class="btn btn-primary" value="< Go Back"
                    onclick="javascript:window.location='<?php echo $current_url; ?>'"
                    style="float:right;position: absolute;right: 6%;top: 9%;">
            </div>
        </div>
        <div class="row"  style=" margin:0; padding:0">
                <div class="tile" style="padding:40px; margin:0 auto; border:1px solid black">
                    <div class="tile-body" style="margin:0; padding:0">
                        <?php
                        $seat_no_arr = [];
                        $seat_no_arr_count = [];
                        $total_paid_amount = $booking->paid_amount;
                        
                        
                        $event_data =  getEvent($booking->event_id);
                        $event_gst_no = $event_data['gst_no'];
  

                        $gst_rate = 18;
                        $total_quantity = $booking['total_quantity'];
                        $paid_amount = $booking['paid_amount'];
                        $taxable_amount = $booking['taxable_amount'];
                        $is_gst_applicable = $booking['is_gst_applicable'];
                        $gst_amount = $booking['gst_amount'];
                  

                        ?>
                        <br class="no-print">
                        @if ($booking_details)
                            @foreach ($booking_details as $key => $booking_detail)
                                <?php
                                $payment_method_name = fetch_payment_method($booking_payment->payment_method_id);
                                $seat_name = fetch_seat_no($booking_detail->seat_id);
                                $row_no = $seat_name->row_no;
                                $base_price = $seat_name->base_price;
                                $total_discount = $seat_name->total_discount;
                                $final_ticket_rate = round($base_price - $total_discount);
                                // $layout_row_label = getLayout($seat_name->layout_id)->layout_row_label;
                                // $layout_row_label = explode(',', $layout_row_label);
                                // $row_name = $layout_row_label[$row_no - 1];
                                
                                if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW') {
                                    $seat_no_arr[] = $seat_name->label . $seat_name->name;
                                }
                                
                                $seat_no_arr_count[] = $seat_name->label . $seat_name->name;
                                
                                if (getTicketType($booking_detail->ticket_type_id)) {
                                    $ttype = getTicketType($booking_detail->ticket_type_id)->ticket_type_name;
                                }

                                ?>
                            @endforeach
                            <div class="counting_label">
                                <?php echo $ttype; ?> - <?php echo count($seat_no_arr_count); ?>
                            </div>

                            <div class="row single_ticket" style="margin: 0; padding:0">
                                <div class="" style="width:100%; margin:0; padding:0;">

                                    <div class="ticket_icon">
                                        <!--<img src="{{ asset('ticket_icon_hero.png') }}" alt="">-->
                                        <img src="{{ asset('ticket_icon.png') }}" alt="">
                                        <!--<img src="{{ asset('ticket_icon_tvs.png') }}" alt="">-->
                                   
                                    </div>
                                 
                                    <table class="rotate_layout" style="text-align:center;  margin:0 auto;;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h3>
                                                        <?php
                                                        if (getEvent($booking->event_id)) {
                                                            $event = getEvent($booking->event_id);
                                                            echo $event->event_title_ticket;
                                                        }
                                                        ?>
                                                    </h3>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h3>
                                                        <?php
                                                        if (getVenue($booking->venue_id)) {
                                                            $venue = getVenue($booking->venue_id);
                                                            echo $venue->name;
                                                        }
                                                        ?>
                                                    </h3>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h3>
                                                        <?php
                                                        if (getEventScheduleList($booking->event_schedule_list_id)) {
                                                            $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                                                            echo date('D d M Y', strtotime($event_date));
                                                        }
                                                        ?>
                                                    </h3>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h3>
                                                        <?php
                                                        if (getEventShowTime($booking->event_show_time_id)) {
                                                            $event_show_time = getEventShowTime($booking->event_show_time_id);
                                                            echo $event_show_time->start_time;
                                                        }
                                                        ?>
                                                    </h3>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h3></h3>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                   
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h4>


                                                        <?php
                                                        if ($payment_method_name->show_hide_price == 'SHOW') {
                                                            if ($seat_name->total_discount > 0) {
                                                                echo 'Discounted Rate : &#8377; ' . number_format($total_paid_amount, 2);
                                                            } else {
                                                                echo $payment_method_name->name . ' : &#8377; ' . number_format($total_paid_amount, 2);
                                                            }
                                                        } else {
                                                            echo $payment_method_name->name;
                                                        }
                                                        ?>
                                                        <br>
                                                        <div style="font-size:28px;margin-left: -1px;line-height: 55px;">
                                                            @if (getTicketType($booking_detail->ticket_type_id))
                                                                {{ getTicketType($booking_detail->ticket_type_id)->ticket_type_name }}
                                                            @endif
                                                        </div>

                                                    </h4>
                                                    <h4 style="font-size:28px;margin-left: -1px;">
                                                        @if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW')
                                                         Seat No : <div style="word-wrap: break-word; max-width:400px">
                                                                                                  
                                                                <?php  
                                                            
                                                                // sort($seat_no_arr, 2);
                                                                echo implode(', ', $seat_no_arr); ?></div>
                                                        @endif
                                                    </h4>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td> <h4>{{'Booking ID: ' . $booking->booking_id_str}}</h4> </td>
                                            </tr>

                                            
                                            
                                            
                                            <tr>
                                                <td>
                                                    <ol
                                                    style="text-align:left;font-size: 15px;">
                                                    <li>This tickets is allowed only for this show.</li>
                                                    <li>Ticket is mandatory for children age above 3 Years.</li>
                                                    <li>Drunken people are not allowed.</li>
                                                    <li>All admission rights are reserved by management.</li>
                                                </ol>
                                                </td>
                                            </tr>
    
                                            
                                            <tr>
                                                <td style="font-family: sans-serif;    font-size: 15px;   font-weight:600; padding-top: 17px; padding-bottom: 10px;"> 
                                                <h4>Ticket QR Code</h4>
                                                <img crossorigin="anonymous" src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo simple_crypt($booking->id)?>&size=200x200" alt="QR Code" style="width:170px">
                                                <h3 style="margin-top:10px;letter-spacing: 5px;font-size: 30px;">{{$booking->booking_id_str}}</h3> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                     <h3><?php
                                                    if ($payment_method_name->show_hide_price == 'SHOW') {
                                                        echo 'Ticket Rate : &#8377; ' . $booking_detail->base_price;
                                                    }
                                                    ?>
                                                    </h3>
                                                    
                                                    
                                                    <div class="card shadow-sm border-0 mb-4" style="max-width: 500px;">
                                                      <div class="card-body">
                                                        <h5 class="card-title mb-3">Summary</h5>
                                                        
                                                        <ul class="list-group list-group-flush">
                                                          <li class="list-group-item d-flex justify-content-between">
                                                            <span class="fw-bold">Taxable Amount</span>
                                                            <span>
                                                              <?php  
                                                                if($is_gst_applicable == 1) {
                                                                  echo $taxable_amount;
                                                                } else {
                                                                  echo $taxable_amount = 0;
                                                                }
                                                              ?>
                                                            </span>
                                                          </li>
                                                          
                                                          <li class="list-group-item d-flex justify-content-between">
                                                            <span class="fw-bold">GST %</span>
                                                            <span>
                                                              <?php echo $is_gst_applicable ? $gst_rate."%" : 'Nil'; ?>
                                                            </span>
                                                          </li>
                                                          
                                                          <li class="list-group-item d-flex justify-content-between">
                                                            <span class="fw-bold">Tax</span>
                                                            <span>
                                                              <?php 
                                                                if($is_gst_applicable == 1) { 
                                                                  echo $gst_amount;
                                                                } else { 
                                                                  echo '0';
                                                                } 
                                                              ?>
                                                            </span>
                                                          </li>
                                                          
                                                          <li class="list-group-item d-flex justify-content-between">
                                                            <span class="fw-bold">Paid Amount</span>
                                                            <span>
                                                              ₹ @php 
                                                                if(!empty($total_paid_amount)) { echo $total_paid_amount; }  
                                                              @endphp
                                                            </span>
                                                          </li>
                                                          
                                                          <!--<li class="list-group-item d-flex justify-content-between">-->
                                                          <!--  <span class="fw-bold">GST No.</span>-->
                                                          <!--  <span><?php  $event_gst_no; ?></span>-->
                                                          <!--</li>-->
                                                        </ul>
                                                      </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                             <tr>
                                                <td style="font-family: sans-serif;    font-size: 18px;   font-weight:600; padding-top: 17px; padding-bottom: 30px;"> 
                                                    Ticketing Software : <br> BillionByte IT Solutions, Kanpur
                                                </td>
                                            </tr>
                                            
                                             
                                        </tbody>
                                    </table>
                                    <Br>
                                    <hr style="border-top:1px dashed;"/>
                                    <table class="rotate_layout"  style="text-align:center;margin:0 auto; padding-top:60px">
                                        <tbody>
                                          
                                            <tr>    <Br>  <Br>
                                                <td>
                                                    <h3>
                                                        <?php
                                                        if (getEvent($booking->event_id)) {
                                                            $event = getEvent($booking->event_id);
                                                            echo $event->event_title_ticket;
                                                        }
                                                        ?>
                                                    </h3>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h3>
                                                        <?php
                                                        if (getVenue($booking->venue_id)) {
                                                            $venue = getVenue($booking->venue_id);
                                                            echo $venue->name;
                                                        }
                                                        ?>
                                                    </h3>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h3>
                                                        <?php
                                                        if (getEventScheduleList($booking->event_schedule_list_id)) {
                                                            $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                                                            echo date('D d M Y', strtotime($event_date));
                                                        }
                                                        echo '&nbsp;';
                                                        echo '&nbsp;';
                                                        if (getEventShowTime($booking->event_show_time_id)) {
                                                            $event_show_time = getEventShowTime($booking->event_show_time_id);
                                                            echo $event_show_time->start_time;
                                                        }
                                                        ?>
                                                    </h3>
                                                </td>
                                                <td>
                                                    <h3>

                                                    </h3>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h4>
                                                        <?php
                                                        if ($payment_method_name->show_hide_price == 'SHOW') {
                                                            echo 'Ticket Rate : &#8377; ' . $booking_detail->base_price;
                                                        }
                                                        ?>
                                                    </h4>

                                                </td>

                                            </tr>

                                            <tr>
                                                <td>

                                                    <h4>

                                                        <?php
                                                        if ($payment_method_name->show_hide_price == 'SHOW') {
                                                            if ($seat_name->total_discount > 0) {
                                                                echo 'Discounted Rate : &#8377; ' . number_format($total_paid_amount, 2);
                                                            } else {
                                                                echo $payment_method_name->name . ' : &#8377; ' . number_format($total_paid_amount, 2);
                                                            }
                                                        } else {
                                                            echo $payment_method_name->name;
                                                        }
                                                        ?>
                                                        <br>
                                                        <div style="font-size:28px;margin-left: -1px; line-height: 55px;">
                                                            @if (getTicketType($booking_detail->ticket_type_id))
                                                                {{ getTicketType($booking_detail->ticket_type_id)->ticket_type_name }}
                                                            @endif
                                                        </div>

                                                    </h4>
                                                    <h4 style="font-size:28px;margin-left: -1px;">
                                                        @if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW')
                                                                Seat No : <div style="word-wrap: break-word;max-width:400px">
                                                                
                                                                <?php echo implode(', ', $seat_no_arr); ?></div>
                                                        @endif
                                                    </h4>
                                                </td>
                                                <td></td>
                                            </tr>



                                            <tr>
                                                <td>
                                                 
                                                    <?php
                                                    if (getEventScheduleList($booking->event_schedule_list_id)) {
                                                        $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                                                         date('d/M/Y h:i A', strtotime($booking_payment->created_at));
                                                    }
                                                    ?> <?php
                                                    if (getEventShowTime($booking->event_show_time_id)) {
                                                        $event_show_time = getEventShowTime($booking->event_show_time_id);
                                                        //echo $event_show_time->start_time;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <h3><br>{{'SW ID: ' . $booking_payment->reference_no}}</h3>
                                                    
                                                    <?php
                                                    if (getEventScheduleList($booking->event_schedule_list_id)) {
                                                        $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                                                         date('d/M/Y h:i A', strtotime($booking_payment->created_at));
                                                    }
                                                    ?>

                                                <h3>{{'Booking ID: ' . $booking->booking_id_str}}</h3>
                                                    <?php
                                                    if (getEventShowTime($booking->event_show_time_id)) {
                                                        $event_show_time = getEventShowTime($booking->event_show_time_id);
                                                        //echo $event_show_time->start_time;
                                                    }?>


                                                    <h3>
                                                    <?php
                                                    if($booking->payment_method_id==7 && isset($booking->bms_id))
                                                    {
                                                        echo 'BMS ID : '.$booking->bms_id;
                                                    }
                                                    else if($booking->payment_method_id==8 && isset($booking->bms_id))
                                                    {
                                                        echo 'Website ID : '.$booking->bms_id;
                                                    }
                                                    else if($booking->payment_method_id==9 && isset($booking->bms_id))
                                                    {
                                                        echo 'District ID : '.$booking->bms_id;
                                                    }
                                                    ?>
                                                    </h3>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                       
                        <div class="counting_label2">
                            <div style="text-align: right;transform:rotate(180deg)">
                                <?php echo $ttype; ?> - <?php echo count($seat_no_arr_count); ?></div>
                        </div>
                    </div>
                </div>
        </div>
    </main>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    window.onload = function() {
       window.print();
    }
</script>