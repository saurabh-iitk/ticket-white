@extends('layouts.dashboard')

@section('title', 'Edit/Booking Platform')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Edit Booking Platform</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('booking_platform.index') }}">Booking Platforms</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-5">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('booking_platform/'.$booking_platform->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" value="{{ $booking_platform->name }}" name="name" placeholder="Name" autofocus="true"/>
                        </div>
                        <div class="form-group">
                            <label for="role">Status</label>
                            <select class="form-control" name="status">
                                <option value="ACTIVE" <?php if($booking_platform->status=='ACTIVE'){ echo 'selected';} ?>>ACTIVE</option>
                                <option value="INACTIVE" <?php if($booking_platform->status=='INACTIVE'){ echo 'selected';} ?>>INACTIVE</option>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('booking_platform.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection