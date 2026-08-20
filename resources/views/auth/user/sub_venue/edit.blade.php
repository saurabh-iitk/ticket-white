@extends('layouts.dashboard')

@section('title', 'Edit/Sub Venue')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Edit Sub Venue</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('sub_venue.index') }}">Sub Venues</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-5">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">

                    <form action="{{ url('sub_venue/' . $sub_venue->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="venue_id">Venue <span class="required">*</span></label>
                            {{ Html::select('venue_id', $venues, $sub_venue->venue_id, ['class' => 'form-control', 'placeholder' => 'Select Venue', 'autofocus' => 'true']) }}
                        </div>

                        <div class="form-group">
                            <label for="name">Name <span class="required">*</span></label>
                            <input type="text" class="form-control" value="{{ $sub_venue->name }}" name="name" placeholder="Name" autofocus="true" />
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            {{ Html::select('status', ['ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE'], $sub_venue->status, ['class' => 'form-control']) }}
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('sub_venue.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection