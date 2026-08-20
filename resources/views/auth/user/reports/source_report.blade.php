@extends('layouts.dashboard')

@section('title', 'Feedback Report')

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
                <h1><i class="fa fa-bar-chart"></i> Source Report </h1>
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
         foreach($records as $value)
        {
           $val=$value->count;
            $count = $count + $val;
        }
        ?>
        <div class="row">
                
                <div class="col-md-6 d-none">
                    <div class="tile">
                        <h3 class="tile-title">Source </h3>
                         <div id="legend" style="position: absolute; top: 20px; right: 20px;"></div>
                            <div class="embed-responsive embed-responsive-16by9" style="height:490px;">
                            <canvas class="embed-responsive-item" id="pieChartDemo" style="height:400px;width: content-box;"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="tile">
                        <h3 class="tile-title">Source Response  (<?php echo $count; ?>)</h3>
                        <div class="embed-responsive embed-responsive-16by9" style="height:490px;">
                             <div id="legend1" style="position: absolute; top: 20px; right: 20px;"></div>
                            <canvas class="embed-responsive-item" id="lineChartDemo"  style="height:400px;width: content-box;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

    </main>

@endsection

@section('js')

 @php
 
<script type="text/javascript" src="{{ asset('js/plugins/chart.js') }}"></script>
<script type="text/javascript">
<?php
$color_arr = [
    'ADS.ONAUTO'     => '#07ab25',
    'ADS.ONBUS'      => '#36a2eb',
    'ADS.ONTRAIN'    => '#87a2eb',
    'FACEBOOK'       => '#ffcd56',
    'FRIENDS&FAMILY' => '#e77522',
    'GOOGLEADS'      => '#d90000',
    'HOARDINGS'      => '#8f4dff',
    'INSTAGRAM'      => '#ff5733',
    'NEWSPAPER'      => '#3498db',
    'OTHERS'         => '#f39c12',
    'YOUTUBE'        => '#9b59b6'
];

// Calculate total
$totalRecords = 0;
foreach ($records as $item) {
    $totalRecords += $item->count;
}
?>

var ldata = [
<?php
foreach ($records as $value)
{
    $color = $color_arr[$value->find_us];
    $percentage = $totalRecords > 0 ? round(($value->count * 100) / $totalRecords) : 0;
?>
    {
        value: {{$value->count}},
        color: "{{$color}}",
        highlight: "{{$color}}",
        label: "{{$value->find_us}}",
        percentage: "{{$percentage}}"
    },
<?php } ?>
];

var ctxp1 = $("#lineChartDemo").get(0).getContext("2d");
var pieChart1 = new Chart(ctxp1).Doughnut(ldata);

var legend1 = document.getElementById("legend1");
ldata.forEach(function(data) {
    legend1.innerHTML +=
        '<div><span style="width:26px;font-size:36px;height:10px;position:absolute;margin:5px -35px;background-color:' +
        data.color +
        '"></span>' +
        data.label +
        ' (' + data.value + ') - ' + data.percentage + '%</div>';
});
</script>
@endsection