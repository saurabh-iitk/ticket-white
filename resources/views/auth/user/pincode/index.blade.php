@extends('layouts.dashboard')

@section('title', 'Pincode')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Pincode List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('pincode.index') }}">Pincodes</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    @if(in_array('pincode_store', Session::get('permissions')->toArray()))
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <a href="{{ URL::to('pincode/create') }}" class="btn btn-info pl-5 pr-5">Add</a>
                        </div>
                    </div>
                    @endif
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>State</th>
                                <th>City</th>
                                <th>Pincode</th>
                                <th>Status</th>
                                <th width="180px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($pincodes)
                                @foreach($pincodes as $pincode)
                                    <tr>
                                        <td>@if(getState($pincode->state_id)){{ getState($pincode->state_id)->name }}@endif</td>
                                        <td>@if(getCity($pincode->city_id)){{ getCity($pincode->city_id)->name }}@endif</td>
                                        <td>{{ $pincode->pincode }}</td>
                                        <td>{{ $pincode->status }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('pincode.show',$pincode->id) }}">View Details</a>
                                            @if(in_array('pincode_update', Session::get('permissions')->toArray()))
                                            <a class="btn btn-primary btn-sm" href="{{ route('pincode.edit',$pincode->id) }}">Edit</a>
                                            @endif
                                            @if(in_array('pincode_destroy', Session::get('permissions')->toArray()))
                                            <form action="{{ route('pincode.destroy',$pincode->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="confirm_delete();" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
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
    'columnDefs': [ {
        'targets': [1],
        'orderable': false
    }]
});
</script>
@endsection