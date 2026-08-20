<div class="row">
    <div class="col-md-12">
        <!-- include message -->
        @include('../../partials/message')
        <!-- include message -->
        <div class="tile">
            <div class="tile-body">
                <?php
                $events = \App\Models\Event::where('status', 'ACTIVE')
                    ->orderBy('id', 'DESC')
                    ->get();
                $venues = \App\Models\Venue::where('status', 'ACTIVE')
                    ->orderBy('id', 'DESC')
                    ->get();
                $layouts = \App\Models\Layout::where('status', 'ACTIVE')
                    ->orderBy('id', 'DESC')
                    ->get();
                $users = \App\Models\User::where('status', 'ACTIVE')
                    ->orderBy('id', 'DESC')
                    ->get();
                
                $e_id = request()->get('e_id');
                $es_id = request()->get('es_id');
                $esd_id = request()->get('esd_id');
                $est_id = request()->get('est_id');
                $venue_id = request()->get('venue_id');
                $layout_id = request()->get('layout_id');
                $u_id = request()->get('u_id');
                ?>
                <form action="{{ url($form_url) }}" method="GET">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="for">Event</label>
                            <select class="form-control" name="e_id" id="event_id" autofocus="true"
                                onchange="get_event_schedule_by_event_id(this.value);">
                                <option value="">All Event</option>
                                @if (isset($events))
                                    @foreach ($events as $key => $event)
                                        <option value="{{ $event->id }}" <?php echo $e_id != null && $e_id == $event->id ? 'selected' : ''; ?>>
                                            {{ $event->event_title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="for">Event Schedule</label>
                            <select class="form-control" name="es_id" id="event_schedule_id"
                                onchange="get_event_schedule_list_by_event_schedule_id(this.value);">
                                <option value="">All Event Schedule</option>
                                @if ($e_id != null)
                                    @foreach (getEventScheduleByEventID($e_id) as $key => $event_schedule)
                                        <option value="{{ $event_schedule->id }}" <?php echo $es_id != null && $es_id == $event_schedule->id ? 'selected' : ''; ?>>
                                            {{ $event_schedule->start_date . ' - ' . $event_schedule->end_date }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="for">Event Schedule Date</label>
                            <select class="form-control" name="esd_id" id="event_schedule_list_id" style="width:100%;">
                                <option value="">All Event Schedule Date</option>
                                @if ($es_id != null)
                                    @foreach (getEventScheduleListByEventScheduleID($es_id) as $key => $event_schedule_list)
                                        <option value="{{ $event_schedule_list->id }}" <?php echo $esd_id != null && $esd_id == $event_schedule_list->id ? 'selected' : ''; ?>>
                                            {{ $event_schedule_list->event_date }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="for">Event Show Time</label>
                            <select class="form-control" name="est_id" id="event_show_time_id" style="width:100%;">
                                <option value="">All Event Show Time</option>
                                @if ($es_id != null)
                                    @foreach (getEventShowTimeByEventScheduleID($es_id) as $key => $event_show_time)
                                        <option value="{{ $event_show_time->id }}" <?php echo $est_id != null && $est_id == $event_show_time->id ? 'selected' : ''; ?>>
                                            {{ $event_show_time->start_time . ' - ' . $event_show_time->end_time }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="for">Venue</label>
                            <select class="form-control" name="venue_id" id="venue_id">
                                <option value="">All Venue</option>
                                @if (isset($venues))
                                    @foreach ($venues as $key => $venue)
                                        <option value="{{ $venue->id }}" <?php echo $venue_id != null && $venue_id == $venue->id ? 'selected' : ''; ?>>{{ $venue->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="for">Layout</label>
                            <select class="form-control" name="layout_id" id="layout_id">
                                <option value="">All Layout</option>
                                @if (isset($layouts))
                                    @foreach ($layouts as $key => $layout)
                                        <option value="{{ $layout->id }}" <?php echo $layout_id != null && $layout_id == $layout->id ? 'selected' : ''; ?>>
                                            {{ $layout->layout_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    @if (\Auth::user()->role_id == 1)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="for">User</label>
                                <select class="form-control" name="u_id" id="user_id">
                                    <option value="">All User</option>
                                    @if (isset($users))
                                        @foreach ($users as $key => $user)
                                            <option value="{{ $user->id }}" <?php echo $u_id != null && $u_id == $user->id ? 'selected' : ''; ?>>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="u_id" value="{{ \Auth::user()->id }}">
                    @endif

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="for" style="margin-top: 42px;"></label>
                            <input type="submit" class="btn btn-primary pl-4 pr-4" value="Filter" />
                            <a href="{{ route($reset_url) }}" class="btn btn-info pl-4 pr-4"
                                style="margin-left: 5px;">Reset</a>
                        </div>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>
