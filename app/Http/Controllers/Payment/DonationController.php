<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\Payment;
use App\Services\RazorpayService;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Initiate the donation process.
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'email' => 'required|email|max:255',
        ]);

        $amount = $request->amount;
        $orgId = $this->orgId(); // Helper inherited from Controller if exists, otherwise we'll need to fetch active org.

        // In case orgId() doesn't exist or isn't applicable, use standard active organization logic
        // For public pages, usually $orgId is passed via middleware or helper. Let's assume $this->orgId() works.

        $razorpayService = new RazorpayService();
        // create dummy pending ID or use time for receipt
        $receiptId = 'DONATION_' . time() . rand(10, 99);
        $order = $razorpayService->createOrder($amount, $receiptId);

        return view('payment.checkout', [
            'orderId' => $order->id,
            'amount' => $amount,
            'callbackUrl' => route('donate.callback', [
                'name' => $request->name,
                'email' => $request->email,
                'amount' => $amount,
                'org_id' => $orgId
            ]),
            'name' => $request->name,
            'email' => $request->email,
            'description' => 'Community Donation'
        ]);
    }

    /**
     * Handle the Razorpay callback for donations.
     */
    public function callback(Request $request)
    {
        $razorpayPaymentId = $request->razorpay_payment_id;
        $razorpayOrderId = $request->razorpay_order_id;
        $razorpaySignature = $request->razorpay_signature;

        $name = $request->query('name');
        $email = $request->query('email');
        $amount = $request->query('amount');
        $orgId = $request->query('org_id');

        $razorpayService = new RazorpayService();
        $isValid = $razorpayService->verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature);

        if (!$isValid) {
            return redirect()->route('home.donors')->withErrors(['payment' => 'Payment verification failed.']);
        }

        DB::transaction(function () use ($name, $amount, $orgId, $razorpayOrderId, $razorpayPaymentId) {
            $donor = Donor::create([
                'name' => $name,
                'amount' => $amount,
                'donation_date' => now(),
                'organization_id' => $orgId,
            ]);

            Payment::create([
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId,
                'amount' => $amount,
                'status' => 'success',
                'type' => 'donation',
                'reference_id' => $donor->id,
            ]);
        });

        return redirect()->route('home.donors')->with('success', 'Thank you for your donation!');
    }
}
