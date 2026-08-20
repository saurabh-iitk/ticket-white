<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\PhotoContent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PhotoGallery;

class PhotoContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = PhotoContent::all();
        return view('auth.user.photo_content.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $photoGalleries = PhotoGallery::all();
        return view('auth.user.photo_content.create', compact('photoGalleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'gallery_id' => 'required|exists:photo_gallery,id',
            'name' => 'required|string|max:255',
            'sequence' => 'required|integer',
            'cover_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the file upload
        if ($request->hasFile('cover_img')) {
            $file = $request->file('cover_img');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
        } else {
            $filename = null;
        }

        // Create a new photo content record
        $photoContent = new PhotoContent();
        $photoContent->gallery_id = $validatedData['gallery_id'];
        $photoContent->name = $validatedData['name'];
        $photoContent->sequence = $validatedData['sequence'];
        $photoContent->cover_img = $filename;
        $photoContent->save();

        // Redirect to the photo content index page with a success message
        return redirect()->route('photo_content.index')->with('success', 'Photo content added successfully.');
    }

    public function show(string $id)
    {
        $photoContent = PhotoContent::findOrFail($id);
        return view('auth.user.photo_content.show', compact('photoContent'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $photoContent = PhotoContent::findOrFail($id);
        $photoGalleries = PhotoGallery::all();
        return view('auth.user.photo_content.edit', compact('photoContent', 'photoGalleries'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'gallery_id' => 'required|exists:photo_gallery,id',
            'name' => 'required|string|max:255',
            'sequence' => 'required|integer',
            'cover_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $photoContent = PhotoContent::findOrFail($id);
    
        // Handle the file upload
        if ($request->hasFile('cover_img')) {
            $file = $request->file('cover_img');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
    
            // Delete the old image if exists
            if ($photoContent->cover_img && file_exists(public_path('images/' . $photoContent->cover_img))) {
                unlink(public_path('images/' . $photoContent->cover_img));
            }
    
            $photoContent->cover_img = $filename;
        }
    
        // Update the photo content record
        $photoContent->gallery_id = $validatedData['gallery_id'];
        $photoContent->name = $validatedData['name'];
        $photoContent->sequence = $validatedData['sequence'];
        $photoContent->save();
    
        // Redirect to the photo content index page with a success message
        return redirect()->route('photo_content.index')->with('success', 'Photo content updated successfully.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photoContent = PhotoContent::findOrFail($id);
    
        // Delete the associated image file if it exists
        if ($photoContent->cover_img && file_exists(public_path('images/' . $photoContent->cover_img))) {
            unlink(public_path('images/' . $photoContent->cover_img));
        }
    
        $photoContent->delete();
    
        // Redirect to the photo content index page with a success message
        return redirect()->route('photo_content.index')->with('success', 'Photo content deleted successfully.');
    }
}