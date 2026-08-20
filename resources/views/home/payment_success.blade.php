@extends('layouts.app')
@section('style')
<style>
.show_on_mobile
{
    display:none !important;
}

.bringer-backlight
{
    z-index:-9999;
}

#bringer-header.is-sticky
{
top:0!important;    
}
@media screen and (max-width: 600px) {
    .show_on_mobile
    {
        display:block !important;
    }

    .hide_on_mobil
    {
        display:none !important;
    }

    .bringer-bento-grid-mobile
    {
        grid-auto-flow: row !important;
    }


}
</style>
@endsection

@section('main_content')
<div class="stg-container">

    

<div class="container">
    <p style="text-align: center; margin-top:150px; font-size:25px;">
        <i class="fa fa-check-circle fa-1x" style="color:#5acaa8" aria-hidden="true"></i> Booking has been completed successfully.
        <p style="color:red;  font-size:20px;  text-align: center; margin:1% 1% 0% 0">Please bring this PDF/Screenshot
            for collecting Physical Ticket from the Ticket Booking Counter.</p>
        <p style="color:red; font-size:20px;  text-align: center; margin:1% 1% 0% 0">You can also collect your Physical
            Ticket by telling Mobile No./Transaction ID</p>
        <p style="color:red; font-size:20px;  text-align: center; margin:1% 1% 0% 0">We have sent your booking on given WhatsApp Mobile No. / E-Mail ID.</p>


        <?php
        $seat_no_arr = [];
        $show_name = false;
        ?>
        @if ($booking_details)
            @foreach ($booking_details as $key => $booking_detail)
                <?php
                $payment_method_name = fetch_payment_method($booking_payment->payment_method_id);
                $seat_name = fetch_seat_no($booking_detail->seat_id);
                $row_no = $seat_name->row_no;
                $base_price = $seat_name->base_price;
                $total_discount = $seat_name->total_discount;
                $final_ticket_rate = round($base_price - $total_discount);
                if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW') {
                    $show_name = true;
                }
                $seat_no_arr[] = $seat_name->label . $seat_name->name;
                ?>
            @endforeach
        @endif


        <?php

            if(empty($payment_details))
             {
                $payment_details=[];
                $payment_details['status']='SUCCESS';
                $payment_details['booking_id']=$booking['id']; 
                $payment_details['booking_id_str']=$booking['booking_id_str']; 
                $payment_details['amount']=$booking['paid_amount'];
                $payment_details['txnid']='';
                $payment_details['bank_ref_num']='';
                $payment_details['pg_txn']='';
            }         

        
        if (getTicketType($booking_detail->ticket_type_id)) {
            $ticket_type_name = getTicketType($booking_detail->ticket_type_id)->ticket_type_name;
        } else {
            $ticket_type_name = '';
        }
        
        $show_time='';
        $show_date='';
        
        if (getEventScheduleList($booking->event_schedule_list_id)) {
            $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
            $show_date=date('D d M Y', strtotime($event_date));
        }
                                                        
                                                        
        if (getEventShowTime($booking->event_show_time_id)) {
            $event_show_time = getEventShowTime($booking->event_show_time_id);
            $show_time=$event_show_time->start_time;
        }
        ?>
    </p>
    <br>
    <div class="row">
        <div class="col-lg-12" style="text-align:center">
        <a class="btn btn-danger d-none" id="back_to_website" style="color:white" href="<?php echo env('APP_URL'); ?>"> <i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Website</a>
        <a class="btn btn-success" id="download_pdf"> <i class="fa fa-download" aria-hidden="true"></i> Download Booking &nbsp;&nbsp; <i class="fa fa-spinner fa-spin d-none"></i></a>
        </div>


        <table id="example" class="table table-striped table-bordered d-none" style="width:60%; margin:1% 20% 5% 20%">
            <thead>
                <tr>
                    <th>Transaction Details</th>
                    <th>Transaction Value </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Payment Status </td>
                    <td style="color:green; text-transform: capitalize;">
                    @php if(!empty($payment_details['status'])) { echo $payment_details['status']; }  @endphp
                </td>
                </tr>
                <tr>
                    <td>Booking ID </td>
                    <td>    @php if(!empty($payment_details['booking_id_str'])) { echo $payment_details['booking_id_str']; }  @endphp</td>
                </tr>
                <tr>
                    <td>Paid Amount</td>
                    <td style="color:green"> @php if(!empty($payment_details['amount'])) { echo $payment_details['amount']; }  @endphp</td>
                </tr>
                <tr>
                    <td>Ticket (s)</td>
                    <th style="color:#47494b"> <?php if ($show_name == true) {
                        echo $seat_no = implode(', ', $seat_no_arr) . ' - ';
                    } else {
                        $seat_no = '';
                    }
                    echo count($seat_no_arr) . ' Tickets';
                    echo ' (' . $ticket_type_name . ') ';
                    if ($show_name == false) {
                        echo ' -  Seat Number not allotted';
                    }
                    
                    ?></th>
                </tr>
                @php if(!empty($show_time)) { @endphp
                <tr>
                    <td>Show Time</td>
                    <td> {{$show_time}} {{$show_date}}</td>
                </tr>
                @php } @endphp
                
                
                 @php if(!empty($payment_details['txnid'])) { @endphp
                <tr>
                    <td>SW Transaction ID </td>
                    <td>  @php if(!empty($payment_details['txnid'])) {echo $payment_details['txnid'];} @endphp</td>
                </tr>
                @php } @endphp
                

                @php if(!empty($payment_details['bank_ref_num'])) { @endphp
                <tr>
                    <td>Bank Ref. Number </td>
                    <td>  @php if(!empty($payment_details['bank_ref_num'])) {echo $payment_details['bank_ref_num'];} @endphp</td>
                </tr>
                @php } @endphp

                @php if(!empty($payment_details['pg_txn'])) { @endphp
                <tr>
                    <td>PG Transaction ID </td>
                    <td>  @php if(!empty($payment_details['pg_txn'])) {echo $payment_details['pg_txn'];} @endphp</td>
                </tr>

                @php } @endphp

                @php if(!empty($customer_details['customer_name'])) { @endphp
                <tr>
                    <td>Name </td>
                    <td>  @php if(!empty($customer_details['customer_name'])) {echo $customer_details['customer_name'];} @endphp</td>
                </tr>
                @php } @endphp

                @php if(!empty($customer_details['email'])) { @endphp
                <tr>
                    <td>Email </td>
                    <td>  @php if(!empty($customer_details['email'])) {echo $customer_details['email'];} @endphp</td>
                </tr>
                @php } @endphp

                @php if(!empty($customer_details['mobile_no'])) { @endphp
                <tr>
                    <td>Mobile </td>
                    <td>  @php if(!empty($customer_details['mobile_no'])) {echo $customer_details['mobile_no'];} @endphp</td>
                </tr>
                @php } @endphp


                <tr>
                    <td>Payment Time </td>
                    <td>  @php if(!empty($booking['updated_at'])) {echo date('D d M Y h:i:s A', strtotime($booking['updated_at'])); } @endphp</td>
                </tr>
            </tbody>

        </table>
    </div>
