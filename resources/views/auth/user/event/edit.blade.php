@extends('layouts.dashboard')

@section('title', 'Edit/Event')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Edit Event</h1>
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
                    <form action="{{ url('event/' . $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">State <span class="required">*</span></label>
                                    <select class="form-control" name="state_id" id="state_id" onchange="get_city_by_state_id(this.value);" autofocus="true">
                                        <option value="">Select State</option>
                                        @foreach($states as $key => $state)
                                        <option value="{{$state->id}}" <?php if($event->state_id==$state->id){ echo 'selected';} ?>>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
    
    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">GST State <span class="required">*</span></label>
                                    <select class="form-control" name="state" id="state">
                                        <option value="">---Please Select State---</option>
                                        <?php 
                                            $states = [
                                                "Andaman and Nicobar Islands",
                                                "Andhra Pradesh",
                                                "Arunachal Pradesh",
                                                "Assam",
                                                "Bihar",
                                                "Chandigarh",
                                                "Chhattisgarh",
                                                "Dadra and Nagar Haveli and Daman and Diu",
                                                "Delhi",
                                                "Goa",
                                                "Gujarat",
                                                "Haryana",
                                                "Himachal Pradesh",
                                                "Jammu and Kashmir",
                                                "Jharkhand",
                                                "Karnataka",
                                                "Kerala",
                                                "Ladakh",
                                                "Lakshadweep",
                                                "Madhya Pradesh",
                                                "Maharashtra",
                                                "Manipur",
                                                "Meghalaya",
                                                "Mizoram",
                                                "Nagaland",
                                                "Odisha",
                                                "Puducherry",
                                                "Punjab",
                                                "Rajasthan",
                                                "Sikkim",
                                                "Tamil Nadu",
                                                "Telangana",
                                                "Tripura",
                                                "Uttar Pradesh",
                                                "Uttarakhand",
                                                "West Bengal"
                                            ];
                            
                                            foreach ($states as $state) {
                                                $selected = ($event->state == $state) ? "selected" : "";
                                                echo "<option value='$state' $selected>$state</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            
                              <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event State <span class="required">*</span></label>
                                    <select class="form-control" name="event_state" id="event_state">
                                        <option value="">---Please Select Event State---</option>
                                        <?php 
                                            $states = [
                                                "Andaman and Nicobar Islands",
                                                "Andhra Pradesh",
                                                "Arunachal Pradesh",
                                                "Assam",
                                                "Bihar",
                                                "Chandigarh",
                                                "Chhattisgarh",
                                                "Dadra and Nagar Haveli and Daman and Diu",
                                                "Delhi",
                                                "Goa",
                                                "Gujarat",
                                                "Haryana",
                                                "Himachal Pradesh",
                                                "Jammu and Kashmir",
                                                "Jharkhand",
                                                "Karnataka",
                                                "Kerala",
                                                "Ladakh",
                                                "Lakshadweep",
                                                "Madhya Pradesh",
                                                "Maharashtra",
                                                "Manipur",
                                                "Meghalaya",
                                                "Mizoram",
                                                "Nagaland",
                                                "Odisha",
                                                "Puducherry",
                                                "Punjab",
                                                "Rajasthan",
                                                "Sikkim",
                                                "Tamil Nadu",
                                                "Telangana",
                                                "Tripura",
                                                "Uttar Pradesh",
                                                "Uttarakhand",
                                                "West Bengal"
                                            ];
                            
                                            foreach ($states as $state) {
                                                $selected = ($event->event_state == $state) ? "selected" : "";
                                                echo "<option value='$state' $selected>$state</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">City <span class="required">*</span></label>
                                    <select class="form-control" name="city_id" id="city_id" onchange="get_venue_by_city_id(this.value);">
                                        <option value="">Select City</option>
                                        @foreach(getCityByStateID($event->state_id) as $key => $city)
                                        <option value="{{$city->id}}" <?php if($event->city_id==$city->id){ echo 'selected';} ?>>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Venue <span class="required">*</span></label>
                                    <select class="form-control" name="venue_id" id="venue_id" onchange="get_sub_venue_by_venue_id(this.value);">
                                        <option value="">Select Venue</option>
                                        @foreach(getVenueByCityID($event->city_id) as $key => $venue)
                                        <option value="{{$venue->id}}" <?php if($event->venue_id==$venue->id){ echo 'selected';} ?>>{{$venue->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Sub Venue <span class="required">*</span></label>
                                    <select class="form-control" name="sub_venue_id" id="sub_venue_id">
                                        <option value="">Select Sub Venue</option>
                                        @foreach(getSubVenueByVenueID($event->venue_id) as $key => $sub_venue)
                                        <option value="{{$sub_venue->id}}" <?php if($event->sub_venue_id==$sub_venue->id){ echo 'selected';} ?>>{{$sub_venue->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Organizer <span class="required">*</span></label>
                                    <select class="form-control" name="organizer_id" id="organizer_id">
                                        <option value="">Select Organizer</option>
                                        @foreach($organizers as $key => $organizer)
                                        <option value="{{$organizer->id}}" <?php if($event->organizer_id==$organizer->id){ echo 'selected';} ?>>{{$organizer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Title <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $event->event_title }}" name="event_title" placeholder="Event Title" autofocus="true" />
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Description</label>
                                    <textarea class="form-control" name="event_description" rows="2" placeholder="Event Description" autofocus="true">{{ $event->event_description }}</textarea>
                                </div>
                            </div>

                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Start Date</label>
                                    <input type="text" class="form-control" value="{{ $event->start_date }}" name="start_date" id="start_date" placeholder="Start Date" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">End Date</label>
                                    <input type="text" class="form-control" value="{{ $event->end_date }}" name="end_date" id="end_date" placeholder="End Date" autofocus="true" />
                                </div>
                            </div> -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Banner</label>
                                    <input type="file" class="form-control" name="event_banner" id="Multifileupload" />
                                    @if($event->event_banner)
                                        <br>
                                        <img src="{!! url('/').'/uploads/events/banner/'.$event->event_banner !!}" alt="img" class="img-responsive" style="height:100px;width:100px;" />
                                    @endif
                                </div>
                                
                                <div id="MultidvPreview"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Video</label>
                                    <input type="file" class="form-control" id="Multivideoupload" name="event_video" size="55550" accept=".mp4, .mkv, .wmv, .webm, .3gp" autofocus="true" />
                                    @if($event->event_video)
                                        <br>
                                        <video width="100" height="100" controls><source src="{!! url('/').'/uploads/events/video/'.$event->event_video !!}" type="video/mp4"></video>
                                    @endif
                                </div>
                                <div id="VideoPreview"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Category</label>
                                    <select class="form-control" name="event_category">
                                        <option value="COMEDY" <?php if($event->event_category=='COMEDY'){ echo 'selected';} ?>>COMEDY</option>
                                        <option value="CONFERENCE" <?php if($event->event_category=='CONFERENCE'){ echo 'selected';} ?>>CONFERENCE</option>
                                        <option value="LIVE_PERFORMANCE" <?php if($event->event_category=='LIVE_PERFORMANCE'){ echo 'selected';} ?>>LIVE PERFORMANCE</option>
                                        <option value="MAGIC_SHOW" <?php if($event->event_category=='MAGIC_SHOW'){ echo 'selected';} ?>>MAGIC SHOW</option>
                                        <option value="OTHER" <?php if($event->event_category=='OTHER'){ echo 'selected';} ?>>OTHER</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Event Type</label>
                                    <select class="form-control" name="event_type">
                                        <option value="SINGLE_DAY" <?php if($event->event_type=='SINGLE_DAY'){ echo 'selected';} ?>>SINGLE DAY</option>
                                        <option value="RECURRING" <?php if($event->event_type=='RECURRING'){ echo 'selected';} ?>>RECURRING</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Recurring Type</label>
                                    <select class="form-control" name="recurring_type">
                                        <option value="DAILY" <?php if($event->recurring_type=='DAILY'){ echo 'selected';} ?>>DAILY</option>
                                        <option value="ALTERNATIVE" <?php if($event->recurring_type=='ALTERNATIVE'){ echo 'selected';} ?>>ALTERNATIVE</option>
                                        <option value="WEEKLY" <?php if($event->recurring_type=='WEEKLY'){ echo 'selected';} ?>>WEEKLY</option>
                                        <option value="MONTHLY" <?php if($event->recurring_type=='MONTHLY'){ echo 'selected';} ?>>MONTHLY</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Is Published</label>
                                    <select class="form-control" name="is_published">
                                        <option value="NO" <?php if($event->is_published=='NO'){ echo 'selected';} ?>>NO</option>
                                        <option value="YES" <?php if($event->is_published=='YES'){ echo 'selected';} ?>>YES</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="ACTIVE" <?php if($event->status=='ACTIVE'){ echo 'selected';} ?>>ACTIVE</option>
                                        <option value="INACTIVE" <?php if($event->status=='INACTIVE'){ echo 'selected';} ?>>INACTIVE</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">GST Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $event->gst_name }}" name="gst_name" placeholder="GST Name" autofocus="true" />
                                </div>
                            </div>
                            

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">GST No. <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $event->gst_no }}" name="gst_no" placeholder="GST No." autofocus="true" />
                                </div>
                            </div>
                            

                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">GST Address <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $event->gst_address }}"   name="gst_address" placeholder="GST Address" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Invoice Prefix <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $event->invoice_prefix }}" name="invoice_prefix" placeholder="Invoice Prefix" autofocus="true" />
                                </div>
                            </div>
                            
                            
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Show Hide Timing (+ / -) <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $event->show_hide_time }}" name="show_hide_time" placeholder="Show Hide Timing" autofocus="true" />
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