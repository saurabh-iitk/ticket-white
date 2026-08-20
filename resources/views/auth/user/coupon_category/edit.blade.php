@extends('layouts.dashboard')

@section('title', 'Edit/Coupon Category')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star"></i> Edit Coupon Category</h1>
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
                    <form action="{{ url('coupon_category/' . $coupon_category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Event <span class="required">*</span></label>
                                    <select class="form-control" name="event_id" id="event_id" autofocus="true">
                                        <option value="">Select Event</option>
                                        @foreach($events as $key => $event)
                                        <option value="{{$event->id}}" <?php if($coupon_category->event_id==$event->id){ echo 'selected';} ?>>{{$event->event_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $coupon_category->name }}" name="name" placeholder="Name" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Discount Value</label>
                                    <input type="number" class="form-control" value="{{ $coupon_category->discount_value }}" name="discount_value" placeholder="Discount Value" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Discount Unit</label>
                                    <input type="number" class="form-control" value="{{ $coupon_category->discount_unit }}" name="discount_unit" placeholder="Discount Unit" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Valid From <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $coupon_category->valid_from }}" name="valid_from" id="start_date" placeholder="Valid From" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Valid Till <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{ $coupon_category->valid_till }}" name="valid_till" id="end_date" placeholder="Valid Till" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Max Order Value</label>
                                    <input type="number" class="form-control" value="{{ $coupon_category->max_order_value }}" name="max_order_value" placeholder="Max Order Value" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Max Discount Value</label>
                                    <input type="number" class="form-control" value="{{ $coupon_category->max_discount_value }}" name="max_discount_value" placeholder="Max Discount Value" autofocus="true" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="for">Is Redeemable</label>
                                    <select class="form-control" name="is_redeemable">
                                        <option value="YES" <?php if($coupon_category->is_redeemable=='YES'){ echo 'selected';} ?>>YES</option>
                                        <option value="NO" <?php if($coupon_category->is_redeemable=='NO'){ echo 'selected';} ?>>NO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="role">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="ACTIVE" <?php if($coupon_category->status=='ACTIVE'){ echo 'selected';} ?>>ACTIVE</option>
                                        <option value="INACTIVE" <?php if($coupon_category->status=='INACTIVE'){ echo 'selected';} ?>>INACTIVE</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('coupon_category.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
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
@endsection