@extends('layouts.dashboard')

@section('title', 'Edit/Company')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Edit Company</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('company.index') }}">Companies</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('company/' . $company->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">State <span class="required">*</span></label>
                                    <select class="form-control" name="state_id" id="state_id" onchange="get_city_by_state_id(this.value);" autofocus="true">
                                        <option value="">Select State</option>
                                        @foreach($states as $key => $state)
                                        <option value="{{$state->id}}" <?php if($company->state_id==$state->id){ echo 'selected';} ?>>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">City <span class="required">*</span></label>
                                    <select class="form-control" name="city_id" id="city_id">
                                        <option value="">Select City</option>
                                        @foreach(getCityByStateID($company->state_id) as $key => $city)
                                        <option value="{{$city->id}}" <?php if($company->city_id==$city->id){ echo 'selected';} ?>>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $company->name }}" name="name" placeholder="Name" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Address</label>
                                    <textarea class="form-control" name="address" rows="2" placeholder="Address" autofocus="true">{{ $company->address }}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pincode">Pincode (Type Numeric Value) <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $company->pincode }}" name="pincode" id="pin_code" placeholder="Pincode" maxlength="6" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Email <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $company->email }}" name="email" placeholder="Email" autofocus="true" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Website</label>
                                    <input type="text" class="form-control" value="{{ $company->website }}" name="website" placeholder="Website" autofocus="true" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Contact Person</label>
                                    <input type="text" class="form-control" value="{{ $company->contact_person }}" name="contact_person" placeholder="Contact Person" autofocus="true" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">GST No.</label>
                                    <input type="text" class="form-control" value="{{ $company->gst_no }}" name="gst_no" placeholder="GST No." autofocus="true" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Registered Address</label>
                                    <textarea class="form-control" name="registered_address" rows="2" placeholder="Registered Address" autofocus="true">{{ $company->registered_address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Category</label>
                                    <input type="text" class="form-control" value="{{ $company->category }}" name="category" placeholder="Category" autofocus="true" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Helpline</label>
                                    <input type="text" class="form-control" value="{{ $company->helpline }}" name="helpline" placeholder="Helpline" autofocus="true" maxlength="10" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Logo</label>
                                    <input type="file" class="form-control" name="logo" id="Multifileupload" />
                                    @if($company->logo)
                                        <br>
                                        <img src="{!! url('/').'/uploads/logo/'.$company->logo !!}" alt="img" class="img-responsive" style="height:100px;width:100px;" />
                                    @endif
                                </div>

                                <div id="MultidvPreview"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Description</label>
                                    <textarea class="form-control" name="description" rows="2" placeholder="Description" autofocus="true">{{ $company->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="ACTIVE" <?php if($company->status=='ACTIVE'){ echo 'selected';} ?>>ACTIVE</option>
                                        <option value="INACTIVE" <?php if($company->status=='INACTIVE'){ echo 'selected';} ?>>INACTIVE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('company.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
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
<script src="{{ asset('js/preview.js') }}"></script>
<script>
    //Restricts input for the given textbox to the given inputFilter.
    function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                }
            });
        });
    }
    // Install input filters.
    setInputFilter(document.getElementById("pin_code"), function(value) {
    return /^-?\d*$/.test(value); });

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
        }
    }

</script>
@endsection