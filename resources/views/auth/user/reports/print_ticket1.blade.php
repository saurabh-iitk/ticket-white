@extends('layouts.dashboard')

@section('title', 'Print Ticket')

@section('css')
    <style type="text/css" media="all">
        .rotate_layout {
            transform: rotate(90deg);
            margin-top: 20px;
            margin-left: 0px;
        }

        .single_ticket {
            page-break-after: auto;
        }

        @media print {
            .single_ticket {
                page-break-after: auto;
            }

            .rotate_layout {
                transform: rotate(90deg);
                margin-top: 0px;
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
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <!--<a href="javascript:void(0)" onclick="window.print();" class="btn btn-info btn-sm no-print"><i class="fa fa-print"></i>Print</a>
                                    <a href="{{ route('reports.booking') }}" class="btn btn-info btn-sm no-print">Back</a> -->
                            </div>
                        </div>

                        <br class="no-print">

                        @if ($booking_details)

                            @foreach ($booking_details as $key => $booking_detail)
                                <?php $payment_method_name = fetch_payment_method($booking_payment->payment_method_id); ?>
                                <?php
                                
                                $seat_name = fetch_seat_no($booking_detail->seat_id);
                                $row_no = $seat_name->row_no;
                                $base_price = $seat_name->base_price;
                                $total_discount = $seat_name->total_discount;
                                $final_ticket_rate = round($base_price - $total_discount);
                                // $layout_row_label = getLayout($seat_name->layout_id)->layout_row_label;
                                // $layout_row_label = explode(',', $layout_row_label);
                                // $row_name = $layout_row_label[$row_no - 1];
                                ?>

                                <div class="row single_ticket"
                                    style="border-bottom: 1px solid #151515; border-top: 1px solid #151515; padding-top:28px; margin-bottom:40px ">
                                    <div class="col-md-6 " style=" border-right: 1px dashed #151515; margin-left:50px">
                                        <table class="rotate_layout">
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
                                                        <h3><?php
                                                        if ($payment_method_name->show_hide_price == 'SHOW') {
                                                            echo 'Ticket Rate : &#8377; ' . $booking_detail->base_price;
                                                        }
                                                        ?>
                                                        </h3>
                                                        <div style="font-size:20px; font-weight: bold; text-align: left;">
                                                            GST : Nill</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4>
                                                            <?php
                                                            if ($payment_method_name->show_hide_price == 'SHOW') {
                                                                if ($seat_name->total_discount > 0) {
                                                                    echo 'Discounted Rate : &#8377; ' . number_format($final_ticket_rate, 2);
                                                                } else {
                                                                    echo $payment_method_name->name . ' : &#8377; ' . number_format($final_ticket_rate, 2);
                                                                }
                                                            } else {
                                                                echo $payment_method_name->name;
                                                            }
                                                            ?>
                                                        </h4>
                                                        <h4 style="font-size:28px;margin-left: -1px;">
                                                            @if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW')
                                                                Seat No : {{ $seat_name->label }}{{ $seat_name->name }}
                                                            @endif &nbsp;
                                                            @if (getTicketType($booking_detail->ticket_type_id))
                                                                {{ getTicketType($booking_detail->ticket_type_id)->ticket_type_name }}
                                                            @endif
                                                        </h4>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>


                                        <h3 class="mt-2"
                                            style="float:left;margin-top: -208px !important;margin-left: -163px;transform:rotate(90deg);text-align:left;font-size: 13px;">

                                            <?php echo $booking_payment->reference_no; ?> &nbsp;
                                            <?php
                                            if (getEventScheduleList($booking->event_schedule_list_id)) {
                                                $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                                                echo date('d/M/Y h:i A', strtotime($booking_payment->created_at));
                                            }
                                            ?> <?php
                                            if (getEventShowTime($booking->event_show_time_id)) {
                                                $event_show_time = getEventShowTime($booking->event_show_time_id);
                                                //echo $event_show_time->start_time;
                                            }
                                            ?>
                                        </h3>
                                    </div>

                                    <br><br>

                                    <div class="col-md-6 ticket_layout"
                                        style="margin-left: 86px;margin-top: 74px;margin-bottom:50px">
                                        <table class="rotate_layout">
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
                                                                    echo 'Discounted Rate : &#8377; ' . number_format($final_ticket_rate, 2);
                                                                } else {
                                                                    echo $payment_method_name->name . ' : &#8377; ' . number_format($final_ticket_rate, 2);
                                                                }
                                                            } else {
                                                                echo $payment_method_name->name;
                                                            }
                                                            ?>
                                                        </h4>
                                                        <h4 style="font-size:28px;margin-left: -1px;">
                                                            @if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW')
                                                                Seat No : {{ $seat_name->lable }}{{ $seat_name->name }}
                                                            @endif &nbsp;&nbsp;
                                                            @if (getTicketType($booking_detail->ticket_type_id))
                                                                {{ getTicketType($booking_detail->ticket_type_id)->ticket_type_name }}
                                                            @endif
                                                        </h4>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>
                                        <br>


                                        <ol
                                            style="float:left;margin-top: -215px !important;margin-left: -175px;transform:rotate(90deg);text-align:left;font-size: 15px;">
                                            <li>This tickets is allowed only for this show.</li>
                                            <li>Ticket is mandatory for children age above 3 Years.</li>
                                            <li>Drunken people are not allowed.</li>
                                            <li>All admission rights are reserved by management.</li>
                                        </ol>


                                        <h3
                                            style="float:left;margin-top: -211px !important;margin-left: -199px;transform:rotate(90deg);text-align:left;font-size: 13px;">
                                            <?php echo $booking_payment->reference_no; ?> &nbsp;
                                            <?php
                                            if (getEventScheduleList($booking->event_schedule_list_id)) {
                                                $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
                                                echo date('d/M/Y h:i A', strtotime($booking_payment->created_at));
                                            }
                                            ?> <?php
                                            if (getEventShowTime($booking->event_show_time_id)) {
                                                $event_show_time = getEventShowTime($booking->event_show_time_id);
                                                //echo $event_show_time->start_time;
                                            }
                                            ?>
                                        </h3>
                                    </div>
                                </div>
                            @endforeach
                        @endif

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
