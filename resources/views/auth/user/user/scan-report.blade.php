@extends('layouts.dashboard')
@section('title', 'Scan Ticket Report')
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-camera"></i>  Scan Ticket Report</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">Scan Ticket Report</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    @if(in_array('user_store', Session::get('permissions')->toArray()))
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <a href="{{ route('scan-ticket') }}" class="btn btn-success pl-5 pr-5">New Scan</a>
                        </div>
                    </div>
                    @endif
                    
                    <table class="table table-hover table-bordered" id="userTable" >
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
                                <th>Scanned By</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;?>
                        @foreach ($today_data as $single)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$single->booking_id}}</td>
                                <td>{{$single->booking_id_str}}</td>
                                <td>{{$single->seat_info}}</td>
                                <td>{{$single->total_quantity}}</td>
                                <td>{{$single->scanned_seat_count}}</td>
                                <td class="label label-success">{{$single->total_quantity - $single->scanned_seat_count}}</td>
                                <td>{{date('d-M-Y h:i:s A', strtotime($single->last_scan_time))}}</td>
                                <td>{{$single->scanned_by_name}}</td>
                            </tr>
                        @endforeach
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
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/confirm_delete.js') }}"></script>
<script>
    $('#userTable').DataTable({
        'columnDefs': [{
            'targets': [3],
            'orderable': false
        }]
    });
</script>
@endsection