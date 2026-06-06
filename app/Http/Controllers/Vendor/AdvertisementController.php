<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorAdvertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        $vendorId = session('vid');
        $advertisements = VendorAdvertisement::where('vendor_id', $vendorId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('vendor.advertisements.index', compact('advertisements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_url' => 'nullable|url',
        ]);

        $vendorId = session('vid');

        VendorAdvertisement::create([
            'vendor_id' => $vendorId,
            'title' => $request->title,
            'description' => $request->description,
            'target_url' => $request->target_url,
            'status' => 'pending',
            'advertisement_fee' => 10.00,
        ]);

        return redirect()->back()->with('success', 'Advertisement submitted for approval.');
    }
}
