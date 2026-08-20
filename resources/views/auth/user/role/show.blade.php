@extends('layouts.dashboard')

@section('title', 'Show/Role')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Show Role</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('role.index') }}">Role</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" value="{{ $role->name }}" disabled="true" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if($role->permissions)
                            @foreach($role->permissions as $key => $permissions)
                                <div class="col-md-4">
                                    <strong>{{ $key }}</strong>
                                    <ul class="list-group mt-2">
                                        @foreach($permissions as $permission)
                                            <li class="list-group-item">{{$permission}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-4">
                                    <h4 class="mb-4"><strong>No Records</strong></h4>
                                </div>

                            </div>
                        @endif
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('role.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection