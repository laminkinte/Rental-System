<?php

namespace App\Livewire\Auth;

use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $identifier = '';
    public $password = '';
    public $remember = false;
    public $loginMethod = 'auto'; // auto, email, phone, username

    protected $rules = [
        'identifier' => 'required|string',
        'password' => 'required|string',
    ];

    public function updatedIdentifier()
    {
        // Auto-detect login method based on input
        $this->loginMethod = 'auto';
    }

    public function login(AuthenticationService $authService)
    {
        $this->validate();

        // Use AuthenticationService for flexible login
        $result = $authService->authenticate([
            'identifier' => $this->identifier,
            'password' => $this->password,
        ], $this->remember);

        if (!$result) {
            $this->addError('identifier', 'The provided credentials do not match our records.');
            return;
        }

        // Redirect based on user role
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard');
        }
        
        if ($user->isHost()) {
            return redirect('/host/dashboard');
        }
        
        return redirect('/');
    }

    /**
     * Login with email specifically
     */
    public function loginWithEmail(AuthenticationService $authService)
    {
        $this->validate([
            'identifier' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $this->identifier,
            'password' => $this->password,
        ];

        if (!Auth::attempt($credentials, $this->remember)) {
            $this->addError('identifier', 'Invalid email or password.');
            return;
        }

        session()->regenerate();
        return redirect('/');
    }

    /**
     * Login with phone number
     */
    public function loginWithPhone(AuthenticationService $authService)
    {
        $this->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'phone' => $this->identifier,
            'password' => $this->password,
        ];

        if (!Auth::attempt($credentials, $this->remember)) {
            $this->addError('identifier', 'Invalid phone number or password.');
            return;
        }

        session()->regenerate();
        return redirect('/');
    }

    /**
     * Login with username
     */
    public function loginWithUsername(AuthenticationService $authService)
    {
        $this->validate([
            'identifier' => 'required|string|min:3|max:30',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => strtolower($this->identifier),
            'password' => $this->password,
        ];

        if (!Auth::attempt($credentials, $this->remember)) {
            $this->addError('identifier', 'Invalid username or password.');
            return;
        }

        session()->regenerate();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