</div>

<?php


  $event_data =  getEvent($booking->event_id);
  $event_gst_no = $event_data['gst_no'];
  
if ($booking->is_whatsapp_sent == 'NO') {
    if (getEventScheduleList($booking->event_schedule_list_id)) {
        $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
        $event_date = date('D d M Y', strtotime($event_date));
    }

    if (getEventShowTime($booking->event_show_time_id)) {
        $event_show_time = getEventShowTime($booking->event_show_time_id);
        $event_show_time = $event_show_time->start_time;
    }

    if (getVenue($booking->venue_id)) {
        $venue = getVenue($booking->venue_id);
        $venue = $venue->name;
    }

    if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW') {
        $seat_no_message = '';
    } else {
        $seat_no_message = ' -  Seat Number not allotted';
    }

    $data = [];
    $data['status'] = $payment_details['status'];
    $data['booking_id'] = $payment_details['booking_id'];
    $data['amount'] = $payment_details['amount'];
    $data['tickets'] = $seat_no . count($seat_no_arr) . ' Ticket(s)' . ' (' . $ticket_type_name . ')' . $seat_no_message;
    $data['show_name'] = $event_date . ' ' . $event_show_time;
    $data['txnid'] = $payment_details['txnid'];
    $data['venue'] = $venue;
    $data['bank_ref_num'] = $payment_details['bank_ref_num'];
    $data['pg_txn'] = $payment_details['pg_txn'];
    $data['name'] = $customer_details['customer_name'];
    $data['email'] = $customer_details['email'];
    $data['mobile'] = trim($customer_details['mobile_no']);
    $data['booking_id_str'] = $booking->booking_id_str;
    $data['updated_at'] = $event_date = date('D d M Y h:i:s A', strtotime($booking['updated_at']));
    
    
    $updated = App\Models\VisitorLog::where('ip_address', $ipAddress)
        ->whereNull('booking_id')
        ->latest('created_at')
        ->first();
    
    if ($updated) {
       // echo 'IP Found'. count($seat_no_arr);
        $updated->booking_id = $booking->id;
        $updated->tickets = count($seat_no_arr);
        $updated->amount = $payment_details['amount'];
        $updated->save(); 
    }


    $res = send_whatsapp($data);
    if ($res == 'SENT') {
        update_whatsapp_sent($booking->id);
    }
}

