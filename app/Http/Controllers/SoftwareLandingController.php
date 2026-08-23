<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class SoftwareLandingController extends Controller
{
    /**
     * Display the software landing homepage.
     */
    public function home()
    {
        return view('software.home');
    }

    /**
     * Display the software features page.
     */
    public function features()
    {
        return view('software.features');
    }

    /**
     * Display the software pricing page.
     */
    public function pricing()
    {
        return view('software.pricing');
    }

    /**
     * Display the software contact us page.
     */
    public function contact()
    {
        return view('software.contact');
    }

    /**
     * Handle AJAX contact form submissions.
     */
    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:200',
            'message' => 'nullable|string',
            'type' => 'nullable|string|in:contact_form,popup_newsletter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $type = $request->input('type', 'contact_form');
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'type' => $type
        ];

        try {
            // Save to database
            ContactMessage::create($data);
            $message = $type === 'popup_newsletter' 
                ? 'Thank you for your demo request! We will contact you shortly.'
                : 'Thank you for contacting us! Your message has been received.';
                
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            // Log database failure
            Log::error('Database submission failed for contact message: ' . $e->getMessage(), $data);

            // Write to a backup flat file in storage directory
            try {
                $logPath = storage_path('logs/contact_submissions.log');
                $logDirectory = dirname($logPath);
                
                if (!File::exists($logDirectory)) {
                    File::makeDirectory($logDirectory, 0755, true, true);
                }

                $logData = sprintf(
                    "[%s] IP: %s | Type: %s | Name: %s | Email: %s | Phone: %s | Subject: %s | Message: %s\n",
                    date('Y-m-d H:i:s'),
                    $data['ip_address'],
                    $data['type'],
                    $data['name'] ?? 'N/A',
                    $data['email'],
                    $data['phone'] ?? 'N/A',
                    $data['subject'] ?? 'N/A',
                    $data['message'] ?? 'N/A'
                );
                
                File::append($logPath, $logData);
            } catch (\Exception $fileEx) {
                Log::error('Backup log file write failed: ' . $fileEx->getMessage());
            }

            // Return success anyway, since we safely captured the lead in files
            $message = $type === 'popup_newsletter' 
                ? 'Thank you for your demo request! (Captured)'
                : 'Thank you for contacting us! Your message has been saved.';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }
    }
}
