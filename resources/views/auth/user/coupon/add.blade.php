@extends('layouts.dashboard')

@section('title', 'Add/Coupon')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Add Coupon</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('coupon.index') }}">Coupons</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('coupon') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Coupon Category <span class="required">*</span></label>
                                    <select class="form-control" name="category_id" id="category_id" autofocus="true">
                                        <option value="">Select Coupon Category</option>
                                        @foreach($coupon_categories as $key => $coupon_category)
                                        <option value="{{$coupon_category->id}}">{{$coupon_category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Coupon Code <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="coupon_code" placeholder="Coupon Code" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Is Used</label>
                                    <select class="form-control" name="is_used">
                                        <option value="NO">NO</option>
                                        <option value="YES">YES</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('coupon.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection