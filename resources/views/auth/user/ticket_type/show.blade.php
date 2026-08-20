@extends('layouts.dashboard')

@section('title', 'Show/Ticket Type')

@section('css')
<style>
    .input-group-addon {
        padding: 12px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 35px;
        height: 35px;
        float: right;
        margin-top: -36px;
    }
</style>
@endsection

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Show Ticket Type</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('ticket_type.index') }}">Ticket Type</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event</label>
                                <input type="text" class="form-control" value="{{ getEvent($ticket_type->event_id)->event_title }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Ticket Type Name</label>
                                <input type="text" class="form-control" value="{{ $ticket_type->ticket_type_name }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Color</label>
                                <input type="text" class="form-control" value="{{ $ticket_type->color }}" disabled="true" />
                                <div class="input-group-addon" style="background-color:{{ $ticket_type->color }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Status</label>
                                <input type="text" class="form-control" value="{{ $ticket_type->status }}" disabled="true" />
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('ticket_type.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection