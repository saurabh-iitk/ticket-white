@extends('layouts.dashboard')

@section('title', 'Show/Event Ticket')

@section('css')
<!-- <link href="{{ asset('css/bootstrap-responsive.css') }}" rel="stylesheet"> -->
<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="ico/favicon.png">
<style>
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
        height: 44px;
        float: left;
        empty-cells: show;
        margin-left: 30px;
        margin-top: 3px;
    }
    #venue .rows td {
        text-align: center;
        line-height: 43px;
        background: #ccffe2;
    }


   
    table.legends td.DamagedSeat   { border: 1px solid #5f5b5b; color: #5f5b5b; background: #ebebeb; }
    table.legends td.ReservedSeat  { border: 3px solid #5f5b5b; color: #5f5b5b; }
    table.legends td.seatAvailable { border: 1px solid #01710c; color: #fff; }
    table.legends td.noSeatStorage    { background-color: #0085c1 !important; color: white !important;}


    .seat_row td.DamagedSeat  { border: 1px solid #5f5b5b; color: #5f5b5b; background: #ebebeb; }
     .seat_row td.ReservedSeat  { border: 3px solid #5f5b5b; color: #5f5b5b; }
    .seat_row td { width: 15px; height: 45px; border: solid 1px #666; border-radius: 7px 7px 0px 0px; text-align: center; cursor: pointer; }
    .seat_row td.row              { background-color: transparent; border: none; font-weight: bold; padding-right: 7px; }
    .seat_row td.seatAvailable    { border: 1px solid #01710c; color: #fff; }
    .seat_row td.seatUnavailable  { background-color: #aaa;  color: #ddd  }
    .seat_row td.ExtraPay         { background-color: navy; color: #fff  }
    .seat_row td.LargeSeat        { /*width: 23px; */}
    .seat_row td.noSeatGalley     { background-color: transparent; border: none; width: 10px; height: 10px;  }
    .seat_row td.noSeatStorage    { background-color: #0085c1 !important; color: white !important;}
    .seat_row td.noSeatLavatory   { background-color: #aaa; }
    .seat_row tr:first-child td { height: 30px; border: none; border-radius: 0; }

<?php
$color_array = [];
$class_array = [];
$ticket_type_array = [];
if($event_ticket_lists):
    foreach($event_ticket_lists as $key => $event_ticket_list):
        if(getTicketType($event_ticket_list->ticket_type_id)):
            $ticket_type_name=getTicketType($event_ticket_list->ticket_type_id)->ticket_type_name;
            $ticket_type_name=explode(' ', $ticket_type_name);
            $ticket_type_name=strtolower($ticket_type_name[0]);

            $color_array[$ticket_type_name] = getTicketType($event_ticket_list->ticket_type_id)->color;
            $class_array[$event_ticket_list->ticket_type_id] = $ticket_type_name;
            $ticket_type_array[getTicketType($event_ticket_list->ticket_type_id)->id] = getTicketType($event_ticket_list->ticket_type_id)->ticket_type_name;
        endif;
    endforeach;
endif;



foreach ($color_array as $class => $bgcolor)
{
    echo '.seat_row td.'.$class .'{border-color:'.$bgcolor.'; color:'.$bgcolor.';}';
    echo "\n";
}
?>

    .hiddenCheckbox input {
        opacity: 0;
        transform: scale(2.7);
    }
    .hiddenSeat {
        color: #fff;
        border-color: white !important;
    }
    .mt-40{
        margin-top: 40px;
    }

    seat_row td.bookSeat {
        background-color: #d7d7d7 !important;
    }

</style>
@endsection

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Show Event Ticket</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_ticket.index') }}">Event Ticket</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event</label>
                                <input type="text" class="form-control" value="{{ getEvent($event_ticket->event_id)->event_title }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Schedule</label>
                                <input type="text" class="form-control" value="{{ getEventSchedule($event_ticket->event_schedule_id)->start_date.' - '.getEventSchedule($event_ticket->event_schedule_id)->end_date }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Schedule Date</label>
                                <select class="form-control" name="event_date" id="demoSelect" multiple="multiple" disabled="true" style="width:100%;">
                                    <optgroup label="Select Event Schedule Date">
                                    @foreach(getEventScheduleListByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_schedule_list)
                                        <option value="{{$event_schedule_list->id}}" <?php if($event_ticket->event_schedule_list_id != '' && in_array($event_schedule_list->id, explode(',',$event_ticket->event_schedule_list_id))){ echo 'selected';} ?>>{{$event_schedule_list->event_date}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Event Show Time</label>
                                <select class="form-control" name="event_show_time_id" id="demoSelect2" multiple="multiple" disabled="true" style="width:100%;">
                                    <optgroup label="Select Event Show Time">
                                        @foreach(getEventShowTimeByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_show_time)
                                        <option value="{{$event_show_time->id}}" <?php if($event_ticket->event_show_time_id != '' && in_array($event_show_time->id, explode(',',$event_ticket->event_show_time_id))){ echo 'selected';} ?>>{{$event_show_time->start_time.' - '.$event_show_time->end_time}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Layout</label>
                                <input type="text" class="form-control" value="{{ getLayout($event_ticket->layout_id)->layout_name }}" disabled="true" />
                            </div>
                        </div>

                        {{--<div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Status</label>
                                <input type="text" class="form-control" value="{{ $event_ticket->status }}" disabled="true" />
                            </div>
                        </div>--}}
                        
                    </div>

                    @if($event_ticket_lists)
                        @foreach($event_ticket_lists as $key => $event_ticket_list)
                            <div class="row" id="{{$key+1}}">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Ticket Type</label>
                                        <input type="text" class="form-control" value="{{ getTicketType($event_ticket_list->ticket_type_id)->ticket_type_name }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Total Ticket</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->total_ticket }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Base Price</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->base_price }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Total Discount</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->total_discount }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Discounted Amount</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->discounted_amount }}" disabled="true" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="for">Final Price</label>
                                        <input type="text" class="form-control" value="{{ $event_ticket_list->final_price }}" disabled="true" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <hr>
                    <?php
                        $char = 'A';
                        $alphas = array_merge(range('A', 'Z'),range('a', 'z'));
                        $event_ticket_id = $event_ticket->id;
                        $event_id = $event_ticket->event_id;
                        $event_schedule_list_id = $event_ticket->event_schedule_list_id;
                        $event_show_time_id = $event_ticket->event_show_time_id;
                        $layout_id = $event_ticket->layout_id;

                        // $eslid_temp=explode(',', $event_schedule_list_id);
                        // $estid_temp=explode(',', $event_show_time_id);
                        $eslid_temp=$esd_id;
                        $estid_temp=$est_id;

                        $data = DB::table('event_seat')
                        ->where(['event_schedule_list_id'=>$eslid_temp,'event_show_time_id'=>$estid_temp,'event_ticket_id'=>$event_ticket_id,'layout_id'=>$layout_id])
                        ->selectRaw('max(row_no) as row_no, max(col_no) as col_no')
                        ->first();

                        $row_no = $data->row_no;
                        $col_no = $data->col_no;


                        $seat_master_array=[];
                        $all_seat_data=fetch_all_seat_data();
                        foreach($all_seat_data as $single_seat)
                        {
                            $seat_master_array[$single_seat->id]=$single_seat;
                        }
                    ?>

                    @if(\App\Models\EventSeat::where(['event_schedule_list_id'=>$eslid_temp,'event_show_time_id'=>$estid_temp,'event_ticket_id'=>$event_ticket_id,'layout_id'=>$layout_id])->count() > 0)
                    <div class="row">
                        <div class="col-md-12" id="sidebar">

                            

                            <table class="legends" style="font-size: 19px;width: 1250px;text-align: center;margin-bottom: 40px;">
                                <tbody><tr>
                                    
                                    <td class="DamagedSeat" style="width:170px;/* text-transform: capitalize; */">DAMAGED SEAT</td>
                                    <td class="ReservedSeat" style="width:170px">RESERVED SEAT</td>
                                    <td class="noSeatStorage" style="width:170px">SELECTED SEAT</td>
                                    @foreach($color_array as $class => $bgcolor)
                                  <td class="{{ $class }}" style="color:{{ $bgcolor}};text-transform: uppercase;width:170px; border:1px solid {{ $bgcolor}} ">{{ $class }}</td>
                                @endforeach
                            </tr>
                            </tbody></table>


                          <input type="radio" id="show" name="hide_show" value="ON"> Show &nbsp;&nbsp;
                            <input type="radio" id="hide" name="hide_show" value="OFF"> Hide &nbsp;&nbsp;

                             <input type="radio"  id="damaged" name="hide_show" value="DAMAGED"> Damaged &nbsp;&nbsp;
                                <input type="radio"  id="undamaged" name="hide_show" value="UNDAMAGED"> UnDamaged &nbsp;&nbsp;
                            <input type="radio" id="reserve" name="hide_show" value="RESERVE"> Reserve &nbsp;&nbsp;
                            <input type="radio" id="unreserve" name="hide_show" value="UNRESERVE"> UnReserve &nbsp;&nbsp;
                            
                            @foreach($ticket_type_array as $tkt_type_id => $tkt_type_name)
                            <tr>
                                <input type="radio" id="event_ticket_type_id" name="hide_show" value="{{ $tkt_type_id }}"> {{ $tkt_type_name }} &nbsp;&nbsp;
                            </tr>
                            @endforeach

                            <!--   <input type="checkbox" name="select_row" id="select_row"> Select Row &nbsp;&nbsp;
                            <input type="checkbox" name="select_colum" id="select_colum"> Select Column &nbsp;&nbsp; -->
                            <input type="button" name="action" id="action" class="btn btn-sm btn-success" value="Save Action" onclick="save_action();">

                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-2" style="display: none;">
                            <table class="seat_row" style="width: 170px">
                                <tr>
                                    <td style="text-transform: uppercase;">Legends</td>
                                </tr>
                            <!--     <tr>
                                    <td class="hiddenSeat" style="text-transform: uppercase; color: gray !important; ;">Hidden Seat</td>
                                </tr> -->
                                <tr>
                                    <td class="seatAvailable" style="color: #01710c;text-transform: uppercase;">Available Seat</td>
                                </tr>
                                <tr>
                                    <td class="ReservedSeat" style="color: white;text-transform: uppercase;">Reserved Seat</td>
                                </tr>

                                 <tr>
                                    <td class="DamagedSeat" style="color: white;text-transform: uppercase;">Damaged Seat</td>
                                </tr>
                                <tr>
                                    <td class="noSeatStorage" style="color: white;text-transform: uppercase;">Selected Seat</td>
                                </tr>

                                
                                @foreach($color_array as $class => $bgcolor)
                                <tr>
                                    <td class="{{ $class }}" style="color:{{ $bgcolor}};text-transform: uppercase;">{{ $class }}</td>
                                </tr>
                                @endforeach
                            </table>
                            <span><b>Note:</b> Hidden Seat will not be clickable and visible to Customer</span>
                        </div>

                        <div class="col-md-12" id="main_area">
                            
                            <input type="checkbox" id="multiple"> Multi Select
                            <div id="seatmap">
                                <div id="venue">
                                    <br>


<?php 
$layout_data=json_decode($layout);
$layout_data=$layout_data[0];

if($layout_data->stage_direction=='UP'){?>
    <div class="col-md-12">
 <table>
    <tr>
        <td style="background-color:#242424; text-align:center;color:White;width: 100%; text-transform:uppercase;">ALL EYES THIS WAY PLEASE<td></tr>
</table>
</div>
<?php } ?>


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
                                                  //  echo "<td class='noSeatGalley'>".$i."</td>";
                                                }
                                                ?>
                                            </tr>

<!-- creating seat row and column here  -->
<?php 
$seat_id_data = find_booking_event($event_id, $event_schedule_list_id, $event_show_time_id, $layout_id);

for($i=1; $i<=$row_no; $i++)
{
    $random_class_td=Str::random(6);
    echo "<tr>";
    for($j=1; $j<=$col_no; $j++)
    {
        $seat_id = $seat_id_data[$i][$j];
        // $seat_id=find_event_seat_id($eslid_temp, $estid_temp, $event_ticket_id, $layout_id, $i, $j);

        $seat_details = $seat_master_array[$seat_id];
        // $seat_details=fetch_layout_seat_name($seat_id);

       
        $seat_name=$seat_details->name;
        $seat_name = '<div style="margin-top: -32px;width: 30px;height: 10px;font-size: 18px;">'.$seat_name.'</div>';

        $ij_visibility = ($seat_details->is_visible=='YES' ? TRUE : FALSE );
        // $ij_visibility=check_event_seat_visibility($seat_id);


if(!empty($ij_visibility))
{
    $ij_reserved = ($seat_details->is_reserved=='YES' ? TRUE : FALSE );
    // $ij_reserved=check_event_seat_reserved($seat_id);

    $ij_damaged = ($seat_details->is_damaged=='YES' ? TRUE : FALSE );
    // $ij_damaged=check_event_seat_damaged($seat_id);

    // echo '<br>';
        if(!$ij_damaged)
        {
            // finding seat id by passing i and j here
            if(!$ij_reserved)
            {
                $tt_data = $seat_details;
                // $tt_data=fetch_event_ticket_type_id($seat_id);
                if($tt_data->event_ticket_type_id) 
                {
                    $tt_id=$tt_data->event_ticket_type_id;
                    $seat_class=$class_array[$tt_id];
                    echo "<td title=".$seat_id." class='hiddenCheckbox ".$seat_class. "  ".$random_class_td. "'><input title='".$seat_class."' type='checkbox' value=".$seat_id.">".$seat_name."</td>";
                }
                else
                {
                    echo "<td title=".$seat_id." class='seatAvailable hiddenCheckbox text-dark ".$random_class_td. "'><input type='checkbox' value=".$seat_id.">".$seat_name."</td>";
                }
            }
            else
            {
                echo "<td title=".$seat_id." class='ReservedSeat hiddenCheckbox'><input type='checkbox' value=".$seat_id." >".$seat_name."</td>";
            }
        }
        else
        {
            echo "<td title=".$seat_id." class='DamagedSeat hiddenCheckbox'><input type='checkbox' value=".$seat_id." >".$seat_name."</td>";
        }
    }
    else
    {
        echo "<td title=".$seat_id." class='hiddenCheckbox hiddenSeat'><input type='checkbox' value=".$seat_id."></td>";
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
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('event_ticket.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>
<script type="text/javascript">
    $('#demoSelect').select2();
    $('#demoSelect2').select2();
</script>

<script type="text/javascript">

    function save_action()
    {
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
        if(hide_show=='DAMAGED')
        {
            var action='damage';
        }
        if(hide_show=='UNDAMAGED')
        {
            var action='undamage';
        }

        if(hide_show=='ON' || hide_show=='OFF' || hide_show=='RESERVE' || hide_show=='UNRESERVE'|| hide_show=='DAMAGED' || hide_show=='UNDAMAGED') {
            var event_ticket_type_id = 0;
        } else {
            var event_ticket_type_id = hide_show;
        }

        var seat = [];
        $("input:checkbox[class=noSeatStorage]:checked").each(function () {
            var seat_id=$(this).val();
            seat.push(seat_id);
        });

        var data = {_token:'{{ csrf_token() }}', action:action, event_ticket_type_id:event_ticket_type_id, ids: seat, event_schedule_list_id:'{{ $esd_id }}', event_show_time_id:'{{ $est_id }}', event_ticket_id:'{{ $event_ticket->id }}'};
        $.ajax({
            url: '{{ route('event_ticket.update_event_seat') }}',
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

    
    $('td').on('click', function () {
        var c= $(this).prop('class');
        c=c.split(" ").pop();
        if(c.length==6)
        {
            if($('#multiple').is(":checked"))
            {
                $('td.'+c).removeClass('noSeatStorage');
                $('td.'+c).find('input:checkbox').removeClass('noSeatStorage');
                // $(this).find('input:checkbox').click();
                $('td.'+c).find('input:checkbox').click();
            }
        }
    });
</script>
@endsection