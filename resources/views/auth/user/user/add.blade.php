@extends('layouts.dashboard')

@section('title', 'Add/User')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Add User</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">Users</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ url('user') }}" method="POST">
                        @csrf
                    
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" autofocus="true" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mobile">Mobile No.</label>
                                    <input type="text" class="form-control" name="mobile" placeholder="Mobile No." autofocus="true" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role_id" class="form-control">
                                        <option value="" disabled selected>Please select Role ...</option>
                                        @foreach($roles as $role_id => $role_name)
                                            <option value="{{ $role_name->id }}">{{ $role_name->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <?php 
                            $payment_methods = $payment_methods->pluck('name', 'id');
                            ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_methods">Payment Method Not Allowed for Ticket Booking</label>
                                    <select name="payment_methods" class="form-control" multiple="multiple">
                                        @foreach($payment_methods as $id => $name)
                                            <option value="{{ $id }}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="reserve_unreserve">Reserve / Unreserve</label>
                                    <input type="checkbox" class="form-control" name="reserve_unreserve" style="margin-left:-42%" />
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="remove_unremoved">Remove / Unremove & Seat Arrangement</label>
                                    <input type="checkbox" class="form-control" name="remove_unremoved" style="margin-left:-42%"/>
                                </div>
                            </div>

                    
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="res_unres_dmg_hide">All Action (Reserve / Hide / DMG)</label>
                                    <input type="checkbox" class="form-control" name="res_unres_dmg_hide" style="margin-left:-42%" />
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('user.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $('#payment_methods').select2();
</script>
@endsection