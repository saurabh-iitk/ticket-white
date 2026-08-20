@extends('layouts.dashboard')

@section('title', 'Edit/Event Ticket')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Edit Event Ticket</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_ticket.index') }}">Event Tickets</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('event_ticket/' . $event_ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center">Event Detail</h3>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Event</label>
                                    <select class="form-control" name="event_id" id="event_id" onchange="get_event_schedule_by_event_id(this.value);" autofocus="true">
                                        <option value="">Select Event</option>
                                        @foreach($events as $key => $event)
                                        <option value="{{$event->id}}" <?php if($event_ticket->event_id==$event->id){ echo 'selected';} ?>>{{$event->event_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Schedule</label>
                                    <select class="form-control" name="event_schedule_id" id="event_schedule_id" onchange="get_event_schedule_list_by_event_schedule_id(this.value);">
                                        <option value="">Select Event Schedule</option>
                                        @foreach(getEventScheduleByEventID($event_ticket->event_id) as $key => $event_schedule)
                                        <option value="{{$event_schedule->id}}" <?php if($event_ticket->event_schedule_id==$event_schedule->id){ echo 'selected';} ?>>{{$event_schedule->start_date.' - '.$event_schedule->end_date}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Schedule Date</label>
                                    <select class="form-control" name="event_schedule_list_id[]" id="event_schedule_list_id" multiple="multiple" data-placeholder="Select Event Schedule Date" style="width:100%;">
                                        <!-- <option value="">Select Event Schedule Date</option> -->
                                        @foreach(getEventScheduleListByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_schedule_list)
                                        <option value="{{$event_schedule_list->id}}" <?php if($event_ticket->event_schedule_list_id != '' && in_array($event_schedule_list->id, explode(',',$event_ticket->event_schedule_list_id))){ echo 'selected';} ?>>{{$event_schedule_list->event_date}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Show Time</label>
                                    <select class="form-control" name="event_show_time_id[]" id="event_show_time_id" multiple="multiple" data-placeholder="Select Event Show Time" style="width:100%;">
                                        <option value="">Select Event Show Time</option>
                                        @foreach(getEventShowTimeByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_show_time)
                                        <option value="{{$event_show_time->id}}" <?php if($event_ticket->event_show_time_id != '' && in_array($event_show_time->id, explode(',',$event_ticket->event_show_time_id))){ echo 'selected';} ?>>{{$event_show_time->start_time.' - '.$event_show_time->end_time}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Layout</label>
                                    <select class="form-control" name="layout_id" id="layout_id" onchange="get_layout_details_by_layout_id(this.value);">
                                        <option value="">Select Layout</option>
                                        @foreach($layouts as $key => $layout)
                                        <option value="{{$layout->id}}" <?php if($event_ticket->layout_id==$layout->id){ echo 'selected';} ?>>{{$layout->layout_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="ACTIVE" <?php if($event_ticket->status=='ACTIVE'){ echo 'selected';} ?>>ACTIVE</option>
                                        <option value="INACTIVE" <?php if($event_ticket->status=='INACTIVE'){ echo 'selected';} ?>>INACTIVE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        @php
                            $event_ticket_lists = \App\Models\EventTicketList::where('event_ticket_id', $event_ticket->id)->get();
                        @endphp

                        @if(count($event_ticket_lists) > 0)
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="bs-component">
                              <div class="alert alert-dismissible alert-warning">
                                <button class="close" type="button" data-dismiss="alert">×</button>
                                <h4>Warning!</h4>
                                <p>Before Edit Tickets Detail You Should Clear All Tickets Detail.</p>
                              </div>
                            </div>

                            <a href="{{ url('/event_ticket/delete_event_ticket_lists/'.$event_ticket->id) }}" class="btn btn-danger delete_confirm pull-right"> Clear All Tickets Detail </a>
                          </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center">Tickets Detail</h3>
                            </div>
                        </div>

                        <hr>

                        <div class="wrapper" id="wrapper">
                            @if($event_ticket_lists)
                            @foreach($event_ticket_lists as $key => $event_ticket_list)
                            <div class="row div_row" id="row_{{$key}}">
                                <input type="hidden" name="event_ticket_list_id[]" id="event_ticket_list_id_{{$key}}" value="{{$event_ticket_list->id}}">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="for">Ticket Type</label>
                                        <select class="form-control" name="ticket_type_id[]" id="ticket_type_id_{{$key}}" style="display:none;">
                                            <option value="">Select Ticket Type</option>
                                            @foreach($ticket_types as $key1 => $ticket_type)
                                            <option value="{{$ticket_type->id}}" <?php if($event_ticket_list->ticket_type_id==$ticket_type->id){ echo 'selected';} ?> >{{$ticket_type->ticket_type_name}}</option>
                                            @endforeach
                                        </select>
                                       <input type="text" class="form-control" value="{{ getTicketType($event_ticket_list->ticket_type_id)->ticket_type_name }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="for">Total Ticket</label>
                                        <input type="number" class="form-control" value="{{ $event_ticket_list->total_ticket }}" name="total_ticket[]" id="total_ticket_{{$key}}" placeholder="Total Ticket" autofocus="true" min="0" onkeyup="sub_calculate('{{$key}}');" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="for">Base Price</label>
                                        <input type="number" class="form-control" value="{{ round($event_ticket_list->base_price) }}" name="base_price[]" id="base_price_{{$key}}" placeholder="Base Price" autofocus="true" min="0" onkeyup="sub_calculate('{{$key}}');" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="for">Total Discount</label>
                                        <input type="number" class="form-control" value="{{ round($event_ticket_list->total_discount) }}" name="total_discount[]" id="total_discount_{{$key}}" placeholder="Total Discount" autofocus="true" min="0" onkeyup="sub_calculate('{{$key}}');" />
                                    </div>
                                </div>

                                <div class="col-md-3" style="display: none;">
                                    <div class="form-group">
                                        <label for="for">Discounted Amount</label>
                                        <input type="number" class="form-control" value="{{ round($event_ticket_list->discounted_amount) }}" name="discounted_amount[]" id="discounted_amount_{{$key}}" placeholder="Discounted Amount" autofocus="true" min="0" />
                                    </div>
                                </div>
                                
                                <div class="col-md-3" style="display: none;">
                                    <div class="form-group">
                                        <label for="for">Final Price</label>
                                        <input type="number" class="form-control" value="{{ round($event_ticket_list->final_price) }}" name="final_price[]" id="final_price_{{$key}}" placeholder="Final Price" autofocus="true" min="0" />
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="add_fields btn btn-primary pl-4 pr-4 mt-0"><i class="fa fa-plus"></i> Add More</button>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('event_ticket.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
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
<script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>
<script type="text/javascript">
    $('#event_schedule_list_id').select2();
    $('#event_show_time_id').select2();
</script>
<script>

    //add more
    $(function(){
        var i=$('#wrapper div.div_row').length;
        $('.add_fields').click(function(e){
            e.preventDefault();
            $('.wrapper').append('<span id="hr_'+i+'"><hr></span><div class="row div_row" id="row_'+i+'"> <div class="col-md-3"><div class="form-group"><label for="for">Ticket Type</label><select class="form-control" name="ticket_type_id[]" id="ticket_type_id_'+i+'"><option value="">Select Ticket Type</option>@foreach($ticket_types as $key1 => $ticket_type)<option value="{{$ticket_type->id}}">{{$ticket_type->ticket_type_name}}</option>@endforeach</select></div></div> <div class="col-md-3"><div class="form-group"><label for="for">Total Ticket</label><input type="number" class="form-control" value="0" name="total_ticket[]" id="total_ticket_'+i+'" placeholder="Total Ticket" autofocus="true" min="0" onkeyup="sub_calculate('+i+');" /></div></div> <div class="col-md-3"><div class="form-group"><label for="for">Base Price</label><input type="number" class="form-control" value="0" name="base_price[]" id="base_price_'+i+'" placeholder="Base Price" autofocus="true" min="0" onkeyup="sub_calculate('+i+');" /></div></div> <div class="col-md-3"><div class="form-group"><label for="for">Total Discount</label><input type="number" class="form-control" value="0" name="total_discount[]" id="total_discount_'+i+'" placeholder="Total Discount" autofocus="true" min="0" onkeyup="sub_calculate('+i+');" /></div></div> <div class="col-md-3" style="display: none;"><div class="form-group"><label for="for">Discounted Amount</label><input type="number" class="form-control" value="0" name="discounted_amount[]" id="discounted_amount_'+i+'" placeholder="Discounted Amount" autofocus="true" min="0" /></div></div> <div class="col-md-3" style="display: none;"><div class="form-group"><label for="for">Final Price</label><input type="number" class="form-control" value="0" name="final_price[]" id="final_price_'+i+'" placeholder="Final Price" autofocus="true" min="0" /></div></div> <div class="col-md-12 text-right" style="margin-top:-30px;"><a href="javascript:void(0);" class="btn btn-danger remove_field mt-4" id="remove_field_'+i+'"><i class="fa fa-trash"></i></a></div> </div>');
            i++;
        });
        
        $('.wrapper').on("click",".remove_field", function(e){ 
            e.preventDefault();
            //1 part
            //$(this).parent('div').parent('div').remove();
            
            //2 part
            var button_id = $(this).attr("id");
            var button_id=button_id.replace("remove_field_", '');
            $('#row_'+button_id).remove();
            $('#hr_'+button_id).remove();
        });
    });

    //get event schedule by event id
    function get_event_schedule_by_event_id(event_id)
    {
        if(event_id!='' && event_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', event_id:event_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('event_schedules.get_event_schedule_by_event_id') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#event_schedule_id').empty();
                    $('#event_schedule_id').append('<option value="">Select Event Schedule</option>');

                    $('#event_schedule_list_id').empty();
                    $('.select2-selection__choice').remove();
                    //$('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');

                    $.each(response, function(key,value){
                        $('#event_schedule_id').append('<option value="'+ value.id +'">'+ value.start_date+' - '+value.end_date +'</option>');
                    });
                }
            });
        }
        else
        {
            $('#event_schedule_id').empty();
            $('#event_schedule_id').append('<option value="">Select Event Schedule</option>');
            
            $('#event_schedule_list_id').empty();
            $('.select2-selection__choice').remove();
            //$('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');
        }
    }

    //get event shedule list by event shedule id
    function get_event_schedule_list_by_event_schedule_id(event_schedule_id) 
    {
        if(event_schedule_id!='' && event_schedule_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', event_schedule_id:event_schedule_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('event_schedules.get_event_schedule_list_by_event_schedule_id') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#event_schedule_list_id').empty();
                    $('.select2-selection__choice').remove();
                    //$('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');
                    $.each(response.event_schedule_lists, function(key,value){
                        $('#event_schedule_list_id').append('<option value="'+ value.id +'">'+ value.event_date+'</option>');
                    });

                    $('#event_show_time_id').empty();
                    $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');
                    $.each(response.event_show_times, function(key,value){
                        $('#event_show_time_id').append('<option value="'+ value.id +'">'+ value.start_time+' - '+value.end_time+'</option>');
                    });
                }
            });
        }
        else
        {
            $('#event_schedule_list_id').empty();
            $('.select2-selection__choice').remove();
            //$('#event_schedule_list_id').append('<option value="">Select Event Schedule Date</option>');

            $('#event_show_time_id').empty();
            $('#event_show_time_id').append('<option value="">Select Event Show Time</option>');
        }
    }

    function get_layout_details_by_layout_id(layout_id) {
        console.log(layout_id);
    }

    //claculate final amount
    function sub_calculate(i) 
    {
        var total_ticket=$('#total_ticket_'+i).val();
        var total_ticket=parseInt(total_ticket);

        var base_price=$('#base_price_'+i).val();
        var base_price=parseFloat(base_price);

        var total_discount=$('#total_discount_'+i).val();
        var total_discount=parseInt(total_discount);

        var net_discount=total_discount*total_ticket;
        var sub_total=base_price*total_ticket;
        
        var net_amount=sub_total-net_discount;
        //var net_amount=parseFloat(net_amount).toFixed(2);
        var net_amount=parseFloat(net_amount);

        $('#discounted_amount_'+i).val(net_discount);
        $('#final_price_'+i).val(net_amount);
    }

    //at page loading by default remove readonly
    /*var is_discount_allowed="{{ $event_ticket->is_discount_allowed }}";
    if(is_discount_allowed=='BLOCKED')
    {
        $("#total_discount").attr('readonly','readonly');
    }
    else
    {
        $("#total_discount").removeAttr('readonly','readonly');
    }
    
    function discount_allowed(i,value) 
    {
        var is_discount_allowed = value;
        //var is_discount_allowed = $("#is_discount_allowed_"+i).val();
        if(is_discount_allowed=='BLOCKED')
        {
            $("#total_discount_"+i).val(0);
            $("#total_discount_"+i).attr('readonly','readonly');
            sub_calculate(i);
        }
        else
        {
            $("#total_discount_"+i).removeAttr('readonly','readonly');
            sub_calculate(i);
        }
    }*/

</script>
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    $('.delete_confirm').on('click', function (event) {
        event.preventDefault();
        const url = $(this).attr('href');

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this record!",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: true, //false
            closeOnCancel: true //false
        }, function(isConfirm) {
            if (isConfirm) {
                window.location.href = url;
            }
        });
    });
</script>
@endsection