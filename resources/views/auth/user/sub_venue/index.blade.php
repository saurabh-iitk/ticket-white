@extends('layouts.dashboard')

@section('title', 'Sub Venue')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Sub Venue List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('sub_venue.index') }}">Sub Venues</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    @if(in_array('sub_venue_store', Session::get('permissions')->toArray()))
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <a href="{{ URL::to('sub_venue/create') }}" class="btn btn-info pl-5 pr-5">Add</a>
                        </div>
                    </div>
                    @endif
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>Venue</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th width="180px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($sub_venues)
                                @foreach($sub_venues as $sub_venue)
                                    <tr>
                                        <td>@if(getVenue($sub_venue->venue_id)){{ getVenue($sub_venue->venue_id)->name }}@endif</td>
                                        <td>{{ $sub_venue->name }}</td>
                                        <td>{{ $sub_venue->status }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('sub_venue.show',$sub_venue->id) }}">View Details</a>
                                            @if(in_array('sub_venue_update', Session::get('permissions')->toArray()))
                                            <a class="btn btn-primary btn-sm" href="{{ route('sub_venue.edit',$sub_venue->id) }}">Edit</a>
                                            @endif
                                            @if(in_array('sub_venue_destroy', Session::get('permissions')->toArray()))
                                            <form action="{{ route('sub_venue.destroy',$sub_venue->id) }}" method="POST" style="display:inline-block;">
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