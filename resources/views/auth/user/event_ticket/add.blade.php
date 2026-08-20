@extends('layouts.dashboard')

@section('title', 'Add/Event Ticket')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Add Event Ticket</h1>
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
                    <form action="{{ url('event_ticket') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <?php $i=0; ?>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center">Event Detail</h3>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Event</label>
                                    <select class="form-control" name="event_id" id="event_id_{{$i}}" onchange="get_event_schedule_by_event_id('{{$i}}',this.value);" autofocus="true">
                                        @foreach($events as $key => $event)
                                        <option value="{{$event->id}}">{{$event->event_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Event Schedule</label>
                                    <select class="form-control" name="event_schedule_id" id="event_schedule_id_{{$i}}" onchange="get_event_schedule_list_by_event_schedule_id('{{$i}}',this.value);">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">Event Schedule Date</label>
                                    <select class="form-control" disabled="disabled" name="event_schedule_list_id[]" id="event_schedule_list_id_{{$i}}" onchange="get_event_show_time_by_event_schedule_list_id('{{$i}}',this.value);"  data-placeholder="Select Event Schedule Date" style="width:100%;" >
                                        <!-- <option value="">Select Event Schedule Date</option> -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">Event Show Time</label>
                                    <select class="form-control" name="event_show_time_id[]" id="event_show_time_id_{{$i}}" data-placeholder="Select Event Show Time" onchange="check_for_duplicate_mapping(this.value, {{$i}})" style="width:100%;">
                                        <option value="">Select Event Show Time</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">Layout</label>
                                    <select class="form-control" name="layout_id" id="layout_id_{{$i}}" onchange="get_layout_details_by_layout_id('{{$i}}',this.value);">
                                        <!-- <option value="">Select Layout</option> -->
                                        @foreach($layouts as $key => $layout)
                                        <option value="{{$layout->id}}">{{$layout->layout_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="for">Seating Plan</label>
                                <select class="form-control" name="seating_plan" id="seating_plan_{{$i}}" onchange="show_hide_tickets_detail('{{$i}}',this.value);" autofocus="true">
                                    <option value="">--Please choose--</option>
                                    <option value="fresh">Fresh</option>
                                    <option value="import">Import from show</option>
                                </select>
                            </div>

                            <input type="hidden" name="event_ticket_id" value="{{ $event_ticket->id ?? '' }}">
                            <div class="col-md-3 import-detail">
                                <div class="form-group">
                                    <label for="for">Schedule Date</label>
                                    <select class="form-control" name="schedule_list_id" id="schedule_list_id" style="width:100%;" onchange="schedule_date_show_time_fetch(this.value)">
                                       
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 import-detail">
                                <div class="form-group">
                                    <label for="for">Show Time</label>
                                    <select class="form-control" name="show_time_id"  id="show_time_id" style="width:100%;">
                                        
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="ticket-detail">
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="text-center">Tickets Detail</h3>
                                </div>
                            </div>

                            <hr>

                            <div class="wrapper" id="wrapper">
                                <div class="row" id="row_{{$i}}">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="for">Ticket Type</label>
                                            <select class="form-control" name="ticket_type_id[]" id="ticket_type_id_{{$i}}">
                                                <option value="">Select Ticket Type</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="for">Total Ticket</label>
                                            <input type="number" class="form-control" value="0" name="total_ticket[]" id="total_ticket_{{$i}}" placeholder="Total Ticket" autofocus="true" min="0" onkeyup="sub_calculate('{{$i}}');" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="for">Base Price</label>
                                            <input type="number" class="form-control" value="0" name="base_price[]" id="base_price_{{$i}}" placeholder="Base Price" autofocus="true" min="0" onkeyup="sub_calculate('{{$i}}');" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="for">Total Discount</label>
                                            <input type="number" class="form-control" value="0" name="total_discount[]" id="total_discount_{{$i}}" placeholder="Total Discount" autofocus="true" min="0" onkeyup="sub_calculate('{{$i}}');" />
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="for">Discounted Amount</label>
                                            <input type="number" class="form-control" value="0" name="discounted_amount[]" id="discounted_amount_{{$i}}" placeholder="Discounted Amount" autofocus="true" min="0" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3" style="display: none;">
                                        <div class="form-group">
                                            <label for="for">Final Price</label>
                                            <input type="number" class="form-control" value="0" name="final_price[]" id="final_price_{{$i}}" placeholder="Final Price" autofocus="true" min="0" />
                                        </div>
                                    </div>
                                  
                                    <!-- <div class="col-md-3">
                                        <a href="javascript:void(0);" class="btn btn-danger remove_field mt-4" id="remove_field_{{$i}}"><i class="fa fa-trash"></i></a>
                                    </div> -->

                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="add_fields btn btn-primary pl-4 pr-4 mt-4"><i class="fa fa-plus"></i> Add More</button>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="row" id="footer_box">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('event_ticket.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                        
                        <div class="row" id="footer_box_error" style="display:none; color:red">
                            <div class="col-md-12 text-center">
                                
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
    // $('#event_schedule_list_id_0').select2();
   // $('#event_show_time_id_0').select2();
    // $('#event_id_0').select2();
    // $('#layout_id_0').select2();

    //add more
    $(function(){
        var i=$('#wrapper div#row').length+1;
        $('.add_fields').click(function(e){
            e.preventDefault();
            $('.wrapper').append('<span id="hr_'+i+'"><hr></span><div class="row" id="row_'+i+'"> <div class="col-md-3"><div class="form-group"><label for="for">Ticket Type</label><select class="form-control" name="ticket_type_id[]" id="ticket_type_id_'+i+'"></select></div></div> <div class="col-md-3"><div class="form-group"><label for="for">Total Ticket</label><input type="number" class="form-control" value="0" name="total_ticket[]" id="total_ticket_'+i+'" placeholder="Total Ticket" autofocus="true" min="0" onkeyup="sub_calculate('+i+');" /></div></div> <div class="col-md-3"><div class="form-group"><label for="for">Base Price</label><input type="number" class="form-control" value="0" name="base_price[]" id="base_price_'+i+'" placeholder="Base Price" autofocus="true" min="0" onkeyup="sub_calculate('+i+');" /></div></div> <div class="col-md-3"><div class="form-group"><label for="for">Total Discount</label><input type="number" class="form-control" value="0" name="total_discount[]" id="total_discount_'+i+'" placeholder="Total Discount" autofocus="true" min="0" onkeyup="sub_calculate('+i+');" /></div></div> <div class="col-md-3" style="display: none;"><div class="form-group"><label for="for">Discounted Amount</label><input type="number" class="form-control" value="0" name="discounted_amount[]" id="discounted_amount_'+i+'" placeholder="Discounted Amount" autofocus="true" min="0" /></div></div> <div class="col-md-3" style="display: none;"><div class="form-group"><label for="for">Final Price</label><input type="number" class="form-control" value="0" name="final_price[]" id="final_price_'+i+'" placeholder="Final Price" autofocus="true" min="0" /></div></div> <div class="col-md-12 text-right" style="margin-top:-30px;"><a href="javascript:void(0);" class="btn btn-danger remove_field mt-4" id="remove_field_'+i+'"><i class="fa fa-trash"></i></a></div> </div>');

            event_ticket_data(i);

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
    function get_event_schedule_by_event_id(i,event_id)
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
                    $('#event_schedule_id_'+i).empty();

                    $('#event_schedule_list_id_'+i).empty();
                    $('.select2-selection__choice').remove();
                    //$('#event_schedule_list_id_'+i).append('<option value="">Select Event Schedule Date</option>');

                    $('#event_show_time_id_'+i).empty();
                    $('#event_show_time_id_'+i).append('<option value="">Select Event Show Time</option>');

                    $.each(response, function(key,value){
                        $('#event_schedule_id_'+i).append('<option value="'+ value.id +'">'+ value.start_date+' - '+value.end_date+'</option>');
                    });

                    setTimeout(function () {
                        var event_schedule_id= $('select#event_schedule_id_0 option:selected').val();
                        $('select#event_schedule_list_id_0').removeAttr("disabled");
                        get_event_schedule_list_by_event_schedule_id('0', event_schedule_id);
                    }, 2000);


                }
            });
        }
        else
        {
            $('#event_schedule_id_'+i).empty();
            $('#event_schedule_id_'+i).append('<option value="">Select Event Schedule</option>');
            
            $('#event_schedule_list_id_'+i).empty();
            $('.select2-selection__choice').remove();
            //$('#event_schedule_list_id_'+i).append('<option value="">Select Event Schedule Date</option>');

            $('#event_show_time_id_'+i).empty();
            $('#event_show_time_id_'+i).append('<option value="">Select Event Show Time</option>');
        }
    }

    //get event shedule list by event shedule id
    function get_event_schedule_list_by_event_schedule_id(i,event_schedule_id) 
    {
        if(event_schedule_id!='' && event_schedule_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', event_schedule_id:event_schedule_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('event_schedules.get_event_schedule_list_by_event_schedule_id_unmapped') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#event_schedule_list_id_'+i).empty();
                    $('.select2-selection__choice').remove();
                    //$('#event_schedule_list_id_'+i).append('<option value="">Select Event Schedule Date</option>');
                    $.each(response.event_schedule_lists, function(key,value){
                        $('#event_schedule_list_id_'+i).append('<option value="'+ value.id +'">'+ value.event_date+'</option>');
                    });

                    $('#event_show_time_id_'+i).empty();
                    $('#event_show_time_id_'+i).append('<option value="">Select Event Show Time</option>');
                    $.each(response.event_show_times, function(key,value){
                        $('#event_show_time_id_'+i).append('<option value="'+ value.id +'">'+ value.start_time+' - '+value.end_time+'</option>');
                    });
                }
            });
        }
        else
        {
            $('#event_schedule_list_id_'+i).empty();
            $('.select2-selection__choice').remove();
            //$('#event_schedule_list_id_'+i).append('<option value="">Select Event Schedule Date</option>');

            $('#event_show_time_id_'+i).empty();
            $('#event_show_time_id_'+i).append('<option value="">Select Event Show Time</option>');
        }
    }


    function get_event_show_time_by_event_schedule_list_id(i)
    {
         var event_schedule_list_id= $('select#event_schedule_list_id_0 option:selected').val();
         var event_schedule_id= $('select#event_schedule_id_0 option:selected').val();

        if(event_schedule_list_id!='' && event_schedule_list_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', event_schedule_list_id:event_schedule_list_id, event_schedule_id:event_schedule_id};
            $.ajax({
                type : 'POST',
                url : '{{ route('event_schedules.get_event_schedule_list_by_event_schedule_id_unmapped') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#event_show_time_id_'+i).empty();
                    $('#event_show_time_id_'+i).append('<option value="">Select Event Show Time</option>');
                    $.each(response.event_show_times, function(key,value){
                        $('#event_show_time_id_'+i).append('<option value="'+ value.id +'">'+ value.start_time+' - '+value.end_time+'</option>');
                    });
                }
            });
        }
        else
        {
                $('#event_show_time_id_'+i).empty();
            $('#event_show_time_id_'+i).append('<option value="">Select Event Show Time</option>');
        }
    }

    function get_layout_details_by_layout_id(i,layout_id) {
        console.log('test');
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
    /*$("#total_discount_0").removeAttr('readonly','readonly');
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

    $('.ticket-detail').hide();
    $('.import-detail').hide();

    function show_hide_tickets_detail(i,val) {

         var event_id= $('select#event_id_0 option:selected').val();

        if(val == "fresh") {
            $('.ticket-detail').show();
            $('.import-detail').hide();
             
            event_ticket_data('0');

        } else if(val == "import") {
            $('.ticket-detail').hide();
            $('.import-detail').show();
            
            var event_id= $('select#event_id_0 option:selected').val();
            var data = {_token:'{{ csrf_token() }}', event_id:event_id };
            $.ajax({
                type : 'POST',
                url : '{{ route('event_schedules.event_schedule_import_data') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#schedule_list_id').empty();
                    $('#schedule_list_id').append('<option value="">Select Show Date</option>');
                    $.each(response.event_schedule_lists, function(key,value){
                        $('#schedule_list_id').append('<option value="'+ value.id +'">'+ value.event_date+'</option>');
                    });
                    $('#show_time_id').empty();
                    // $('#show_time_id').append('<option value="">Select Show Time</option>');
                    // $.each(response.event_show_times, function(key,value){
                    //     $('#show_time_id').append('<option value="'+ value.id +'">'+ value.start_time+' - '+value.end_time+'</option>');
                    // });

                }
            });
        } else {
            $('.ticket-detail').hide();
            $('.import-detail').hide();
        }
    }

    function schedule_date_show_time_fetch(schedule_list_id)
    {
        var event_id= $('select#event_id_0 option:selected').val();
        var data = {_token:'{{ csrf_token() }}', schedule_list_id:schedule_list_id , event_id:event_id };
        $.ajax({
            type : 'POST',
            url : '{{ route('event_schedules.event_schedule_import_data_show') }}',
            data: data,
            dataType : 'json',
            success:function(response)
            {
                $('#show_time_id').empty();
                $('#show_time_id').append('<option value="">Select Show Time</option>');
                $.each(response.event_show_times, function(key,value){
                    $('#show_time_id').append('<option value="'+ value.event_show_time_id +'">'+ value.start_time+' - '+value.end_time+'</option>');
                });
            }
        });
    }

    function event_ticket_data(i)
    {
        var event_id= $('select#event_id_0 option:selected').val();
        var data = {_token:'{{ csrf_token() }}', event_id:event_id };
        $.ajax({
            type : 'POST',
            url : '{{ route('event_schedules.event_ticket_data') }}',
            data: data,
            dataType : 'json',
            success:function(response)
            {
                $('#ticket_type_id_'+i).empty();
                $('#ticket_type_id_'+i).append('<option value="">Select Ticket Type</option>');
                $.each(response.event_ticket, function(key,value){
                    $('#ticket_type_id_'+i).append('<option value="'+ value.id +'">'+ value.ticket_type_name+'</option>');
                });
            }
        });
    }

    
    function check_for_duplicate_mapping(show_time_id, row)
        {
          
            let event_id  = $('select#event_id_0 option:selected').val();
            let event_schedule_id  = $('select#event_schedule_id_0 option:selected').val();
            let event_schedule_list_id = $('select#event_schedule_list_id_0 option:selected').val();
            let event_show_time_id = $('select#event_show_time_id_0 option:selected').val();
            
            // console.log("event_id", event_id);
            // console.log("event_schedule_list_id", event_schedule_list_id);
            // console.log("event_show_time_id", event_show_time_id);
            
            
            var data = {_token:'{{ csrf_token() }}', event_id:event_id, event_schedule_list_id:event_schedule_list_id, event_show_time_id:event_show_time_id };
            $.ajax({
                type : 'POST',
                url : '{{ route('event_ticket.check_for_duplicate_mapping') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    if(response.count == 0)
                    {
                         $('#footer_box').show();
                          $('#footer_box_error').hide();
                    }
                    else
                    {
                         $('#footer_box').hide();
                          $('#footer_box_error').show();
                        $('#footer_box_error div').html('<h3>This show already been mapped</h3>');
                    }
                }
            });
        
            
        }

    $('document').ready(function () {
        var event_id= $('select#event_id_0 option:selected').val();
        get_event_schedule_by_event_id('0', event_id);
      

        setTimeout(function () {
            var event_schedule_id= $('select#event_schedule_id_0 option:selected').val();
            $('select#event_schedule_list_id_0').removeAttr("disabled");
            get_event_schedule_list_by_event_schedule_id('0', event_schedule_id);
        }, 2000);
        
        
        
    });
</script>
@endsection