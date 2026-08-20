@extends('layouts.dashboard')

@section('title', 'Event Show Time')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-circle-os"></i> Event Show Time List</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item active"><a href="{{ route('event_show_time.index') }}">Event Show Times</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <!-- include message -->
                        @include('../../partials/message')
                        <!-- include message -->
                        <div class="tile">
                            <div class="tile-body">
                                <form action="{{ route('event_show_time.index') }}" method="GET" >

                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="for">Event</label>
                                            <select class="form-control" name="e_id" id="event_id" autofocus="true"
                                                style="width:300px">
                                                @if (isset($events))
                                                    @foreach ($events as $key => $event)
                                                        <option value="{{ $event->id }}" <?php echo $e_id != null && $e_id == $event->id ? 'selected' : ''; ?>>
                                                            {{ $event->event_title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-3  col-md-2  mt-4 pull-right">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary pl-4 pr-4 pull-right"
                                                value="Filter" />
                                        </div>
                                    </div>


                                    <div class="col-sm-3  col-md-2  mt-4 pull-right">
                                        <div class="form-group">
                                            <a href="{{ URL::to('event_show_time') }}"
                                                class="btn btn-info pl-4 pr-4 pull-right"
                                                style="margin-left: 5px;">Reset</a>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-md-5 mt-4 pull-right">
                                        @if (in_array('event_show_time_store', Session::get('permissions')->toArray()))
                                            <div class="row">
                                                <div class="col-md-12 pb-4 text-right">
                                                    <a href="{{ URL::to('event_show_time/create') }}"
                                                        class="btn btn-info pl-5 pr-5">Add</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>


                <div class="tile">
                    <div class="tile-body">
                        <?php 
                        if(isset($e_id) && $e_id!=null)
                        {
                        ?>
                        <table class="table table-hover table-bordered" id="userTable">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <!-- <th>Event Schedule</th> -->
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Status</th>
                                    <th>Online Booking</th>
                                    <th width="180px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($event_show_times)
                                    @foreach ($event_show_times as $event_show_time)
                                        <tr>
                                            <td>
                                                @if (getEvent($event_show_time->event_id))
                                                    {{ getEvent($event_show_time->event_id)->event_title }}
                                                @endif
                                            </td>
                                            <!-- <td>
                                                                              @if (getEventSchedule($event_show_time->event_schedule_id))
    {{ getEventSchedule($event_show_time->event_schedule_id)->start_date . ' - ' . getEventSchedule($event_show_time->event_schedule_id)->end_date }}
    @endif
                                                                                     </td> -->
                                            <td>{{ $event_show_time->start_time }}</td>
                                            <td>{{ $event_show_time->end_time }}</td>
                                            <td>{{ $event_show_time->status }}</td>
                                            <td>{{ $event_show_time->allow_online_booking }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('event_show_time.show', $event_show_time->id) }}">View
                                                    Details</a>
                                                @if (in_array('event_show_time_update', Session::get('permissions')->toArray()))
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('event_show_time.edit', $event_show_time->id) }}">Edit</a>
                                                @endif
                                                @if (in_array('event_show_time_destroy', Session::get('permissions')->toArray()))
                                                    <form
                                                        action="{{ route('event_show_time.destroy', $event_show_time->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="confirm_delete();"
                                                            class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <?php 
                        }
                        ?>
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
                'targets': [1],
                'orderable': false
            }]
        });
    </script>
@endsection
