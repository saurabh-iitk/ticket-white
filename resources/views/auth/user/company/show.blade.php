@extends('layouts.dashboard')

@section('title', 'Show/Company')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-pie-chart"></i> Show Company</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('company.index') }}">Company</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">State</label>
                                <input type="text" class="form-control" value="{{ getState($company->state_id)->name }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">City</label>
                                <input type="text" class="form-control" value="{{ getCity($company->city_id)->name }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Name</label>
                                <input type="text" class="form-control" value="{{ $company->name }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Address</label>
                                <input type="text" class="form-control" value="{{ $company->address }}" disabled="true" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Pincode</label>
                                <input type="text" class="form-control" value="{{ $company->pincode }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Email</label>
                                <input type="text" class="form-control" value="{{ $company->email }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Website</label>
                                <input type="text" class="form-control" value="{{ $company->website }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Contact Person</label>
                                <input type="text" class="form-control" value="{{ $company->contact_person }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">GST NO.</label>
                                <input type="text" class="form-control" value="{{ $company->gst_no }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Registered Address</label>
                                <input type="text" class="form-control" value="{{ $company->registered_address }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Category</label>
                                <input type="text" class="form-control" value="{{ $company->category }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Helpline</label>
                                <input type="text" class="form-control" value="{{ $company->helpline }}" disabled="true" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Logo</label>
                                <input type="text" class="form-control" value="{{ $company->logo }}" disabled="true" />
                                @if($company->logo)
                                    <br>
                                    <img src="{!! url('/').'/uploads/logo/'.$company->logo !!}" alt="img" class="img-responsive" style="height:100px;width:100px;" />
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="for">Description</label>
                                <input type="text" class="form-control" value="{{ $company->description }}" disabled="true" />
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Status</label>
                                <input type="text" class="form-control" value="{{ $company->status }}" disabled="true" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('company.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection