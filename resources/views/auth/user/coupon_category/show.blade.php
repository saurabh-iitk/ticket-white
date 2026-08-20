@extends('layouts.dashboard')

@section('title', 'Show/Coupon Category')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Show Coupon Category</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('coupon_category.index') }}">Coupon Category</a></li>
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
                                <input type="text" class="form-control" value="{{ getEvent($coupon_category->event_id)->event_title }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" value="{{ $coupon_category->name }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Discount Value</label>
                                <input type="text" class="form-control" value="{{ $coupon_category->discount_value }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Discount Unit</label>
                                <input type="text" class="form-control" value="{{ $coupon_category->discount_unit }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Valid From</label>
                                <input type="text" class="form-control" value="{{ nice_date($coupon_category->valid_from) }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Valid Till</label>
                                <input type="text" class="form-control" value="{{ nice_date($coupon_category->valid_till) }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Max Order Value</label>
                                <input type="text" class="form-control" value="{{ $coupon_category->max_order_value }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Max Discount Value</label>
                                <input type="text" class="form-control" value="{{ $coupon_category->max_discount_value }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Is Redeemable</label>
                                <input type="text" class="form-control" value="{{ $coupon_category->is_redeemable }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Status</label>
                                <input type="text" class="form-control" value="{{ $coupon_category->status }}" disabled="true" />
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('coupon_category.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection