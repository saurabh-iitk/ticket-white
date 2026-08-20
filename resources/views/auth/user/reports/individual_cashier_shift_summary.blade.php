@extends('layouts.dashboard')

@section('title', 'Individual Cashier Shift Report')

@section('css')

@endsection

@section('content')
    <style>
        table,
        th,
        td,
        thead {
            border: 2px solid black !important;
            padding: 2px !important;
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-bar-chart"></i>Individual Cashier Shift Summary</h1>
            </div>
        </div>

        <!-- include search -->
        <form action="{{ url($form_url) }}" method="GET">

        <div class="row">
            <div class="col-sm-2 col-md-4">
                <div class="form-group">
                    <label for="for">Event</label>
                    <select class="form-control" name="e_id" id="event_id" autofocus="true" style="width:300px">
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
                    <input type="date" name="start_date" class="form-control" min="2022-01-01" max="2030-12-31"
                        value="<?php echo $start_date; ?>">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="for">To</label>
                    <input type="date" name="end_date" class="form-control" min="2022-01-01" max="2030-12-31"
                        value="<?php echo $end_date; ?>">
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <label for="for" style="margin-top: 42px;"></label>
                    <input type="submit" class="btn btn-primary pl-4 pr-4" value="Filter" />
                    <a href="{{ route($reset_url) }}" class="btn btn-info pl-4 pr-4" style="margin-left: 5px;">Reset</a>
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
                            <thead style=" border: 1px solid;background-color:#4ec5ed;">
                                <tr>
                                    <th>S.No.</th>
                                    <th>Vendor Name</th>
                                    <th>Payment Type</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Discount</th>
                                    <th class="text-right">Received</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            $net_total = 0;
                            foreach ($vendor_data as $key => $vendor) :

                                $grand_total = 0;
                                $grand_total_collected = 0;
                                $total_amount= 0;
                                $total_discount= 0;
                                $total_received= 0;
                                $counter_cash= 0;
                                $counter_discount= 0;
                                $counter_cash_collected= 0;
                          		$comp =0;
                            ?>
                                <tr>
                                    <td></td>

                                    <th colspan="3">
                                        <?php
                                        if (isset($vendor->vendor_id) && getUser($vendor->vendor_id)) {
                                            $vendor_d = getUser($vendor->vendor_id);
                                            echo $vendor_d->name;
                                        }
                                        ?>
                                    </th>
                                </tr>

                                <?php
                                if (isset($vendor->vendor_id) && getPaymentMethodByvendor($vendor->vendor_id, $start_date, $end_date)) {
                                    $payment_methods = getPaymentMethodByvendor($vendor->vendor_id, $start_date, $end_date);
                                
                                    foreach ($payment_methods as $payment_method) {
                                        echo '<tr>';
                                
                                        echo '<td>';
                                        echo '</td>';
                                
                                        echo '<td>';
                                        echo '</td>';
                                
                                        echo '<td>';
                                        echo $payment_method->name;
                                        echo '</td>';
                                
                                        $operation = $payment_method->operation;
                                
                                        $amount = $payment_method->amount;
                                        $discount = $payment_method->discount;
                                        $received = $amount - $discount;
                                
                                        $total_amount = $total_amount + $amount;
                                        $total_discount = $total_discount + $discount;
                                        $total_received = $total_received + $received;
                                
                                        $counter_cash = $counter_cash + $amount * $operation;
                                
                                        $counter_discount = $counter_discount + $discount * $operation;
                                
                                        $counter_cash_collected = $counter_cash - $counter_discount;
                                
                                        $grand_total = $grand_total + $amount;
                                
                                        echo "<td  class='text-right'>";
                                        echo number_format($payment_method->amount, 2);
                                        echo '</td>';
                                
                                        echo "<td class='text-right'>";
                                        echo number_format($discount, 2);
                                        echo '</td>';
                                
                                        echo "<td class='text-right'>";
                                        echo number_format($received, 2);
                                        echo '</td>';
                                
                                        echo '</tr>';
                                    }
                                }
                                ?>

                                <tr style="background-color:#c9eaf5;">
                                    <th colspan="3" class="text-right">Total</th>
                                    <th class='text-right'><?php echo number_format($total_amount, 2); ?></th>
                                    <th class='text-right'><?php echo number_format($total_discount, 2); ?></th>
                                    <th class='text-right'><?php echo number_format($total_received, 2); ?></th>
                                </tr>


                                <tr style="background-color:#c9eaf5;">
                                    <th colspan="3" class="text-right">Counter Cash</th>
                                    <th class='text-right'><?php echo number_format($counter_cash, 2); ?></th>
                                    <th class='text-right'><?php echo number_format($counter_discount, 2); ?></th>
                                    <th class='text-right'><?php echo number_format($counter_cash_collected, 2); ?></th>
                                </tr>

                                <tr></tr>
                                <?php
                            endforeach;
                            ?>


                            </tbody>
                            <tfoot>
                                <?php
                                $grand_total = 0;
                                $total_discount = 0;
                                $total_amount = 0;
                                $grand_total_collected = 0;
                                $total_received = 0;
                                
                                $counter_cash = 0;
                                $counter_discount = 0;
                                $counter_received = 0;
                                
                                $comp = 0;
                                
                                foreach ($bookings as $booking) {
                                    echo '<tr>';
                                    echo '<td>';
                                    echo '</td>';
                                    echo '<td>';
                                    echo '</td>';
                                    echo '<td>';
                                
                                    if (getPaymentMethod($booking->payment_method_id)) {
                                        $payment_method = getPaymentMethod($booking->payment_method_id);
                                        echo $payment_method->name;
                                    }
                                
                                    $operation = $payment_method->operation;
                                    $amount = $booking->total_amount;
                                    $discount = $booking->total_discount;
                                    $received = $amount - $discount;
                                
                                    echo '</td>';
                                    echo "<td  class='text-right'>";
                                    echo number_format($amount, 2);
                                    echo '</td>';
                                
                                    $total_amount = $total_amount + $amount;
                                    $total_discount = $total_discount + $discount;
                                    $total_received = $total_received + $received;
                                
                                    $counter_cash = $counter_cash + $amount * $operation;
                                    $counter_discount = $counter_discount + $discount * $operation;
                                    $counter_received = $counter_received + $received * $operation;
                                
                                    echo "<td  class='text-right'>";
                                    echo number_format($discount, 2);
                                    echo '</td>';
                                    echo "<td  class='text-right'>";
                                    echo number_format($received, 2);
                                    echo '</td>';
                                
                                    echo '</tr>';
                                }
                                ?>

                                <tr style="background-color:#c9eaf5;">
                                    <th colspan="3" class="text-right">Grand Total</th>
                                    <th class="text-right"><?php echo number_format($total_amount, 2); ?></th>
                                    <th class="text-right"><?php echo number_format($total_discount, 2); ?></th>
                                    <th class="text-right"><?php echo number_format($total_received, 2); ?></th>
                                </tr>

                                <tr style="background-color:#c9eaf5;">
                                    <th colspan="3" class="text-right">Total Cash</th>
                                    <th class='text-right'><?php echo number_format($counter_cash, 2); ?></th>
                                    <th class='text-right'><?php echo number_format($counter_discount, 2); ?></th>
                                    <th class='text-right'><?php echo number_format($counter_received, 2); ?></th>
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
    <script>
        $('#userTable').DataTable({
            'columnDefs': [{
                'targets': [1],
                'orderable': false
            }]
        });
    </script>

@endsection
