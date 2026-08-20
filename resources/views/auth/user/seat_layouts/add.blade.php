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
                    <form action="{{url('layout')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Venue <span class="required">*</span></label>
                                    <select class="form-control" name="venue_id" id="venue_id" autofocus="true" onchange="get_sub_venue_by_venue_id(this.value);">
                                        <option value="">Select Venue</option>
                                        @foreach($venues as $key => $venue)
                                        <option value="{{$venue->id}}">{{$venue->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Sub Venue <span class="required">*</span></label>
                                    <select class="form-control" name="sub_venue_id" id="sub_venue_id">
                                        <option value="">Select Sub Venue</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Layout Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="layout_name" id="layout_name" placeholder="Layout Name"/>
                                </div>
                            </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for">Default Layout <span class="required"></span></label>
                                    <input type="checkbox" value="YES" class="form-control" name="default_layout" id="" style="width:20%"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="for" class="mt-40"></label>
                                    <input type="submit" class="btn btn-primary pl-4 pr-4" value="Continue" />
                                </div>
                            </div>

                        </div>
                         

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Venue</th>
                                <th>Sub Venue</th>
                                <th>Layout Name</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th width="160px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($layouts)
                                @foreach($layouts as $key => $layout)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>@if(getVenue($layout->venue_id)){{ getVenue($layout->venue_id)->name }}@endif</td>
                                        <td>@if(getSubVenue($layout->sub_venue_id)){{ getSubVenue($layout->sub_venue_id)->name }}@endif</td>
                                        <td>{{ $layout->layout_name }}</td>
                                        <td>{{ $layout->status }}</td>
                                        <td>{{ nice_date($layout->created_at) }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ url('/layout/create/'.$layout->id) }}">View Seat Layout</a>
                                            @if(in_array('layout_update', Session::get('permissions')->toArray()))
                                            {{--<!-- <a class="btn btn-primary btn-sm" href="{{ route('layout.edit',$layout->id) }}">Edit</a> -->--}}
                                            @endif
                                            @if(in_array('layout_destroy', Session::get('permissions')->toArray()))
                                            <form action="{{ route('layout.destroy',$layout->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="confirm_delete();" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
<script>
$('#userTable').DataTable({
    'columnDefs': [ {
        'targets': [1],
        'orderable': false
    }]
});
</script>

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
</script>
@endsection