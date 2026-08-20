@extends('layouts.dashboard')

@section('title', 'Add/Pincode')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Add Pincode</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('pincode.index') }}">Pincodes</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-5">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('pincode') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">State <span class="required">*</span></label>
                            <select class="form-control" name="state_id" id="state_id" onchange="get_city_by_state_id(this.value);" autofocus="true">
                                <option value="">Select State</option>
                                @foreach($states as $key => $state)
                                <option value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">City <span class="required">*</span></label>
                            <select class="form-control" name="city_id" id="city_id">
                                <option value="">Select City</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="pincode">Pincode (Type Numeric Value) <span class="required">*</span></label>
                            <input type="text" class="form-control" name="pincode" id="pin_code" placeholder="Pincode" autofocus="true" maxlength="6" />
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('pincode.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
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