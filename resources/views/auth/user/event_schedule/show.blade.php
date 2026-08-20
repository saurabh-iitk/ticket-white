@extends('layouts.dashboard')

@section('title', 'Show/Event Schedule')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Show Event Schedule</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_schedule.index') }}">Event Schedule</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event</label>
                                <input type="text" class="form-control" value="{{ getEvent($event_schedule->event_id)->event_title }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Start Date</label>
                                <input type="text" class="form-control" value="{{ nice_date($event_schedule->start_date) }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">End Date</label>
                                <input type="text" class="form-control" value="{{ nice_date($event_schedule->end_date) }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Status</label>
                                <input type="text" class="form-control" value="{{ $event_schedule->status }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Date</label>
                                <select class="form-control" name="event_date" id="demoSelect" multiple="multiple" disabled="true">
                                    <optgroup label="Select Event Date">
                                    @foreach($event_schedule_lists as $key => $event_schedule_list)
                                    <option value="{{ $event_schedule_list->event_date}}" <?php if($event_schedule_list->event_schedule_id==$event_schedule->id){ echo 'selected';} ?>>{{ nice_date($event_schedule_list->event_date,'d-m-Y') }}</option>
                                    @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('event_schedule.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>
<script type="text/javascript">
    $('#demoSelect').select2();
</script>
@endsection