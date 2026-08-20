@extends('layouts.dashboard')

@section('title', 'Add/Event')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Add Event</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event.index') }}">Events</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('event') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">State <span class="required">*</span></label>
                                    <select class="form-control" name="state_id" id="state_id" onchange="get_city_by_state_id(this.value);" autofocus="true">
                                        <option value="">Select State</option>
                                        @foreach($states as $key => $state)
                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">GST State <span class="required">*</span></label>
                                    <select class="form-control" name="state" id="state">
                                        <option value="">---Please Select State---</option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chandigarh">Chandigarh</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Ladakh">Ladakh</option>
                                        <option value="Lakshadweep">Lakshadweep</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Odisha">Odisha</option>
                                        <option value="Puducherry">Puducherry</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Uttarakhand">Uttarakhand</option>
                                        <option value="West Bengal">West Bengal</option>
                                    </select>
                                </div>
                            </div>
                            
                            
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event State <span class="required">*</span></label>
                                    <select class="form-control" name="event_state" id="event_state">
                                        <option value="">---Please Select Event State---</option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chandigarh">Chandigarh</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Ladakh">Ladakh</option>
                                        <option value="Lakshadweep">Lakshadweep</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Odisha">Odisha</option>
                                        <option value="Puducherry">Puducherry</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Uttarakhand">Uttarakhand</option>
                                        <option value="West Bengal">West Bengal</option>
                                    </select>
                                </div>
                            </div>
                            

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">City <span class="required">*</span></label>
                                    <select class="form-control" name="city_id" id="city_id" onchange="get_venue_by_city_id(this.value);">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Venue <span class="required">*</span></label>
                                    <select class="form-control" name="venue_id" id="venue_id" onchange="get_sub_venue_by_venue_id(this.value);">
                                        <option value="">Select Venue</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Sub Venue <span class="required">*</span></label>
                                    <select class="form-control" name="sub_venue_id" id="sub_venue_id">
                                        <option value="">Select Sub Venue</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Organizer <span class="required">*</span></label>
                                    <select class="form-control" name="organizer_id" id="organizer_id">
                                        <option value="">Select Organizer</option>
                                        @foreach($organizers as $key => $organizer)
                                        <option value="{{$organizer->id}}">{{$organizer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Title <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="event_title" placeholder="Event Title" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Description</label>
                                    <textarea class="form-control" name="event_description" rows="2" placeholder="Event Description" autofocus="true"></textarea>
                                </div>
                            </div>

                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Start Date</label>
                                    <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Start Date" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">End Date</label>
                                    <input type="text" class="form-control" name="end_date" id="end_date" placeholder="End Date" autofocus="true" />
                                </div>
                            </div> -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Banner</label>
                                    <input type="file" class="form-control" name="event_banner" id="Multifileupload" />
                                </div>

                                <div id="MultidvPreview"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Video</label>
                                    <input type="file" class="form-control" id="Multivideoupload" name="event_video" size="55550" accept=".mp4, .mkv, .wmv, .webm, .3gp" autofocus="true" />
                                </div>

                                <div id="VideoPreview"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Category</label>
                                    <select class="form-control" name="event_category">
                                        <option value="COMEDY">COMEDY</option>
                                        <option value="CONFERENCE">CONFERENCE</option>
                                        <option value="LIVE_PERFORMANCE">LIVE PERFORMANCE</option>
                                        <option value="MAGIC_SHOW">MAGIC SHOW</option>
                                        <option value="OTHER" selected="selected">OTHER</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Type</label>
                                    <select class="form-control" name="event_type">
                                        <option value="SINGLE_DAY">SINGLE DAY</option>
                                        <option value="RECURRING">RECURRING</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Recurring Type</label>
                                    <select class="form-control" name="recurring_type">
                                        <option value="DAILY">DAILY</option>
                                        <option value="ALTERNATIVE">ALTERNATIVE</option>
                                        <option value="WEEKLY">WEEKLY</option>
                                        <option value="MONTHLY">MONTHLY</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Is Published</label>
                                    <select class="form-control" name="is_published">
                                        <option value="NO">NO</option>
                                        <option value="YES">YES</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">GST Name <span class="required">*</span></label>
                                    <input type="text" class="form-control"  name="gst_name" placeholder="GST Name" autofocus="true" />
                                </div>
                            </div>
                            

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">GST No. <span class="required">*</span></label>
                                    <input type="text" class="form-control"  name="gst_no" placeholder="GST No." autofocus="true" />
                                </div>
                            </div>
                            

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">GST Address <span class="required">*</span></label>
                                    <input type="text" class="form-control"  name="gst_address" placeholder="GST Address" autofocus="true" />
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Invoice Prefix <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="invoice_prefix" placeholder="Invoice Prefix" autofocus="true" />
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Show Hide Timing (+ / -) <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="show_hide_time" placeholder="Show Hide Timing" autofocus="true" />
                                </div>
                                <i> Note: Put + for after time close and - for before show time close</i>
                            </div>
                            


                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('event.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
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
<script src="{{ asset('js/plugins/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/preview.js') }}"></script>
<script>
    //get city by state id
    function get_city_by_state_id(state_id)
    {
        if(state_id!='' && state_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', state_id:state_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('cities.get_city_by_state_id') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select City</option>');
                    $('#venue_id').empty();
                    $('#venue_id').append('<option value="">Select Venue</option>');
                    $('#sub_venue_id').empty();
                    $('#sub_venue_id').append('<option value="">Select Sub Venue</option>');
                    $.each(response, function(key,value){
                        $('#city_id').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }
        else
        {
            $('#city_id').empty();
            $('#city_id').append('<option value="">Select City</option>');
            $('#venue_id').empty();
            $('#venue_id').append('<option value="">Select Venue</option>');
            $('#sub_venue_id').empty();
            $('#sub_venue_id').append('<option value="">Select Sub Venue</option>');
        }
    }

    //get venue by city id
    function get_venue_by_city_id(city_id)
    {
        if(city_id!='' && city_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', city_id:city_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('venues.get_venue_by_city_id') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#venue_id').empty();
                    $('#venue_id').append('<option value="">Select Venue</option>');
                    $('#sub_venue_id').empty();
                    $('#sub_venue_id').append('<option value="">Select Sub Venue</option>');
                    $.each(response, function(key,value){
                        $('#venue_id').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }
        else
        {
            $('#venue_id').empty();
            $('#venue_id').append('<option value="">Select Venue</option>');
            $('#sub_venue_id').empty();
            $('#sub_venue_id').append('<option value="">Select Sub Venue</option>');
        }
    }

    //get sub venue by venue id
    function get_sub_venue_by_venue_id(venue_id)
    {
        if(venue_id!='' && venue_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', venue_id:venue_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('sub_venues.get_sub_venue_by_venue_id') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#sub_venue_id').empty();
                    $('#sub_venue_id').append('<option value="">Select Sub Venue</option>');
                    $.each(response, function(key,value){
                        $('#sub_venue_id').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }
        else
        {
            $('#sub_venue_id').empty();
            $('#sub_venue_id').append('<option value="">Select Sub Venue</option>');
        }
    }
</script>
@endsection