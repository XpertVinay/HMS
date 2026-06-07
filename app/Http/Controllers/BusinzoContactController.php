<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusinzoContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'service' => 'nullable|string',
            'message' => 'required|string',
        ]);

        // Here we could send an email or store in DB.
        // For now, we will log it and return success.
        Log::info('Businzo Contact Submission: ', $validated);

        return redirect()->back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you shortly.');
    }
}
