@extends('layouts.dashboard')

@section('title', 'Add/Venue')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Add Photos</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('photo_gallery.index') }}">Photos List</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ route('photo_gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter name" autofocus required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sequence">Sequence <span class="required">*</span></label>
                                    <input type="number" class="form-control" name="sequence" value="{{ old('sequence') }}" placeholder="Enter Sequence" autofocus required>
                                    @error('sequence')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                    
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cover_image">Cover Image <span class="required">*</span></label>
                                    <input type="file" class="form-control" name="cover_img" accept="image/*" required>
                                    @error('cover_img')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <input type="submit" class="btn btn-primary pl-4 pr-4" value="Submit" />
                                <a href="{{ route('photo_gallery.index') }}" class="btn btn-info pl-4 pr-4">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection