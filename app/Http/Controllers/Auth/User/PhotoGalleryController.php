<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = PhotoGallery::all();
        // dd($photos);
        return view('auth.user.photo_gallery.index', compact('photos')); // Change 'photo_gallery' to 'photos'
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.user.photo_gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sequence' => 'required|int|max:255',
            'cover_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image types
        ]);

        // Handle file upload
        if ($request->hasFile('cover_img')) {
            $image = $request->file('cover_img');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Unique name for the image
            $image->move(public_path('images'), $imageName); // Store the image in the public/images directory
            $validated['cover_img'] = $imageName; // Save the file name in the validated array
        }

        // Create the photo entry in the database
        PhotoGallery::create($validated);

        return redirect()->route('photo_gallery.index')->with('success', 'Photo added successfully');
    }



    /**
     * Display the specified resource.
     */
    public function show(PhotoGallery $photos)
    {
        return view('auth.user.photo_gallery.show', compact('photos'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhotoGallery $photos)
    {
        return view('auth.user.photo_gallery.edit', compact('photos'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhotoGallery $photos)
    {
        // Validate the inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sequence' => 'required|int|max:255',
            'cover_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image upload is optional
        ]);
    
        // Handle file upload if a new image is provided
        if ($request->hasFile('cover_img')) {
            $image = $request->file('cover_img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
    
            // Delete the old image file if it exists
            if ($photos->cover_img && file_exists(public_path('images/' . $photos->cover_img))) {
                unlink(public_path('images/' . $photos->cover_img));
            }
    
            $photos->cover_img = $imageName;
        }
    
        // Update other fields
        $photos->name = $validated['name'];
        $photos->sequence = $validated['sequence'];
        $photos->save();
    
        return redirect()->route('photo_gallery.index')->with('success', 'Photo gallery updated successfully.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhotoGallery $photos)
    {
        // Delete the associated image file if it exists
        if ($photos->cover_img && file_exists(public_path('images/' . $photos->cover_img))) {
            unlink(public_path('images/' . $photos->cover_img));
        }
    
        // Delete the record
        $photos->delete();
    
        return redirect()->route('photo_gallery.index')->with('success', 'Photo gallery deleted successfully.');
    }
}