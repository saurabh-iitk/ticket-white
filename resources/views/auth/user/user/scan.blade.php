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
            <div class="tile" style="text-align: center">
                <div class="tile-body">
                    <div id="reader" width="600px"></div>
                    <button id="restartButton" class="btn btn-success btn-lg mt-2" style="width:100%; font-size:32px">Scan New Ticket</button>
                </div>
                <bR><bR><h4>OR</h4><bR><bR>
                <div class="tile-body">
                    <input type="text" class="form-control" name="booking_reference" maxlength="8"  id="booking_reference" placeholder="Enter Booking Reference No."><Br>
                    <button id="searchButton"  onclick="searchbyref()" class="btn btn-warning btn-lg mt-2" style="width:70%; font-size:32px">Search</button>
                </div>

                <div class="tile-body">
                    <bR><bR>
                    <hr>
                    <bR><bR>
                    <h3>Today Scans : <?php echo $todayScans;?></h3><bR>
                    <h3>Total Scans :  <?php echo $totalScans;?></h3>
                </div>

                <div class="tile-body" style="width: 100%">
                    <bR><bR>
                    <table class="table table-responsive align-center" >
                        <thead>
                            <tr>
                                <th>SN.</th>
                                <th>Booking ID</th>
                                <th>Booking Reference</th>
                                <th>Seat No</th>
                                <th>Total Seats</th>
                                <th>Scanned Seats</th>
                                <th>Remaining Seats</th>
                                <th>Scanning Time</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;?>
                        @foreach ($today_data as $single)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$single->booking_id}}</td>
                                <td>{{$single->booking_id_str}}</td>
                                <td>{{$single->label}}{{$single->name}}</td>
                                <td>{{$single->total_seat_count}}</td>
                                <td>{{$single->total_seat_count-$single->remaining_seat_count}}</td>
                                <td class="label label-success">{{$single->remaining_seat_count}}</td>
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
            <button type="button" onclick="scanTickets()" id="submit_button" class="btn btn-primary btn-lg" style="width:100%; font-size:32px">Submit</button>
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