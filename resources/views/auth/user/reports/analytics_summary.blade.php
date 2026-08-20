@extends('layouts.dashboard')

@section('title', 'Analytics Summary')

@section('css')

@endsection

@section('content')

    <style>
        table.dataTable,
        table.dataTable td,
        table.dataTable th {
            font-size: 12px;
            padding: 5px;
            border: 1px solid;
            text-align: center;
        }
  

    </style>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-bar-chart"></i> Analytics Summary </h1>
            </div>
        </div>

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
                        
                        ?>
                        <form action="{{ url($form_url) }}" method="GET">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Event</label>
                                    <select class="form-control" name="e_id" id="event_id" autofocus="true"
                                        onchange="get_event_schedule_by_event_id(this.value);">
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
                                    <label for="for">Source</label>
                                    <select class="form-control" name="utm_source" id="utm_source" autofocus="true" multiple>
                                        <option value="" selected>All</option>
                                        @if (isset($utm_sources))
                                            @foreach ($utm_sources as  $utm_source)
                                                <option value="{{ $utm_source->utm_source }}">{{$utm_source->utm_source}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Medium</label>
                                    <select class="form-control" name="utm_medium" id="utm_medium" autofocus="true" multiple>
                                                                                <option value="" selected>All</option>

                                        @if (isset($utm_mediums))
                                            @foreach ($utm_mediums as  $utm_medium)
                                                <option value="{{ $utm_medium->utm_medium }}">{{$utm_medium->utm_medium}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Campaign</label>
                                    <select class="form-control" name="utm_campaign" id="utm_campaign" autofocus="true" multiple>
                                                                                <option value="" selected>All</option>

                                        @if (isset($utm_campaigns))
                                            @foreach ($utm_campaigns as  $utm_campaign)
                                                <option value="{{ $utm_campaign->utm_campaign }}">{{$utm_campaign->utm_campaign}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">From</label>
                                    <input type="date" name="start_date" class="form-control" min="2022-01-01" max="2030-12-31" value="<?php echo $start_date;?>">
                                </div>
                            </div>
                            
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">To</label>
                                    <input type="date" name="end_date" class="form-control" min="2022-01-01" max="2030-12-31" value="<?php echo $end_date;?>">
                                </div>
                            </div>
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
        
        <?php
        $count = 0;
        $t_count = 0;
        $sale = 0;
        foreach($records as $value)
        {
            $sale = $value->grand_total + $sale;
            $count = $value->total_booking + $count;
            $t_count = $value->total_quantity + $t_count;
        }
        
        $sale = round($sale,2);
        $count = round($count, 2);
        $t_count = round($t_count, 2);

        ?>
        <div class="row">
                
                <div class="col-md-4">
                    <div class="tile">
                        <h3 class="tile-title">Booking Count Summary (<?php echo $count; ?>)</h3>
                        <div class="embed-responsive embed-responsive-16by9" style="height:600px;">
                             <div id="legend1" style="position: absolute; top: 20px; right: 20px; "></div>
                            <canvas class="embed-responsive-item" id="lineChartDemo1"  style="height:500px;width: content-box;"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="tile">
                        <h3 class="tile-title" style="font-size:22px">Booking Total Summary (&#8377; <?php echo $sale; ?>) </h3>
                         <div id="legend2" style="position: absolute; top: 20px; right: 20px;padding-top:50px"></div>
                            <div class="embed-responsive embed-responsive-16by9" style="height:600px;">
                            <canvas class="embed-responsive-item" id="lineChartDemo2" style="height:500px;width: content-box;"></canvas>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="col-md-4">
                    <div class="tile">
                        <h3 class="tile-title">Ticket Count Summary (<?php echo $t_count; ?>)</h3>
                        <div class="embed-responsive embed-responsive-16by9" style="height:600px;">
                             <div id="legend3" style="position: absolute; top: 20px; right: 20px;"></div>
                            <canvas class="embed-responsive-item" id="lineChartDemo3"  style="height:500px;width: content-box;"></canvas>
                        </div>
                    </div>
                </div>
                
                
                    <div class="col-md-12">
                       <div class="tile">
                            <table class="table table-hover table-bordered" id="userTable">
                                <thead>
                                    <tr>
                                          <th>SN.</th>
                                        <th>Traffic Count</th>
                                        <th>Total Business</th>
                                        <th>Total Tickets</th>
                                        <th>UTM Source</th>
                                        <th>UTM Medium</th>
                                        <th>UTM Campaign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                     @php
                                        $totalTraffic = 0;
                                        $totalBusiness = 0;
                                        $totalTickets = 0;
                                        $i=0;
                                    @endphp
                                    
                                    @foreach ($visitor_stats as $stat)
                                        <tr>
                                              <td>{{ $i++ }}</td>
                                            <td>{{ $stat->traffic_count }}</td>
                                            <td>{{ $stat->total_business }}</td>
                                            <td>{{ $stat->total_tickets }}</td>
                                            <td>{{ $stat->utm_source }}</td>
                                            <td>{{ $stat->utm_medium }}</td>
                                            <td>{{ $stat->utm_campaign }}</td>
                                        </tr>
                                        
                                         @php
                                            $totalTraffic += $stat->traffic_count;
                                            $totalBusiness += $stat->total_business;
                                            $totalTickets += $stat->total_tickets;
                                        @endphp
                                    @endforeach
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>{{ $totalTraffic }}</th>
                                         <th>{{ $totalBusiness }}</th>
                                        <th>{{ $totalTickets }}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-12">
                       <div class="tile">
                            <table class="table table-hover table-bordered" id="userTable">
                                <thead>
                                    <tr>
                                         <th>SN.</th>
                                        <th>Traffic Count</th>
                                        <th>Total Business</th>
                                        <th>Total Tickets</th>
                                        <th>UTM Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @php
                                        $totalTraffic = 0;
                                        $totalBusiness = 0;
                                        $totalTickets = 0;
                                        $i=0;
                                    @endphp
                                    @foreach ($visitor_stats2 as $stat)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $stat->traffic_count }}</td>
                                            <td>{{ $stat->total_business }}</td>
                                            <td>{{ $stat->total_tickets }}</td>
                                            <td>{{ $stat->utm_source }}</td>
                                        </tr>
                                        @php
                                            $totalTraffic += $stat->traffic_count;
                                            $totalBusiness += $stat->total_business;
                                            $totalTickets += $stat->total_tickets;
                                        @endphp
                                    @endforeach
                                </tbody>
                                
                                 <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>{{ $totalTraffic }}</th>
                                         <th>{{ $totalBusiness }}</th>
                                        <th>{{ $totalTickets }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    
                     <div class="col-md-12">
                       <div class="tile">
                            <table class="table table-hover table-bordered" id="userTable">
                                <thead>
                                    <tr>
                                        <th>SN.</th>
                                        <th>Traffic Count</th>
                                        <th>Total Business</th>
                                        <th>Total Tickets</th>
                                        <th>UTM Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @php
                                        $totalTraffic = 0;
                                        $totalBusiness = 0;
                                        $totalTickets = 0;
                                        $i=0;
                                    @endphp
        
                                    @foreach ($visitor_stats3 as $stat)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $stat->unique_traffic_count }}</td>
                                            <td>{{ $stat->total_business }}</td>
                                            <td>{{ $stat->total_tickets }}</td>
                                            <td>{{ $stat->utm_source }}</td>
                                        </tr>
                                        @php
                                            $totalTraffic += $stat->unique_traffic_count;
                                            $totalBusiness += $stat->total_business;
                                            $totalTickets += $stat->total_tickets;
                                        @endphp
                                    @endforeach
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th>{{ $totalTraffic }}</th>
                                         <th>{{ $totalBusiness }}</th>
                                        <th>{{ $totalTickets }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
    
                            </table>
                        </div>
                    </div>
            </div>





    </main>

@endsection

@section('js')

<script type="text/javascript">
  // ===== PIE CHART 1 =====
  var ldata1 = [
    <?php 
    $color_arr = [
      '#07ab25', '#36a2eb', '#ffcd56', '#e77522', '#d90000',
      '#8f4dff', '#ff5733', '#3498db', '#f39c12', '#9b59b6'
    ];
    
    if (isset($records) && count($records) > 0) {
        $k = 0;
        foreach ($records as $value) {
            // Ensure color index doesn't go out of range
            $color = $color_arr[$k % count($color_arr)];
            ?>
            {
                value: <?= $value->total_booking ?>,
                color: "<?= $color ?>",
                highlight: "<?= $color ?>",
                label: "<?= $value->utm_source ?>"
            },
            <?php
            $k++;
        }
    }
    ?>
  ];
  var ctxp1 = $("#lineChartDemo1").get(0).getContext("2d");
  var pieChart1 = new Chart(ctxp1).Doughnut(ldata1);
  var legend1 = document.getElementById("legend1");
  ldata1.forEach(function(data) {
      legend1.innerHTML += '<div><span style="display:inline-block;width:20px;height:10px;margin-right:5px;background-color:' + data.color + '"></span>' + data.label +' (' + data.value + ')</div>';
  });


  // ===== PIE CHART 2 =====
  var ldata2 = [
    <?php 
    $u = 0;
    if (isset($records) && count($records) > 0) {
        foreach ($records as $value) {
            $color = $color_arr[$u % count($color_arr)];
            ?>
            {
                value: <?= $value->grand_total ?>,
                color: "<?= $color ?>",
                highlight: "<?= $color ?>",
                label: "<?= $value->utm_source ?>"
            },
            <?php
            $u++;
        }
    }
    ?>
  ];
  var ctxp2 = $("#lineChartDemo2").get(0).getContext("2d");
  var pieChart2 = new Chart(ctxp2).Doughnut(ldata2);
  var legend2 = document.getElementById("legend2");
  ldata2.forEach(function(data) {
      legend2.innerHTML += '<div><span style="display:inline-block;width:20px;height:10px;margin-right:5px;background-color:' + data.color + '"></span>' + data.label +' (' + data.value + ')</div>';
  });


  // ===== PIE CHART 3 =====
  var ldata3 = [
    <?php 
    $color_arr2 = [
      '#e77522', '#d90000', '#8f4dff', '#ff5733', '#3498db',
      '#f39c12', '#9b59b6', '#07ab25', '#36a2eb', '#ffcd56'
    ];
    $v = 0;
    if (isset($records) && count($records) > 0) {
        foreach ($records as $value) {
            $color = $color_arr2[$v % count($color_arr2)];
            ?>
            {
                value: <?= $value->total_quantity ?>,
                color: "<?= $color ?>",
                highlight: "<?= $color ?>",
                label: "<?= $value->utm_source ?>"
            },
            <?php
            $v++;
        }
    }
    ?>
  ];
  var ctxp3 = $("#lineChartDemo3").get(0).getContext("2d");
  var pieChart3 = new Chart(ctxp3).Doughnut(ldata3);
  var legend3 = document.getElementById("legend3");
  ldata3.forEach(function(data) {
      legend3.innerHTML += '<div><span style="display:inline-block;width:20px;height:10px;margin-right:5px;background-color:' + data.color + '"></span>' + data.label +' (' + data.value + ')</div>';
  });
</script>

@endsection