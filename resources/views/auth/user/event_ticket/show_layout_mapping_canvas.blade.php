@extends('layouts.dashboard')

@section('title', 'Show/Event Ticket Canvas Designer')

@section('css')
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="ico/favicon.png">
<style>
    #seatmap { 
        position: relative; 
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }

    #venue {
        position: relative;
        width: 100%;
        height: 100%;
    }

    table.legends td.DamagedSeat   { border: 1px solid #5f5b5b; color: #5f5b5b; background: #ebebeb; }
    table.legends td.ReservedSeat  { border: 3px solid #5f5b5b; color: #5f5b5b; }
    table.legends td.seatAvailable { border: 1px solid #01710c; color: #fff; }
    table.legends td.noSeatStorage    { background-color: #0085c1 !important; color: white !important;}

    /* Free-form Absolute Seat Badges */
    .canvas-seat {
        position: absolute;
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: move;
        border-radius: 6px;
        background-color: #f8fafc;
        border: 1.5px solid #cbd5e1;
        transition: transform 0.1s ease, box-shadow 0.1s ease;
        user-select: none;
    }

    .canvas-seat:hover {
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        transform: scale(1.08);
        z-index: 200;
    }

    .canvas-seat .seat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }

    .canvas-seat.seatAvailable {
        background-color: #ccffe2;
        border: 1.5px solid #01710c;
        color: #01710c;
    }

    .canvas-seat.ReservedSeat {
        background-color: #fff;
        border: 3px solid #5f5b5b;
        color: #5f5b5b;
    }

    .canvas-seat.DamagedSeat {
        background-color: #ebebeb;
        border: 1.5px solid #5f5b5b;
        color: #5f5b5b;
    }

    .canvas-seat.hiddenSeat {
        background-color: transparent !important;
        border: 1.5px dashed #cbd5e1 !important;
        opacity: 0.4;
    }

    /* Object Selection Styling */
    .canvas-gate.selected-object,
    .canvas-seat.selected-object {
        outline: 2.5px solid #2563eb !important;
        outline-offset: 3px;
        box-shadow: 0 0 0 6px rgba(37, 99, 235, 0.25) !important;
        z-index: 500 !important;
    }

    /* Floating Context Action Menu */
    .object-action-menu {
        display: none;
        position: absolute;
        background: #1e293b;
        border: 1px solid #475569;
        border-radius: 8px;
        padding: 6px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        z-index: 99999;
        gap: 6px;
    }

    .object-action-menu.active {
        display: flex;
    }

    .object-action-menu button {
        background: transparent;
        border: none;
        color: #e2e8f0;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .object-action-menu button:hover {
        background: #334155;
        color: #3b82f6;
    }

    .object-action-menu button.btn-danger-action:hover {
        background: #dc2626;
        color: white;
    }

    /* Canvas Gate / Markers Styling */
    .canvas-gate {
        position: absolute;
        z-index: 100;
        color: #fff;
        cursor: move;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15), 0 2px 4px -1px rgba(0, 0, 0, 0.08);
        user-select: none;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(0, 0, 0, 0.15);
        transition: transform 0.1s ease, box-shadow 0.1s ease;
    }

    .canvas-gate:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        transform: scale(1.03);
    }

    /* Sidebar Object List grid */
    .designer-panel-card {
        border-left: 4px solid #2563eb !important;
    }

    .object-list-section {
        margin-bottom: 15px;
    }

    .object-list-title {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.8px;
        margin-bottom: 8px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 4px;
    }

    .object-list-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }

    .brush-item-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: grab;
        transition: all 0.2s ease;
        user-select: none;
        font-size: 16px;
    }

    .brush-item-box:hover {
        background: #eff6ff;
        border-color: #3b82f6;
        color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .brush-item-box.active-brush {
        background: #eff6ff;
        border-color: #2563eb;
        color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .brush-color-indicator-box {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
    }

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
    echo '.canvas-seat.'.$class .'{border: 2.5px solid '.$bgcolor.'; background-color: #fff; color: '.$bgcolor.';}';
    echo "\n";
}
?>

    /* Paint mode cursor */
    .paint-mode-active .canvas-seat {
        cursor: crosshair !important;
    }
</style>
@endsection

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Seating Layout Designer</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('event_ticket.index') }}">Event Ticket</a></li>
        </ul>
    </div>
    
    <?php
        $char = 'A';
        $alphas = array_merge(range('A', 'Z'),range('a', 'z'));
        $event_ticket_id = $event_ticket->id;
        $event_id = $event_ticket->event_id;
        $event_schedule_list_id = $event_ticket->event_schedule_list_id;
        $event_show_time_id = $event_ticket->event_show_time_id;
        $layout_id = $event_ticket->layout_id;

        $eslid_temp=$esd_id;
        $estid_temp=$est_id;

        $data = DB::table('event_seat')
        ->where(['event_schedule_list_id'=>$eslid_temp,'event_show_time_id'=>$estid_temp,'event_ticket_id'=>$event_ticket_id,'layout_id'=>$layout_id])
        ->selectRaw('max(row_no) as row_no, max(col_no) as col_no')
        ->first();

        $row_no = $data ? $data->row_no : 0;
        $col_no = $data ? $data->col_no : 0;

        $seat_master_array=[];
        $all_seat_data=fetch_all_seat_data();
        foreach($all_seat_data as $single_seat)
        {
            $seat_master_array[$single_seat->id]=$single_seat;
        }

        // Space calculations for default grid dimensions
        $spacing = 46;
        $canvas_width = $col_no * $spacing + 100;
        $canvas_height = $row_no * $spacing + 240;
    ?>

    @if(\App\Models\EventSeat::where(['event_schedule_list_id'=>$eslid_temp,'event_show_time_id'=>$estid_temp,'event_ticket_id'=>$event_ticket_id,'layout_id'=>$layout_id])->count() > 0)
    <div class="row">
        <!-- Sidebar: Object List Column -->
        <div class="col-md-3">
            <div class="tile designer-panel-card shadow-sm mb-3">
                <h4 class="tile-title" style="font-size: 16px; margin-bottom: 12px; color: #2563eb;">
                    <i class="fa-solid fa-list"></i> Object List
                </h4>
                <div class="tile-body">
                    <p class="text-muted" style="font-size: 11px; line-height: 1.4; margin-bottom: 15px;">
                        <strong>Canvas elements</strong>: Drag & drop to map. <br>
                        <strong>Seating tools</strong>: Click to pick tool, click seats to paint, or drag seats/structures to position them.
                    </p>
                    
                    <!-- Brush Status Banner -->
                    <div id="active_brush_banner" class="alert alert-info py-2 px-3 mb-3 d-none" style="font-size:12px; font-weight:600;">
                        <span id="brush_banner_text">Active Tool: None</span>
                        <button type="button" class="close" onclick="resetBrush();" style="font-size:16px;">&times;</button>
                    </div>

                    <!-- Category 1: Canvas Elements -->
                    <div class="object-list-section">
                        <div class="object-list-title">Canvas Elements</div>
                        <div class="object-list-grid">
                            @foreach($layout_objects as $obj)
                            <div class="brush-item-box" title="{{ $obj['label'] }}" data-type="canvas-object" data-object-type="{{ $obj['type'] }}" data-label="{{ $obj['label'] }}" data-icon="{{ $obj['icon'] }}" data-color="{{ $obj['color'] }}" draggable="true" ondragstart="dragCanvasObject(event)" style="color: {{ $obj['color'] }};">
                                <i class="{{ $obj['icon'] }}"></i>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category 2: Seating Classes -->
                    <div class="object-list-section">
                        <div class="object-list-title">Seat Classes</div>
                        <div class="object-list-grid">
                            @foreach($ticket_type_array as $tkt_type_id => $tkt_type_name)
                                @php
                                $class_name = strtolower(explode(' ', $tkt_type_name)[0]);
                                $color = isset($color_array[$class_name]) ? $color_array[$class_name] : '#64748b';
                                @endphp
                                <div class="brush-item-box seat-brush-item" title="{{ $tkt_type_name }}" data-type="class" data-value="{{ $tkt_type_id }}" data-color="{{ $color }}" data-label="{{ $tkt_type_name }}" onclick="selectBrush(this);" draggable="true" ondragstart="dragBrush(event)">
                                    <span class="brush-color-indicator-box" style="background-color: {{ $color }}; border: 1px solid rgba(0,0,0,0.15);"></span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category 3: Seating Statuses -->
                    <div class="object-list-section">
                        <div class="object-list-title">Seat Statuses</div>
                        <div class="object-list-grid">
                            <div class="brush-item-box seat-brush-item" title="Available Seat" data-type="status" data-value="show" data-color="#ccffe2" data-label="Available Seat" onclick="selectBrush(this);" draggable="true" ondragstart="dragBrush(event)">
                                <i class="fa-solid fa-chair text-success"></i>
                            </div>
                            <div class="brush-item-box seat-brush-item" title="Hidden Seat" data-type="status" data-value="hide" data-color="transparent" data-label="Hidden Seat" onclick="selectBrush(this);" draggable="true" ondragstart="dragBrush(event)">
                                <i class="fa-solid fa-eye-slash text-muted"></i>
                            </div>
                            <div class="brush-item-box seat-brush-item" title="Damaged Seat" data-type="status" data-value="damaged" data-color="#ebebeb" data-label="Damaged Seat" onclick="selectBrush(this);" draggable="true" ondragstart="dragBrush(event)">
                                <i class="fa-solid fa-triangle-exclamation text-dark"></i>
                            </div>
                            <div class="brush-item-box seat-brush-item" title="Reserved Seat" data-type="status" data-value="reserve" data-color="#fff" data-label="Reserved Seat" onclick="selectBrush(this);" draggable="true" ondragstart="dragBrush(event)">
                                <i class="fa-solid fa-lock text-warning"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Category 4: Seat Shapes -->
                    <div class="object-list-section">
                        <div class="object-list-title">Seat Shapes</div>
                        <div class="object-list-grid">
                            <div class="brush-item-box seat-brush-item" title="Chair" data-type="shape" data-value="chair" data-color="#3b82f6" data-label="Chair" onclick="selectBrush(this);" draggable="true" ondragstart="dragBrush(event)">
                                <i class="fa-solid fa-chair"></i>
                            </div>
                            <div class="brush-item-box seat-brush-item" title="Sofa" data-type="shape" data-value="sofa" data-color="#2563eb" data-label="Sofa" onclick="selectBrush(this);" draggable="true" ondragstart="dragBrush(event)">
                                <i class="fa-solid fa-couch"></i>
                            </div>
                        </div>
                    </div>

                    <hr style="margin: 15px 0;">

                    <!-- Unified Save Controls -->
                    <button type="button" class="btn btn-success btn-block mb-2" onclick="save_designer_layout();" style="padding: 10px 12px; font-weight: 700;">
                        <i class="fa-solid fa-floppy-disk"></i> Save Layout
                    </button>
                    
                    <button type="button" class="btn btn-outline-danger btn-sm btn-block" onclick="clear_entire_canvas();" style="padding: 8px 12px; font-weight: 600;">
                        <i class="fa-solid fa-trash-can"></i> Clear Entire Canvas
                    </button>
                </div>
            </div>
        </div>

        <!-- Seating Map Column -->
        <div class="col-md-9">
            <div class="tile shadow-sm">
                <div class="tile-body">
                    <!-- Event Info Block -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for" class="font-weight-bold small text-muted uppercase">Event</label>
                                <input type="text" class="form-control form-control-sm" value="{{ getEvent($event_ticket->event_id)->event_title }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for" class="font-weight-bold small text-muted uppercase">Event Schedule</label>
                                <input type="text" class="form-control form-control-sm" value="{{ getEventSchedule($event_ticket->event_schedule_id)->start_date.' - '.getEventSchedule($event_ticket->event_schedule_id)->end_date }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for" class="font-weight-bold small text-muted uppercase">Schedule Date</label>
                                <select class="form-control form-control-sm" name="event_date" id="demoSelect" multiple="multiple" disabled="true" style="width:100%;">
                                    <optgroup label="Select Event Schedule Date">
                                    @foreach(getEventScheduleListByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_schedule_list)
                                        <option value="{{$event_schedule_list->id}}" <?php if($event_ticket->event_schedule_list_id != '' && in_array($event_schedule_list->id, explode(',',$event_ticket->event_schedule_list_id))){ echo 'selected';} ?>>{{$event_schedule_list->event_date}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label for="for" class="font-weight-bold small text-muted uppercase">Show Time</label>
                                <select class="form-control form-control-sm" name="event_show_time_id" id="demoSelect2" multiple="multiple" disabled="true" style="width:100%;">
                                    <optgroup label="Select Event Show Time">
                                        @foreach(getEventShowTimeByEventScheduleID($event_ticket->event_schedule_id) as $key => $event_show_time)
                                        <option value="{{$event_show_time->id}}" <?php if($event_ticket->event_show_time_id != '' && in_array($event_show_time->id, explode(',',$event_ticket->event_show_time_id))){ echo 'selected';} ?>>{{$event_show_time->start_time.' - '.$event_show_time->end_time}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label for="for" class="font-weight-bold small text-muted uppercase">Layout Template</label>
                                <input type="text" class="form-control form-control-sm" value="{{ getLayout($event_ticket->layout_id)->layout_name }}" disabled="true" />
                            </div>
                        </div>
                    </div>

                    <hr style="margin: 15px 0;">

                    <!-- Legend Table -->
                    <table class="legends" style="font-size: 11px; width: 100%; text-align: center; margin-bottom: 20px; border-collapse: separate; border-spacing: 4px;">
                        <tbody>
                            <tr>
                                <td class="DamagedSeat font-weight-bold" style="padding: 6px; border-radius: 4px;">DAMAGED SEAT</td>
                                <td class="ReservedSeat font-weight-bold" style="padding: 6px; border-radius: 4px;">RESERVED SEAT</td>
                                <td class="noSeatStorage font-weight-bold" style="padding: 6px; border-radius: 4px;">SELECTED SEAT</td>
                                @foreach($color_array as $class => $bgcolor)
                                <td class="{{ $class }} font-weight-bold" style="color:{{ $bgcolor}}; text-transform: uppercase; border: 1px solid {{ $bgcolor}}; padding: 6px; border-radius: 4px;">{{ $class }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>

                    <hr style="margin: 15px 0;">

                    <!-- Seating Map Canvas Area -->
                    <div style="position: relative;">
                        <!-- Canvas / Seating designer container -->
                        <div id="seatmap" style="width: 100%; height: {{ $canvas_height }}px; overflow: auto; position: relative;">
                            <div id="venue">
                                <!-- Stage Header if direction is UP -->
                                <?php 
                                $layout_data=json_decode($layout);
                                $layout_data=$layout_data[0];
                                
                                if($layout_data->stage_direction=='UP'){?>
                                <div style="position: absolute; top: 15px; left: 5%; width: 90%; background-color:#0f172a; text-align:center; color:white; text-transform:uppercase; padding: 12px; font-weight: 700; border-radius: 6px; letter-spacing: 1px; font-size: 13px; z-index: 10;">
                                    <i class="fa-solid fa-chalkboard"></i> STAGE (ALL EYES THIS WAY PLEASE)
                                </div>
                                <?php } ?>

                                <!-- Seating Canvas elements -->
                                <?php 
                                $seat_id_data = find_booking_event($event_id, $event_schedule_list_id, $event_show_time_id, $layout_id);
                                
                                $layout_model = $layout->first();
                                $markers_data = $layout_model && $layout_model->markers ? json_decode($layout_model->markers, true) : null;
                                $saved_seat_coords = is_array($markers_data) && isset($markers_data['seat_coords']) ? $markers_data['seat_coords'] : [];

                                for($i=1; $i<=$row_no; $i++)
                                {
                                    $random_class_td=Str::random(6);
                                    for($j=1; $j<=$col_no; $j++)
                                    {
                                        $seat_id = $seat_id_data[$i][$j];
                                        $seat_details = $seat_master_array[$seat_id];
                                        
                                        // Fetch dimensions and positions
                                        if (isset($saved_seat_coords[$seat_id])) {
                                            $left = $saved_seat_coords[$seat_id]['x'];
                                            $top = $saved_seat_coords[$seat_id]['y'];
                                            $seat_w = isset($saved_seat_coords[$seat_id]['w']) ? $saved_seat_coords[$seat_id]['w'] : 32;
                                            $seat_h = isset($saved_seat_coords[$seat_id]['h']) ? $saved_seat_coords[$seat_id]['h'] : 32;
                                            $seat_shape = isset($saved_seat_coords[$seat_id]['shape']) ? $saved_seat_coords[$seat_id]['shape'] : 'chair';
                                        } else {
                                            $left_px = ($j - 1) * $spacing + 50;
                                            $top_px = ($i - 1) * $spacing + 100;
                                            $left = ($left_px / $canvas_width) * 100;
                                            $top = ($top_px / $canvas_height) * 100;
                                            $seat_w = 32;
                                            $seat_h = 32;
                                            $seat_shape = 'chair';
                                        }

                                        $icon_class = $seat_shape === 'sofa' ? 'fa-solid fa-couch' : 'fa-solid fa-chair';
                                        $ij_visibility = ($seat_details->is_visible=='YES' ? TRUE : FALSE );

                                        if(!empty($ij_visibility))
                                        {
                                            $ij_reserved = ($seat_details->is_reserved=='YES' ? TRUE : FALSE );
                                            $ij_damaged = ($seat_details->is_damaged=='YES' ? TRUE : FALSE );

                                            $status_class = '';
                                            $inline_style = '';
                                            $icon_to_render = $icon_class;

                                            if(!$ij_damaged)
                                            {
                                                if(!$ij_reserved)
                                                {
                                                    $tt_data = $seat_details;
                                                    if($tt_data->event_ticket_type_id) 
                                                    {
                                                        $tt_id=$tt_data->event_ticket_type_id;
                                                        $seat_class=$class_array[$tt_id];
                                                        $status_class = $seat_class;
                                                        $border_color = isset($color_array[$seat_class]) ? $color_array[$seat_class] : '#64748b';
                                                        $inline_style = "border: 2.5px solid ".$border_color."; background-color: #fff; color: ".$border_color.";";
                                                    }
                                                    else
                                                    {
                                                        $status_class = 'seatAvailable';
                                                        $inline_style = "border: 1.5px solid #01710c; background-color: #ccffe2; color: #01710c;";
                                                    }
                                                }
                                                else
                                                {
                                                    $status_class = 'ReservedSeat';
                                                    $inline_style = "border: 3px solid #5f5b5b; background-color: #fff; color: #5f5b5b;";
                                                }
                                            }
                                            else
                                            {
                                                $status_class = 'DamagedSeat';
                                                $inline_style = "border: 1.5px solid #5f5b5b; background-color: #ebebeb; color: #5f5b5b;";
                                                $icon_to_render = 'fa-solid fa-triangle-exclamation';
                                            }
                                            
                                            echo "<div title='".$seat_details->name." (Click to select/drag)' class='canvas-seat ".$status_class."' style='left: ".$left."%; top: ".$top."%; width: ".$seat_w."px; height: ".$seat_h."px; ".$inline_style."' data-id='".$seat_id."' data-w='".$seat_w."' data-h='".$seat_h."' data-row='".$i."' data-col='".$j."' onclick='clickSeat(event, this)' ondrop='dropOnSeat(event)' ondragover='allowDrop(event)'>";
                                            echo "<span class='seat-icon' style='font-size: ".($seat_w * 0.45)."px;'><i class='".$icon_to_render."'></i></span>";
                                            echo "</div>";
                                        }
                                        else
                                        {
                                            echo "<div title='".$seat_details->name." (Click to select/drag)' class='canvas-seat hiddenSeat' style='left: ".$left."%; top: ".$top."%; width: ".$seat_w."px; height: ".$seat_h."px; background-color: transparent;' data-id='".$seat_id."' data-w='".$seat_w."' data-h='".$seat_h."' data-row='".$i."' data-col='".$j."' onclick='clickSeat(event, this)' ondrop='dropOnSeat(event)' ondragover='allowDrop(event)'></div>";
                                        }
                                    }
                                }
                                ?>

                                <!-- Stage Header if direction is DOWN -->
                                <?php 
                                if($layout_data->stage_direction=='DOWN'){?>
                                <div style="position: absolute; bottom: 15px; left: 5%; width: 90%; background-color:#0f172a; text-align:center; color:white; text-transform:uppercase; padding: 12px; font-weight: 700; border-radius: 6px; letter-spacing: 1px; font-size: 13px; z-index: 10;">
                                    <i class="fa-solid fa-chalkboard"></i> STAGE (ALL EYES THIS WAY PLEASE)
                                </div>
                                <?PHP } ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Context Action Menu -->
                    <div id="object_action_menu" class="object-action-menu">
                        <button type="button" id="btn_action_rename" title="Rename"><i class="fa-solid fa-pen-to-square"></i> Rename</button>
                        <button type="button" id="btn_action_size_up" title="Increase Size"><i class="fa-solid fa-magnifying-glass-plus"></i> Size +</button>
                        <button type="button" id="btn_action_size_down" title="Decrease Size"><i class="fa-solid fa-magnifying-glass-minus"></i> Size -</button>
                        <button type="button" id="btn_action_duplicate" title="Duplicate"><i class="fa-solid fa-copy"></i> Duplicate</button>
                        <button type="button" id="btn_action_delete" class="btn-danger-action" title="Delete"><i class="fa-solid fa-trash-can"></i> Delete</button>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('event_ticket.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</main>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>
<script type="text/javascript">
    $('#demoSelect').select2();
    $('#demoSelect2').select2();
</script>

<script type="text/javascript">
    // Variables
    var gates = [];
    var seatShapes = {};
    var seatUpdates = {}; 
    var activeBrush = null; 
    var layoutId = '{{ $layout_id }}';
    
    var classMap = {
        @foreach($class_array as $type_id => $class_name)
            '{{ $type_id }}': '{{ $class_name }}',
        @endforeach
    };

    $(document).ready(function() {
        // Load existing gates/canvas elements & seat shapes
        var savedLayoutData = {!! $layout->first() && $layout->first()->markers ? $layout->first()->markers : '{"gates":[], "seat_shapes":{}}' !!};
        if (typeof savedLayoutData === 'string') {
            try {
                savedLayoutData = JSON.parse(savedLayoutData);
            } catch(e) {
                savedLayoutData = { gates: [], seat_shapes: {} };
            }
        }
        
        // Handle legacy format where markers was just a flat array of gates
        if (Array.isArray(savedLayoutData)) {
            savedLayoutData = {
                gates: savedLayoutData,
                seat_shapes: {}
            };
        } else if (savedLayoutData.seat_coords) {
            // Pull shapes from seat_coords if present
            Object.keys(savedLayoutData.seat_coords).forEach(function(sid) {
                savedLayoutData.seat_shapes[sid] = savedLayoutData.seat_coords[sid].shape;
            });
        }
        
        var savedGates = savedLayoutData.gates || [];
        seatShapes = savedLayoutData.seat_shapes || {};
        
        // Render gates
        savedGates.forEach(function(gate) {
            createGateElement(gate.id, gate.type, gate.label, gate.icon, gate.color, gate.x, gate.y, { w: gate.w, h: gate.h });
        });

        // Setup Dragging & Canvas Dropping Handlers
        setupDraggingHandlers();
        setupCanvasDrop();

        // Listen for Esc key to cancel active paint brush tool or selection
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                resetBrush();
                deselectObject();
            }
        });

        // Deselect object when clicking specifically on canvas background
        $('#seatmap, #venue').on('click', function(e) {
            if (e.target === this || e.target.id === 'venue' || e.target.id === 'seatmap') {
                deselectObject();
            }
        });

        // Floating action menu click events
        setupActionMenuHandlers();
    });

    // -------------------------------------------------------------
    // CANVAS DESIGNER GATES & MARKERS
    // -------------------------------------------------------------
    function spawnGate(type, defaultLabel) {
        var id = 'gate_' + Date.now();
        var count = $('.canvas-gate[data-type="' + type + '"]').length + 1;
        var label = defaultLabel + ' ' + count;
        
        var icon = 'fa-solid fa-circle';
        var color = '#64748b';
        
        if (type === 'entry') {
            icon = 'fa-solid fa-door-open';
            color = '#10b981';
        } else if (type === 'exit') {
            icon = 'fa-solid fa-door-closed';
            color = '#ef4444';
        } else if (type === 'emergency_exit') {
            icon = 'fa-solid fa-person-running';
            color = '#dc2626';
        } else if (type === 'stage') {
            icon = 'fa-solid fa-chalkboard';
            color = '#1e293b';
        } else if (type === 'bar') {
            icon = 'fa-solid fa-glass-martini-alt';
            color = '#f59e0b';
        } else if (type === 'restroom') {
            icon = 'fa-solid fa-restroom';
            color = '#3b82f6';
        } else if (type === 'info') {
            icon = 'fa-solid fa-circle-info';
            color = '#06b6d4';
        }
        
        createGateElement(id, type, label, icon, color, 35, 35);
    }

    function createGateElement(id, type, label, icon, color, x, y, size) {
        var currentSize = size || (type === 'stage' ? { w: 140, h: 50 } : { w: 44, h: 44 });
        var borderRadius = type === 'stage' ? '8px' : '50%';
        var minDimension = Math.min(currentSize.w, currentSize.h);
        
        var gateHtml = `
            <div id="${id}" class="canvas-gate" title="${label} (Click to select/drag)" style="left: ${x}%; top: ${y}%; background-color: ${color}; width: ${currentSize.w}px; height: ${currentSize.h}px; border-radius: ${borderRadius};" data-id="${id}" data-type="${type}" data-icon="${icon}" data-color="${color}" data-w="${currentSize.w}" data-h="${currentSize.h}">
                <span class="gate-icon" style="font-size: ${minDimension * 0.45}px;"><i class="${icon}"></i></span>
            </div>
        `;
        
        $('#seatmap').append(gateHtml);
        
        // Track gate if not already tracked
        if (!gates.some(g => g.id === id)) {
            gates.push({ id: id, type: type, label: label, icon: icon, color: color, x: x, y: y, w: currentSize.w, h: currentSize.h });
        }
    }

    // Handle gate selection click
    $(document).on('click', '.canvas-gate', function(e) {
        e.stopPropagation();
        var gateEl = $(this);
        selectObject(gateEl, 'gate');
    });

    function resizeGate(e, id, diff) {
        if (e) e.stopPropagation();
        var gateEl = $(`#${id}`);
        if (!gateEl.length) return;
        var type = gateEl.data('type');
        
        var w = parseInt(gateEl.attr('data-w')) || parseInt(gateEl.css('width')) || 44;
        var h = parseInt(gateEl.attr('data-h')) || parseInt(gateEl.css('height')) || 44;
        
        var newW = w + diff;
        var newH = h + (type === 'stage' ? diff * 0.35 : diff);
        
        newW = Math.max(type === 'stage' ? 60 : 24, Math.min(newW, 300));
        newH = Math.max(type === 'stage' ? 24 : 24, Math.min(newH, 150));
        
        gateEl.css({
            width: newW + 'px',
            height: newH + 'px'
        });
        
        gateEl.attr('data-w', newW);
        gateEl.attr('data-h', newH);
        gateEl.data('w', newW);
        gateEl.data('h', newH);
        
        var minDimension = Math.min(newW, newH);
        gateEl.find('.gate-icon').css('font-size', (minDimension * 0.45) + 'px');
        
        // Update in gates array
        var idx = gates.findIndex(g => g.id === id);
        if (idx !== -1) {
            gates[idx].w = newW;
            gates[idx].h = newH;
        }
    }

    function duplicateGate(e, id) {
        if (e) e.stopPropagation();
        var gateEl = $(`#${id}`);
        var type = gateEl.data('type');
        var label = gateEl.attr('title').replace(" (Click to select/drag)", "") + ' (Copy)';
        var icon = gateEl.data('icon');
        var color = gateEl.data('color');
        
        var leftStr = gateEl.css('left');
        var topStr = gateEl.css('top');
        var parentRect = document.getElementById('seatmap').getBoundingClientRect();
        
        var leftPct = parseFloat(leftStr);
        var topPct = parseFloat(topStr);
        
        if (leftStr.indexOf('px') !== -1) {
            leftPct = (leftPct / parentRect.width) * 100;
        }
        if (topStr.indexOf('px') !== -1) {
            topPct = (topPct / parentRect.height) * 100;
        }
        
        leftPct = Math.min(90, leftPct + 4);
        topPct = Math.min(90, topPct + 4);
        
        var w = parseInt(gateEl.data('w'));
        var h = parseInt(gateEl.data('h'));
        
        var newId = 'gate_' + Date.now();
        createGateElement(newId, type, label, icon, color, leftPct.toFixed(2), topPct.toFixed(2), { w: w, h: h });
    }

    function deleteGate(e, id) {
        if (e) e.stopPropagation();
        $(`#${id}`).remove();
        gates = gates.filter(g => g.id !== id);
    }

    function clear_entire_canvas() {
        if (confirm('Are you sure you want to clear the entire canvas? This will remove all gates/structures, reset all seat shapes to chairs, reset positions back to the default grid, and set all seats back to Available.')) {
            // 1. Remove all gates/structures
            $('.canvas-gate').remove();
            gates = [];
            
            // 2. Reset shapes and updates list
            seatShapes = {};
            seatUpdates = {};
            
            // 3. Loop through each seat and reset to default grid position and status
            var spacing = 46;
            var canvasWidth = {{ $canvas_width }};
            var canvasHeight = {{ $canvas_height }};
            
            $('.canvas-seat').each(function() {
                var seatEl = $(this);
                var seatId = seatEl.data('id');
                var row = parseInt(seatEl.attr('data-row')) || parseInt(seatEl.data('row'));
                var col = parseInt(seatEl.attr('data-col')) || parseInt(seatEl.data('col'));
                
                var leftPx = (col - 1) * spacing + 50;
                var topPx = (row - 1) * spacing + 100;
                var leftPct = (leftPx / canvasWidth) * 100;
                var topPct = (topPx / canvasHeight) * 100;
                
                seatEl.css({
                    'left': leftPct.toFixed(2) + '%',
                    'top': topPct.toFixed(2) + '%',
                    'width': '32px',
                    'height': '32px',
                    'background-color': '#ccffe2',
                    'border': '1.5px solid #01710c',
                    'color': '#01710c'
                });
                
                seatEl.attr('data-w', 32).data('w', 32);
                seatEl.attr('data-h', 32).data('h', 32);
                seatEl.find('.seat-icon').html('<i class="fa-solid fa-chair"></i>').css('font-size', '14.4px');
                
                // Clear existing status classes and set back to seatAvailable
                seatEl.removeClass('ReservedSeat DamagedSeat hiddenSeat noSeatStorage text-dark');
                @foreach($class_array as $type_id => $class_name)
                    seatEl.removeClass('{{ $class_name }}');
                @endforeach
                seatEl.addClass('seatAvailable');
                
                // Queue the database resets
                seatUpdates[seatId] = { id: seatId, type: 'clear_status', value: '' };
            });
            
            deselectObject();
            alert('Canvas cleared locally! Press "Save Layout" to persist changes to the database.');
        }
    }

    // -------------------------------------------------------------
    // FLOATING ACTION MENU LOGIC
    // -------------------------------------------------------------
    function selectObject(target, type) {
        deselectObject();
        target.addClass('selected-object');
        
        var menu = $('#object_action_menu');
        var targetRect = target[0].getBoundingClientRect();
        var parentRect = document.getElementById('seatmap').getBoundingClientRect();
        
        var menuLeft = (targetRect.left - parentRect.left) + (targetRect.width / 2);
        var menuTop = (targetRect.top - parentRect.top) - 45;
        
        menu.css({
            left: menuLeft + 'px',
            top: menuTop + 'px',
            transform: 'translateX(-50%)'
        }).addClass('active');
        
        menu.data('target-id', type === 'gate' ? target.attr('id') : target.data('id'));
        menu.data('target-type', type);
        
        if (type === 'seat') {
            $('#btn_action_duplicate').hide();
            $('#btn_action_delete').hide();
            $('#btn_action_rename').hide();
        } else {
            $('#btn_action_duplicate').show();
            $('#btn_action_delete').show();
            $('#btn_action_rename').show();
        }
    }

    function deselectObject() {
        $('.canvas-gate, .canvas-seat').removeClass('selected-object');
        $('#object_action_menu').removeClass('active');
    }

    function repositionMenu(targetId, targetType) {
        var target = targetType === 'gate' ? $(`#${targetId}`) : $(`.canvas-seat`).filter(function() { return $(this).data('id') == targetId || $(this).attr('data-id') == targetId; });
        if (!target.length) return;
        var menu = $('#object_action_menu');
        var targetRect = target[0].getBoundingClientRect();
        var parentRect = document.getElementById('seatmap').getBoundingClientRect();
        
        var menuLeft = (targetRect.left - parentRect.left) + (targetRect.width / 2);
        var menuTop = (targetRect.top - parentRect.top) - 45;
        
        menu.css({
            left: menuLeft + 'px',
            top: menuTop + 'px'
        });
    }

    function setupActionMenuHandlers() {
        $('#btn_action_rename').on('click', function(e) {
            e.stopPropagation();
            var menu = $('#object_action_menu');
            var targetId = menu.data('target-id');
            var targetType = menu.data('target-type');
            if (targetType === 'gate') {
                var gateEl = $(`#${targetId}`);
                var currentLabel = gateEl.attr('title').replace(" (Click to select/drag)", "");
                var newLabel = prompt("Enter new name for this object:", currentLabel);
                if (newLabel !== null && newLabel.trim() !== "") {
                    var trimmed = newLabel.trim();
                    gateEl.attr('title', trimmed + " (Click to select/drag)");
                    var idx = gates.findIndex(g => g.id === targetId);
                    if (idx !== -1) {
                        gates[idx].label = trimmed;
                    }
                }
            }
            deselectObject();
        });

        $('#btn_action_size_up').on('click', function(e) {
            e.stopPropagation();
            var menu = $('#object_action_menu');
            var targetId = menu.data('target-id');
            var targetType = menu.data('target-type');
            if (targetType === 'gate') {
                resizeGate(null, targetId, 10);
            } else {
                resizeSeat(null, targetId, 4);
            }
            repositionMenu(targetId, targetType);
        });

        $('#btn_action_size_down').on('click', function(e) {
            e.stopPropagation();
            var menu = $('#object_action_menu');
            var targetId = menu.data('target-id');
            var targetType = menu.data('target-type');
            if (targetType === 'gate') {
                resizeGate(null, targetId, -10);
            } else {
                resizeSeat(null, targetId, -4);
            }
            repositionMenu(targetId, targetType);
        });

        $('#btn_action_duplicate').on('click', function(e) {
            e.stopPropagation();
            var menu = $('#object_action_menu');
            var targetId = menu.data('target-id');
            var targetType = menu.data('target-type');
            if (targetType === 'gate') {
                duplicateGate(null, targetId);
            }
            deselectObject();
        });

        $('#btn_action_delete').on('click', function(e) {
            e.stopPropagation();
            var menu = $('#object_action_menu');
            var targetId = menu.data('target-id');
            var targetType = menu.data('target-type');
            if (targetType === 'gate') {
                deleteGate(null, targetId);
            }
            deselectObject();
        });
    }

    // -------------------------------------------------------------
    // DRAG AND DROP MECHANICS (HTML5 API)
    // -------------------------------------------------------------
    function dragCanvasObject(ev) {
        ev.dataTransfer.setData("text/plain", JSON.stringify({
            source: 'canvas-object',
            type: ev.currentTarget.getAttribute('data-object-type'),
            label: ev.currentTarget.getAttribute('data-label'),
            icon: ev.currentTarget.getAttribute('data-icon'),
            color: ev.currentTarget.getAttribute('data-color')
        }));
    }

    function dragBrush(ev) {
        ev.dataTransfer.setData("text/plain", JSON.stringify({
            source: 'brush',
            type: ev.currentTarget.getAttribute('data-type'),
            value: ev.currentTarget.getAttribute('data-value'),
            color: ev.currentTarget.getAttribute('data-color'),
            label: ev.currentTarget.getAttribute('data-label')
        }));
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function setupCanvasDrop() {
        var canvas = $('#seatmap');
        
        canvas.on('dragover', function(e) {
            e.preventDefault();
        });

        canvas.on('drop', function(e) {
            e.preventDefault();
            var dataStr = e.originalEvent.dataTransfer.getData("text/plain");
            if (!dataStr) return;
            
            try {
                var data = JSON.parse(dataStr);
                
                if (data.source === 'canvas-object') {
                    var parentRect = document.getElementById('seatmap').getBoundingClientRect();
                    var dropX = e.originalEvent.clientX - parentRect.left;
                    var dropY = e.originalEvent.clientY - parentRect.top;
                    
                    dropX = Math.max(0, Math.min(dropX - 60, parentRect.width - 120));
                    dropY = Math.max(0, Math.min(dropY - 15, parentRect.height - 35));
                    
                    var xPct = (dropX / parentRect.width) * 100;
                    var yPct = (dropY / parentRect.height) * 100;
                    
                    var id = 'gate_' + Date.now();
                    createGateElement(id, data.type, data.label, data.icon, data.color, xPct.toFixed(2), yPct.toFixed(2));
                }
            } catch (err) {
                console.error("Drop error", err);
            }
        });
    }

    function dropOnSeat(ev) {
        ev.preventDefault();
        var dataStr = ev.dataTransfer.getData("text/plain");
        if (!dataStr) return;
        
        try {
            var data = JSON.parse(dataStr);
            if (data.source === 'brush') {
                var seatCell = $(ev.currentTarget);
                applyBrushToSeat(seatCell, data);
            }
        } catch (e) {
            console.error("Seat Drop error", e);
        }
    }

    // -------------------------------------------------------------
    // PAINT BRUSH MECHANICS (CLICK TO APPLY)
    // -------------------------------------------------------------
    function selectBrush(element) {
        var el = $(element);
        
        if (el.hasClass('active-brush')) {
            resetBrush();
            return;
        }

        $('.brush-item-box').removeClass('active-brush');
        el.addClass('active-brush');

        activeBrush = {
            type: el.data('type'),
            value: el.data('value'),
            color: el.data('color'),
            label: el.data('label')
        };

        $('#seatmap').addClass('paint-mode-active');
        $('#active_brush_banner').removeClass('d-none');
        $('#brush_banner_text').text('Active Tool: ' + activeBrush.label + ' (Esc to cancel)');
    }

    function resetBrush() {
        $('.brush-item-box').removeClass('active-brush');
        activeBrush = null;
        $('#seatmap').removeClass('paint-mode-active');
        $('#active_brush_banner').addClass('d-none');
    }

    function clickSeat(e, element) {
        if (e) e.stopPropagation();
        var seatCell = $(element);
        if (activeBrush) {
            applyBrushToSeat(seatCell, activeBrush);
        } else {
            selectObject(seatCell, 'seat');
        }
    }

    function applyBrushToSeat(seatCell, brush) {
        var seatId = seatCell.data('id');
        if (!seatId) return;

        if (brush.type === 'shape') {
            seatShapes[seatId] = brush.value;
            var iconClass = brush.value === 'sofa' ? 'fa-solid fa-couch' : 'fa-solid fa-chair';
            seatCell.find('.seat-icon i').attr('class', iconClass);
            return;
        }

        // Clear existing classes
        seatCell.removeClass('seatAvailable ReservedSeat DamagedSeat hiddenSeat noSeatStorage text-dark');
        @foreach($class_array as $type_id => $class_name)
            seatCell.removeClass('{{ $class_name }}');
        @endforeach

        // Reset styling
        seatCell.css({
            'background-color': '',
            'border-color': '',
            'border-width': '',
            'border-style': '',
            'color': ''
        });

        var currentShape = seatShapes[seatId] || 'chair';
        var iconClass = currentShape === 'sofa' ? 'fa-solid fa-couch' : 'fa-solid fa-chair';

        if (brush.type === 'status') {
            if (brush.value === 'show') {
                seatCell.addClass('seatAvailable text-dark');
                seatCell.css({
                    'background-color': '#ccffe2',
                    'border': '1.5px solid #01710c',
                    'color': '#01710c'
                });
                seatCell.find('.seat-icon').html('<i class="' + iconClass + '"></i>');
            } else if (brush.value === 'hide') {
                seatCell.addClass('hiddenSeat');
                seatCell.css({
                    'background-color': 'transparent',
                    'border-color': 'white',
                    'color': '#fff'
                });
                seatCell.find('.seat-icon').html('');
            } else if (brush.value === 'damaged') {
                seatCell.addClass('DamagedSeat');
                seatCell.css({
                    'background-color': '#ebebeb',
                    'border': '1.5px solid #5f5b5b',
                    'color': '#5f5b5b'
                });
                seatCell.find('.seat-icon').html('<i class="fa-solid fa-triangle-exclamation"></i>');
            } else if (brush.value === 'reserve') {
                seatCell.addClass('ReservedSeat');
                seatCell.css({
                    'background-color': '#fff',
                    'border': '3px solid #5f5b5b',
                    'color': '#5f5b5b'
                });
                seatCell.find('.seat-icon').html('<i class="' + iconClass + '"></i>');
            }
            
            seatUpdates[seatId] = { id: seatId, type: 'status', value: brush.value };
        } else if (brush.type === 'class') {
            var ticketClass = classMap[brush.value];
            seatCell.addClass(ticketClass);
            seatCell.css({
                'background-color': '#fff',
                'border': '2.5px solid ' + brush.color,
                'color': brush.color
            });
            seatCell.find('.seat-icon').html('<i class="' + iconClass + '"></i>');
            
            seatUpdates[seatId] = { id: seatId, type: 'class', value: brush.value };
        }
    }

    // -------------------------------------------------------------
    // SEAT RESIZING HANDLER
    // -------------------------------------------------------------
    function resizeSeat(e, id, diff) {
        if (e) e.stopPropagation();
        var seatEl = $(`.canvas-seat`).filter(function() { return $(this).data('id') == id || $(this).attr('data-id') == id; });
        if (!seatEl.length) return;
        
        var w = parseInt(seatEl.attr('data-w')) || parseInt(seatEl.css('width')) || 32;
        var h = parseInt(seatEl.attr('data-h')) || parseInt(seatEl.css('height')) || 32;
        
        var newW = w + diff;
        var newH = h + diff;
        
        newW = Math.max(20, Math.min(newW, 100));
        newH = Math.max(20, Math.min(newH, 100));
        
        seatEl.css({
            width: newW + 'px',
            height: newH + 'px'
        });
        
        seatEl.attr('data-w', newW);
        seatEl.attr('data-h', newH);
        seatEl.data('w', newW);
        seatEl.data('h', newH);
        
        seatEl.find('.seat-icon').css('font-size', (newW * 0.45) + 'px');
    }

    // -------------------------------------------------------------
    // UNIFIED SAVE LOGIC
    // -------------------------------------------------------------
    function save_designer_layout() {
        var updatedGates = [];
        $('.canvas-gate').each(function() {
            var gateEl = $(this);
            var id = gateEl.data('id');
            var type = gateEl.data('type');
            var label = gateEl.attr('title').replace(" (Click to select/drag)", "");
            var icon = gateEl.data('icon');
            var color = gateEl.data('color');
            var w = parseInt(gateEl.data('w'));
            var h = parseInt(gateEl.data('h'));
            
            var leftVal = gateEl.css('left');
            var topVal = gateEl.css('top');
            var xPct = parseFloat(leftVal);
            var yPct = parseFloat(topVal);
            
            if (leftVal.indexOf('px') !== -1 || topVal.indexOf('px') !== -1) {
                var parentRect = document.getElementById('seatmap').getBoundingClientRect();
                xPct = (xPct / parentRect.width) * 100;
                yPct = (yPct / parentRect.height) * 100;
            }
            
            updatedGates.push({
                id: id,
                type: type,
                label: label,
                icon: icon,
                color: color,
                x: xPct.toFixed(2),
                y: yPct.toFixed(2),
                w: w,
                h: h
            });
        });

        // B. Gather Seat Coordinates and Shapes
        var seatCoords = {};
        $('.canvas-seat').each(function() {
            var seatEl = $(this);
            var seatId = seatEl.data('id');
            var w = parseInt(seatEl.data('w'));
            var h = parseInt(seatEl.data('h'));
            
            var leftVal = seatEl.css('left');
            var topVal = seatEl.css('top');
            var xPct = parseFloat(leftVal);
            var yPct = parseFloat(topVal);
            
            if (leftVal.indexOf('px') !== -1 || topVal.indexOf('px') !== -1) {
                var parentRect = document.getElementById('seatmap').getBoundingClientRect();
                xPct = (xPct / parentRect.width) * 100;
                yPct = (yPct / parentRect.height) * 100;
            }
            
            var shape = 'chair';
            if (seatEl.find('.seat-icon i').hasClass('fa-couch')) {
                shape = 'sofa';
            }
            
            seatCoords[seatId] = {
                x: xPct.toFixed(2),
                y: yPct.toFixed(2),
                w: w,
                h: h,
                shape: shape
            };
        });

        var seatUpdatesArray = Object.values(seatUpdates);

        var saveBtn = $('button[onclick="save_designer_layout()"]');
        var originalBtnHtml = saveBtn.html();
        saveBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

        var unifiedMarkers = {
            gates: updatedGates,
            seat_coords: seatCoords,
            seat_shapes: seatShapes
        };

        var data = {
            _token: '{{ csrf_token() }}',
            layout_id: layoutId,
            markers: unifiedMarkers,
            seat_updates: seatUpdatesArray,
            event_ticket_id: '{{ $event_ticket->id }}',
            event_schedule_list_id: '{{ $esd_id }}',
            event_show_time_id: '{{ $est_id }}'
        };

        $.ajax({
            url: '{{ route('event_ticket.save_layout_designer') }}',
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.status === 'success') {
                    alert('Layout and seating updates saved successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + response.message);
                    saveBtn.prop('disabled', false).html(originalBtnHtml);
                }
            },
            error: function(err) {
                alert('Ajax error saving layout.');
                saveBtn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    }

    // -------------------------------------------------------------
    // DRAGGING SYSTEM (GATES, STRUCTURES & SEATS ON CANVAS)
    // -------------------------------------------------------------
    function setupDraggingHandlers() {
        var activeGate = null;
        var startX = 0, startY = 0;
        var startLeft = 0, startTop = 0;

        $(document).on('mousedown', '.canvas-gate, .canvas-seat', function(e) {
            // Prevent dragging if clicking hover controls or delete buttons
            if ($(e.target).closest('.gate-hover-controls, .seat-hover-controls, .gate-delete-btn, #object_action_menu').length) {
                return;
            }
            
            activeGate = this;
            var parent = document.getElementById('seatmap');
            var parentRect = parent.getBoundingClientRect();
            var rect = activeGate.getBoundingClientRect();
            
            startX = e.clientX;
            startY = e.clientY;
            
            startLeft = rect.left - parentRect.left;
            startTop = rect.top - parentRect.top;
            
            e.preventDefault();
        });

        $(document).on('mousemove', function(e) {
            if (!activeGate) return;
            
            var parent = document.getElementById('seatmap');
            var parentRect = parent.getBoundingClientRect();
            
            var dx = e.clientX - startX;
            var dy = e.clientY - startY;
            
            var newLeft = startLeft + dx;
            var newTop = startTop + dy;
            
            newLeft = Math.max(0, Math.min(newLeft, parentRect.width - activeGate.offsetWidth));
            newTop = Math.max(0, Math.min(newTop, parentRect.height - activeGate.offsetHeight));
            
            var leftPct = (newLeft / parentRect.width) * 100;
            var topPct = (newTop / parentRect.height) * 100;
            
            activeGate.style.left = leftPct.toFixed(2) + '%';
            activeGate.style.top = topPct.toFixed(2) + '%';
        });

        $(document).on('mouseup', function() {
            activeGate = null;
        });
    }
</script>
@endsection
