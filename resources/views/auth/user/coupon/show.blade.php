@extends('layouts.dashboard')

@section('title', 'Show/Coupon')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Show Coupon</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('coupon.index') }}">Coupon</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Coupon Category</label>
                                <input type="text" class="form-control" value="{{ getCouponCategory($coupon->category_id)->name }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Coupon Code</label>
                                <input type="text" class="form-control" value="{{ $coupon->coupon_code }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Is Used</label>
                                <input type="text" class="form-control" value="{{ $coupon->is_used }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Status</label>
                                <input type="text" class="form-control" value="{{ $coupon->status }}" disabled="true" />
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('coupon.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection