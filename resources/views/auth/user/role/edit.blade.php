@extends('layouts.dashboard')

@section('title', 'Edit/Role')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Edit Role</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('role.index') }}">Roles</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('role/'.$role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" value="{{ $role->name }}" name="name" placeholder="Name" autofocus="true" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if($modulesWithPermissions)
                                @foreach($modulesWithPermissions as $module)
                                    <div class="col-md-4">
                                        <strong>{{ $module->display_name }}</strong>
                                        <ul class="list-group mt-2">
                                            @foreach($module->permissions as $permission)
                                            <li class="list-group-item">
                                                @if(in_array($module->id.'_'.$permission->id,$role->permissions))
                                                    <input type="checkbox" name="modules_permissions[]" value="{{$module->id}}_{{$permission->id}}" checked="true">
                                                    {{$permission->display_name}}
                                                @else
                                                    <input type="checkbox" name="modules_permissions[]" value="{{$module->id}}_{{$permission->id}}">
                                                    {{$permission->display_name}}
                                                @endif
                                            </li>
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
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('role.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection