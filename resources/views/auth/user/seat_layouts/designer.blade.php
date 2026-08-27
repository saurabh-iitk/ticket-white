@extends('layouts.dashboard')

@section('title', 'Venue Layout Designer')

@section('content')
<main class="app-content py-3">
    <div class="app-title mb-3">
        <div>
            <h1><i class="fa-solid fa-map-location-dot text-primary mr-2"></i> Interactive Venue Seating Designer</h1>
            <p class="text-muted small mb-0">Venue: <strong>{{ $venue->name }}</strong> | Layout: <strong>{{ $layout->layout_name }}</strong></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('../../partials/message')
            
            <div class="tile p-0 border-0 shadow-sm rounded-lg overflow-hidden" style="min-height: 80vh;">
                <!-- React App Mount Node -->
                <div id="layout-designer-root" data-layout-id="{{ $layout->id }}"></div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
@viteReactRefresh
@vite('resources/js/venue-designer/index.tsx')
@endsection
