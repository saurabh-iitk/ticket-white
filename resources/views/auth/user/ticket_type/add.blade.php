@extends('layouts.dashboard')

@section('title', 'Add/Ticket Type')

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
<style>
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
</style>
@endsection

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Add Ticket Type</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('ticket_type.index') }}">Ticket Types</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-5">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('ticket_type') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="for">Event <span class="required">*</span></label>
                            <select class="form-control" name="event_id" id="event_id" autofocus="true">
                                <option value="">Select Event</option>
                                @foreach($events as $key => $event)
                                <option value="{{$event->id}}">{{$event->event_title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="for">Ticket Type Name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="ticket_type_name" id="ticket_type_name" placeholder="Ticket Type Name" autofocus="true" />   
                        </div>
                        
                        <div class="form-group">
                            <label for="for">Color <span class="required">*</span></label>
                            <div class="input-group my-colorpicker2">
                                <input type="text" class="form-control" name="color" id="color" placeholder="Color" autofocus="true" value="#000000" />
                                <div class="input-group-addon">
                                    <i></i>
                                </div>
                            </div>
                        </div>
                       <div class="form-group">
                            <label for="for">Hide Seat No.<span class="required"></span></label>
                            <input type="checkbox" class="form-control" name="show_hide_seat_no" value="HIDE"  autofocus="true" style="width:20px;" />
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('ticket_type.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="{{ asset('js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script>
//Colorpicker
$('.my-colorpicker1').colorpicker();
//color picker with addon
$('.my-colorpicker2').colorpicker();
</script>
@endsection