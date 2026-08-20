@extends('layouts.dashboard')

@section('title', 'Show/Module')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Show Module</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('module.index') }}">Modules</a></li>
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
                                <input type="text" class="form-control " value="{{ $module->name }}" name="name" readonly />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Display Name</label>
                                <input type="text" class="form-control " value="{{ $module->display_name }}" name="display_name" readonly />
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h4 class="mb-4"><strong>Permissions List</strong></h4>
                                <div class="wrapper">
                                    @if($module['permissions'])
                                        @foreach($module['permissions'] as $permission)
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control mt-4" value="{{ $permission['name'] }}" readonly />
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control mt-4" value="{{ $permission['display_name'] }}" readonly />
                                                </div>
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('module.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection