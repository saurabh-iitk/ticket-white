@extends('layouts.dashboard')

@section('title', 'Edit/City')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Edit City</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('city.index') }}">Cities</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-5">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('city/' . $city->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <div class="form-group">
                            <label for="state_id">State <span class="required">*</span></label>
                            <select name="state_id" id="state_id" class="form-control" autofocus>
                                <option value="" disabled>Select State</option>
                                @foreach($states as $key => $value)
                                    <option value="{{ $key }}" {{ $key == $city->state_id ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Name <span class="required">*</span></label>
                            <input type="text" id="name" class="form-control" value="{{ $city->name }}" name="name" placeholder="Name" autofocus />
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="ACTIVE" {{ $city->status == 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                                <option value="INACTIVE" {{ $city->status == 'INACTIVE' ? 'selected' : '' }}>INACTIVE</option>
                            </select>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('city.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</main>
@endsection