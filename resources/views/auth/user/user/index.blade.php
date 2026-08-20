@extends('layouts.dashboard')

@section('title', 'User')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> User List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">Users</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    @if(in_array('user_store', Session::get('permissions')->toArray()))
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <a href="{{ URL::to('user/create') }}" class="btn btn-info pl-5 pr-5">Add</a>
                        </div>
                    </div>
                    @endif
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="180px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users)
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-sm" href="{{ route('user.show',$user->id) }}">View Details</a>
                                    @if(Auth::user()->role_id ==1  || Auth::user()->role_id ==8)

                                        @if(in_array('user_update', Session::get('permissions')->toArray()) && ($user->role->id!=1))
                                            <a class="btn btn-primary btn-sm" href="{{ route('user.edit',$user->id) }}">Edit</a>
                                        @endif
                                        
                                        @if(in_array('user_destroy', Session::get('permissions')->toArray()))
                                        
                                        @if($user->id != 1)
                                            <form action="{{ route('user.destroy',$user->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="confirm_delete();" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                       
                                            @if($user->status == 'ACTIVE')
                                            <form action="{{ route('user.block',['id' => $user->id,'status' => 'INACTIVE']) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" onclick="confirm_block();" class="btn btn-danger btn-sm">Block</button>
                                            </form>
                                            @else
                                            <form action="{{ route('user.block',['id' => $user->id,'status' => 'ACTIVE']) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" onclick="confirm_block();" class="btn btn-warning btn-sm">Unblock</button>
                                            </form>
                                            @endif
                                            
                                         @endif
                                         
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<!-- Data table plugin-->
<script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/confirm_delete.js') }}"></script>
<script>
    $('#userTable').DataTable({
        'columnDefs': [{
            'targets': [3],
            'orderable': false
        }]
    });
</script>
@endsection