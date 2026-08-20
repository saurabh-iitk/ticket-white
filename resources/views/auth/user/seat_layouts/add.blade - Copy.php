@extends('layouts.dashboard')

@section('title', 'Add/Layout')

@section('css')
<!-- <link href="{{ asset('css/bootstrap-responsive.css') }}" rel="stylesheet"> -->
<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="ico/favicon.png">
<style>
    .wingRowTop {
        border-collapse: collapse;
        border-spacing: 0px;
        position:absolute;
        margin-top:-37px;

    }
    .wingRowBottom {
        position:absolute;
        border-collapse: collapse;
        border-spacing: 0px;
    }
    #seatmap { 
        position: relative; 
    }
    #seatmap table {
        border-collapse: separate;
        border-spacing: 3px;
    }


    #venue {
        /*width: 800px;*/
        height: auto;
        background: #fff;
        z-index: 1;
    }
    #venue .rows {
        width: 30px;
        float: left;  
        empty-cells: show;
        margin-left: 30px;
        margin-top: 30px;
    }
    #venue .rows td { 
        height: 30px; 
        text-align: right;
    }


    .seat_row td { width: 15px; height: 15px; border: solid 1px #666; border-radius: 7px 7px 0px 0px; text-align: center; cursor: pointer; }
    .seat_row td.row              { background-color: transparent; border: none; font-weight: bold; padding-right: 7px; }
    .seat_row td.seatAvailable    { background-color: #01B213; color: #fff; }
    .seat_row td.seatUnavailable  { background-color: #aaa;  color: #ddd  }
    .seat_row td.ExtraPay         { background-color: navy; color: #fff  }
    .seat_row td.LargeSeat        { /*width: 23px; */}
    .seat_row td.noSeatGalley     { background-color: transparent; border: none; width: 10px; height: 10px;  }
    .seat_row td.noSeatStorage    { background-color: #0085c1; }
    .seat_row td.noSeatLavatory   { background-color: #aaa; }
    .seat_row tr:first-child td { height: 30px; border: none; border-radius: 0; }


    .hiddenCheckbox input {
        opacity: 0;
    }
    .mt-40{
        margin-top: 40px;
    }

</style>
@endsection

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Add Layout</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('layout.index') }}">Layouts</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('layout') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Venue</label>
                                    <select class="form-control" name="venue_id" id="venue_id" autofocus="true" onchange="get_sub_venue_by_venue_id(this.value);">
                                        <option value="">Select Venue</option>
                                        @foreach($venues as $key => $venue)
                                        <option value="{{$venue->id}}">{{$venue->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Sub Venue</label>
                                    <select class="form-control" name="sub_venue_id" id="sub_venue_id">
                                        <option value="">Select Sub Venue</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for" class="mt-40"></label>
                                    <input type="submit" class="btn btn-primary pl-4 pr-4" value="Continue" />
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Rows</label>
                                    <input type="text" class="form-control" name="rows" id="rows" placeholder="Rows"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Cols</label>
                                    <input type="text" class="form-control" name="cols" id="cols" placeholder="Cols"/>
                                </div>
                            </div>

                        </div>
                        
                        <hr>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9" id="sidebar">
                                <input type="radio"  id="show" name="hide_show" value="ON"> Show &nbsp;&nbsp;
                                <input type="radio"  id="hide" name="hide_show" value="OFF"> Hide &nbsp;&nbsp;
                                <input type="radio"  id="reserve" name="hide_show" value="RESERVE"> Reserve &nbsp;&nbsp;
                                <input type="radio"  id="unreserve" name="hide_show" value="UNRESERVE"> UnReserve &nbsp;&nbsp;
                                <!--   <input type="checkbox" name="select_row" id="select_row"> Select Row &nbsp;&nbsp;
                                <input type="checkbox" name="select_colum" id="select_colum"> Select Column &nbsp;&nbsp; -->
                                <input type="button" name="action" id="action" class="btn btn-sm btn-success" value="Save Action" onclick="save_action()">

                            </div>
                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-3">
                                <table class="seat_row" style="width: 200px">
                                <tr>
                                <td>Legends</td>
                                </tr>
                                <tr>
                                <td class=''>Hidden Seat</td>
                                </tr>
                                <tr>
                                <td class='seatAvailable'>Available Seat</td>
                                </tr>
                                <tr>
                                <td class="seatUnavailable" style="color: white">Reserved Seat</td>
                                </tr>
                                <tr>
                                <td class="noSeatStorage" style="color: white">Selected Seat</td>
                                </tr>
                                </table>
                                <span><b>Note:</b> Hidden Seat will not be <br> clickable and visible to Customer</span>
                            </div>

                            <div class="col-md-9" id="main_area">
                                <?php
                                    $alphas = range('A', 'Z');

                                    $data = DB::table('layouts')
                                    ->selectRaw('max(row_no) as row_no, max(col_no) as col_no')
                                    ->first();
                                    $row_no = $data->row_no;
                                    $col_no = $data->col_no;
                                ?>
                                <div id="seatmap">
                                    <div id="venue">
                                        <table class="rows">
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <?php 
                                            for($i=0; $i<$row_no; $i++)
                                            {
                                                echo "<tr><td>".$alphas[$i]."</td></tr>";
                                            }
                                            ?>
                                        </table>

                                        <div class="seat_row">
                                            <table>
                                                <!-- Making blank space for labels -->
                                                <tr class="wingRowTop">
                                                    <?php 
                                                    for($i=1; $i<$row_no; $i++)
                                                    {
                                                        echo "<td></td>";
                                                    }
                                                    ?>
                                                </tr>

                                                <tr>
                                                    <!-- Making Labels for seat -->
                                                    <?php 
                                                    for($i=1; $i<=$col_no; $i++)
                                                    {
                                                        echo "<td class='noSeatGalley'>".$i."</td>";
                                                    }
                                                    ?>
                                                </tr>

                                                <!-- creating seat row and column here  -->
                                                <?php 
                                                for($i=1; $i<=$row_no; $i++)
                                                {
                                                    echo "<tr>";
                                                    for($j=1; $j<=$col_no; $j++)
                                                    {
                                                        $seat_id=find_seat_id($i, $j);

                                                        $ij_visibility=check_seat_visibility($seat_id);

                                                        if(!empty($ij_visibility))
                                                        {
                                                            $ij_reserved=check_seat_reserved($seat_id);

                                                            // finding seat id by passing i and j here

                                                            if(!$ij_reserved)
                                                            {
                                                                echo "<td title=".$seat_id." class='seatAvailable hiddenCheckbox'><input type='checkbox' value=".$seat_id."></td>";
                                                            }
                                                            else
                                                            {
                                                                echo "<td title=".$seat_id." class='seatUnavailable hiddenCheckbox'><input type='checkbox' value=".$seat_id." ></td>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "<td title=".$seat_id." class='hiddenCheckbox' ><input type='checkbox' value=".$seat_id."></td>";
                                                        }
                                                    }
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>  

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('layout.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="{{ asset('js/plugins/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/preview.js') }}"></script>

<script>
    //get sub venue by venue id
    function get_sub_venue_by_venue_id(venue_id)
    {
        if(venue_id!='' && venue_id>0)
        {
            var data = {_token:'{{ csrf_token() }}', venue_id:venue_id};

            $.ajax({
                type : 'POST',
                url : '{{ route('sub_venues.get_sub_venue_by_venue_id') }}',
                data: data,
                dataType : 'json',
                success:function(response)
                {
                    $('#sub_venue_id').empty();
                    $('#sub_venue_id').append('<option value="">Select Sub Venue</option>');
                    $.each(response, function(key,value){
                        $('#sub_venue_id').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }
        else
        {
            $('#sub_venue_id').empty();
            $('#sub_venue_id').append('<option value="">Select Sub Venue</option>');
        }
    }

    function save_action() {

        var hide_show=$('input[name="hide_show"]:checked').val();
        if(hide_show=='ON')
        {
            var action='hide';
        }
        if(hide_show=='OFF')
        {
            var action='show';
        }
        if(hide_show=='RESERVE')
        {
            var action='reserve';
        }
        if(hide_show=='UNRESERVE')
        {
            var action='unreserve';
        }

        var seat = [];
        $("input:checkbox[class=noSeatStorage]:checked").each(function () {
            var seat_id=$(this).val();
            seat.push(seat_id);
        });

        var data = {_token:'{{ csrf_token() }}', action:action, ids: seat};
        $.ajax({
            url: '{{ route('layouts.update_layout') }}',
            type: 'POST',
            data: data,
            success: function(data) {
                window.location.reload();
            }
        });
    }

    $('input[type=checkbox]').change(function() {
        var id = $(this).val(); // this gives me null
        var check_status=$(this).is(':checked');

        if (id != null && check_status==true) {
            $(this).parent().addClass('noSeatStorage');
            $(this).addClass('noSeatStorage');
            // alert(id);
        }
        else
        {
            $(this).removeClass('noSeatStorage');
            $(this).parent().removeClass('noSeatStorage');
        }
    });
</script>
@endsection