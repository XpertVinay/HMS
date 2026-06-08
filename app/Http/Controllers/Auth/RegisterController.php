<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Show RWA/Organization registration form.
     */
    public function showForm()
    {
        return view('auth.register');
    }

    /**
     * Handle RWA registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'org_address' => 'required|string',
            'registration_code' => 'required|string|max:100|unique:organizations,registration_code',
            'subdomain' => 'required|string|max:100|unique:organizations,subdomain|alpha_dash',
            'admin_username' => 'required|string|max:50',
            'admin_first_name' => 'nullable|string|max:100',
            'admin_last_name' => 'nullable|string|max:100',
            'admin_email' => 'required|email|max:50',
            'admin_password' => 'required|string|min:6|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $org = Organization::create([
                'name' => $request->org_name,
                'address' => $request->org_address,
                'registration_code' => $request->registration_code,
                'subdomain' => $request->subdomain,
                'status' => 'pending',
            ]);

            Admin::create([
                'username' => $request->admin_username,
                'first_name' => $request->admin_first_name,
                'last_name' => $request->admin_last_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'organization_id' => $org->id,
                'role' => 'admin',
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Registration submitted! Your organization is pending approval.');
    }
}
