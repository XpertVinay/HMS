<?php

namespace App\Services;

use Razorpay\Api\Api;
use Exception;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $keyId = config('razorpay.key');
        $keySecret = config('razorpay.secret');
        
        if ($keyId && $keySecret) {
            $this->api = new Api($keyId, $keySecret);
        }
    }

    /**
     * Create a new Razorpay Order.
     *
     * @param float $amount Amount in INR
     * @param string $receiptId A unique receipt ID
     * @return \Razorpay\Api\Order
     */
    public function createOrder($amount, $receiptId)
    {
        if (!$this->api) {
            throw new Exception("Razorpay API not configured properly.");
        }

        $orderData = [
            'receipt'         => $receiptId,
            'amount'          => $amount * 100, // Amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        return $this->api->order->create($orderData);
    }

    /**
     * Verify the Razorpay payment signature.
     *
     * @param string $razorpayOrderId
     * @param string $razorpayPaymentId
     * @param string $razorpaySignature
     * @return bool
     */
    public function verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature)
    {
        if (!$this->api) {
            throw new Exception("Razorpay API not configured properly.");
        }

        $attributes = [
            'razorpay_order_id'   => $razorpayOrderId,
            'razorpay_payment_id' => $razorpayPaymentId,
            'razorpay_signature'  => $razorpaySignature
        ];

        try {
            $this->api->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            return false;
        }
    }
}
