<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class ImageController extends Controller
{
    public function generateImage(Request $request)
    {
        $url = $request->input('url'); 
        $booking_id = $request->input('booking_id');
        $imagePath = 'public/images/bookings/'.$booking_id.'.png';
        Browsershot::url($url)->windowSize(1920, 1080)->save($imagePath);
        return response()->json(['message' => 'Image generated successfully!', 'path' => $imagePath]);
    }
}
?>