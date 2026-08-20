@extends('layouts.dashboard')

@section('title', 'Show/Event Ticket')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Show Event Ticket</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_ticket.index') }}">Event Ticket</a></li>
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
                                <input type="text" class="form-control" value="{{ getEvent($event_ticket->event_id)->event_title }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Schedule</label>
                                <input type="text" class="form-control" value="{{ getEventSchedule($event_ticket->event_schedule_id)->start_date.' - '.getEventSchedule($event_ticket->event_schedule_id)->end_date }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Schedule Date</label>
                                {{--<input type="text" class="form-control" value="" disabled="true" />--}}
                                <select class="form-control" name="event_date" id="demoSelect" multiple="multiple" disabled="true" style="width:100%;">
                                    <optgroup label="Select Event Schedule Date">
                                    @foreach(getEventScheduleListByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_schedule_list)
                                        <option value="{{$event_schedule_list->id}}" <?php if($event_ticket->event_schedule_list_id != '' && in_array($event_schedule_list->id, explode(',',$event_ticket->event_schedule_list_id))){ echo 'selected';} ?>>{{$event_schedule_list->event_date}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Show Time</label>
                                {{--<input type="text" class="form-control" value="{{ getEventShowTime($event_ticket->event_show_time_id)->start_time.' - '.getEventShowTime($event_ticket->event_show_time_id)->end_time }}" disabled="true" />--}}
                                <select class="form-control" name="event_show_time_id" id="demoSelect2" multiple="multiple" disabled="true" style="width:100%;">
                                    <optgroup label="Select Event Show Time">
                                        @foreach(getEventShowTimeByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_show_time)
                                        <option value="{{$event_show_time->id}}" <?php if($event_ticket->event_show_time_id != '' && in_array($event_show_time->id, explode(',',$event_ticket->event_show_time_id))){ echo 'selected';} ?>>{{$event_show_time->start_time.' - '.$event_show_time->end_time}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Layout</label>
                                <input type="text" class="form-control" value="{{ getLayout($event_ticket->layout_id)->layout_name }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Status</label>
                                <input type="text" class="form-control" value="{{ $event_ticket->status }}" disabled="true" />
                            </div>
                        </div>
                        
                    </div>

                    @php
                        $event_ticket_lists = \App\Models\EventTicketList::where('event_ticket_id', $event_ticket->id)->get();
                    @endphp

                    @if($event_ticket_lists)
                        @foreach($event_ticket_lists as $key => $event_ticket_list)
                            <div class="row" id="{{$key+1}}">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Ticket Type</label>
                                        <input type="text" class="form-control" value="{{ getTicketType($event_ticket_list->ticket_type_id)->ticket_type_name }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Total Ticket</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->total_ticket }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Base Price</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->base_price }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Total Discount</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->total_discount }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Discounted Amount</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->discounted_amount }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Final Price</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->final_price }}" disabled="true" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('event_ticket.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>
<script type="text/javascript">
    $('#demoSelect').select2();
    $('#demoSelect2').select2();
</script>
@endsection