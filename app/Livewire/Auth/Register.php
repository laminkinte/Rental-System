<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $name = '';
    public $username = '';
    public $email = '';
    public $phone = '';
    public $password = '';
    public $password_confirmation = '';
    public $profile_type = 'guest';
    public $marketing_consent = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users|regex:/^[a-zA-Z0-9_]+$/',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|string|min:8|confirmed',
        'profile_type' => 'required|in:guest,host',
        'marketing_consent' => 'boolean',
    ];

    public function register(AuthenticationService $authService)
    {
        $this->validate();

        // Normalize username
        $username = strtolower(trim($this->username));
        
        // Create user
        $user = User::create([
            'name' => $this->name,
            'username' => $username,
            'email' => strtolower(trim($this->email)),
            'phone' => $this->phone ?: null,
            'password' => Hash::make($this->password),
            'is_host' => $this->profile_type === 'host',
            'marketing_consent' => $this->marketing_consent,
            'email_verified_at' => now(), // Auto-verify for demo purposes
        ]);

        // Create wallet for new user
        $user->wallet()->create([
            'balance' => 0,
            'currency' => 'GMD',
        ]);

        // Login the user
        Auth::login($user);
        
        // Regenerate session
        session()->regenerate();

        // Redirect based on profile type
        if ($this->profile_type === 'host') {
            return redirect()->intended('/host/dashboard');
        }
        
        return redirect()->intended('/');
    }

    /**
     * Check if username is available
     */
    public function checkUsername()
    {
        if (empty($this->username)) {
            return;
        }

        $username = strtolower(trim($this->username));
        
        if (User::where('username', $username)->exists()) {
            $this->addError('username', 'This username is already taken.');
        } else {
            $this->resetErrorBag('username');
        }
    }

    /**
     * Check if email is available
     */
    public function checkEmail()
    {
        if (empty($this->email)) {
            return;
        }

        $email = strtolower(trim($this->email));
        
        if (User::where('email', $email)->exists()) {
            $this->addError('email', 'This email is already registered.');
        } else {
            $this->resetErrorBag('email');
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
