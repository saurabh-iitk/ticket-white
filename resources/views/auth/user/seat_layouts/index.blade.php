@extends('layouts.dashboard')

@section('title', 'Layout')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Layout List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('layout.index') }}">Layouts</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    @if(in_array('layout_store', Session::get('permissions')->toArray()))
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <a href="{{ URL::to('layout/create') }}" class="btn btn-info pl-5 pr-5">Add</a>
                        </div>
                    </div>
                    @endif
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Venue</th>
                                <th>Sub Venue</th>
                                <th>Layout Name</th>
                                <th>Status</th>
                                <th width="160px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($layouts)
                                @foreach($layouts as $key => $layout)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>@if(getVenue($layout->venue_id)){{ getVenue($layout->venue_id)->name }}@endif</td>
                                        <td>@if(getSubVenue($layout->sub_venue_id)){{ getSubVenue($layout->sub_venue_id)->name }}@endif</td>
                                        <td>{{ $layout->layout_name }}</td>
                                        <td>{{ $layout->status }}</td>
                                        <td class="text-center">
                                            @if(in_array('layout_update', Session::get('permissions')->toArray()))
                                            {{--<!-- <a class="btn btn-primary btn-sm" href="{{ route('layout.edit',$layout->id) }}">Edit</a> -->--}}
                                            @endif
                                            @if(in_array('layout_destroy', Session::get('permissions')->toArray()))
                                            <form action="{{ route('layout.destroy',$layout->id) }}" method="POST" style="display:inline-block;">
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