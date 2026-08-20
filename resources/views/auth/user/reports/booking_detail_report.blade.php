@extends('layouts.dashboard')

@section('title', 'View Details')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-bar-chart"></i> View Details</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Event</label>
                                <input type="text" class="form-control" value="@if(getEvent($booking->event_id)){{ getEvent($booking->event_id)->event_title }}@endif" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Event Schedule</label>
                                <input type="text" class="form-control" value="@if(getEventSchedule($booking->event_schedule_id)){{ getEventSchedule($booking->event_schedule_id)->start_date.' - '.getEventSchedule($booking->event_schedule_id)->end_date }}@endif" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Event Schedule Date</label>
                                <input type="text" class="form-control" value="@if(getEventScheduleList($booking->event_schedule_list_id)){{ getEventScheduleList($booking->event_schedule_list_id)->event_date }}@endif" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Event Show Time</label>
                                <input type="text" class="form-control" value="@if(getEventShowTime($booking->event_show_time_id)){{ getEventShowTime($booking->event_show_time_id)->start_time.' - '.getEventShowTime($booking->event_show_time_id)->end_time }}@endif" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Venue</label>
                                <input type="text" class="form-control" value="@if(getVenue($booking->venue_id)){{ getVenue($booking->venue_id)->name }}@endif" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Layout</label>
                                <input type="text" class="form-control" value="@if(getLayout($booking->layout_id)){{ getLayout($booking->layout_id)->layout_name }}@endif" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Quantity</label>
                                <input type="text" class="form-control" value="{{ $booking->total_quantity }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Total Amount</label>
                                <input type="text" class="form-control" value="{{ $booking->grand_total }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Booking Code</label>
                                <input type="text" class="form-control" value="{{ $booking->booking_code }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Booking Date</label>
                                <input type="text" class="form-control" value="{{ $booking->booking_date }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Booking Time</label>
                                <input type="text" class="form-control" value="{{ $booking->booking_time }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Payment Status</label>
                                <input type="text" class="form-control" value="{{ $booking->payment_status }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Customer</label>
                                <input type="text" class="form-control" value="@if(getCustomer($booking->customer_id)){{ getCustomer($booking->customer_id)->customer_name }}@endif" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Vendor</label>
                                <input type="text" class="form-control" value="@if(getUser($booking->vendor_id)){{ getUser($booking->vendor_id)->name }}@endif" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Status</label>
                                <input type="text" class="form-control" value="{{ $booking->status }}" disabled="true" />
                            </div>
                        </div>
                        
                    </div>

                    @if($booking_details)
                        <div style="overflow-y:scroll;max-height: 200px;">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Venue</th>
                                        <th>Ticket Type</th>
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Discount</th>
                                        <th>Seat No.</th>
                                        <th>Row</th>
                                        <th>Column</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($booking_details as $key => $booking_detail)
                                    <tr>
                                        <td>@if(getVenue($booking_detail->venue_id))
                                        {{ getVenue($booking_detail->venue_id)->name }}
                                        @endif</td>
                                        <td>@if(getTicketType($booking_detail->ticket_type_id)){{ getTicketType($booking_detail->ticket_type_id)->ticket_type_name }}@endif</td>
                                        <td>{{ $booking_detail->quantity }}</td>
                                        <td>{{ $booking_detail->base_price }}</td>
                                        <td>{{ $booking_detail->discount }}</td>
                                        <td>{{ $booking_detail->seat_no }}</td>
                                        <td>{{ $booking_detail->row_id }}</td>
                                        <td>{{ $booking_detail->col_id }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Reference No.</label>
                                <input type="text" class="form-control" value="{{ $booking_payment->reference_no }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Payment Method</label>
                                <input type="text" class="form-control" value="@if(getPaymentMethod($booking_payment->payment_method_id)){{ getPaymentMethod($booking_payment->payment_method_id)->name }}@endif" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Total Amount</label>
                                <input type="text" class="form-control" value="{{ $booking_payment->amount }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">Note</label>
                                <input type="text" class="form-control" value="{{ $booking_payment->note }}" disabled="true" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('reports.booking') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection