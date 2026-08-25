@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
        </ul>
    </div>

    <!-- Row 1: Primary Metrics -->
    @if(Session::has('permissions') && in_array('admin_action', Session::get('permissions')->toArray()))
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa-solid fa-indian-rupee-sign"></i>
                <div class="info">
                    <h4>Gross Sales</h4>
                    <p><b>₹{{ number_format(\App\Models\Booking::sum('paid_amount') ?? 0) }}</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon">
                <i class="icon fa-solid fa-ticket"></i>
                <div class="info">
                    <h4>Total Bookings</h4>
                    <p><b>{{ \App\Models\Booking::count() }}</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa-solid fa-calendar-check"></i>
                <div class="info">
                    <h4>Active Events</h4>
                    <p><b>{{ \App\Models\Event::where('status','ACTIVE')->count() }}</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small danger coloured-icon">
                <i class="icon fa-solid fa-hotel"></i>
                <div class="info">
                    <h4>Listed Venues</h4>
                    <p><b>{{ \App\Models\Venue::count() }}</b></p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Row 2: Secondary Metrics -->
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa-solid fa-users"></i>
                <div class="info">
                    <h4>Registered Users</h4>
                    <p><b>{{ \App\Models\User::where('status','ACTIVE')->count() }}</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon">
                <i class="icon fa-solid fa-user-tie"></i>
                <div class="info">
                    <h4>Organizers</h4>
                    <p><b>{{ \App\Models\Organizer::where('status','ACTIVE')->count() }}</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa-solid fa-tags"></i>
                <div class="info">
                    <h4>Active Coupons</h4>
                    <p><b>{{ \App\Models\Coupon::where('status','ACTIVE')->count() }}</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small danger coloured-icon">
                <i class="icon fa-solid fa-ban"></i>
                <div class="info">
                    <h4>Cancelled Bookings</h4>
                    <p><b>{{ \App\Models\CancelledBooking::count() }}</b></p>
                </div>
            </div>
        </div>
    </div>

@php
$is_admin = optional($role_data)->is_admin ?? 0;
$role_name = optional($role_data)->name ?? 'User';
$cityName = optional($city)->name ?? 'City';
@endphp

@if($is_admin == 1)

<div class="row">

    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">
                <span style="color:#2563eb">{{ ucwords(strtolower($cityName)) }}</span> Daily Show Viewers
            </h3>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="monthlySales"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">
                <span style="color:#2563eb">{{ ucwords(strtolower($cityName)) }}</span> Break-Even
            </h3>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="dailySales"></canvas>
            </div>
        </div>
    </div>

</div>

@else

<div class="row">
    <div class="col-md-12" style="text-align:center">
        <div class="tile">
            <h1>Welcome to {{ ucwords(strtolower($role_name)) }} Dashboard</h1>
        </div>
    </div>
</div>

@endif

</main>
@endsection


@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

@php

$labels = [];
$booking_count_data = [];

foreach($monthlySales ?? [] as $sales){
    $labels[] = $sales->day ?? '';
    $booking_count_data[] = round($sales->total_quantity ?? 0,2);
}

$daily_labels = [];
$daily_booking_amount_data = [];

foreach($dailySales ?? [] as $sales){
    $daily_labels[] = $sales->day ?? '';
    $daily_booking_amount_data[] = round($sales->total_paid_amount ?? 0,1);
}

/* fallback if no data */

if(empty($labels)){
    $labels = ['No Data'];
    $booking_count_data = [0];
}

if(empty($daily_labels)){
    $daily_labels = ['No Data'];
    $daily_booking_amount_data = [0];
}

@endphp


<script>
$(document).ready(function() {
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            display: true,
            position: 'top',
            labels: {
                fontColor: '#475569',
                fontFamily: "'Plus Jakarta Sans', sans-serif",
                fontSize: 12,
                boxWidth: 10,
                padding: 15
            }
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    fontColor: '#94a3b8',
                    fontFamily: "'Plus Jakarta Sans', sans-serif",
                    fontSize: 10,
                    padding: 8
                }
            }],
            yAxes: [{
                gridLines: {
                    color: '#f1f5f9',
                    zeroLineColor: '#f1f5f9',
                    drawBorder: false
                },
                ticks: {
                    beginAtZero: true,
                    fontColor: '#94a3b8',
                    fontFamily: "'Plus Jakarta Sans', sans-serif",
                    fontSize: 10,
                    padding: 8
                }
            }]
        },
        tooltips: {
            backgroundColor: '#0f172a',
            titleFontFamily: "'Plus Jakarta Sans', sans-serif",
            titleFontSize: 12,
            titleFontColor: '#ffffff',
            bodyFontFamily: "'Plus Jakarta Sans', sans-serif",
            bodyFontSize: 12,
            bodyFontColor: '#cbd5e1',
            xPadding: 12,
            yPadding: 12,
            cornerRadius: 8,
            displayColors: false
        }
    };

    // Chart 1: Bar chart with smooth gradient
    var ctx1 = document.getElementById("monthlySales").getContext("2d");
    var gradient1 = ctx1.createLinearGradient(0, 0, 0, 300);
    gradient1.addColorStop(0, 'rgba(37, 99, 235, 0.85)');
    gradient1.addColorStop(1, 'rgba(37, 99, 235, 0.15)');

    var data1 = {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            label: "Daily Viewers Count",
            data: {!! json_encode($booking_count_data) !!},
            backgroundColor: gradient1,
            borderColor: "#2563eb",
            borderWidth: 1.5,
            hoverBackgroundColor: "rgba(37, 99, 235, 0.95)"
        }]
    };

    new Chart(ctx1, {
        type: 'bar',
        data: data1,
        options: chartOptions
    });

    // Chart 2: Line & Dashed Threshold line
    var ctx2 = document.getElementById("dailySales").getContext("2d");
    var gradient2 = ctx2.createLinearGradient(0, 0, 0, 300);
    gradient2.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
    gradient2.addColorStop(1, 'rgba(37, 99, 235, 0.02)');

    var data2 = {
        labels: {!! json_encode($daily_labels) !!},
        datasets: [
            {
                label: "Daily Sales",
                fill: true,
                backgroundColor: gradient2,
                borderColor: "#2563eb",
                borderWidth: 2.5,
                pointBackgroundColor: "#ffffff",
                pointBorderColor: "#2563eb",
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: "#2563eb",
                pointHoverBorderColor: "#ffffff",
                data: {!! json_encode($daily_booking_amount_data) !!},
                tension: 0.35
            },
            {
                label: "Daily Expense",
                fill: false, // No fill under expense threshold line!
                borderColor: "#f43f5e",
                borderWidth: 2,
                borderDash: [6, 6], // Elegant dashed threshold!
                pointRadius: 0, // No points on threshold line!
                pointHoverRadius: 0,
                data: {!! json_encode(array_fill(0, count($daily_labels), 75000)) !!}
            }
        ]
    };

    new Chart(ctx2, {
        type: 'line',
        data: data2,
        options: chartOptions
    });
});</script>

@endsection