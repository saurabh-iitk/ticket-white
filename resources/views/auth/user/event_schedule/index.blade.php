@extends('layouts.dashboard')

@section('title', 'Event Schedule')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-calendar"></i> Event Schedule List</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item active"><a href="{{ route('event_schedule.index') }}">Event Schedules</a></li>
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
                                <form action="event_schedule" method="GET">

                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="for">Event</label>
                                            <select class="form-control" name="id" id="event_id" autofocus="true"
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
                                            <a href="{{ URL::to('event_schedule') }}"
                                                class="btn btn-info pl-4 pr-4 pull-right"
                                                style="margin-left: 5px;">Reset</a>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 col-md-5 mt-4 pull-right">
                                        @if (in_array('event_schedule_store', Session::get('permissions')->toArray()))
                                            <a href="{{ URL::to('event_schedule/create') }}"
                                                class="btn btn-info pl-5 pr-5 pull-right ">Add</a>
                                        @endif
                                    </div>
                                </div>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>



                <!-- include message -->
                @include('../../partials/message')
                <!-- include message -->

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
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th width="180px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($event_schedules)
                                    @foreach ($event_schedules as $event_schedule)
                                        <tr>
                                            <td>
                                                @if (getEvent($event_schedule->event_id))
                                                    {{ getEvent($event_schedule->event_id)->event_title }}
                                                @endif
                                            </td>
                                            <td>{{ nice_date($event_schedule->start_date) }}</td>
                                            <td>{{ nice_date($event_schedule->end_date) }}</td>
                                            <td>{{ $event_schedule->status }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('event_schedule.show', $event_schedule->id) }}">View
                                                    Details</a>
                                                @if (in_array('event_schedule_update', Session::get('permissions')->toArray()))
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('event_schedule.edit', $event_schedule->id) }}">Edit</a>
                                                @endif
                                                @if (in_array('event_schedule_destroy', Session::get('permissions')->toArray()))
                                                    <form
                                                        action="{{ route('event_schedule.destroy', $event_schedule->id) }}"
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
