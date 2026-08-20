@extends('layouts.dashboard')

@section('title', 'Edit/Module')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Edit Module</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('module.index') }}">Modules</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                
                    <form action="{{ url('module/' . $module->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $module->name }}" name="name" placeholder="Name" autofocus="true"/>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="display_name">Display Name</label>
                                    <input type="text" class="form-control @error('display_name') is-invalid @enderror" value="{{ $module->display_name }}" name="display_name" placeholder="Display Name" />
                                    @error('display_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- -->
                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h4 class="mb-4"><strong>Permissions To Be Added</strong></h4>
                                    <div class="wrapper">
                                        @if($module['permissions'])
                                            @foreach($module['permissions'] as $permission)
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control mt-4 @error('name') is-invalid @enderror"  name="input_array_name[]" value="{{ $permission['name'] }}" placeholder="Permission Name" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control mt-4 @error('display_name') is-invalid @enderror"  name="input_array_display_name[]" value="{{ $permission['display_name'] }}" placeholder="Permission Display Name" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a href="javascript:void(0);" class="btn btn-danger remove_field mt-4">Remove</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror"  name="input_array_name[]" placeholder="Permission Name" />
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control @error('display_name') is-invalid @enderror"  name="input_array_display_name[]" placeholder="Permission Display Name" />
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="javascript:void(0);" class="btn btn-danger remove_field mt-4">Remove</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <p><button class="add_fields btn btn-primary pl-4 pr-4 mt-4">Add More Permission</button></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('module.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
</script>
<!-- -->
<script>
$(function()
{
    $('.add_fields').click(function(e)
    {
        e.preventDefault();
        $('.wrapper').append('<div class="row mt-4"><div class="col-md-4"><input type="text" class="form-control @error('name') is-invalid @enderror"  name="input_array_name[]" placeholder="Next Permission Name" /></div><div class="col-md-4"><input type="text" class="form-control @error('display_name') is-invalid @enderror"  name="input_array_display_name[]" placeholder="Next Permission Display Name" /></div><div class="col-md-4 text-left"><a href="javascript:void(0);" class="btn btn-danger remove_field">Remove</a></div></div>');
    });
    
    $('.wrapper').on("click",".remove_field", function(e)
    { 
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
    });
});
</script>

@endsection