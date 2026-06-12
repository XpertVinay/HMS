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
        $industries = \App\Models\Industry::where('is_active', true)->with('features')->get();
        return view('auth.register', compact('industries'));
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
            'industry_id' => 'required|exists:industries,id',
            'features' => 'nullable|array',
            'features.*' => 'exists:industry_features,id',
        ]);

        $industry = \App\Models\Industry::findOrFail($request->industry_id);
        $baseFee = (float) $industry->base_fee;
        $featureFee = 0;

        if ($request->has('features') && is_array($request->features)) {
            $featureFee = (float) \App\Models\IndustryFeature::whereIn('id', $request->features)->sum('price');
        }

        $totalFeeAmount = $baseFee + $featureFee;

        $pending = \App\Models\PendingRwaRegistration::create([
            'org_name' => $request->org_name,
            'org_address' => $request->org_address,
            'registration_code' => $request->registration_code,
            'subdomain' => $request->subdomain,
            'admin_username' => $request->admin_username,
            'admin_first_name' => $request->admin_first_name,
            'admin_last_name' => $request->admin_last_name,
            'admin_email' => $request->admin_email,
            'admin_password' => Hash::make($request->admin_password),
            'industry_id' => $industry->id,
            'selected_features' => $request->features ?? [],
            'platform_fee' => $baseFee,
            'feature_fee' => $featureFee,
            'fee_amount' => $totalFeeAmount,
            'status' => 'pending_payment',
        ]);

        $razorpayService = new \App\Services\RazorpayService();
        $order = $razorpayService->createOrder($totalFeeAmount, 'RWA_REG_' . $pending->id);

        return view('payment.checkout', [
            'orderId' => $order->id,
            'amount' => $totalFeeAmount,
            'callbackUrl' => route('register.payment_callback', ['pending_id' => $pending->id]),
            'name' => $request->org_name,
            'email' => $request->admin_email,
            'description' => 'RWA Registration Fee'
        ]);
    }

    /**
     * Handle Razorpay payment callback for registration.
     */
    public function paymentCallback(Request $request)
    {
        $pendingId = $request->query('pending_id');
        $razorpayPaymentId = $request->razorpay_payment_id;
        $razorpayOrderId = $request->razorpay_order_id;
        $razorpaySignature = $request->razorpay_signature;

        $razorpayService = new \App\Services\RazorpayService();
        $isValid = $razorpayService->verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature);

        if (!$isValid) {
            return redirect()->route('register')->withErrors(['payment' => 'Payment verification failed. Please try again.']);
        }

        $pending = \App\Models\PendingRwaRegistration::findOrFail($pendingId);

        if ($pending->status === 'converted') {
            return redirect()->route('login')->with('success', 'Registration already completed.');
        }

        DB::transaction(function () use ($pending, $razorpayOrderId, $razorpayPaymentId) {
            $org = Organization::create([
                'name' => $pending->org_name,
                'address' => $pending->org_address,
                'registration_code' => $pending->registration_code,
                'subdomain' => $pending->subdomain,
                'industry_id' => $pending->industry_id,
                'selected_features' => $pending->selected_features,
                'platform_fee' => $pending->platform_fee,
                'feature_fee' => $pending->feature_fee,
                'status' => 'pending',
            ]);

            Admin::create([
                'username' => $pending->admin_username,
                'first_name' => $pending->admin_first_name,
                'last_name' => $pending->admin_last_name,
                'email' => $pending->admin_email,
                'password' => $pending->admin_password, // Already hashed
                'organization_id' => $org->id,
                'role' => 'admin',
            ]);

            // Assign Roles and Permissions based on Industry Presets
            $industryPresets = \App\Models\IndustryRolePreset::where('industry_id', $org->industry_id)->get();
            foreach ($industryPresets as $preset) {
                $role = \Spatie\Permission\Models\Role::firstOrCreate([
                    'name' => $preset->role_name,
                    'guard_name' => 'web',
                    'organization_id' => $org->id,
                ]);

                if (!empty($preset->default_permissions)) {
                    // Find matching global permissions
                    $permissions = \Spatie\Permission\Models\Permission::whereNull('organization_id')
                        ->whereIn('name', $preset->default_permissions)
                        ->get();
                    $role->syncPermissions($permissions);
                }
            }

            // Fallback: If no preset was created for 'admin', create it.
            $adminRole = \Spatie\Permission\Models\Role::firstOrCreate([
                'name' => 'admin',
                'guard_name' => 'web',
                'organization_id' => $org->id,
            ]);

            $pending->update(['status' => 'converted']);

            \App\Models\Payment::create([
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId,
                'amount' => $pending->fee_amount,
                'status' => 'success',
                'type' => 'rwa_registration',
                'reference_id' => $pending->id,
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Payment successful! Registration submitted and your organization is pending approval.');
    }
}
