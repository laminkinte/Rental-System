<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\PaymentService;
use Livewire\Component;

class PaymentComponent extends Component
{
    public $booking;
    public $paymentIntent;
    public $clientSecret;
    public $paymentStatus = 'pending';
    public $errorMessage;
    public $demoMode = false;
    public $showDemoNotice = false;

    protected $listeners = [
        'paymentCompleted' => 'handlePaymentCompleted',
        'paymentFailed' => 'handlePaymentFailed',
    ];

    public function mount(Booking $booking)
    {
        $this->booking = $booking;

        // Check if payment already exists
        $existingPayment = Payment::where('booking_id', $booking->id)->first();
        if ($existingPayment) {
            if ($existingPayment->status === 'completed') {
                $this->paymentStatus = 'completed';
                return redirect()->route('booking.confirmation', $booking);
            }
        }

        $this->initializePayment();
    }

    public function initializePayment()
    {
        try {
            $paymentService = new PaymentService();
            
            // Check if we're in demo mode
            $this->demoMode = $paymentService->isDemoMode();
            $this->showDemoNotice = $this->demoMode;
            
            $result = $paymentService->createPaymentIntent($this->booking);

            $this->paymentIntent = $result['payment_intent'];
            $this->clientSecret = $result['client_secret'];
            $this->paymentStatus = 'initialized';

        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            $this->paymentStatus = 'error';
            $this->demoMode = true;
            $this->showDemoNotice = true;
        }
    }

    public function handlePaymentCompleted($paymentIntentId)
    {
        try {
            $paymentService = new PaymentService();
            $paymentService->confirmPayment($paymentIntentId);

            $this->paymentStatus = 'completed';

            // Update booking status
            $this->booking->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);

            // Redirect to confirmation page
            return redirect()->route('booking.confirmation', $this->booking)
                           ->with('success', 'Payment completed successfully!');

        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
            $this->paymentStatus = 'error';
        }
    }

    public function handlePaymentFailed($error)
    {
        $this->errorMessage = $error['message'] ?? 'Payment failed';
        $this->paymentStatus = 'failed';
    }

    public function retryPayment()
    {
        $this->errorMessage = null;
        $this->paymentStatus = 'pending';
        $this->initializePayment();
    }

    public function render()
    {
        return view('components.payment-component');
    }
}
