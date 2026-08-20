@extends('layouts.dashboard')

@section('title', 'Photo Gallery List')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Photo Gallery List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('photo_gallery.index') }}">Photo Gallery List</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- include message -->
            @include('../../partials/message')
            <!-- include message -->
            <div class="tile">
                <div class="tile-body">
                    {{-- @if(in_array('photos_store', Session::get('permissions')->toArray())) --}}
                    <div class="row">
                        <div class="col-md-12 pb-4 text-right">
                            <a href="{{ route('photo_content.create') }}" class="btn btn-info pl-5 pr-5">Add Photo Content</a>
                        </div>
                    </div>
                    {{-- @endif --}}
                    <table class="table table-hover table-bordered" id="photoTable">
                        <thead>
                            <tr>
                                <th>Gallery ID</th>
                                <th>Name</th>
                                <th>Sequence No.</th>
                                <th>Image Name</th>
                                <th width="180px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($photos->count())
                                @foreach($photos as $photo)
                                    <tr>
                                        <td>{{ $photo->gallery ? $photo->gallery->id : 'N/A' }}</td>
                                        <td>{{ $photo->name }}</td>
                                        <td>{{ $photo->sequence }}</td>
                                        <td><img src="{{ asset('images/' . $photo->cover_img) }}" alt="{{ $photo->imageName }}" width="100"></td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('photo_content.show', $photo->id) }}">View Details</a>
                                            {{-- @if(in_array('photos_update', Session::get('permissions')->toArray())) --}}
                                            <a class="btn btn-primary btn-sm" href="{{ route('photo_content.edit', $photo->id) }}">Edit</a>
                                            {{-- @endif --}}
                                            {{-- @if(in_array('photos_destroy', Session::get('permissions')->toArray())) --}}
                                            <form action="{{ route('photo_content.destroy', $photo->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="confirm_delete();" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                            {{-- @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No photos found</td>
                                </tr>
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
$('#photoTable').DataTable({
    'columnDefs': [ {
        'targets': [3],
        'orderable': false
    }]
});
</script>
@endsection