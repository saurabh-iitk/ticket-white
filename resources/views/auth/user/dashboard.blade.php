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

    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4>Users</h4>
                    <p><b>{{ \App\Models\User::where('status','ACTIVE')->count() }}</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon">
                <i class="icon fa fa-thumbs-o-up fa-3x"></i>
                <div class="info">
                    <h4>Organizers</h4>
                    <p><b>{{ \App\Models\Organizer::where('status','ACTIVE')->count() }}</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <h4>Events</h4>
                    <p><b>{{ \App\Models\Event::where('status','ACTIVE')->count() }}</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-small danger coloured-icon">
                <i class="icon fa fa-star fa-3x"></i>
                <div class="info">
                    <h4>Event Tickets</h4>
                    <p><b>{{ \App\Models\EventTicket::where('status','ACTIVE')->count() }}</b></p>
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
                <span style="color:#17a2b8">{{ ucwords(strtolower($cityName)) }}</span> Daily Show Viewers
            </h3>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="monthlySales"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">
                <span style="color:#17a2b8">{{ ucwords(strtolower($cityName)) }}</span> Break-Even
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

var data = {
    labels: {!! json_encode($labels) !!},
    datasets: [{
        label: "Daily Viewers Count",
        data: {!! json_encode($booking_count_data) !!},
        backgroundColor: "#b2ede7",
        borderColor: "#009688",
        borderWidth: 2
    }]
};

var ctx1 = document.getElementById("monthlySales").getContext("2d");

new Chart(ctx1,{
    type:'bar',
    data:data,
    options:{
        scales:{
            yAxes:[{
                ticks:{
                    beginAtZero:true
                }
            }]
        }
    }
});


var data2 = {
    labels: {!! json_encode($daily_labels) !!},
    datasets:[
        {
            label:"Daily Sales",
            fill:false,
            borderColor:"#17a2b8",
            borderWidth:2,
            data:{!! json_encode($daily_booking_amount_data) !!},
            tension:0.5
        },
        {
            label:"Daily Expense",
            fill:false,
            borderColor:"#dc3545",
            borderWidth:2,
            data:{!! json_encode(array_fill(0,count($daily_labels),75000)) !!},
            tension:1
        }
    ]
};

var ctx2 = document.getElementById("dailySales").getContext("2d");

new Chart(ctx2,{
    type:'line',
    data:data2,
    options:{
        scales:{
            yAxes:[{
                ticks:{
                    beginAtZero:true
                }
            }]
        }
    }
});

</script>

@endsection