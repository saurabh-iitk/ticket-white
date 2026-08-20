@extends('layouts.dashboard')

@section('title', 'Edit/Configuration')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Edit Configuration</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('configuration.index') }}">Configurations</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-5">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('configuration/' . $configuration->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="for">Email</label>
                            <input type="text" class="form-control" value="{{ $configuration->email }}" name="email" placeholder="Email" autofocus="true" />
                        </div>
                        <div class="form-group">
                            <label for="role">Status</label>
                            <select class="form-control" name="status">
                                <option value="ACTIVE" <?php if($configuration->status=='ACTIVE'){ echo 'selected';} ?>>ACTIVE</option>
                                <option value="INACTIVE" <?php if($configuration->status=='INACTIVE'){ echo 'selected';} ?>>INACTIVE</option>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('configuration.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection