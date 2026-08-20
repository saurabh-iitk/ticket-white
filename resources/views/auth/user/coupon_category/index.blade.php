@extends('layouts.dashboard')

@section('title', 'Coupon Category')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Coupon Category List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('coupon_category.index') }}">Coupon Categories</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    @if(in_array('coupon_category_store', Session::get('permissions')->toArray()))
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <a href="{{ URL::to('coupon_category/create') }}" class="btn btn-info pl-5 pr-5">Add</a>
                        </div>
                    </div>
                    @endif
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Name</th>
                                <th>Discount Value</th>
                                <th>Valid From</th>
                                <th>Valid Till</th>
                                <th>Status</th>
                                <th width="180px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($coupon_categories)
                                @foreach($coupon_categories as $coupon_category)
                                    <tr>
                                        <td>@if(getEvent($coupon_category->event_id)){{ getEvent($coupon_category->event_id)->event_title }}@endif</td>
                                        <td>{{ $coupon_category->name }}</td>
                                        <td>{{ $coupon_category->discount_value }}</td>
                                        <td>{{ nice_date($coupon_category->valid_from) }}</td>
                                        <td>{{ nice_date($coupon_category->valid_till) }}</td>
                                        <td>{{ $coupon_category->status }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('coupon_category.show',$coupon_category->id) }}">View Details</a>
                                            @if(in_array('coupon_category_update', Session::get('permissions')->toArray()))
                                            <a class="btn btn-primary btn-sm" href="{{ route('coupon_category.edit',$coupon_category->id) }}">Edit</a>
                                            @endif
                                            @if(in_array('coupon_category_destroy', Session::get('permissions')->toArray()))
                                            <form action="{{ route('coupon_category.destroy',$coupon_category->id) }}" method="POST" style="display:inline-block;">
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
@endsection