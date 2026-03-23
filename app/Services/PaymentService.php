<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Exception;

class PaymentService
{
    protected $demoMode = false;

    public function __construct()
    {
        $stripeKey = config('services.stripe.secret');
        
        // Check if we're in demo mode (no API key or test key placeholder)
        if (empty($stripeKey) || $stripeKey === 'your_stripe_secret_key' || str_starts_with($stripeKey, 'sk_test_placeholder')) {
            $this->demoMode = true;
            return;
        }
        
        Stripe::setApiKey($stripeKey);
    }

    /**
     * Check if we're in demo mode
     */
    public function isDemoMode(): bool
    {
        return $this->demoMode;
    }

    /**
     * Create a payment intent for a booking
     */
    public function createPaymentIntent(Booking $booking, array $paymentMethodData = null)
    {
        // Demo mode - simulate successful payment
        if ($this->demoMode) {
            return $this->createDemoPaymentIntent($booking);
        }

        try {
            $amount = ($booking->total_price ?? $booking->total_amount ?? 0) * 100; // Convert to cents

            $paymentIntentData = [
                'amount' => $amount,
                'currency' => strtolower($booking->currency ?? 'usd'),
                'metadata' => [
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'property_id' => $booking->property_id,
                ],
                'description' => "Booking for " . ($booking->property->title ?? 'Property'),
            ];

            if ($paymentMethodData) {
                $paymentIntentData['payment_method_data'] = $paymentMethodData;
                $paymentIntentData['confirm'] = true;
                $paymentIntentData['return_url'] = route('booking.confirmation', $booking);
            }

            $paymentIntent = PaymentIntent::create($paymentIntentData);

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'payment_method' => 'stripe',
                'payment_provider_id' => $paymentIntent->id,
                'amount' => $booking->total_price ?? $booking->total_amount ?? 0,
                'currency' => strtoupper($booking->currency ?? 'USD'),
                'status' => 'pending',
                'payment_details' => [
                    'client_secret' => $paymentIntent->client_secret,
                ],
            ]);

