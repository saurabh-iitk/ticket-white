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


<h5 style="text-align:left">Booking Details</h5>
<table class="table table-hover table-bordered" id="userTable">
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Trans. Date</th>
            <th>Name</th>
            <th>Mobile No</th>
            <th>Email</th>
            <th style="width:70px">Show Date</th>
            <th style="width:70px">Show Time</th>
            <th style="width:100px">Ticket(s)</th>
            <th>Total Amount</th>
            <th>Total Discount</th>
            <th>Total Paid</th>
            <th>Paid By</th>
            <th>Booked By</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $user_data=array();
        $all_users=getUser();
        $layout_master_data=array();
        $event_schedule_master_data=array();
        $event_show_time_master_data=array();
        foreach ($all_users as $user) {
            $user_data[$user->id]=$user->name;
        }
        $pm_data=getAllPaymentMethod(); 
        $pm_data_final=array();
        foreach($pm_data as $pm_single)
        {   
            $pm_data_final[$pm_single->id]=$pm_single;
        }
        ?>
        @if($bookings && $count==2)
        @foreach($bookings as $key => $booking)
        <tr>

            <td>{{ $booking->booking_id_str }}</td>
            <td><?php echo date('D d-M-Y h:i A', strtotime ($booking->created_at)); ?></td>

            <?php 
            $customer_id=$booking->customer_id; 
            $customer_data=getCustomer($customer_id);

            if($customer_data->customer_name =='Walk In Customer')
            {
                $customer_name='N/A';
            }
            else
            {
                $customer_name=$customer_data->customer_name;
            }

            if($customer_data->mobile_no =='0000000000')
            {
                $mobile_no='N/A';
            }
            else
            {
                $mobile_no=$customer_data->mobile_no;
            }
             $email=$customer_data->email;

            ?>

            <td>{{ $customer_name }}</td>
            <td>{{ $mobile_no }}</td>
            <td>{{ $email }}</td>

            <td style="width:70px">
                <?php 
                $booking->encrypt_id=simple_crypt($booking->id); 
                $esl_id=$booking->event_schedule_list_id;

                if(empty($event_schedule_master_data[$esl_id]))
                {
                   $event_schedule_master_data[$esl_id]=getEventScheduleList($esl_id)->event_date;
                }
                
                $event_date =  $event_schedule_master_data[$esl_id]; 

                if($event_date)
                {
                    echo date('D d-M-Y', strtotime ($event_date));
                }
                ?>
            </td>




            <td style="width: 70px">
                <?php 
                $est_id=$booking->event_show_time_id;
                if(empty($event_show_time_master_data[$est_id]))
                {
                    $est_data_temp=getEventShowTime($est_id);
                    $event_show_time_master_data[$est_id]= $est_data_temp->start_time.' - '.$est_data_temp->end_time ;
                }
                
                echo $event_show_time =  $event_show_time_master_data[$est_id]; 
                
                ?>
            </td>


            <td style="width:100px">
            <?php 
            $booking_details_data=fetch_booking_details_data($booking->id); 
            foreach ($booking_details_data as $single_data) {
                echo $single_data->ticket_type_name.' : '.$single_data->total_ticket.' Ticket(s) <br>';
            }
            $seat_arr=array();
            $seat_data=fetch_all_seat_by_booking_id($booking->id); 
            foreach ($seat_data as $single_data) {
                $row_no = $single_data->row_no;

                $lid=$single_data->layout_id;
                if(empty($layout_master_data[$lid]))
                {
                   $layout_master_data[$lid]=getLayout($lid)->layout_row_label;
                }

                // $layout_row_label =  $layout_master_data[$lid]; 
                // $layout_row_label=explode(',', $layout_row_label);
                // $row_name=$layout_row_label[$row_no-1];
                $seat_arr[]=$single_data->label.$single_data->name;
            }

            echo implode(', ', $seat_arr);
            ?></td>
            <td>{{ $booking->grand_total }}</td>
            <td>{{ $booking->discount }}</td>
            <td>{{ $booking->grand_total-$booking->discount }}</td>
            <td>
            <?php
                $res = fetch_booking_payments_data($booking->id);
            // dd($res);
            
            $payment_method_id= $res->payment_method_id; 
            
            echo $payment_method_name=$pm_data_final[$payment_method_id]->name; 
            if(!empty($booking->bms_id))
            {
                echo "<br>ID: ".$booking->bms_id;
            }
            ?>
            </td>

             <td>
                <?php 
                if(isset($booking->vendor_id)  && $booking->vendor_id!=null)
                {
                    $vendor_id=$booking->vendor_id;
                    echo $user_data[$vendor_id];
                }
                else
                {
                    echo 'Customer';
                }
               
                ?>
            </td>

            
        </tr>
        @endforeach
        @endif
    </tbody>
</table>