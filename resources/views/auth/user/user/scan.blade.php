@extends('layouts.dashboard')

@section('title', 'Add/User')

@section('content')
<audio id="beepSound" src="{{asset('beep.mp3')}} " preload="auto"></audio>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Scan Ticket</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">Users</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div id="msg"></div>

            <!-- KPI Metric Widget Cards -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="widget-small primary coloured-icon" style="height: 80px; margin-bottom: 15px;">
                        <i class="icon fa-solid fa-camera-retro"></i>
                        <div class="info">
                            <h4 style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 600; margin-bottom: 2px;">Today Scans</h4>
                            <p style="font-size: 22px; font-weight: 700; color: #0f172a; margin: 0;">{{ $todayScans }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="widget-small info coloured-icon" style="height: 80px; margin-bottom: 15px;">
                        <i class="icon fa-solid fa-qrcode"></i>
                        <div class="info">
                            <h4 style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 600; margin-bottom: 2px;">Total Scans</h4>
                            <p style="font-size: 22px; font-weight: 700; color: #0f172a; margin: 0;">{{ $totalScans }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Scanner Control Panel Card -->
            <div class="tile">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6" style="padding: 10px 15px;">
                        <!-- Scan Button Section -->
                        <div class="scan-action-section text-center mb-4">
                            <div id="reader" style="width: 100%; border-radius: 12px; overflow: hidden; border: 1px dashed #cbd5e1; background: #f8fafc; margin-bottom: 15px;"></div>
                            <button id="restartButton" class="btn btn-primary btn-lg btn-block" style="padding: 12px 24px; font-size: 18px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.15); display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%;">
                                <i class="fa-solid fa-qrcode"></i> Scan New Ticket
                            </button>
                        </div>

                        <!-- Elegant Divider -->
                        <div class="divider-container d-flex align-items-center justify-content-center my-4">
                            <div style="flex-grow: 1; height: 1px; background-color: #e2e8f0;"></div>
                            <span class="mx-3" style="font-weight: 700; font-size: 12px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">OR</span>
                            <div style="flex-grow: 1; height: 1px; background-color: #e2e8f0;"></div>
                        </div>

                        <!-- Manual Reference Search Section -->
                        <div class="manual-search-section mb-3">
                            <div class="form-group position-relative mb-3">
                                <label for="booking_reference" style="font-weight: 600; color: #475569; font-size: 13px;">Booking Reference</label>
                                <input type="text" class="form-control" name="booking_reference" maxlength="8" id="booking_reference" placeholder="Enter Booking Reference No." style="height: 48px; border-radius: 8px; font-size: 15px; padding: 10px 16px; border: 1px solid #cbd5e1;">
                            </div>
                            <button id="searchButton" onclick="searchbyref()" class="btn btn-warning btn-lg btn-block" style="padding: 12px 24px; font-size: 16px; font-weight: 600; border-radius: 8px; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background-color: #f59e0b; border-color: #f59e0b; color: #ffffff;">
                                <i class="fa-solid fa-magnifying-glass"></i> Search Reference
                            </button>
                        </div>
                    </div>
                </div>

                <hr style="border-top: 1px solid #e2e8f0; margin: 30px 0;">

                <!-- Scan History Table Section -->
                <div class="tile-title-w-btn" style="margin-bottom: 20px;">
                    <h3 class="title" style="font-size: 16px; font-weight: 700; color: #1e3a8a; margin: 0;"><i class="fa-solid fa-clock-rotate-left mr-2"></i> Today's Scanned History</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th class="text-center">SN.</th>
                                <th>Booking ID</th>
                                <th>Booking Reference</th>
                                <th>Seat No</th>
                                <th class="text-center">Total Seats</th>
                                <th class="text-center">Scanned Seats</th>
                                <th class="text-center">Remaining Seats</th>
                                <th>Scanning Time</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;?>
                        @foreach ($today_data as $single)
                            <tr>
                                <td class="text-center" style="font-weight: 600;">{{$i++}}</td>
                                <td>{{$single->booking_id}}</td>
                                <td style="font-family: monospace; font-weight: 600; color: #475569;">{{$single->booking_id_str}}</td>
                                <td>{{$single->label}}{{$single->name}}</td>
                                <td class="text-center">{{$single->total_seat_count}}</td>
                                <td class="text-center" style="color: #10b981; font-weight: 600;">{{$single->total_seat_count-$single->remaining_seat_count}}</td>
                                <td class="text-center">
                                    <span class="badge badge-success" style="padding: 6px 12px; font-size: 12px; border-radius: 99px;">{{$single->remaining_seat_count}}</span>
                                </td>
                                <td>{{date('d-M-Y h:i:s A', strtotime($single->last_scan_time))}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<style>
.seat_row  {
    width:100% !important;
}
.hiddenCheckbox input {
opacity: 0;
transform: scale(5);
}

.seatAvailable{
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0;
    background: #597c12 !important
}

.seat_row table {
    border-collapse: separate !important;
    margin: 0 auto;

}

.seatAvailable div{
  color:white !important;
  font-size:18px !important;
  line-height: 33px;
}


.seat_row td {
    border: none !important;
    height: 65px;
    width: 65px;
    display: block;
    float: left;
    line-height: 33px;
    margin: 10px;
}

.seat_row td div {
   font-size: 28px !important;
   line-height: 60px;
}


.seat_row td {
    border-radius: 56%;
    line-height: 28px;
}

.seat_row td.row {
background-color: transparent;
border: none;
font-weight: bold;
padding-right: 7px;
}

.seat_row td.seatAvailable {
border: 1px solid #01710c;
color: #fff;
cursor: pointer
}


.seat_row td {
    line-height: 0px;
}

.seatUnavailable div{
  color:black !important;
  font-size:18px !important;
  width: 60px !important;
}

.seat_row td.seatUnavailable {
    background-color:#dc3545;
    visibility: visible;
    opacity: 1;
    cursor: not-allowed
}

.seat_row td.seatUnavailable div {
   color:white !important
}

.seat_row td.noSeatGalley {
background-color: transparent;
border: none;
width: 10px;
height: 10px;
}

.seat_row td.noSeatStorage {
background-color: #0085c1 !important;
color: white !important;
}


.seat_row td.bookSeat {
background-color: #d7d7d7;
border: 1px solid #b1acac;
}



.seat_row th.seatAvailable {
border: 1px solid #01710c !important;
color: #fff;
}

.seat_row th.seatUnavailable {
    background-color: #ddd;
    color: #8b8a8a;
    visibility: visible;
    opacity: 1;
}


.seat_row th.bookSeat {
background-color: #d7d7d7;
border: 1px solid #b1acac;
}


    </style>
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script type="text/javascript">

    function fetch_seat_data(text, type)
    {
        if(type == 'booking_reference')
        {
            var data = {
            _token: '{{ csrf_token() }}',
            booking_reference: text
            };
        }

        if(type == 'booking_id')
        {
            var data = {
            _token: '{{ csrf_token() }}',
            booking_id : text
            };
        }
        

        $.ajax({
            type: 'POST',
            url: "{{ route('scan-data-check') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if(response.status == 'FOUND')
                {
                    var beepSound = document.getElementById('beepSound');
                    beepSound.play();

                    $('#exampleModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#ticket_booking_detail').html('');
                    $('#ticket_booking_detail').append("<h3><?php echo env('APP_NAME')?>,</h3>");
                    $('#ticket_booking_detail').append("<h3>"+response.data.venue+"</h3>");
                    $('#ticket_booking_detail').append("<h3>"+response.data.ticket_category+" - "+ response.data.total_tickets+"</h3>");
                    $('#ticket_booking_detail').append("Show Date : "+response.data.show_date+"<Br>");
                    $('#ticket_booking_detail').append("Show Time : "+response.data.show_time+"<Br>");
                    $('#ticket_booking_detail').append("Payment Method : "+response.data.payment_method_name+"<Br>");
                    $('#ticket_booking_detail').append("<h5>Booking ID : "+response.data.booking_id+"</h5>");
                    $('#ticket_booking_detail').append(response.data.seat_html);
                    $('#booking_id').val(response.data.booking_id);
                    $('#submit_button').show();
                }
                else
                {
                    $('#exampleModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#ticket_booking_detail').html('');
                    $('#ticket_booking_detail').append("<h3>"+response.message+"</h3>");
                    $('#submit_button').hide();
                }
            }
        });
    }
    
    
    function scanTickets() {
        
        const seatIds = [];
        $('input[name="seat_ids[]"]:checked').each(function () {
            seatIds.push(parseInt($(this).val()));
        });

        const bookingId = $('#booking_id').val();
        if (seatIds.length === 0) {
            alert('Please select at least one seat.');
            return;
        }

        if (!bookingId) {
            alert('Booking ID is missing.');
            return;
        }
        
        
        $.ajax({
            url: "{{ route('update-ticket-scan') }}",
            method: "POST",
            data: {
                seat_ids: seatIds,
                booking_id: bookingId,
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.success) {
                    restart_scan();
                    // $('#restartButton').click();
                    $('#exampleModal').modal('hide');
                    $('#msg').html('<div class="alert alert-success">' + response.message + '</div>');
                    // Auto-remove message after 3 seconds
                    setTimeout(function() {
                        $('#msg').html('');
                    }, 3000);
        
        
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    alert("Validation error: " + JSON.stringify(errors));
                } else {
                    alert("Server error: " + xhr.responseText);
                }
            }
        });
    }
    


    // $('#body').addClass('app sidebar-mini rtl pace-done sidenav-toggled');
    let html5QrcodeScanner;
    function onScanSuccess(decodedText, decodedResult) {
        if(decodedText)
        {
            $('#restartButton').show();
            fetch_seat_data(decodedText, 'booking_id' );
            html5QrcodeScanner.clear();
        }
       
    }

    function onScanFailure(error) {
        console.warn(`Code scan error = ${error}`);
    }

    function startScanner() {
        html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: { width: 250, height: 250 } }, false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }

    // startScanner();

    // Restart button functionality
    document.getElementById('restartButton').addEventListener('click', () => {
        // Stop the current scanner
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
            
        }
        startScanner();
    });

    function restart_scan()
    {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
            
        }
        startScanner();
    }
    
    
    
   function choose_seat(seat_id)
   {
        var check_status = $('input[value="'+seat_id+'"]').is(':checked');
        if(check_status == true)
        {
            $('td[title="'+seat_id+'"]').addClass('noSeatStorage');
            $('input[value="'+seat_id+'"]').addClass('noSeatStorage');
        }
        else
        {
            $('td[title="'+seat_id+'"]').removeClass('noSeatStorage');
            $('input[value="'+seat_id+'"]').removeClass('noSeatStorage');
        }
        
   }

    function searchbyref()
    {
        var booking_reference =  $('#booking_reference').val();
        $('#booking_reference').val('');
        fetch_seat_data(booking_reference, 'booking_reference' );
    }
</script>
<form method="post" action="{{ route('update-ticket-scan') }}">
    @csrf
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Booking Details</h5>
          <button type="button" class="btn btn-danger" onclick="restart_scan();" data-dismiss="modal">X</button>
        </div>
        <div class="modal-body" id="">
            <input type="hidden" name="booking_id" id="booking_id">
            <div id="ticket_booking_detail" style="text-align: center"> </div><br>
            <hr>
           <div style="width: 100%;margin: 0 auto;text-align: center;">
            <button type="button" onclick="scanTickets()" id="submit_button" class="btn btn-primary btn-lg btn-block" style="padding: 12px 24px; font-size: 18px; font-weight: 600; border-radius: 8px;">Submit</button>
           </div>
        </div>
        <div class="modal-footer">
           <p>Note:</p><Br>
            <ul style=" text-align: left; float: left; width: 100%; ">
            <li>Submit only after counting the persons.</li>
            <li>In case of any QR dont work, use Booking Reference.</li>
           </ul>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection