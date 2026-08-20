@extends('layouts.dashboard')

@section('title', 'Edit/Venue')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Edit Venue</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('venue.index') }}">Venues</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form method="post" action="{{ route('venue.index') }}<?php echo '/'.$venue->id;?>">
                        
                        <input name="_method" type="hidden" value="PUT">
                        
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">State <span class="required">*</span></label>
                                    <select class="form-control" name="state_id" id="state_id" onchange="get_city_by_state_id(this.value);" autofocus="true">
                                        <option value="">Select State</option>
                                        @foreach($states as $key => $state)
                                        <option value="{{$state->id}}" <?php if($venue->state_id==$state->id){ echo 'selected';} ?>>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">City <span class="required">*</span></label>
                                    <select class="form-control" name="city_id" id="city_id" onchange="get_pincode_by_city_id(this.value);">
                                        <option value="">Select City</option>
                                        @foreach(getCityByStateID($venue->state_id) as $key => $city)
                                        <option value="{{$city->id}}" <?php if($venue->city_id==$city->id){ echo 'selected';} ?>>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Pincode <span class="required">*</span></label>
                                    <select class="form-control" name="pincode_id" id="pincode_id">
                                        <option value="">Select Pincode</option>
                                        @foreach(getPincodeByCityID($venue->city_id) as $key => $pincode)
                                        <option value="{{$pincode->id}}" <?php if($venue->pincode_id==$pincode->id){ echo 'selected';} ?>>{{$pincode->pincode}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $venue->name }}" name="name" placeholder="Name" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" name="address" rows="2" placeholder="Enter your address" autofocus="true">{{ $venue->address }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">Map</label>
                                    <textarea class="form-control" name="map" rows="2" placeholder="Map" autofocus="true">{{ $venue->map }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="capacity">Capacity</label>
                                    <input type="number" class="form-control" value="{{ $venue->capacity }}" name="capacity" placeholder="Capacity" autofocus="true" min="0" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_person_name">Contact Person Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $venue->contact_person_name }}" name="contact_person_name" placeholder="Contact Person Name" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_no">Contact No <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $venue->contact_no }}" name="contact_no" placeholder="Contact No" autofocus="true" maxlength="10" />
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role">Parking</label>
                                    <select class="form-control" name="parking">
                                        <option value="NO" <?php if($venue->parking=='NO'){ echo 'selected';} ?>>NO</option>
                                        <option value="YES" <?php if($venue->parking=='YES'){ echo 'selected';} ?>>YES</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role">Type</label>
                                    <select class="form-control" name="type">
                                        <option value="COMMERCIAL_BUILDING" <?php if($venue->type=='COMMERCIAL_BUILDING'){ echo 'selected';} ?>>COMMERCIAL BUILDING</option>
                                        <option value="MALL" <?php if($venue->type=='MALL'){ echo 'selected';} ?>>MALL</option>
                                        <option value="THEATRE" <?php if($venue->type=='THEATRE'){ echo 'selected';} ?>>THEATRE</option>
                                        <option value="UNIVERSITY" <?php if($venue->type=='UNIVERSITY'){ echo 'selected';} ?>>UNIVERSITY</option>
                                        <option value="OTHER" <?php if($venue->type=='OTHER'){ echo 'selected';} ?>>OTHER</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="ACTIVE" <?php if($venue->status=='ACTIVE'){ echo 'selected';} ?>>ACTIVE</option>
                                        <option value="INACTIVE" <?php if($venue->status=='INACTIVE'){ echo 'selected';} ?>>INACTIVE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('venue.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
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
                    $('#pincode_id').empty();
                    $('#pincode_id').append('<option value="">Select Pincode</option>');
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
            $('#pincode_id').empty();
            $('#pincode_id').append('<option value="">Select Pincode</option>');
        }
    }
    
    //get pincode by city id
    function get_pincode_by_city_id(city_id) 
    {
        if(city_id!='' && city_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', city_id:city_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('pincodes.get_pincode_by_city_id') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#pincode_id').empty();
                    $('#pincode_id').append('<option value="">Select Pincode</option>');
                    $.each(response, function(key,value){
                        $('#pincode_id').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }
        else
        {
            $('#pincode_id').empty();
            $('#pincode_id').append('<option value="">Select Pincode</option>');
        }
    }
</script>
@endsection