if ($booking->is_email_sent == 'NO') {
    if (getEventScheduleList($booking->event_schedule_list_id)) {
        $event_date = getEventScheduleList($booking->event_schedule_list_id)->event_date;
        $event_date = date('D d M Y', strtotime($event_date));
    }

    if (getEventShowTime($booking->event_show_time_id)) {
        $event_show_time = getEventShowTime($booking->event_show_time_id);
        $event_show_time = $event_show_time->start_time;
    }

    if (getVenue($booking->venue_id)) {
        $venue = getVenue($booking->venue_id);
        $venue = $venue->name;
    }

    if (getTicketType($booking_detail->ticket_type_id)->show_hide_seat_no == 'SHOW') {
        $seat_no_message = '';
    } else {
        $seat_no_message = ' -  Seat Number not allotted';
    }

    $data = [];
    $data['status'] = $payment_details['status'];
    $data['booking_id'] = $booking['booking_id_str'];
    $data['amount'] = $payment_details['amount'];
    $data['tickets'] = $seat_no . count($seat_no_arr) . ' Ticket(s)' . ' (' . $ticket_type_name . ')' . $seat_no_message;
    $data['show_name'] = $event_date . ' ' . $event_show_time;
    $data['txnid'] = $payment_details['txnid'];
    $data['venue'] = $venue;
    $data['bank_ref_num'] = $payment_details['bank_ref_num'];
    $data['pg_txn'] = $payment_details['pg_txn'];
    $data['name'] = $customer_details['customer_name'];
    $data['email'] = $customer_details['email'];
    $data['mobile'] = trim($customer_details['mobile_no']);
    $data['updated_at'] = $event_date = date('D d M Y h:i:s A', strtotime($booking['updated_at']));

    if(!empty($data['email']))
    {
        $res = send_email($data);
        if ($res == 'SENT') {
            update_email_sent($booking->id);
        }
    }
    
    
    
}



?>



</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!--  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<link type="text/css" rel="stylesheet" href="{{asset('assets/css/ticket.css')}}">

