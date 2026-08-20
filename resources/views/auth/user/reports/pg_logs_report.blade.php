@extends('layouts.dashboard')

@section('title', 'Customer Payment Report')

@section('css')

@endsection

@section('content')
    <style>
        .table th,
        .table td {
            padding: 4px !important;
        }

            table,   table td, table th {
            font-size: 12px;
            padding: 5px;
            border: 1px solid black; 
            text-align: center;
        }
    </style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-bar-chart"></i> Customer Payment Report1</h1>
            </div>
        </div>

        <!-- include search -->
        <!-- include search -->

        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <!-- include message -->
                        @include('../../partials/message')
                        <!-- include message -->
                        <div class="tile">
                            <div class="tile-body">
                                <!-- include search -->
                                <form action="{{ url($form_url) }}" method="GET">
                                    <div class="row">
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


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="for">Payment Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="ALL" <?php if($status=='ALL') { echo 'selected';}?>>ALL</option>
                                                    <option value="SUCCESS" <?php if($status=='SUCCESS') { echo 'selected';}?>>SUCCESS</option>
                                                    <option value="FAILED" <?php if($status=='FAILED') { echo 'selected';}?>>FAILED</option>
                                                </select>
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
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-12 pb-4 text-right">
                                <!-- <a href="{{ URL::to('booking/create') }}" class="btn btn-info pl-5 pr-5">Add</a> -->
                            </div>
                        </div>
                        <table class="table table-hover table-bordered" id="userTable">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Entrytime</th>
                                    <th>Payment ID</th>
                                    <th>Transaction ID </th>
                                    <th>Entrytime</th>
                                    <th>Mode</th>
                                    <th>Gateway</th>
                                    <!-- <th width="180px">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $net_total = 0;
                                $grand_total = 0;
                                $i = 0;
                                ?>
                                @if ($payment_transactions)
                                    <?php 
	                                foreach($payment_transactions as $payment_transaction)
                                    {
                                        $email=$payment_transaction->customerEmail;
                                        $name=$payment_transaction->customerName;
                                        $mobile=$payment_transaction->customerPhone;
                                        $amount=$payment_transaction->amount;
                                        $status=$payment_transaction->status;
                                        $status=strtoupper($status);
                                        $merchantTransactionId=$payment_transaction->merchantTransactionId;
                                        $paymentId=$payment_transaction->paymentId;
                                        $paymentMode=$payment_transaction->paymentMode;
                                        $udf1=$payment_transaction->udf1;
                                        $created_at=date('d-M-y h:i A', strtotime($payment_transaction->created_at));
                                    ?>
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $name }}</td>
                                        <td>{{ $email }}</td>
                                        <td>{{ $mobile }}</td>
                                        <td>{{ $amount }}</td>
                                        <td>@if($status=='SUCCESS')
                                               <label style="background: #41e641;padding: 5px;border-radius: 3px;color: black;">SUCCESS</label>
                                            @endif 
                                        
                                        
                                            @if($status!='SUCCESS')
                                               <label style="background: RED;padding: 5px;border-radius: 3px;color: WHITE;">FAILED</label>
                                            @endif 
                                        </td>
                                        <td>{{ $created_at }}</td>
                                        <td>{{ $merchantTransactionId }}</td>
                                        <td>{{ $paymentId }}</td>
                                        <td>{{ $created_at }}</td>
                                        <td>{{ $paymentMode }}</td>
                                        <td>
                                            
                                            @if($udf1=='RAZORPAY')
                                                <label style="background: #286dc3;padding: 5px;border-radius: 3px;color: WHITE;">RAZORPAY</label>
                                            @endif
                                            
                                            @if($udf1=='PAYU MONEY')
                                                <label style="background: #8db20e;padding: 5px;border-radius: 3px;color: WHITE;">PAYU MONEY</label>
                                            @endif
                                        </td>
                                            
                                            
                                        
                                    </tr>
                                    <?php 
                                $i++;
                            		} 
                            	?>
                                @endif
                            </tbody>
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
                dom: 'Blfrtip',
                    "bPaginate": true,
                    "bSort": true,
                buttons: [
                    'excel',  'print'
                ]
            });
    </script>

    <script>
        $('#body').addClass('sidenav-toggled');
    </script>
@endsection