            return [
                'payment_intent' => $paymentIntent,
                'payment' => $payment,
                'client_secret' => $paymentIntent->client_secret,
            ];

        } catch (Exception $e) {
            throw new Exception('Failed to create payment intent: ' . $e->getMessage());
        }
    }

    /**
     * Create a demo payment intent for testing
     */
    protected function createDemoPaymentIntent(Booking $booking)
    {
        $amount = $booking->total_price ?? $booking->total_amount ?? 0;
        $demoPaymentIntentId = 'demo_pi_' . time() . '_' . $booking->id;
        
        // Create payment record for demo
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'payment_method' => 'demo',
            'payment_provider_id' => $demoPaymentIntentId,
            'amount' => $amount,
            'currency' => strtoupper($booking->currency ?? 'USD'),
            'status' => 'pending',
            'payment_details' => [
                'demo_mode' => true,
                'client_secret' => $demoPaymentIntentId . '_secret_demo',
            ],
        ]);

        return [
            'payment_intent' => (object)[
                'id' => $demoPaymentIntentId,
                'status' => 'requires_payment_method',
            ],
            'payment' => $payment,
            'client_secret' => $demoPaymentIntentId . '_secret_demo',
            'demo_mode' => true,
        ];
    }

    /**
     * Confirm a payment intent
     */
    public function confirmPayment(string $paymentIntentId)
    {
        // Demo mode - simulate successful confirmation
        if ($this->demoMode || str_starts_with($paymentIntentId, 'demo_')) {
            return $this->confirmDemoPayment($paymentIntentId);
        }

        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $paymentIntent->confirm();

            // Update payment record
            $payment = Payment::where('payment_provider_id', $paymentIntentId)->first();
            if ($payment) {
                $payment->markAsCompleted($paymentIntentId);
                
                // Update booking status
                $booking = $payment->booking;
                $booking->update(['status' => 'confirmed']);
            }

            return $paymentIntent;

        } catch (Exception $e) {
            throw new Exception('Failed to confirm payment: ' . $e->getMessage());
        }
    }

    /**
     * Confirm a demo payment
     */
    protected function confirmDemoPayment(string $paymentIntentId)
    {
        // Update payment record
        $payment = Payment::where('payment_provider_id', $paymentIntentId)->first();
        if ($payment) {
            $payment->update([
                'status' => 'completed',
            ]);
            
            // Update booking status
            $booking = $payment->booking;
            $booking->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);
        }

        return (object)[
            'id' => $paymentIntentId,
            'status' => 'succeeded',
            'demo_mode' => true,
        ];
    }

    /**
     * Process a refund
     */
    public function processRefund(Payment $payment, float $amount = null, string $reason = null)
    {
        if ($this->demoMode) {
            // Demo refund
            $payment->update([
                'refunded_amount' => $amount ?: $payment->amount,
            ]);
            return (object)['id' => 'demo_refund_' . time(), 'status' => 'succeeded'];
        }

        try {
            if (!$payment->canRefund()) {
                throw new Exception('Payment cannot be refunded');
            }

            $refundAmount = $amount ?: ($payment->amount - $payment->refunded_amount);
            $refundAmountCents = $refundAmount * 100;

            $refund = Refund::create([
                'payment_intent' => $payment->payment_provider_id,
                'amount' => $refundAmountCents,
                'reason' => $reason ?: 'requested_by_customer',
                'metadata' => [
                    'booking_id' => $payment->booking_id,
                    'user_id' => $payment->user_id,
                ],
            ]);

            // Update payment record
            $payment->update([
                'refunded_amount' => $payment->refunded_amount + $refundAmount,
            ]);

            return $refund;

        } catch (Exception $e) {
            throw new Exception('Failed to process refund: ' . $e->getMessage());
        }
    }

    /**
     * Handle Stripe webhook
     */
    public function handleWebhook(array $payload)
    {
        try {
            $event = $payload;

            switch ($event['type']) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event['data']['object'];
                    $this->handlePaymentSuccess($paymentIntent);
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event['data']['object'];
                    $this->handlePaymentFailure($paymentIntent);
                    break;

                case 'charge.dispute.created':
                    // Handle dispute
                    break;

                default:
                    // Unknown event type
                    break;
            }

        } catch (Exception $e) {
            throw new Exception('Failed to handle webhook: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     */
    private function handlePaymentSuccess($paymentIntent)
    {
        $payment = Payment::where('payment_provider_id', $paymentIntent['id'])->first();
        if ($payment) {
            $payment->markAsCompleted($paymentIntent['id']);

            // Update booking status
            $booking = $payment->booking;
            $booking->update(['status' => 'confirmed']);
        }
    }

    /**
     * Handle failed payment
     */
    private function handlePaymentFailure($paymentIntent)
    {
        $payment = Payment::where('payment_provider_id', $paymentIntent['id'])->first();
        if ($payment) {
            $failureReason = $paymentIntent['last_payment_error']['message'] ?? 'Payment failed';
            $payment->markAsFailed($failureReason);

            // Update booking status
            $booking = $payment->booking;
            $booking->update(['status' => 'payment_failed']);
        }
    }

    /**
     * Get payment methods for a user
     */
    public function getPaymentMethods($userId)
    {
        // This would integrate with Stripe's customer payment methods
        // For now, return empty array
        return [];
    }

    /**
     * Calculate fees and amounts
     */
    public function calculateFees(float $amount, string $currency = 'USD')
    {
        // Service fees (example: 3% service fee)
        $serviceFee = $amount * 0.03;
        $processingFee = $amount * 0.029 + 0.30; // Stripe processing fee

        return [
            'subtotal' => $amount,
            'service_fee' => $serviceFee,
            'processing_fee' => $processingFee,
            'total' => $amount + $serviceFee + $processingFee,
        ];
    }
}
