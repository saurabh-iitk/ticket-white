@extends('layouts.dashboard')

@section('title', 'Cashier Shift Vs Payment Summary')

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

        .table_auto {
            display: flex;
            justify-content: space-between;
            overflow: auto;
            height: 500px;
        }

        .table_auto .table {
            margin: 0px 15px;
            min-width: 550px;
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-bar-chart"></i>Cashier Shift Vs Payment Summary</h1>
            </div>
        </div>

        <!-- include search -->
        <form action="{{ url($form_url)}}" method="GET">

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
                    <div class="tile-body ">
                        @if(isset($start_date) && isset($end_date) )
                            @php
                                $all_dates=getBetweenDates($start_date, $end_date);
                                $net_total = array();
                            @endphp
                             <table class="table table-hover table-bordered" id="userTable" style="width: 100%">
                                <thead style=" border: 1px solid;">
                                    <tr style="background-color:#4ec5ed;height: 15px;">
                                        <th>Date</th>
                                        <th>UPI</th>
                                        <th>Cash</th>
                                        <th>Barter</th>
                                        <th>Discount Cash</th>
                                        <th>Discount UPI</th>
                                        <th>Complementry</th>
                                        <th>BookMyShow</th>
                                        <th>Website</th>
                                        <th>Insider</th>
                                        <th>Grand Total</th>
                                       
                                         <th>Net Total</th>
                                          <th>Total Cash</th>
                                    </tr>
                                    
                                     </thead>
                                     <tbody style=" border: 1px solid;">
                                    @foreach ($bookings as $booking)
                                    <tr style="height: 15px;" >
                                        <th>{{date('d-M-Y', strtotime($booking->pay_date))}}</th>
                                        <th>{{number_format($booking->UPI, 2)}}</th>
                                        <th>{{number_format($booking->Cash, 2)}}</th>
                                        <th>{{number_format($booking->Barter, 2)}}</th>
                                        <th>{{number_format($booking->DiscountCash, 2)}}</th>
                                        <th>{{number_format($booking->DiscountUPI, 2)}}</th>
                                        <th>{{number_format($booking->Complementry, 2)}}</th>
                                        <th>{{number_format($booking->BookMyShow, 2)}}</th>
                                        <th>{{number_format($booking->Website, 2)}}</th>
                                        <th>{{number_format($booking->Insider, 2)}}</th>
                                        <th>{{number_format($booking->UPI+$booking->Cash+$booking->Barter+$booking->DiscountCash+$booking->DiscountUPI+$booking->Complementry+$booking->BookMyShow+$booking->Website+$booking->Insider, 2)}}</th>
                                        
                                        @php
                                       $net_total[]= $booking->UPI+$booking->Cash+$booking->DiscountCash+$booking->DiscountUPI+$booking->BookMyShow+$booking->Website+$booking->Insider;
                                        @endphp
                                        <th>{{number_format($booking->UPI+$booking->Cash+$booking->DiscountCash+$booking->DiscountUPI+$booking->BookMyShow+$booking->Website+$booking->Insider, 2)}}</th>
                                        <th>{{number_format($booking->Cash+$booking->DiscountCash, 2)}}</th>
                                    </tr>
                                    @endforeach
                                    
                                    
                                     @foreach ($booking_total as $booking)
                                     <tr style="background-color:#d7f5ff; height: 15px;" >
                                        <th>Total</th>
                                        <th>{{number_format($booking->UPI, 2)}}</th>
                                        <th>{{number_format($booking->Cash, 2)}}</th>
                                        <th>{{number_format($booking->Barter, 2)}}</th>
                                        <th>{{number_format($booking->DiscountCash, 2)}}</th>
                                        <th>{{number_format($booking->DiscountUPI, 2)}}</th>
                                        <th>{{number_format($booking->Complementry, 2)}}</th>
                                        <th>{{number_format($booking->BookMyShow, 2)}}</th>
                                        <th>{{number_format($booking->Website, 2)}}</th>
                                        <th>{{number_format($booking->Insider, 2)}}</th>
                                        <th>{{number_format($booking->UPI+$booking->Cash+$booking->Barter+$booking->DiscountCash+$booking->DiscountUPI+$booking->Complementry+$booking->BookMyShow+$booking->Website+$booking->Insider, 2)}}</th>
                                        
                                        <th>{{number_format(array_sum($net_total), 2)}}</th>
                                        <th>{{number_format($booking->Cash+$booking->DiscountCash, 2)}}</th>
                                    </tr>
                                    @endforeach
                                    
                                    
                                   
                                </tbody>
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
        
        
        $('#userTable').DataTable({
            dom: 'Blfrtip',
            paging: false,
             searching: false,
            ordering: true,
            order: [], // Prevent initial sort
            buttons: ['excel', 'print'],
            columnDefs: [{
                targets: 0,
                orderable: false
            }]
        });
    </script>
@endsection
