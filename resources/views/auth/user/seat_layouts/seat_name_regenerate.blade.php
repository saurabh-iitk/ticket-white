@extends('layouts.dashboard')

@section('title', 'Seat Rename and Stage Setup')

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
    margin-left: 10px;
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
        float: left;
        empty-cells: show;
        margin-left: 30px;
        margin-top: 5px;
    }
    #venue .rows td { 
        text-align: center;
        line-height: 50px;
        background: #ccffe2;
    }

      #venue table td input{ 
        border: none;
        text-align: center;
    }

     .seat_row1{
     width: 15px !important;
    height: 44px !important;
       margin-top:0px !important;
       margin-bottom:0px !important;
            }


    .seat_row td { width: 15px; height:52px; border: solid 1px #666; border-radius: 7px 7px 0px 0px; text-align: center; cursor: pointer; }
    .seat_row td.row              { background-color: transparent; border: none; font-weight: bold; padding-right: 7px; }
    .seat_row td.seatAvailable    { background-color: #01B213; color: #fff; }
    .seat_row td.seatUnavailable  { background-color: #aaa;  color: #ddd  }
    .seat_row td.ExtraPay         { background-color: navy; color: #fff  }
    .seat_row td.LargeSeat        { /*width: 23px; */}
    .seat_row td.noSeatGalley     { background-color: transparent; border: none; width: 10px; height: 10px;  }
    .seat_row td.noSeatStorage    { background-color: #0085c1; }
    .seat_row td.noSeatLavatory   { background-color: #aaa; }
    .seat_row tr:first-child td { height: 20px; border: none; border-radius: 0; }


    .hiddenCheckbox input {
        opacity: 0;
    }
    .hiddenSeat {
        color:#fff;
        background-color: #ff0000;
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

    .LabeledSeat input
    {
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
            <h1><i class="fa fa-pie-chart"></i>Seat Rename and Stage Setup</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('layout.index') }}">Seat Rename and Stage Setup</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                        @if(\App\Models\LayoutDetail::where('layout_id',$layout->id)->count() > 0) 

                   <?php $layout_data=getLayout($layout->id); ?>
                    <div id="success" class="text-success"></div>
                        <hr>
                        <div class="row"> 
                          
                            <div class="col-md-12" id="main_area">
                              <div class="col-md-6">

                                <input type="checkbox" id="autofill_seat_no"> Autofill Seat Number Increase

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" id="autofill_seat_no_right"> Autofill Seat Number Decrese
                                <br><Br>

                                Screen / Stage : &nbsp;&nbsp;
                                <input type="radio" name="screen" value="UP" onchange="update_screen(this.value, <?php echo $layout->id; ?>)" <?php if($layout_data->stage_direction=='UP') {echo 'checked';}?>>  Up &nbsp;&nbsp;
                                <input type="radio" name="screen" value="DOWN" onchange="update_screen(this.value, <?php echo $layout->id; ?>)" <?php if($layout_data->stage_direction=='DOWN') {echo 'checked';}?>> Down


                                <br><Br>
                                
                                  <form action="{{ url('layout/layout_row_label/' . $layout->id) }}" method="POST" enctype="multipart/form-data" STYLE="display:none">
                                <div>
                                  <lable class="col-row">Row Label</lable>
                          		  <input type="text" name="layout_row_label"  placeholder="Example A,B,C..." class="form-control" value="<?php echo $layout_data->layout_row_label; ?>">
                                    <lable class="col-row">Skip Label</lable>
                                  <input type="text" name="layout_skip_label"  placeholder="Example A,B,C..." class="form-control" value="<?php echo $layout_data->layout_skip_label; ?>">
                                    <bR>
                                  <input type="submit"   class="btn btn-primary btn-sm input-inline" value="Submit"  /><bR>
                                  </div>
                                  </form>
                              </div>
                                <?php
                                    $char = 'A';
                                    $alphas = array_merge(range('A', 'Z'),range('a', 'z'));

                                    $data = DB::table('layout_details')
                                    ->where('layout_id',$layout->id)
                                    ->selectRaw('max(row_no) as row_no, max(col_no) as col_no')
                                    ->first();
                                    $row_no = $data->row_no;
                                    $col_no = $data->col_no;
                                ?>
                                <div id="seatmap">
                               
                                    <div id="venue">
                                        <?php 
                                            if($layout_data->stage_direction=='UP'){?>
                                             <table>
                                                <tr>
                                                    <td style="background-color:#242424; text-align:center;color:White;width: 100%; text-transform:uppercase;">ALL EYES THIS WAY PLEASE<td></tr>
                                            </table>
                                            <?PHP } ?>


                                        <table class="rows">
                                        
                                            <?php                                        
                                            $layout_data=getLayout($layout->id);
                                          	$layout_row_label=explode(',', $layout_data->layout_row_label);
                                            for($i=0; $i<count($layout_row_label); $i++)
                                            {
                                              	if(isset($layout_row_label[$i]))
                                                {
                                                // echo "<tr><td>".$layout_row_label[$i]."</td></tr>";
                                                }  
                                            }

                                            $seat_arr =array();
                                            $layout_data_new= \App\Models\LayoutDetail::where('layout_id', $layout->id)->get();
                                            foreach($layout_data_new as $single)
                                            {
                                                $seat_arr[$single->id] = $single->toArray();
                                            }

                                            
                                            ?>
                                        </table>

                                        <div class="seat_row overflow-auto">
                                            <table id="main_table">
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
                                                        $seat_details=fetch_layout_seat_no($seat_id);
                                                        $seat_name = $seat_arr[$seat_id]['name'];
                                                        $label = $seat_arr[$seat_id]['label'];
                                                        $is_visible = isset($seat_arr[$seat_id]) ? ($seat_arr[$seat_id]['is_visible'] === 'YES') : false;
                                                        $ij_removed = isset($seat_arr[$seat_id]) ? ($seat_arr[$seat_id]['is_removed'] === 'YES') : false;
                                                        $ij_labeled = isset($seat_arr[$seat_id]) ? ($seat_arr[$seat_id]['is_labeled'] === 'YES') : false;
                                                        $ij_damaged = isset($seat_arr[$seat_id]) ? ($seat_arr[$seat_id]['is_damaged'] === 'YES') : false;
                                                        if($ij_labeled)
                                                        {
                                                            $ij_labeled_class = 'LabeledSeat';
                                                        }
                                                        else
                                                        {
                                                            $ij_labeled_class = '';
                                                        }

                                                        if($is_visible)
                                                        {
                                                            if($ij_labeled)
                                                            {
                                                                echo "<td title=".$seat_id." class='".$ij_labeled_class."'>
                                                                <input type='text' onchange='seat_rename(this.value, this.name)' style='width:32px'  name=".$seat_id." value=".$label.">
                                                                </td>";
                                                            }
                                                            else
                                                            {
                                                                echo "<td title=".$seat_id." class='".$ij_labeled_class."'>
                                                                <span>".$label."</span>
                                                                <input type='text' onchange='seat_rename(this.value, this.name)' style='width:32px'  name=".$seat_id." value=".$seat_name.">
                                                                </td>";
                                                            }
                                                            
                                                        }
                                                        else
                                                        {
                                                            echo "<td title=".$seat_id." class='hidden_seat' style='visibility:hidden'>
                                                            <input type='text' onchange='seat_rename(this.value, this.name)' disabled='disabled'  style='width:32px; visibility:hidden'  name=".$seat_id." value=".$seat_name.">
                                                            </td>";
                                                        }
                                                    }
                                                    echo "</tr>";
                                                    $char++;
                                                }
                                                ?>
                                            </table> 

                                            <?php 
                                            if($layout_data->stage_direction=='DOWN'){?>
                                             <table>
                                      			<tr>
                                        			<td style="background-color:#242424; text-align:center;color:White;width: 100%; text-transform:uppercase;">ALL EYES THIS WAY PLEASE<td></tr>
                                      		</table>
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
  
  function seat_rename(seat_name,seat_id) {
    //alert(seat_id);
    var id = seat_id;
    var name = seat_name;
    var data = {_token:'{{ csrf_token() }}', id:id, name: name};
     $.ajax({
            url: '{{ route('layouts.update_seat_name') }}',
            type: 'POST',
            data: data,
            success: function(data) {
              //console.log(data);
         $('#success').html('Seat Name Rename Successfully');
       
            }
        });
  }


    
        $("table#main_table input").on('change',function() {
            if($('#autofill_seat_no').is(":checked"))
            {

                var start=parseInt($(this).val());
                var index=$(this).attr('name');
                // var total_input = $(this).closest('tr')  .find('td').filter(function() {return $(this).css('visibility') !== 'hidden'; });
                var total_input = $(this).closest('tr').find('td:not(.hidden_seat):not(.LabeledSeat)');
                var titlesArray = [];
                total_input.each(function() {
                    var input = $(this).find('input');
                    if (input.length) {
                        var title = input.attr('name');
                        if (title) {
                            titlesArray.push(parseInt(title));
                        }
                    }
                });

                for(var i=1 ; i<= titlesArray.length; i++)
                {
                    var k_index=titlesArray[i];
                    $( "input[name='"+k_index+"']" ).val(start+i);
                    seat_rename(start+i, k_index);
                }
            }
            else if($('#autofill_seat_no_right').is(":checked"))
            {

                var start=parseInt($(this).val());
                var index=$(this).attr('name');
                // var total_input = $(this).closest('tr')  .find('td').filter(function() {return $(this).css('visibility') !== 'hidden'; });
                var total_input = $(this).closest('tr').find('td:not(.hidden_seat):not(.LabeledSeat)');
                var titlesArray = [];
                total_input.each(function() {
                    var input = $(this).find('input');
                    if (input.length) {
                        var title = input.attr('name');
                        if (title) {
                            titlesArray.push(parseInt(title));
                        }
                    }
                });

                for(var i=1 ; i<= titlesArray.length; i++)
                {
                    var k_index=titlesArray[i];
                    $( "input[name='"+k_index+"']" ).val(start-i);
                    seat_rename(start-i, k_index);
                }
            }
            else
            {

            }
        });

        function update_screen(direction, layout_id)
        {
            var id = layout_id;
            var direction = direction;
            var data = {_token:'{{ csrf_token() }}', id:id, direction: direction};
            $.ajax({
                url: '{{ route('layouts.update_stage_direction') }}',
                type: 'POST',
                data: data,
                success: function(data)
                {
                    $('#success').fadeIn('fast');
                    $('#success').html('Screen / Stage Direction Updated Successfully');
                    $('#success').delay(2000).fadeOut('slow');

                }
            });
        }
</script>
@endsection