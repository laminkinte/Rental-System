<?php

namespace App\Livewire\Account;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Twilio\Rest\Client as TwilioClient;
use Exception;

class VerificationManager extends Component
{
    use WithFileUploads;

    public $selectedTab = 'id_verification'; // id_verification, phone_verification, email_verification, badges
    public $idDocumentType = 'passport'; // passport, national_id, drivers_license
    public $idDocumentFront;
    public $idDocumentBack;
    public $phone;
    public $verificationCode = '';
    public $codeInput = '';

    protected $rules = [
        'idDocumentType' => 'required|in:passport,national_id,drivers_license',
        'idDocumentFront' => 'required|image|max:10240',
        'idDocumentBack' => 'nullable|image|max:10240',
        'phone' => 'required|string|regex:/^[0-9\+]{7,15}$/',
        'codeInput' => 'required|numeric|digits:6',
    ];

    public function submitIdVerification()
    {
        $this->validate([
            'idDocumentType' => 'required|in:passport,national_id,drivers_license',
            'idDocumentFront' => 'required|image|max:10240',
            'idDocumentBack' => 'nullable|image|max:10240',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Store documents
        $frontPath = $this->idDocumentFront->store('id-verification/' . $user->id, 'public');
        $backPath = null;
        if ($this->idDocumentBack) {
            $backPath = $this->idDocumentBack->store('id-verification/' . $user->id, 'public');
        }

        // Update user verification status using update method
        $user->update([
            'id_verification_status' => 'pending',
            'id_verification_type' => $this->idDocumentType,
            'id_verification_documents' => [
                'front' => $frontPath,
                'back' => $backPath,
            ],
        ]);

        session()->flash('success', 'ID verification submitted. Admin review pending.');
        $this->reset(['idDocumentFront', 'idDocumentBack']);
    }

    public function sendPhoneVerification()
    {
        $this->validate(['phone' => 'required|string|regex:/^[0-9\+]{7,15}$/']);

        /** @var User $user */
        $user = Auth::user();
        $code = random_int(100000, 999999);

        // Store code in cache for 10 minutes
        Cache::put('phone_verification_' . $user->id, $code, now()->addMinutes(10));

        // Send SMS via Twilio
        try {
            // Check if Twilio is configured
            $accountSid = config('services.twilio.account_sid');
            $authToken = config('services.twilio.auth_token');
            $fromNumber = config('services.twilio.from_number');

            if (!$accountSid || !$authToken || !$fromNumber) {
                throw new Exception('Twilio is not properly configured. Please check your .env file.');
            }

            // Create Twilio client
            $twilio = new TwilioClient($accountSid, $authToken);

            // Send message
            $twilio->messages->create(
                $this->phone,
                [
                    'from' => $fromNumber,
                    'body' => "Your JubbaStay verification code: $code"
                ]
            );

            session()->flash('info', 'Verification code sent to ' . $this->phone);
            $this->phone = '';
        } catch (Exception $e) {
            $this->addError('phone', 'Failed to send SMS: ' . $e->getMessage());
        }
    }

    public function verifyPhoneCode()
    {
        $this->validate(['codeInput' => 'required|numeric|digits:6']);

        /** @var User $user */
        $user = Auth::user();
        $storedCode = Cache::get('phone_verification_' . $user->id);

        if (!$storedCode) {
            $this->addError('codeInput', 'Verification code expired');
            return;
        }

        if ($this->codeInput != $storedCode) {
            $this->addError('codeInput', 'Invalid verification code');
            return;
        }

        // Update user using update method
        $user->update([
            'phone_verified_at' => now(),
            'phone_verified' => true,
        ]);

        Cache::forget('phone_verification_' . $user->id);
        session()->flash('success', 'Phone verified successfully');
        $this->reset(['codeInput']);
    }

    public function getBadges()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) {
            return [];
        }

        $badges = [];

        // Load relationship counts for hosts
        if ($user->role === 'host') {
            // Get properties count
            $propertiesCount = $user->properties()->count();
        }

        // ID Verified Badge
        if ($user->id_verification_status === 'approved') {
            $badges['id_verified'] = [
                'name' => 'ID Verified',
                'icon' => '✓',
                'color' => 'blue',
                'description' => 'Identity verified by admin'
            ];
        }

        // Phone Verified Badge
        if ($user->phone_verified) {
            $badges['phone_verified'] = [
                'name' => 'Phone Verified',
                'icon' => '📱',
                'color' => 'green',
                'description' => 'Phone number verified'
            ];
        }

        // Email Verified Badge
        if ($user->email_verified_at) {
            $badges['email_verified'] = [
                'name' => 'Email Verified',
                'icon' => '📧',
                'color' => 'green',
                'description' => 'Email address verified'
            ];
        }

        // Superhost Badge (for hosts)
        if ($user->role === 'host' && $user->superhost_status) {
            $badges['superhost'] = [
                'name' => 'Superhost',
                'icon' => '⭐',
                'color' => 'gold',
                'description' => '4.8+ rating, 90%+ response rate'
            ];
        }

        // Professional Host Badge
        if ($user->role === 'host' && isset($propertiesCount) && $propertiesCount >= 5) {
            $badges['professional_host'] = [
                'name' => 'Professional Host',
                'icon' => '🏆',
                'color' => 'purple',
                'description' => '5+ active listings'
            ];
        }

        // Green Badge (eco-friendly)
        if (property_exists($user, 'sustainability_score') && $user->sustainability_score >= 80) {
            $badges['eco_friendly'] = [
                'name' => 'Eco-Friendly',
                'icon' => '🌱',
                'color' => 'emerald',
                'description' => 'Sustainable practices certified'
            ];
        }

        // Response Rate Badge
        if (property_exists($user, 'message_response_rate') && $user->message_response_rate >= 95) {
            $badges['responsive'] = [
                'name' => 'Highly Responsive',
                'icon' => '⚡',
                'color' => 'amber',
                'description' => '95%+ message response rate'
            ];
        }

        // Long-term Host Badge
        if ($user->created_at < now()->subYears(2)) {
            $badges['veteran_host'] = [
                'name' => 'Veteran Host',
                'icon' => '🎖️',
                'color' => 'slate',
                'description' => '2+ years on JubbaStay'
            ];
        }

        return $badges;
    }

    public function render()
    {
        /** @var User $user */
        $user = Auth::user();
        $badges = $this->getBadges();

        return view('livewire.account.verification-manager', [
            'user' => $user,
            'badges' => $badges,
        ]);
    }
}