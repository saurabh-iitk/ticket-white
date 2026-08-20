@extends('layouts.dashboard')

@section('title', 'Booking')

@section('css')
<link rel="stylesheet" href="{{ asset('css/timepicker/bootstrap-timepicker.min.css') }}">
<style>
    .glyphicon {
        position: relative;
        top: 1px;
        display: inline-block;
        font-family: "Glyphicons Halflings";
        font-style: normal;
        font-weight: 400;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .glyphicon-chevron-up:before {
        content: "\e113";
    }

    .glyphicon-chevron-down:before {
        content: "\e114";
    }

    .fa {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .input-group .input-group-addon {
        border-radius: 0;
        border-color: #d2d6de;
        background-color: #fff;
    }

    .input-group-addon {
        padding: 9px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .fa-clock-o:before {
        content: "\f017";
    }
</style>
@endsection

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Booking List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('booking.index') }}">Bookings</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    @if(in_array('booking_store', Session::get('permissions')->toArray()))
                    <div class="row">



                        @if(Session::get('role_id') == 1)
                        <div class="col-md-12 pb-4 text-right">
                            <a href="{{ route('bookings.block_booking') }}" class="btn btn-info pl-5 pr-5">Block Booking</a>
                        </div>
                        @endif

                        <div class="col-md-12 pb-4 text-right">
                            @if(Session::get('role_id') == 1)
                            <a href="{{ route('bookings.saleStatus') }}" class="btn btn-success pl-5 pr-5">Sale Status</a>
                            @endif
                            <a href="{{ URL::to('booking/create') }}" class="btn btn-info pl-5 pr-5">New Booking</a>
                        </div>

                    </div>
                    @endif
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Status</th>
                                <th width="250px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($bookings)
                            @foreach($bookings as $booking)
                            <tr>
                                <td>@if(getEvent($booking->event_id)){{ getEvent($booking->event_id)->event_title }}@endif</td>
                                <td>{{ $booking->status }}</td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="{{ route('booking.show',$booking->id) }}">View Details</a>


                                    @if(in_array('booking_update', Session::get('permissions')->toArray()))
                                        <a class="btn btn-primary btn-sm" href="{{ route('booking.edit',$booking->id) }}">Edit</a>
                                    @endif
                                    

                                    @if(in_array('booking_destroy', Session::get('permissions')->toArray()))
                                        @if($booking->status == 'ACTIVE')
                                        <form action="{{ route('booking.unbook',$booking->id)  }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" onclick="confirm_unbook();" class="btn btn-warning btn-sm">Cancel</button>
                                        </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
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
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/confirm_delete.js') }}"></script>
<script>
    $('#userTable').DataTable({
        'columnDefs': [{
            'targets': [1],
            'orderable': false
        }]
    });
</script>
<script src="{{ asset('js/plugins/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/preview.js') }}"></script>
<script src="{{ asset('js/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script>
    //Timepicker
    $('.timepicker').timepicker({
        showInputs: false
    });
</script>
@endsection