<section class="detail_ticket_outer_" style="padding-top:15px">
        <div class="detail_ticket_outer" id="detail_ticket_outer" style="border:1px solid black">
            <div class="detail_ticket">
                <div class="row">
                    <div class="col-12" style="text-align: center; "><img src="{{asset('assets/image/icon/logo.png')}}" alt="img" style=" text-align: center; margin:0 auto;"></div>
                    <div class="col-12" style="margin-top:-10px;text-align: center;">
                        <h4 class="mt-4"><?php echo env('APP_NAME')?></h4>
                        <!-- <div class="detail_ticket_lang">Ravindra Natya Grah : Indore</div> -->
                        <div class="detail_ticket_date">{{$show_date}} | {{$show_time}}</div>
                        <div class="detail_ticket_city"></div>
                    </div>
                    <div class="tap_detail">
                        <div class="circle left"></div>
                        <div class="circle right"></div>
                    </div>
                    <Br>
                    <div class="detail_ticket_type">
                        <div class="count text-align-center"><?php echo count($seat_no_arr);?> Ticket(s)</div>
                        <div class="type"><?php  echo  $ticket_type_name; if ($show_name == true) { echo $seat_no = ' - '. implode(', ', $seat_no_arr) . ''; } else { echo $seat_no = '-  Seat Number not allotted'; }?>
                    </div>
                    </div>
                    <div class="col-12" style="margin-top: 18px;">
                    <div class="detaile_stage-barcode">
                    <img crossorigin="anonymous" src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo simple_crypt($booking->id)?>&size=200x200" alt="QR Code">
                        <Br>
                        <p style="font-size:18px">Booking ID : @php if(!empty($booking['booking_id_str'])) { echo $booking['booking_id_str']; }  @endphp <br></p>


                        @php
                            $gst_rate = 18;
                            $total_quantity = $booking['total_quantity'];
                            $paid_amount = $booking['paid_amount'];
                            $is_gst_applicable = $booking['is_gst_applicable'];
                            $taxable_amount = $booking['taxable_amount'];
                            $gst_amount = $booking['gst_amount'];
                        @endphp
                        
                        <p>

                        SW Transaction ID : @php if(!empty($payment_details['txnid'])) {echo $payment_details['txnid'];} @endphp<br>

                        PG Transaction ID : @php if(!empty($payment_details['pg_txn'])) {echo $payment_details['pg_txn'];} @endphp<br>

                        Payment Time :  @php if(!empty($booking['updated_at'])) {echo date('D d M Y h:i:s A', strtotime($booking['updated_at'])); } @endphp <br>

                        Name :  @php if(!empty($customer_details['customer_name'])) {echo $customer_details['customer_name'];} @endphp<br>

                        Mob.: @php if(!empty($customer_details['mobile_no'])) {echo $customer_details['mobile_no'];} @endphp<Br>
                        </p>
                        <p style="font-size:16px"> Helpline : +91-8882546585</p>
                        
                    </div>
                    <div class="tap_detail">
                        <div class="hr"></div>
                        <div class="circle lef"></div>
                        <div class="circle righ"></div>
                    </div>
                    <div class="amount_fr d-flex mt-3"><div class="text_total">Total Amount</div><h5>₹ @php if(!empty($payment_details['amount'])) { echo $payment_details['amount']; }  @endphp</h5></div>
                    <!--<div class="amount_fr d-flex"><div class="text_total">Convinience Fee</div><h5>₹ 0</h5></div>-->
                    <!--<div class="amount_fr d-flex"><div class="text_total">Discount</div><h5>₹ 0</h5></div>-->
                    <div class="amount_fr d-flex"><div class="text_total">Taxable Amount</div><h5><?php  if($is_gst_applicable == 1) {echo $taxable_amount;} else {echo  $final_taxable = 0; } ?></h5></div>
                    <div class="amount_fr d-flex"><div class="text_total">GST</div><h5><?php echo $is_gst_applicable ? $gst_rate."%" : 'Nil'; ?></h5></div>
                    <div class="amount_fr d-flex"><div class="text_total">Tax </div><h5><?php if($is_gst_applicable == 1) { echo $gst_amount ;} else { echo '0';} ?></h5></div>
                    <div class="amount_fr d-flex"><div class="text_total">Paid Amount</div><h5>₹ @php if(!empty($payment_details['amount'])) { echo $payment_details['amount']; }  @endphp</h5></div>
                    
                </div>
                 <div class="amount_fr" style="margin-top:10px;padding: 10px;width: 100%;text-align: center;font-size: 17px;border-top: 1px solid #adadad; display:none">GST No. : <?php echo $event_gst_no;?> </div>
                

            </div>
    </section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

