<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusinzoContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|alpha|min:3|max:255',
            'last_name' => 'nullable|string|alpha|min:3|max:255',
            'email' => 'required|email:rfc,dns|min:3|max:255',
            'service' => 'nullable|string|in:web,mobile,ai,custom,consulting|min:3|max:255',
            'message' => 'required|string|max:1000|regex:/^[a-zA-Z0-9\s.,\'#-]{3,1000}$/',
        ]);

        Contacts::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'service' => $validated['service'],
            'message' => $validated['message'],
        ]);

        // Here we could send an email or store in DB.
        // For now, we will log it and return success.
        Log::info('Businzo Contact Submission: ', $validated);

        return redirect()->back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you shortly.');
    }
}
