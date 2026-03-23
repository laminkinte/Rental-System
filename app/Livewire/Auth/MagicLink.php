<?php

namespace App\Livewire\Auth;

use App\Mail\MagicLoginLink;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;

class MagicLink extends Component
{
    public $email;
    public $sent = false;
    public $message;
    public $error;

    protected $rules = [
        'email' => 'required|email',
    ];

    public function sendLink()
    {
        $this->sent = false;
        $this->error = null;
        
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            $this->addError('email', 'No account found with that email address.');
            return;
        }

        // Generate token and store in cache
        $token = Str::random(64);
        $cacheKey = 'magic-login:' . $token;
        
        // Store for 15 minutes
        Cache::put($cacheKey, $user->id, now()->addMinutes(15));

        // Generate the magic link URL
        $loginUrl = route('auth.magic_login.token', ['token' => $token]);

        // For development: show the link directly if mail is not configured
        if (config('mail.mailer') === 'array' || !config('mail.host')) {
            // Store the link in session for development purposes
            session()->flash('magic_link', $loginUrl);
            $this->sent = true;
            $this->message = 'Magic link generated! For development, the link has been shown below (or check terminal/logs).';
            return;
        }

        try {
            Mail::to($user->email)->send(new MagicLoginLink($loginUrl, $user->name));
            $this->sent = true;
            $this->message = 'A magic login link has been sent to your email address.';
        } catch (\Exception $e) {
            // If mail fails, still show success and link in session
            session()->flash('magic_link', $loginUrl);
            $this->sent = true;
            $this->message = 'Magic link generated! (Mail service unavailable, link shown below for development)';
        }
    }

    public function render()
    {
        return view('livewire.auth.magic-link');
    }
}