<script type="text/javascript">



   $('.bringer-button ').hide();
   
    posthog.capture('Payment Successful', {
        transaction_id: '@php if(!empty($payment_details['txnid'])) {echo $payment_details['txnid'];} @endphp', // Transaction ID
        total_amount: '@php if(!empty($payment_details['amount'])) { echo $payment_details['amount'];} @endphp', // Total amount paid
        mobile: '@php if(!empty($customer_details['mobile_no'])) {echo $customer_details['mobile_no'];} @endphp', // Details of the seats purchased
        email: '@php if(!empty($customer_details['email'])) {echo $customer_details['email'];} @endphp', // Details of the seats purchased
        total_tickets: '@php if(!empty($seat_no_arr)) {echo count($seat_no_arr);} @endphp',
        booking_id: '@php if(!empty($payment_details['booking_id'])) { echo $payment_details['booking_id'];}@endphp', // Optional: User ID (if applicable)
        utm_source : '@php echo $booking['utm_source']; @endphp',
        utm_medium : '@php echo $booking['utm_medium']; @endphp',
        utm_campaign : '@php echo $booking['utm_campaign']; @endphp',
        utm_content : '@php echo $booking['utm_content']; @endphp',
        timestamp: '@php echo date('d-M-Y h:i A', strtotime($booking['created_at'])); @endphp'
    });
        
   
   
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
      
        
        
        //  document.getElementById('download_pdf').addEventListener('click', function() {
        //     html2canvas(document.getElementById('detail_ticket_outer'), {
        //         useCORS: true, // Enable cross-origin images
        //         allowTaint: false // Disable tainted canvases
        //     }).then(function(canvas) {
        //         var link = document.createElement('a');
        //         link.href = canvas.toDataURL('image/jpeg');
        //         link.download = 'table-image.jpg';
        //         link.click();
        //     });
        // });
            
            
         
        
        
        
         document.getElementById('download_pdf').addEventListener('click', function() {
       
     
                   $('#download_pdf i.fa-spin').removeClass('d-none');
            html2canvas(document.getElementById('detail_ticket_outer'), {
                useCORS: true,
                scale: 2 // Higher scale improves quality, but increases file size
            }).then(function(canvas) {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4'); // A4 size PDF

                // Get canvas dimensions
                const imgData = canvas.toDataURL('image/jpeg');
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 297; // A4 height in mm
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                let scaledWidth, scaledHeight;
                let xOffset, yOffset;

                // If the content is too tall, scale it down to fit the A4 page
                if (imgHeight > pageHeight) {
                    const scalingFactor = pageHeight / imgHeight;
                    scaledWidth = imgWidth * scalingFactor;
                    scaledHeight = imgHeight * scalingFactor;
                } else {
                    scaledWidth = imgWidth;
                    scaledHeight = imgHeight;
                }

                // Calculate the x and y offsets to center the image
                xOffset = (pdf.internal.pageSize.getWidth() - scaledWidth) / 2;
                yOffset = (pdf.internal.pageSize.getHeight() - scaledHeight) / 2;

                // Add the image, centered on the page
                pdf.addImage(imgData, 'JPEG', xOffset, yOffset, scaledWidth, scaledHeight);

                // Save the PDF
                pdf.save('magician-op-sharma-ticket-<?php echo  $booking->id; ?>.pdf');
                
                $('#download_pdf i.fa-spin').addClass('d-none');
            });
        });
        
        
    </script>
    


@endsection

