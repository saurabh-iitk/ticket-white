@extends('layouts.dashboard')

@section('title', 'Edit/Profile')

@section('css')
<style>
/* Enforce Blue Theme on Settings Page vertical tabs */
.user .user-tabs .nav-link {
    border: none !important;
    border-left: 3px solid transparent !important;
    padding: 12px 18px !important;
    font-size: 14.5px !important;
    font-weight: 500 !important;
    color: #475569 !important;
    border-radius: 0 !important;
    background: transparent !important;
    transition: all 0.2s ease;
}

.user .user-tabs .nav-link:hover {
    background-color: #f8fafc !important;
    color: #0f172a !important;
    border-left-color: #cbd5e1 !important;
}

.user .user-tabs .nav-link.active {
    background-color: #eff6ff !important;
    color: #2563eb !important;
    border-left-color: #2563eb !important;
    font-weight: 600 !important;
}

.user .tile {
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
    border-radius: 12px !important;
    overflow: hidden !important;
}
</style>
@endsection

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> {{ (request()->segment(3)=='profile') ? 'Edit Profile' : 'Edit Password' }} </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="#">Users</a></li>
        </ul>
    </div>
    <!-- include message -->
    @include('../../partials/message')
    <!-- include message -->
    <div class="row user">
        
        <div class="col-md-3">
          <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
              <li class="nav-item"><a class="nav-link {{ (request()->segment(3)=='profile') ? 'active' : '' }}" href="#user-profile" data-toggle="tab">Profile</a></li>
              <li class="nav-item"><a class="nav-link {{ (request()->segment(3)=='change_password') ? 'active' : '' }}" href="#user-password" data-toggle="tab">Change Password</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">

            <div class="tab-pane {{ (request()->segment(3)=='profile') ? 'active' : '' }}" id="user-profile">
				      <div class="tile user-settings">
	                <h4 class="line-head">Profile</h4>
                  <form action="{{ url('profile/update/'.$user->id) }}" method="POST">
                  @method('PUT')
                	@csrf
	                  	<div class="row">
		                    <div class="col-md-8 mb-4">
		                      <label>Name</label>
		                      <input class="form-control" type="text" value="{{ $user->name }}" name="name" placeholder="Name">
		                    </div>
		                    <div class="clearfix"></div>
                        <div class="col-md-8 mb-4">
                          <label>Mobile No.</label>
                          <input class="form-control" type="text" value="{{ $user->mobile }}" name="mobile" placeholder="Mobile No.">
                        </div>
                        <div class="clearfix"></div>
		                    <div class="col-md-8 mb-4">
		                      <label>Email</label>
		                      <input class="form-control" type="text" value="{{ $user->email }}" name="email" placeholder="Email">
		                    </div>
		                    <div class="clearfix"></div>
	                  	</div>
                  		<div class="row mb-10">
		                    <div class="col-md-12">
		                      <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
		                    </div>
                  		</div>
                  </form>
	            </div>
            </div>

            <div class="tab-pane fade {{ (request()->segment(3)=='change_password') ? 'active show' : '' }}" id="user-password">
              <div class="tile user-settings">
                <h4 class="line-head">Change Password</h4>
                <form action="{{ url('password/update/'.$user->id) }}" method="POST">
                @method('PUT')
                @csrf
                  
                	<div class="row">
                    <div class="col-md-8 mb-4">
                      <label>Old Password</label>
                      <input type="password" class="form-control" name="old_password" placeholder="Old Password">
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-8 mb-4">
                      <label>New Password</label>
                      <input type="password" class="form-control" name="new_password" placeholder="New Password">
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-8 mb-4">
                      <label>Confirm Password</label>
                      <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                    </div>
                    <div class="clearfix"></div>
                	</div>
                	<div class="row mb-10">
                    <div class="col-md-12">
                      <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                    </div>
                	</div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>

</main>
@endsection