@extends('layouts.dashboard')

{{-- @section('title', 'Venue') --}}

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-star-o"></i> Photos Gallery</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="{{ route('photo_gallery.index') }}">Photos Gallery List</a></li>
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
                            <a href="{{ route('photo_gallery.create') }}" class="btn btn-info pl-5 pr-5">Add</a>
                        </div>
                    </div>
                    {{-- @endif --}}
                    <table class="table table-hover table-bordered" id="userTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Sequence No.</th>
                                <th>Cover Image</th>
                                {{-- <th>Name</th>
                                <th>Parking</th>
                                <th>Type</th>
                                <th>Status</th> --}}
                                <th width="180px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($photos)

                                @foreach($photos as $photo)
                                    <tr>
                                        <td>{{ $photo->name }}</td>
                                        <td>{{ $photo->sequence }}</td>
                                        <td><img src="{{ asset('images/' . $photo->cover_img) }}" alt="{{ $photo->name }}" width="100"></td>
                                        <td class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('photo_gallery.show', $photo->id) }}">View Details</a>
                                            {{-- @if(in_array('photos_update', Session::get('permissions')->toArray())) --}}
                                            <a class="btn btn-primary btn-sm" href="{{ route('photo_gallery.edit', $photo->id) }}">Edit</a>
                                            {{-- @endif --}}
                                            {{-- @if(in_array('photos_destroy', Session::get('permissions')->toArray())) --}}
                                            <form action="{{ route('photo_gallery.destroy', $photo->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="confirm_delete();" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                            {{-- @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
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
$('#userTable').DataTable({
    'columnDefs': [ {
        'targets': [1],
        'orderable': false
    }]
});
</script>
@endsection