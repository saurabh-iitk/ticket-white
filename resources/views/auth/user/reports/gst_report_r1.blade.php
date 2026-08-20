@extends('layouts.dashboard')
@section('title', 'GST Report R1')
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
            <h1><i class="fa fa-bar-chart"></i> GST Report R1</h1>
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
                        <div class="col-md-4">
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

                        <table class="table table-hover table-bordered" id="userTable">
                            <thead>
                                <tr  style="text-align: center">
                                    <th>Invoice Date</th>
                                    <th>Invoice No</th>
                                    <th>GST No.of Party</th>
                                    <th>Name</th>
                                    <th>Ticket Type</th>
                                    <th>HSN</th>
                                    <th>BID</th>
                                    <th>Payment Mode</th>
                                    <th>Taxable</th>
                                    <th>Rate of Ticket</th>
                                    <th>Quantity</th>
                                    <th>Taxable Value</th>
                                    <th>Rate of Tax</th>
                                    <th>GST Amount</th>
                                    <th>Paid Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $paid_amount_arr = [];
                                $quantity_arr = [];
                                $taxable_arr = [];
                                $gst_amoutn_arr = [];

                                $gst_rate = 18;
                                $hsn = "999624";
                                ?>
                                @if ($bookings )
                                    @foreach ($bookings as $key => $booking)
                                    @php
                                        $invoice_no_enc = simple_crypt($booking->invoice_no);
                                        $download_url = route('view_invoice', $invoice_no_enc);
                                    @endphp
                                        <tr style="text-align: center">
                                            <td><?php echo date('D d-M-Y', strtotime($booking->created_at)); ?></td>
                                            <td><a target="_blank" href="<?php echo $download_url; ?>"><?php echo $booking->invoice_no; ?></a></td>
                                            <td>N/A</td>
                                            <td><?php echo $booking->customer_name; ?></td>
                                            <td><?php echo $booking->ticket_type_name; ?></td>
                                            <td><?php echo $hsn; ?></td>
                                            <td><?php echo $booking->booking_id_str; ?></td>
                                            <td><?php echo $booking->payment_method_name; ?></td>
                                            <td><?php echo $booking->is_gst_applicable ? 'Yes' : 'No'; ?></td>
                                            <td><?php if( $booking->is_gst_applicable == 0)
                                            {
                                                echo round($booking->paid_amount/$booking->total_quantity,2);
                                            }else
                                            {
                                                echo round($booking->taxable_amount/$booking->total_quantity,2);
                                            } ?>
                                            
                                            </td>
                                            <td><?php echo $booking->total_quantity; $quantity_arr[]=$booking->total_quantity; ?></td>
                                            <td><?php echo $final_taxable = $booking->taxable_amount;  $taxable_arr[]=$final_taxable;?></td>
                                            <td><?php echo $booking->is_gst_applicable ? $gst_rate : '0'; ?>%</td>
                                            <td><?php echo $gst_value = $booking->gst_amount; $gst_amoutn_arr[]=$gst_value; ?></td>
                                            <td><?php echo $booking->paid_amount; $paid_amount_arr[]=$booking->paid_amount; ?></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                              <tfoot>
                                 <tr  style="text-align: center; background:rgb(111, 219, 255)">
                                    <th colspan="10">Total</th>
                                    <th><?php echo array_sum($quantity_arr);?></th>
                                    <th><?php echo array_sum($taxable_arr);?></th>
                                    <th></th>
                                    <th><?php echo array_sum($gst_amoutn_arr);?></th>
                                    <th><?php $paid_amount_arr=array_sum($paid_amount_arr); echo moneyFormatIndia($paid_amount_arr);?></th>
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
        $('#userTable').DataTable({

            dom: 'Blfrtip',
            "bPaginate": true,
            "bSort": true,
            buttons: [
                'excel', 'print'
            ]
        });
    </script>
@endsection