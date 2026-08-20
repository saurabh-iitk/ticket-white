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
input[type="radio"], input[type="checkbox"]
{
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0;
    transform: scale(2.3);
    margin-right: 10px;
    margin-left: 25px;
}



tr:hover {
background-color: #edf1f4;
}


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
        height:46px;
        float: left;
        empty-cells: show;
        margin-left: 30px;
        margin-top: 5px;
    }
    #venue .rows td { 
 		text-align: center;
        line-height:44px;
        background: #ccffe2;
    }
     .seat_row1{
      width: 15px !important;
      height: 15px !important;
       margin-top:0px !important;
       margin-bottom:0px !important;
            }


    .legends td.seatAvailable, .UnDamagedSeat    {     border: 2px solid #aeabab;
    color: #5f5b5b;}
    .legends td { font-weight: 400; text-align: center; font-size: 18px;}
    .legends td.DamagedSeat  { border: 2px solid #5f5b5b; color: #5f5b5b; background: #ebebeb; }
    .legends td.noSeatStorage    { background-color: #0085c1; color: white; border: 2px solid #064967}
    .seat_row td { min-width: 38px; height: 46px; border: solid 1px #666; border-radius: 7px 7px 0px 0px; text-align: center; cursor: pointer; }
    .seat_row td.row              { background-color: transparent; border: none; font-weight: bold; padding-right: 7px; }
    .seat_row td.seatAvailable, .UnDamagedSeat    {     border: 2px solid #aeabab;
    color: #5f5b5b;}

    .seat_row td.seatUnavailable  { border: 2px solid black;color: black;background: #ebebeb; }

    .seat_row td.DamagedSeat  { border: 2px solid #5f5b5b; color: #5f5b5b; background: #ebebeb; }
    .seat_row td.ExtraPay         { border:1px solid navy; color: navy  }
    .seat_row td.LargeSeat        { /*width: 23px; */}
    .seat_row td.noSeatGalley     { background-color: transparent; border: none; width: 10px; height: 10px;  }
    .seat_row td.noSeatStorage    { background-color: #0085c1; color: white;}
    .seat_row td.noSeatLavatory   { background-color: #aaa; }
    .seat_row tr:first-child td   { height: 20px; border: none; border-radius: 0; }


    .hiddenCheckbox input {
        opacity: 0;
        /*width: 33px;*/
        transform: scale(2.7);
        height: 14px;
    }
    
    .hiddenSeat {
        color: #e1a6a6;
        border: 2px solid #e1a6a6 !important;
        background: #fcefef;
    }
    
    .removedSeat, .RemovedSeat {

        border: 2px dashed #000000 !important;
        background: #ffffff;
    }

    .LabeledSeat
    {
        border: 2px solid #000000 !important;
        background: greenyellow;
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
                        <form action="{{ url('layout/' . $layout->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Venue <span class="required">*</span></label>
                                    <select class="form-control" name="venue_id" id="venue_id" autofocus="true" onchange="get_sub_venue_by_venue_id(this.value);">
                                        <option value="">Select Venue</option>
                                        @foreach($venues as $key => $venue)
                                        <option value="{{$venue->id}}" <?php if($venue->id==$layout->venue_id){ echo 'selected';} ?>>{{$venue->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Sub Venue <span class="required">*</span></label>
                                    <select class="form-control" name="sub_venue_id" id="sub_venue_id">
                                        <option value="">Select Sub Venue</option>
                                        @foreach(getSubVenueByVenueID($layout->venue_id) as $key => $sub_venue)
                                        <option value="{{$sub_venue->id}}" <?php if($layout->sub_venue_id==$sub_venue->id){ echo 'selected';} ?>>{{$sub_venue->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">Layout Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="layout_name" id="layout_name" placeholder="Layout Name" value="{{ $layout->layout_name }}"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">Default Layout <span class="required"></span></label>
                                    <input type="checkbox" value="YES" name="default_layout" <?php if($layout->default_layout == 'YES'){ echo 'checked' ; } ?> id="" style="width:20%"/>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for" class="mt-40"></label>
                                    <input type="submit" class="btn btn-primary pl-4 pr-4" value="Continue"  />
                                </div>
                            </div>
                        </div>
                        </form>

                        <form action="{{ url('layout/create_seat/' . $layout->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">Rows <span class="required">*</span></label>
                                    <input type="number" class="form-control" name="rows" id="rows" placeholder="Rows"/>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">Columns <span class="required">*</span></label>
                                    <input type="number" class="form-control" name="cols" id="cols" placeholder="Columns"/>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for">Label Columns <span class="required">*</span></label>
                                    <input type="number" class="form-control" name="label_cols" id="label_cols" placeholder="Label Columns" value="2"/>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="for" class="mt-40"></label>
                                    <input type="submit" class="btn btn-primary pl-4 pr-4" value="Create Seat" />
                                </div>
                            </div>
                        
                        </div>
                        </form>

                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-2" style="margin-top:-55px;margin-left:-40px;">
                                <div class="form-group">
                                    <label for="for"></label>
                                    <form action="{{ route('layout.destroy',$layout->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="confirm_delete();" class="btn btn-danger">Delete All Seat</button>
                                    </form>
                                
                                </div>
                            </div>
                        </div>

                        @if(\App\Models\LayoutDetail::where('layout_id',$layout->id)->count() > 0)
                        
                        <hr>


                        <div class="col-md-12">
                            <table class="legends " style="width: 100%">
                                <tr>
                                    <td>Legends</td>
                                    <td class="hiddenSeat">Hidden Seat</td>
                                    <td class="UnDamagedSeat">Available Seat</td>
                                    <td class="DamagedSeat" >Damaged Seat</td>
                                    <td class="noSeatStorage">Selected Seat</td>
                                    <td class="RemovedSeat">Removed Seat</td>
                                    <td class="LabeledSeat">Labeled Seat</td>
                                </tr>
                            </table>
                        </div>
                        <hr>


                        <div class="row">
                            <div class="col-md-12" id="sidebar">
                                <input type="radio"  id="show" name="hide_show" value="ON"> Show &nbsp;&nbsp;
                                <input type="radio"  id="hide" name="hide_show" value="OFF"> Hide &nbsp;&nbsp;
                                <input type="radio"  id="damaged" name="hide_show" value="DAMAGED"> Damaged &nbsp;&nbsp;
                                <input type="radio"  id="undamaged" name="hide_show" value="UNDAMAGED"> UnDamaged &nbsp;&nbsp;
                                <input type="radio"  id="removed" name="hide_show" value="REMOVED"> Removed &nbsp;&nbsp;
                                <input type="radio"  id="unremoved" name="hide_show" value="UNREMOVED"> UnRemoved &nbsp;&nbsp;
                                <input type="radio"  id="labeled" name="hide_show" value="LABELED"> Labeled &nbsp;&nbsp;
                                <input type="radio"  id="unlabeled" name="hide_show" value="UNLABELED"> UnLabeled &nbsp;&nbsp;
                                <input type="button" name="action" id="action" class="btn btn-sm btn-success" value="Save Action" onclick="save_action()">
                              <a href="{{route('layout.seat_name_regenerate',$layout->id)}}" class="btn btn-sm btn-success" target="_blank">Seat Rename & Stage</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                $layout_data=getLayout($layout->id);
                                
                                if($layout_data->stage_direction=='UP'){?>
                                <table>
                                    <tr>
                                        <td style="background-color:#242424; text-align:center;color:White;width: 100%; text-transform:uppercase;">ALL EYES THIS WAY PLEASE<td></tr>
                                </table>
                                <?PHP } ?>
                            </div>

                            <div class="col-md-12" id="main_area">
                                <?php
                                  $char = 'A';
                                  $alphas = array_merge(range('A', 'Z'),range('a', 'z'));
                                  $seat_arr =array();
                                  $layout_data_new= \App\Models\LayoutDetail::where('layout_id', $layout->id)->get();
                                  foreach($layout_data_new as $single)
                                  {
                                      $seat_arr[$single->id] = $single->toArray();
                                  }

                                  $data =  \App\Models\LayoutDetail::where('layout_id',$layout->id)
                                  ->selectRaw('max(row_no) as row_no, max(col_no) as col_no')
                                  ->first();
                                  $row_no = $data->row_no;
                                  $col_no = $data->col_no;
                                ?>
                                <div id="seatmap">
                               
                                    <div id="venue">
                                        <table class="rows">
                                           <?php                                        
                                           
                                          	$layout_row_label=explode(',', $layout_data->layout_row_label);
                                            for($i=0; $i<count($layout_row_label); $i++)
                                            {
                                              	if(isset($layout_row_label[$i]))
                                                {
                                                // echo "<tr><td>".$layout_row_label[$i]."</td></tr>";
                                                }  
                                            }
                                            ?>
                                        </table>

                                        <div class="seat_row overflow-auto">
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
                                                        //echo "<td class='noSeatGalley'>".$i."</td>";
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
                                                        $seat_id=find_seat_id($layout->id, $i, $j);
                                                        $seat_name=$seat_arr[$seat_id]['name'];
                                                        $label_name=$seat_arr[$seat_id]['label'];
                                                        $is_visible = isset($seat_arr[$seat_id]) ? ($seat_arr[$seat_id]['is_visible'] === 'YES') : false;
                                                        $ij_removed = isset($seat_arr[$seat_id]) ? ($seat_arr[$seat_id]['is_removed'] === 'YES') : false;
                                                        $ij_labeled = isset($seat_arr[$seat_id]) ? ($seat_arr[$seat_id]['is_labeled'] === 'YES') : false;
                                                        $ij_damaged = isset($seat_arr[$seat_id]) ? ($seat_arr[$seat_id]['is_damaged'] === 'YES') : false;

                                                        if($ij_labeled)
                                                        {
                                                            $seat_name='<div style="margin-top: -18px; text-align: center; font-weight: 400;font-size:17px;">'.$label_name.'</div>';
                                                        }
                                                        else
                                                        {
                                                            $seat_name='<div style="margin-top: -18px; text-align: center; font-weight: 400;font-size:17px;">'.$seat_name.'</div>';
                                                        }
                                                    

                                                        if($ij_removed)
                                                        {
                                                            echo "<td title=".$seat_id." class='hiddenCheckbox removedSeat'><input type='checkbox' value=".$seat_id."></td>";
                                                        }
                                                        else
                                                        {
                                                            if($is_visible)
                                                            {
                                                                if($ij_damaged)
                                                                {
                                                                    echo "<td title=".$seat_id." class='DamagedSeat hiddenCheckbox'><input type='checkbox' value=".$seat_id.">".$seat_name."</td>";
                                                                }
                                                                elseif($ij_labeled)
                                                                {
                                                                    echo "<td title=".$seat_id." class='LabeledSeat hiddenCheckbox'><input type='checkbox'  name=".$seat_id." value=".$seat_id.">".$seat_name."</td>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<td title=".$seat_id." class='seatAvailable hiddenCheckbox'><input type='checkbox'  name=".$seat_id." value=".$seat_id.">".$seat_name."</td>";

                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "<td title=".$seat_id." class='hiddenCheckbox hiddenSeat'><input type='checkbox' value=".$seat_id."></td>";
                                                            }
                                                        }
                                                    }
                                                    echo "</tr>";

                                                    $char++;
                                                }
                                                ?>
                                            </table>


<?php 
if($layout_data->stage_direction=='DOWN'){?>
    <div class="col-md-12">
 <table>
    <tr>
        <td style="background-color:#242424; text-align:center;color:White;width: 100%; text-transform:uppercase;">ALL EYES THIS WAY PLEASE<td></tr>
</table>
</div>
<?PHP } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>  

                        @endif
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
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/confirm_delete.js') }}"></script>

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
        if(hide_show=='DAMAGED')
        {
            var action='damaged';
        }
        if(hide_show=='UNDAMAGED')
        {
            var action='undamaged';
        }
        
        if(hide_show=='REMOVED')
        {
            var action='removed';
        }
        
        if(hide_show=='UNREMOVED')
        {
            var action='unremoved';
        }

        if(hide_show=='LABELED')
        {
            var action='labeled';
        }
        
        if(hide_show=='UNLABELED')
        {
            var action='unlabeled';
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