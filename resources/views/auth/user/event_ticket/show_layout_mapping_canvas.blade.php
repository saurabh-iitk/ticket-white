@extends('layouts.dashboard')

@section('title', 'Seat Chart')

@section('content')
<main class="app-content py-3">
    <div class="app-title mb-3">
        <div>
            <h1><i class="fa-solid fa-map-location-dot text-primary mr-2"></i> Seat Chart</h1>
            <p class="text-muted small mb-0">Event: <strong>{{ getEvent($event_ticket->event_id)->event_title }}</strong> | Layout: <strong>{{ getLayout($event_ticket->layout_id)->layout_name }}</strong></p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_ticket.index') }}">Event Ticket</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('../../partials/message')
            
            <div class="tile p-0 border-0 shadow-sm rounded-lg overflow-hidden" style="min-height: 80vh;">
                <!-- React App Mount Node -->
                <div id="layout-designer-root"
                     data-mode="mapping"
                     data-layout-id="{{ $layout->first()->id }}"
                     data-event-ticket-id="{{ $event_ticket->id }}"
                     data-event-schedule-list-id="{{ $esd_id }}"
                     data-event-show-time-id="{{ $est_id }}"
                     data-ticket-categories="{{ json_encode($ticket_categories) }}">
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
@viteReactRefresh
@vite('resources/js/venue-designer/index.tsx')
@endsection
