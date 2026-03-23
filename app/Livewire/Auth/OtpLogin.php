<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Illuminate\Support\Str;

class OtpLogin extends Component
{
    public $phone;
    public $otp;
    public $step = 1;
    public $message;

    protected $rules = [
        'phone' => 'required|string',
        'otp' => 'required|string|min:4|max:6',
    ];

    public function sendOtp()
    {
        $this->validateOnly('phone');

        $user = User::where('phone', $this->phone)->first();
        if (!$user) {
            $this->addError('phone', 'No account found with that phone number.');
            return;
        }

        $code = rand(100000, 999999);
        Cache::put('otp-login:' . $this->phone, $code, now()->addMinutes(10));

        // TODO: integrate with SMS provider (Twilio, etc.)
        // For now, we show the code on screen for dev/testing.
        $this->message = "Your login code is: {$code} (for demo purposes).";

        $this->step = 2;
    }

    public function verifyOtp()
    {
        $this->validateOnly('otp');

        $code = Cache::get('otp-login:' . $this->phone);
        if (!$code || $code != $this->otp) {
            $this->addError('otp', 'Invalid or expired code.');
            return;
        }

        $user = User::where('phone', $this->phone)->first();
        if (!$user) {
            $this->addError('phone', 'No account found with that phone number.');
            return;
        }

        Cache::forget('otp-login:' . $this->phone);

        Auth::login($user);

        // Redirect based on user role
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard');
        }
        
        if ($user->isHost()) {
            return redirect('/host/dashboard');
        }

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.otp-login');
    }
}
