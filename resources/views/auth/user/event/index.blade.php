@extends('layouts.dashboard')

@section('title', 'Event')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Event List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event.index') }}">Events</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    @if(in_array('event_store', Session::get('permissions')->toArray()))
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <a href="{{ URL::to('event/create') }}" class="btn btn-info pl-5 pr-5">Add</a>
                        </div>
                    </div>
                    @endif
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>State</th>
                                <th>City</th>
                                <th>Venue</th>
                                <th>Sub Venue</th>
                                <th>Event Title</th>
                                <!-- <th>Start Date</th>
                                <th>End Date</th> -->
                                <th>Status</th>
                                <th width="180px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($events)
                                @foreach($events as $event)
                                    <tr>
                                        <td>@if(getState($event->state_id)){{ getState($event->state_id)->name }}@endif</td>
                                        <td>@if(getCity($event->city_id)){{ getCity($event->city_id)->name }}@endif</td>
                                        <td>@if(getVenue($event->venue_id)){{ getVenue($event->venue_id)->name }}@endif</td>
                                        <td>@if(getSubVenue($event->sub_venue_id)){{ getSubVenue($event->sub_venue_id)->name }}@endif</td>
                                        <td>{{ $event->event_title }}</td>
                                        <!-- <td>{{ nice_date($event->start_date) }}</td>
                                        <td>{{ nice_date($event->end_date) }}</td> -->
                                        <td>{{ $event->status }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('event.show',$event->id) }}">View Details</a>
                                            @if(in_array('event_update', Session::get('permissions')->toArray()))
                                            <a class="btn btn-primary btn-sm" href="{{ route('event.edit',$event->id) }}">Edit</a>
                                            @endif
                                            @if(in_array('event_destroy', Session::get('permissions')->toArray()))
                                            <form action="{{ route('event.destroy',$event->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="confirm_delete();" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                            <a class="btn btn-dark btn-sm mt-2" target="_blank" href="{{ route('generate.invoice', $event->id) }}" onclick="return confirm('Do you want to Generate Invoice No.')">Generate Invoice</a>

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