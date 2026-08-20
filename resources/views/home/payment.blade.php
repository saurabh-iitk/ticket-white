@extends('layouts.app')
@section('style')
    <style>
        .bringer-header-rp a {
            display: none;
        }

        .bringer-header-mp {
            display: none;
        }

        .my-btn {
            display: none;
        }

        footer {
            display: none;
        }

        .form-group label {
            color: black;
        }

        #mbl_cnt {
            display: none;
        }

        /*  */
        @media only screen and (max-width: 768px) {}

        @media only screen and (max-width: 767px) {
            #mbl_cnt {
                display: block !important;
            }

            #cntect {
                display: none !important;
            }

            #custem_tick {
                padding: 15px !important;
            }

        }

        .bringer-mobile-menu-toggler {
            display: none;
        }

        /* @media only screen and (min-width: 767px) {
            
            #mbl_cnt{
                display:block;
            }
        } */
        #fixed_bottom {
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 999;
            margin-top: 30px
        }
        
        .form-group
        {
            margin-bottom: 6px !important;
        }
    </style>
@endsection

@section('main_content')
    <!-- contect left -->
    <section style='padding:0px !important;padding-top:70px !important;'>
        <div id="msg"></div>
        <div class="container">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <div class="row justify-content-center align-items-baseline">
                <div class="col-lg-7">
                    <div class="contect">
                        <h3 style='background:rgb(63 110 232);'><span><i class="fa fa-angle-down"></i></span>Fill your detail below</h3>
                        <form action="{{ route('payment_process') }}" method="post" class="pt-3" id="payment_process" autocapitalize="off">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="error_msg_py"></div>
                                    <div id="error_msg_rz"></div>
                                </div>

                                <div class="col-lg-6">
                                  
                                    <div class="form-group">
                                        <label for="text">Name *</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter your Full Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">E-mail *</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter your Email ID" required>
                                    </div>
                                </div>
                                
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="number">State *</label>
                                        <select class="form-control" name="state" id="state" required>
                                            <option value="">---Please Select State---</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Ladakh">Ladakh</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Puducherry">Puducherry</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="text">Where you find us? *</label>
                                        <select class="form-control"  name="find_us" id="find_us" >
                                            <option value="">---Please Select---</option>
                                            <option value="Facebook"> Facebook</option>
                                            <option value="Youtube"> Youtube</option>
                                            <option value="Instagram"> Instagram</option>
                                            <option value="Google Ads"> Google Ads</option>
                                            <option value="Friends & Family"> Friends & Family</option>
                                             <option value="NewsPaper"> NewsPaper</option>
                                             <option value="Hoardings"> Hoardings</option>
                                            <option value="Ads. on Auto"> Ads. on Auto</option>
                                            <option value="Ads. on Bus"> Ads. on Bus</option>
                                            <option value="Ads. on Train"> Ads. on Train</option>
                                            <option value="Others"> Others</option>
                                        </select>
                                    </div>
                                </div>
                                    
                                    
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="number">Whatsapp Number *</label>
                                        <input type="digit" oninput="numberOnly(this.id);" class="form-control"
                                            maxlength="10" id="phone" name="phone"
                                            placeholder="Your 10 digit WhatsApp Mobile No." maxlength="10">
                                    </div>
                                </div>
                                
                                
                                
                               
                            </div>

                        </form>
                    </div>

                    <?php
                    $setting_data = getSetting(1);
                    $convenience_fee = $setting_data->convenience_fee;
                    
                    $grand_total = 0;
                    $net_grand_total = 0;
                    $total_ticket_count = 0;
                    $discount_arr = [];
                    
                    foreach ($customer_cart as $key => $cart_item) {
                        $ticket_type_id = $cart_item->ticket_type_id;
                        $qty = $cart_item->quantity;
                        $rate = $cart_item->rate;
                        $discount = $cart_item->discount;
                        $discount_arr[] = $discount;
                        $seat_id = $cart_item->seat_id;
                        $total_amount = ($rate - $discount) * $qty;
                        
                        
                        $total_ticket_count = $total_ticket_count + $qty;
                        $grand_total = $grand_total + $total_amount;
                        $net_grand_total = number_format($grand_total, 2);
                        $convenience = ($grand_total * $convenience_fee) / 100;
                        $convenience = round($convenience);
                        $net_grand_total_with_fee = $grand_total + $convenience;
                        $check_value = $net_grand_total_with_fee;
                        $net_grand_total_with_fee = number_format($net_grand_total_with_fee, 2);
                        $convenience = number_format($convenience, 2);
                    
                        $event_schedule_list_id = $cart_item->event_schedule_list_id;
                        $event_show_time_id = $cart_item->event_show_time_id;
                    
                        $seat_name = fetch_seat_no($seat_id);
                        $row_no = $seat_name->row_no;
                        // $layout_row_label = getLayout($seat_name->layout_id)->layout_row_label;
                        // $layout_row_label = explode(',', $layout_row_label);
                        // $row_name = $layout_row_label[$row_no - 1];
                    
                        $seat_no_arr[] = $seat_name->label . $seat_name->name;
                    }
                    
                    
                    
                    
                    $show_name = false;
                    if (getTicketType($ticket_type_id)->show_hide_seat_no == 'SHOW') {
                        $show_name = true;
                    }
                    
                    
                    $setting_data = getSetting(1);
                    $gst_waiver_rate = $setting_data->gst_waiver_rate;
                    $gst_rate = 18;
                  
                    $per_ticket_paid = $grand_total / $total_ticket_count;
                    $is_gst_applicable = $per_ticket_paid > $gst_waiver_rate;
        
                    if ($is_gst_applicable) {
                        $per_ticket_taxable = round($per_ticket_paid / 1.18, 2);
                        $per_ticket_gst     = round($per_ticket_paid - $per_ticket_taxable, 2);
                        $taxable_amount     = round($per_ticket_taxable * $total_ticket_count, 2);
                        $gst_amount         = round($per_ticket_gst * $total_ticket_count, 2);
                    } else {
                        $taxable_amount = 0.00;
                        $gst_amount     = 0.00;
                    }
                    

                      
                    $event_schedule_list_id = $cart_item->event_schedule_list_id;
                    $event_show_time_id = $cart_item->event_show_time_id;
                    $event_schedule_data = getEventScheduleList($event_schedule_list_id);
                    $event_date = $event_schedule_data->event_date;
                    $event_date = date('D, d F Y', strtotime($event_date));
                    $event_showtime = getEventShowTime($event_show_time_id);
                    $ticket_type_name = getTicketType($ticket_type_id)->ticket_type_name;
                    ?>



                    <!-- payment option -->
                    <div class="contect" id='cntect' style=" margin-bottom:100px;">
                        <h3 style='background:rgb(63 110 232);'><span><i class="fa fa-angle-down"></i></span>Payment Options
                        </h3>
                        <form action="" method="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ticket-method" style='display:block;'>
                                        <div class="place-order mt-2 mr-8 total " id="payu_div">
                                           
                                            <div class="contect-ty">
                                                <div style="color:gray; margin:5px; font-family:Oxygen">Click here to Pay With: </div>
                                                <button id="payubtn" onclick="PAYU_Payment()" type="button"
                                                    style="border: none;background: #a0c93a;box-shadow: rgb(60 64 67 / 30%) 0px 1px 2px 0px, rgb(60 64 67 / 15%) 0px 2px 6px 2px;"><img
                                                        src="{{ asset('payumoney.png') }}" alt="" srcset=""
                                                        style="width: 140px"></button>
                                            </div>
                                        </div>
                                 
                                        @if($check_value <= 1000)
                                       <div class="contect-ty" style='margin-top:30px;'>
                                            <div class="place-order mt-2 ml-0 total" id="rz_div">
                                                <div style="color:gray; margin:5px; font-family:Oxygen">Click here to Pay With: </div>
                                                <button id="razpaybtn" onclick="RAZP_Payment()" type="button"
                                                    style="border: none;background: white;border: 1px solid #b7babc;box-shadow: rgb(60 64 67 / 30%) 0px 1px 2px 0px, rgb(60 64 67 / 15%) 0px 2px 6px 2px;"><img
                                                        src="{{ asset('razorpay.png') }}" alt="" srcset=""
                                                        style="width: 210px">
                                                </button>
                                                <form class="card" method="post"
                                                    action="{{ route('book_ticket_next') }}">
                                                    @csrf
                                                    <input type="hidden" id="event_id" name="event_id">
                                                    <input type="hidden" id="show_date_id" name="show_date_id">
                                                    <input type="hidden" id="show_time_id" name="show_time_id">
                                                    <button type="submit" id="book_ticket_next"
                                                        class="btn btn-success transition-3d-hover"
                                                        style="line-height: 14px;font-size: 22px;height: 40px;background: #073366;border: none; display: none; ">Choose
                                                        another Seats</button>
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        
                                        
                                    </div>
                                </div>

                                <div class="col-md-12 pt-5 pb-4">
                                    <h4>Please note –</h4>
                                    <ul style="text-align: justify;">
                                        <li>Ticket once booked, will not provide refund in any case.</li>
                                        <li>Full Ticket for Children above 3 years</li>
                                        <li>Silver and Balcony seats do not have any seat number.</li>
                                        <li>Fill correct WhatsApp Mobile Number so that you can easily collect Physical
                                            Ticket from Booking
                                            Counter</li>
                                    </ul>
                                </div>

                            </div>


                        </form>

                    </div>

                    <!-- payment end -->


                </div>
                <div class="col-lg-5" id="custem_tick">
                    <div class="order_summery">
                        <h6>Booking Summary</h6>
                        <div class="coun_ticket">
                            <h5><?php echo count($seat_no_arr); ?></h5>Ticket(s)
                        </div>
                        <h6 style="font-weight:600;">{{ config('app.name') }} </h6>
                        <div class="ticket_city">{{$venue_name}} : {{$city_name}}</div>
                        <div class="ticket_date"><span>Seats:</span> {{ $ticket_type_name }} - <?php if ($show_name == true) {
                            echo implode(', ', $seat_no_arr);
                        }
                        if ($show_name == false) {
                            echo ' Seat No. not allotted';
                        }
                        ?></div>
                        <div class="ticket_date"><span>Total Tickets:</span>  <?php echo count($seat_no_arr) . ' Ticket(s)'; ?></div>
                        <div class="ticket_date"><span>Date:</span> {{ $event_date }} </div>
                        <div class="ticket_date"><span>Show Time:</span> {{ $event_showtime->start_time }}</div>
                        <div class="ticket_subtotal"><span>SubTotal:</span>
                        
                        @if($is_gst_applicable)
                         <h6 style="font-weight:600;">₹ {{ $taxable_amount }}</h6>
                        @else
                         <h6 style="font-weight:600;">₹ {{ $net_grand_total }}</h6>
                        @endif
                           
                        </div>
                        <div class="ticket_gst"><span>GST:</span>
                            <h6 style="font-weight:600;">@if($is_gst_applicable) 
                                                            {{$gst_amount}}
                                                        @else
                                                        {{"Nill"}}
                                                        @endif
                                                            </h6>
                        </div>
                        <div class="ticket_gst"><span>Convenience fees:</span>
                            <h6 style="font-weight:600;"> {{ $convenience }}</h6>
                        </div>
                        <div class="ticket_gst"><span>Discounts:</span>
                            <h6 style="font-weight:600;">{{array_sum($discount_arr)}}</h6>
                        </div>

                    </div>
                    <div class="amont_payabl"><span style="font-weight:600; font-size:14px;">Amount Payable:</span>
                        <h6 style="font-weight:600;">₹ {{ $net_grand_total_with_fee }}</h6>
                    </div>
                </div>
                <div class="col-lg-5" style="margin-bottom:60px">
                    <!-- mobile payment option -->
                    <div class="contect" id='mbl_cnt'>
                        <h3 style='background:rgb(63 110 232);'><span><i class="fa fa-angle-down"></i></span>Payment
                            Options</h3>

                        <form action="" method="post">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ticket-method" style='display:block;'>
                                        <div class="contect-ty " onclick="PAYU_Payment()">
                                            <div style="color:gray; margin:5px; font-family:Oxygen">Pay With: </div>
                                            <img src="{{ asset('assets/img/payumoney.png') }}" alt="eticket"
                                                style="width:200px">
                                        </div>
                                        

                                        @if($check_value > 1000)
                                        <div class="contect-ty" style='margin-top:20px;'>
                                            
                                        </div>
                                        @else
                                        <div class="contect-ty" style='margin-top:20px; ' onclick="RAZP_Payment()" >
                                            <div style="color:gray; margin:5px;font-family:Oxygen">Pay With: </div>
                                            <img src="{{ asset('assets/img/razorpay.png') }}" alt="eticket"
                                                style="width:200px">
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12 pt-5 pb-4">
                                    <h4>Please note –</h4>
                                    <ul style="text-align: justify;">
                                        <li>Ticket once booked, will not provide refund in any case.</li>
                                        <li>Full Ticket for Children above 3 years</li>
                                        <li>Silver and Balcony seats do not have any seat number.</li>
                                        <li>Fill correct WhatsApp Mobile Number so that you can easily collect Physical
                                            Ticket from Booking
                                            Counter</li>
                                    </ul>
                                </div>


                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div style='background:rgb(213 234 247);padding:10px;' id="fixed_bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="cencel_btn" style='display:flex;justify-content:center;'>
                        <button class='btn btn-danger'
                            style='background: rgb(233 75 118)!important;padding:10px 30px;cursor:poiner;'  onclick="cancel_ticket_redirect()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contect end -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script type="text/javascript">

        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email)) {
                return false;
            }else{
                return true;
            }
        }

        $('#name, #email, #phone').on('keyup', function () {
            $("#error_msg_py").fadeOut("slow");
        });
        function validation_form()
        {
            
            if ($('#name').val() == '') {
                $("html, body").animate({ scrollTop: 0 }, "fast");
                $('#name').focus();
                $("#error_msg_rz").html('<p class="text-center alert alert-danger mb-1">Full name is required</p>').fadeIn();
                return false;
            }
           
            if ($('#email').val() == '' || IsEmail($('#email').val())==false) {
                $("html, body").animate({ scrollTop: 0 }, "fast");
                $('#email').focus();
                $("#error_msg_rz").html('<p class="text-center alert alert-danger mb-1">Enter a Valid Email ID</p>').fadeIn();
                return false;
            }

            if ($('#phone').val() == '' || $('#phone').val().length !=10) {
                $("html, body").animate({ scrollTop: 0 }, "fast");
                $('#phone').focus();
                $("#error_msg_rz").html('<p class="text-center alert alert-danger mb-1">Enter a valid 10 digit WhatsApp Mobile Number</p>').fadeIn();
                return false;
            }

            if ($('select#find_us option:selected').val() == '' || $('select#find_us option:selected').val() == undefined) {
                $("html, body").animate({ scrollTop: 0 }, "fast");
                $('#find_us').focus();
                $("#error_msg_rz").html('<p class="text-center alert alert-danger mb-1">Please Choose Where you find us</p>').fadeIn();
                return false;
            }

            
            return true;
        }

        function PAYU_Payment() {
            if(validation_form() === true)
            {
                
                 posthog.capture('Clicked on PayU', {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    mobile: document.getElementById('phone').value,
                    source: document.getElementById('find_us').value
                });
        
        
                $('#payubtn').html('<i class="fa fa-spin fa-spinner"></i> Please Wait..').attr('disabled', true);
                $('#rz_div').css('visibility', 'hidden');
                document.getElementById("payment_process").submit();
            }
        }

        function RAZP_Payment() {
            
            if(validation_form() === true)
            {
                 posthog.capture('Clicked on RazorPay', {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    mobile: document.getElementById('phone').value,
                    source: document.getElementById('find_us').value
                });
        
        
                
                $('.container').hide();
                // Show the processing message
                $('#msg').show().html('<h2 class="centered-message text-center p-5" style="font-size:40px">Please Wait, We are processing your request....</h2>');
        
                $('#payu_div').css('visibility', 'hidden');
                var btn = "<img src=\"{{ asset('razorpay.png') }}\" style='width: 210px'>";
                $('#razpaybtn').html('<i class="fa fa-spin fa-spinner"></i> Please Wait..').attr('disabled', true);

                var PayFrm = new FormData();
                PayFrm.append("Name", $('#name').val());
                PayFrm.append("Mobile", $('#phone').val());
               
                PayFrm.append("Email", $('#email').val());
                 PayFrm.append("find_us", $('#find_us').val());
                 
                PayFrm.append("mode", "Razorpay");
                PayFrm.append("_token", '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('raz_customer_payment') }}",
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: PayFrm,
                    dataType: "json",
                    success: function(Response) {
                        if (Response.Success) {

                            var txnid = Response.txnid;
                            var order_id = Response.rz_order_id;
                            var amount = Response.amount;
                            var key = Response.RAZPAY_KEY;
                            var name = Response.name;
                            var contact = Response.mobile;
                            var email = Response.email;
                            var address = Response.address;
                            var description = Response.productinfo;

                            var options = {
                                "key": key,
                                "amount": amount,
                                "currency": "INR",
                                "name": '{{ config('app.name') }}',
                                "description": description,
                                "image": "{{ asset('home/logo/logo.png') }}",
                                "order_id": order_id,
                                "handler": function(response) {
                                    var frm = new FormData();
                                    frm.append("payment_id", response.razorpay_payment_id);
                                    frm.append("order_id", response.razorpay_order_id);
                                    frm.append("signature", response.razorpay_signature);
                                    frm.append("_token", '{{ csrf_token() }}');
                                    $.ajax({
                                        url: "{{ route('raz_customer_payment_success') }}",
                                        type: "POST",
                                        contentType: false,
                                        processData: false,
                                        data: frm,
                                        dataType: "json",
                                        success: function(Response) {
                                            rr = Response.Message;
                                            if (Response.Success) {
                                                $("#msg").html(
                                                    '<p class="text-center alert alert-success mb-0">Booking is confirmed.</p>'
                                                );
                                                window.location.href = Response.print_url;
                                            }
                                            else {
                                                $("#error_msg_rz").html(
                                                    '<p class="text-center alert alert-danger mb-0">' +
                                                    Response.message + '</p>');
                                            }
                                        },
                                        error: function(err) {
                                            $('#razpaybtn').html(
                                                '<span class="btn-title">Make Payment</span>'
                                            ).attr('disabled', false);
                                            $("#error_msg_rz").html(
                                                '<p class="text-center alert alert-danger mb-0">' +
                                                err.statusText + '</p>');
                                        }
                                    });
                                },

                                "modal": {
                                    "ondismiss": function() {
                                        // 
                                        var cfrm = new FormData();
                                        cfrm.append("txnid", order_id);
                                        cfrm.append("note", "Checkout form closed");
                                        cfrm.append("_token", '{{ csrf_token() }}');
                                        $.ajax({
                                            url: '{{ route('payment_fail_rz') }}',
                                            type: "POST",
                                            contentType: false,
                                            processData: false,
                                            data: cfrm,
                                            dataType: "json",
                                            success: function(Response) {
                                                if (Response.Failed) {
                                                    window.location.href = Response.url;
                                                }
                                            }
                                        });
                                    }
                                },
                                "prefill": {
                                    "name": name,
                                    "email": email,
                                    "contact": contact
                                },
                                "notes": {
                                    "address": address
                                },
                                "theme": {
                                    "color": "#3399cc"
                                }
                            };

                            var rzp1 = new Razorpay(options);
                            rzp1.on('payment.failed', function(response) {
                                var cfrm = new FormData();
                                cfrm.append("txnid", response.error.metadata.order_id);
                                cfrm.append("note", response.error.reason);
                                cfrm.append("_token", '{{ csrf_token() }}');
                                $.ajax({
                                    url: '{{ route('payment_fail_rz') }}',
                                    type: "POST",
                                    contentType: false,
                                    processData: false,
                                    data: cfrm,
                                    dataType: "json",
                                    success: function(Response) {
                                        if (Response.Failed) {
                                            window.location.href = Response.url;
                                        }
                                    }
                                });
                            });
                            rzp1.open();
                        } 
                        else if (Response.Hold) {
                            $('#event_id').val(Response.event_id);
                            $('#show_date_id').val(Response.show_date_id);
                            $('#show_time_id').val(Response.show_time_id);
                            $('#razpaybtn').hide();
                            $('#book_ticket_next').show();
                            $('#payu_div').hide()
                            $('#rz_div label').hide();
                            $('#razpaybtn').html('<span class="btn-title">Make Payment</span>').attr('disabled', true);
                            $("#error_msg_rz").html('<p class="text-center alert alert-danger mb-0">' + Response
                                .message +'</p>');

                            var data = {
                                _token: '{{ csrf_token() }}'
                            };
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('seat_reserve_clear') }}',
                                data: data,
                                dataType: 'json',
                                success: function(response) {
                                    
                                }
                            });
                        } 
                        else {
                            $('#razpaybtn').html('<span class="btn-title">Make Payment</span>').attr('disabled',
                                false);
                            $("#error_msg_rz").html('<p class="text-center alert alert-danger mb-0">' + Response
                                .message +
                                '</p>');
                        }
                    },
                    error: function(err) {
                        $('#razpaybtn').html('<span class="btn-title">Make Payment</span>').attr('disabled', false);
                        $("#error_msg_rz").html('<p class="text-center alert alert-danger mb-0">' + err.statusText +
                            '</p>');
                    }
                });
            }
        }

        function cancel_ticket_redirect() {

            var data = {
                _token: '{{ csrf_token() }}'
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('seat_reserve_clear') }}',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $('.tile').css('text-align', 'center').css('margin-top', '80px').html(
                        '<i class="fa fa-spin fa-10x fa-spinner" style="text-align:center; margin:0 auto;"></i>'
                    )
                },
                success: function(response) {
                    // window.location.href = 'https://magicianopsharma.co.in';
                    window.location.href = '{{ config('app.url') }}';
                    
                }
            });

        }

        function numberOnly(id) {
            // Get element by id which passed as parameter within HTML element event
            var element = document.getElementById(id);
            // This removes any other character but numbers as entered by user
            element.value = element.value.replace(/[^0-9]/gi, "");
        }

        $('#email').on('keypress', function(e) {
            if (e.which == 32){
                return false;
            }
        });

        $('#email', '#phone').on("input", function () {
            $(this).val($(this).val().replace(/ /g, ""));
        });

        let innerHeight = window.innerHeight;
        let innerWidth = window.innerWidth;
        let pay_btn_div = 160;
        let pay_btn_div_width = (innerWidth - pay_btn_div) / 2;
        $('#cancel_btn').css('left', parseInt(pay_btn_div_width)).css('display', 'block');
        $('.bringer-button').hide();
    </script>
@endsection
