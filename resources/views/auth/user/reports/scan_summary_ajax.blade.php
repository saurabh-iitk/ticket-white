<table class="table table-hover table-bordered table-striped" >
<thead>
    <tr  style="background-color:#4ec5ed;">
        <th class="text-center" colspan="10">Payment Methods Summary</th>
    </tr> 
    <tr style="background-color:#c9eaf5">
        <?php
        $t_sale=array();
        $t_discount=array();
        $n_total=array();
        $payment_method_data=array();
        $all_payment_methods=getAllPaymentMethod();
        foreach($all_payment_methods as  $single_data){
            $temp_arr=array();
            $temp_arr['id']=$single_data->id;
            $temp_arr['name']=$single_data->name;
            $temp_arr['method_type']=$single_data->method_type;
            $payment_method_data[]=$temp_arr;
            ?>
                <th class="text-center">{{ $single_data->name }}</th>
        <?php 
              }
        ?>
            <th class="text-center">Total Ticket </th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $event_data=array();
             foreach($shift_summary as $single_data)
             {
                $temp_arr=array();
                $temp_arr['id']=$single_data->id;
                $temp_arr['name']=$single_data->name;
                $temp_arr['total']=$single_data->total_ticket_quantity;
                $temp_arr['scanned_ticket_quantity']=$single_data->scanned_ticket_quantity;
                $event_data[$single_data->event_show][]=$temp_arr;
             }

            foreach($event_data as $date => $single_data)
            {
            ?>
            <tr>
                <?php 
                $total_amount_arr=array();
                $total_scan_amount_arr=array();
                $paid_amount_arr=array();
                $net_amount_arr=array();
                $discount_arr=array();
                $cash_arr=array();
                $upi_arr=array();

                
                foreach($payment_method_data as  $single_method)
                {
                    $method_found=false;
                    foreach ($single_data as  $single_summary)
                    {
                        if($single_summary['id']==$single_method['id'])
                        {
                            $method_found=true;
                            $total_amount=$single_summary['total'];
                            $scanned_ticket_quantity=$single_summary['scanned_ticket_quantity'];
                          
                            $total_amount_arr[]=$total_amount;
                            $total_amount=number_format($total_amount);
                            
                            $total_scan_amount_arr[]=$scanned_ticket_quantity;
                            $scanned_ticket_quantity=number_format($scanned_ticket_quantity);
                            
                            echo '<td class="text-center">'.$scanned_ticket_quantity.'/'.$total_amount.'</td>';

                            if($single_method['id']==2 || $single_method['id']==4)
                            {
                                 $cash_arr[]=$single_summary['total'];
                            }

                            if($single_method['id']==1 || $single_method['id']==5)
                            {
                                 $upi_arr[]=$single_summary['total'];
                            }
                        }
                        else
                        {
                            // echo '<td class="text-center">0</td>';
                        }
                    }
                    if(!$method_found)
                    {
                        echo '<td class="text-center">0/0</td>';
                    }
                }


                $total_amount_arr=array_sum($total_amount_arr);
                $t_sale[]=$total_amount_arr;
                $total_amount_arr=number_format($total_amount_arr);
                
                $total_scan_amount_arr=array_sum($total_scan_amount_arr);
                $total_scan_amount_arr=number_format($total_scan_amount_arr);
                

                echo '<th class="text-center">'.$total_scan_amount_arr.'/'.$total_amount_arr.'</th>';
                ?>
            </tr>
    <?php } ?>
</tbody>
</table>