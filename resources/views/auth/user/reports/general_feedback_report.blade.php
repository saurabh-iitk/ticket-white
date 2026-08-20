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
                <h1><i class="fa fa-bar-chart"></i> General Feedback Report</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- include message -->
                @include('../../partials/message')
                <!-- include message -->
                <div class="tile">
                    <div class="tile-body">
                        
                        <form action="{{ url($form_url) }}" method="GET">

                        <div class="row">
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
                         <h4 style="color:red">Note: Please Choose Start and End Date then click on Filter</h4>
                    </div>
                </div>
                   
            </div>
           
        </div>
     
        
        <div class="row">
                
               
                <div class="col-md-12">
                    <div class="tile">
                        <h3 class="tile-title">Feedback Response</h3>
                        <div class="embed-responsive embed-responsive-16by9" style="height:490px;">
                             <div id="legend1" style="position: absolute; top: 20px; right: 20px;"></div>
                            <canvas class="embed-responsive-item" id="lineChartDemo"  style="height:400px;width: content-box;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        <div class="row">
            <div class="col-md-12">
                <!-- include message -->
                @include('../../partials/message')
                <!-- include message -->
                <div class="tile">
                    <div class="tile-body">
                        
                       
                        <table class="table table-hover table-bordered" id="userTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Text</th>
                                    <th>Feedback</th>
                                      <th>Mobile No</th>
                                  
                                    <th>Browser</th>
                                    <th>Platform</th>
                                    <th>IP</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                     @foreach ($feedbacks as $key => $feedback)
                                        <tr>
                                            <td>{{$feedback->id }}</td>
                                            <td><?php echo date('D d-M-Y h:i A', strtotime($feedback->created_at)); ?></td>
                                            <td>{{$feedback->text}}</td>
                                            <td>{{$feedback->feedback}}</td>
                                            <td>{{$feedback->mobile}}</td>
                                            <td>{{$feedback->browser}}</td>
                                            <td>{{$feedback->platform}}</td>
                                            <td>{{$feedback->ip_address}}</td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
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


    <!-- Data table plugin-->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


    <script>
        $('#userTable').DataTable({
            dom: 'Blfrtip',
            "bPaginate": true,
            "bSort": true,
            buttons: [
                'excel', 'print'
            ]
        });
    </script>


<script type="text/javascript" src="{{ asset('js/plugins/chart.js') }}"></script>
<script type="text/javascript">



  var ldata = [
    <?php 
    $color_arr=['VERY_GOOD'=>'#07ab25','GOOD'=>'#36a2eb', 'AVERAGE'=>'#ffcd56', 'POOR'=>'#e77522', 'VERY_POOR'=>'#d90000'];
    $u=0;
    
    
    foreach($feedback_counts as $value)
    {
       $val=$value->feedback;
       $color= $color_arr[$val];
    ?>
        {
            value: {{$value->count}},
            color: "{{$color}}",
            highlight: "{{$color}}",
            label: "{{$value->feedback}}"
        },
    <?php
    $u++;
    }
    ?>
  ];
  
  
    var ctxp1 = $("#lineChartDemo").get(0).getContext("2d");
    var pieChart1 = new Chart(ctxp1).Doughnut(ldata);
    var legend1 = document.getElementById("legend1");
    ldata.forEach(function(data) {
        legend1.innerHTML += '<div><span style="width: 26px;height: 10px;position: absolute;margin: 5px -35px; background-color:' + data.color + '"></span>' + data.label +' (' + data.value + ')</div>';
    });
</script>
@endsection