<?php

namespace App\Services;

use App\Models\User;
use App\Models\SocialLogin;
use App\Models\ConnectedAccount;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthenticationService
{
    /**
     * Supported authentication methods
     */
    public const METHODS = [
        // Primary Methods
        'email' => 'Email Authentication',
        'phone' => 'Phone Authentication',
        'username' => 'Username Authentication',
        
        // Social Authentication
        'google' => 'Google',
        'facebook' => 'Facebook',
        'apple' => 'Apple ID',
        'twitter' => 'Twitter/X',
        'linkedin' => 'LinkedIn',
        'wechat' => 'WeChat',
        'line' => 'LINE',
        'kakao' => 'KakaoTalk',
        'vk' => 'VK',
        
        // Professional Authentication
        'microsoft' => 'Microsoft Account',
        'slack' => 'Slack SSO',
        'google_workspace' => 'Google Workspace',
        
        // Web3 Authentication
        'metamask' => 'MetaMask',
        'walletconnect' => 'WalletConnect',
        'coinbase_wallet' => 'Coinbase Wallet',
    ];

    /**
     * Country codes for phone authentication
     */
    public const COUNTRY_CODES = [
        // North America
        'US' => '+1', 'CA' => '+1', 'MX' => '+52',
        
        // Europe
        'GB' => '+44', 'DE' => '+49', 'FR' => '+33', 'ES' => '+34',
        'IT' => '+39', 'NL' => '+31', 'BE' => '+32', 'AT' => '+43',
        'PT' => '+351', 'IE' => '+353', 'PL' => '+48', 'SE' => '+46',
        'NO' => '+47', 'DK' => '+45', 'FI' => '+358', 'GR' => '+30',
        'CH' => '+41', 'RU' => '+7', 'UA' => '+380',
        
        // Asia
        'JP' => '+81', 'KR' => '+82', 'CN' => '+86', 'HK' => '+852',
        'TW' => '+886', 'IN' => '+91', 'TH' => '+66', 'VN' => '+84',
        'MY' => '+60', 'SG' => '+65', 'ID' => '+62', 'PH' => '+63',
        'PK' => '+92', 'BD' => '+880', 'LK' => '+94', 'NP' => '+977',
        
        // Middle East
        'AE' => '+971', 'SA' => '+966', 'IL' => '+972', 'EG' => '+20',
        'TR' => '+90', 'IR' => '+98', 'IQ' => '+964', 'KW' => '+965',
        
        // Africa
        'ZA' => '+27', 'NG' => '+234', 'KE' => '+254', 'GH' => '+233',
        'MA' => '+212', 'EG' => '+20', 'ET' => '+251', 'TZ' => '+255',
        'SN' => '+221', 'CI' => '+225', 'GM' => '+220', 'SL' => '+232',
        
        // Oceania
        'AU' => '+61', 'NZ' => '+64', 'FJ' => '+679', 'PG' => '+675',
        
        // South America
        'BR' => '+55', 'AR' => '+54', 'CO' => '+57', 'CL' => '+56',
        'PE' => '+51', 'VE' => '+58', 'EC' => '+593', 'UY' => '+598',
    ];

    /**
     * Detect input type from user input
     */
    public function detectInputType(string $input): string
    {
        // Email regex
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        }
        
        // Phone regex (starts with + and followed by digits)
        if (preg_match('/^\+[1-9]\d{6,14}$/', $input)) {
            return 'phone';
        }
        
        // Username (alphanumeric with underscores, 3-30 chars)
        if (preg_match('/^[a-zA-Z0-9_]{3,30}$/', $input)) {
            return 'username';
        }
        
        return 'unknown';
    }

    /**
     * Authenticate user with credentials
     */
    public function authenticate(array $credentials, bool $remember = false): ?User
    {
        $inputType = $this->detectInputType($credentials['identifier'] ?? '');
        
        $authCredentials = ['password' => $credentials['password']];
        
        switch ($inputType) {
            case 'email':
                $authCredentials['email'] = strtolower($credentials['identifier']);
                break;
            case 'phone':
                $authCredentials['phone'] = $credentials['identifier'];
                break;
            case 'username':
                $authCredentials['username'] = strtolower($credentials['identifier']);
                break;
            default:
                // Try all possibilities
                $authCredentials['email'] = strtolower($credentials['identifier']);
                $authCredentials['phone'] = $credentials['identifier'];
                $authCredentials['username'] = strtolower($credentials['identifier']);
        }
        
        if (Auth::attempt($authCredentials, $remember)) {
            $user = Auth::user();
            $this->recordLogin($user);
            return $user;
        }
        
        return null;
    }

    /**
     * Register a new user
     */
    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $inputType = $this->detectInputType($data['email'] ?? $data['phone'] ?? $data['username'] ?? '');
            
            $userData = [
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'] ?? 'guest',
                'preferred_language' => $data['preferred_language'] ?? 'en',
                'preferred_currency' => $data['preferred_currency'] ?? 'USD',
                'timezone' => $data['timezone'] ?? 'UTC',
                'locale' => $data['locale'] ?? 'en',
            ];
            
            switch ($inputType) {
                case 'email':
                    $userData['email'] = strtolower($data['email']);
                    break;
                case 'phone':
                    $userData['phone'] = $data['phone'];
                    $userData['phone_country_code'] = $data['phone_country_code'] ?? '+1';
                    break;
            }
            
            if (!empty($data['username'])) {
                $userData['username'] = strtolower($data['username']);
            }
            
            $user = User::create($userData);
            
            // Generate referral code
            $user->update(['referral_code' => $this->generateReferralCode($user)]);
            
            // Track signup source
            if (!empty($data['utm_source'])) {
                $user->update([
                    'utm_source' => $data['utm_source'],
                    'utm_medium' => $data['utm_medium'] ?? null,
                    'utm_campaign' => $data['utm_campaign'] ?? null,
                ]);
            }
            
            // Record referral if applicable
            if (!empty($data['referral_code'])) {
                $referrer = User::where('referral_code', $data['referral_code'])->first();
                if ($referrer && $referrer->id !== $user->id) {
                    $user->update(['referred_by' => $referrer->id]);
                    // Award points to referrer
                    $referrer->increment('referral_count');
                }
            }
            
            // Create connected account
            if (!empty($data['email'])) {
                ConnectedAccount::create([
                    'user_id' => $user->id,
                    'account_type' => 'email',
                    'account_identifier' => strtolower($data['email']),
                    'is_primary' => true,
                    'is_verified' => false,
                ]);
            }
            
            return $user;
        });
    }

    /**
     * Handle social login/registration
     */
    public function handleSocialLogin(string $provider, array $providerData): User
    {
        return DB::transaction(function () use ($provider, $providerData) {
            // Check if social login exists
            $socialLogin = SocialLogin::where('provider', $provider)
                ->where('provider_id', $providerData['id'])
                ->first();
            
            if ($socialLogin) {
                // User exists, update info and return
                $user = $socialLogin->user;
                $this->updateSocialLogin($socialLogin, $providerData);
                $this->recordLogin($user);
                return $user;
            }
            
            // Check if user with same email exists
            if (!empty($providerData['email'])) {
                $existingUser = User::where('email', strtolower($providerData['email']))->first();
                
                if ($existingUser) {
                    // Link existing account to social login
                    $this->createSocialLogin($existingUser, $provider, $providerData);
                    $this->recordLogin($existingUser);
                    return $existingUser;
                }
            }
            
            // Create new user
            $user = $this->createUserFromSocial($provider, $providerData);
            
            return $user;
        });
    }

    /**
     * Create user from social provider data
     */
    protected function createUserFromSocial(string $provider, array $data): User
    {
        $name = $data['name'] ?? 'User';
        $email = $data['email'] ?? null;
        
        // Generate username from name
        $username = Str::slug($name);
        $baseUsername = $username;
        $counter = 1;
        
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        $userData = [
            'name' => $name,
            'username' => $username,
            'password' => Hash::make(Str::random(32)), // Random password for social login
            'avatar' => $data['avatar'] ?? null,
            'role' => 'guest',
            'email' => $email,
            'email_verified_at' => now(),
            'is_verified' => true,
            'verification_level' => 1,
            'referral_code' => $this->generateReferralCode(null),
        ];
        
        $user = User::create($userData);
        
        // Create social login
        $this->createSocialLogin($user, $provider, $data);
        
        // Create connected account
        if ($email) {
            ConnectedAccount::create([
                'user_id' => $user->id,
                'account_type' => 'social',
                'account_identifier' => $email,
                'is_primary' => true,
                'is_verified' => true,
                'verified_at' => now(),
            ]);
        }
        
        // Map provider-specific fields
        $this->mapProviderFields($user, $provider, $data);
        
        return $user;
    }

    /**
     * Create social login record
     */
    protected function createSocialLogin(User $user, string $provider, array $data): SocialLogin
    {
        return SocialLogin::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_id' => $data['id'],
            'access_token' => $data['access_token'] ?? null,
            'refresh_token' => $data['refresh_token'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
            'provider_data' => $data,
        ]);
    }

    /**
     * Update existing social login
     */
    protected function updateSocialLogin(SocialLogin $login, array $data): void
    {
        $login->update([
            'access_token' => $data['access_token'] ?? $login->access_token,
            'refresh_token' => $data['refresh_token'] ?? $login->refresh_token,
            'expires_at' => $data['expires_at'] ?? $login->expires_at,
            'provider_data' => array_merge($login->provider_data ?? [], $data),
        ]);
    }

    /**
     * Map provider-specific fields to user
     */
    protected function mapProviderFields(User $user, string $provider, array $data): void
    {
        $updateData = [];
        
        switch ($provider) {
            case 'google':
                $updateData['social_google_id'] = $data['id'];
                break;
            case 'facebook':
                $updateData['social_facebook_id'] = $data['id'];
                break;
            case 'apple':
                $updateData['social_apple_id'] = $data['id'];
                break;
            case 'twitter':
                $updateData['social_twitter_id'] = $data['id'];
                break;
            case 'linkedin':
                $updateData['social_linkedin_id'] = $data['id'];
                break;
        }
        
        if (!empty($updateData)) {
            $user->update($updateData);
        }
    }

    /**
     * Generate unique referral code
     */
    protected function generateReferralCode(?User $user): string
    {
        $code = strtoupper(Str::random(8));
        
        // Ensure uniqueness
        while (User::where('referral_code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }
        
        return $code;
    }

    /**
     * Record user login activity
     */
    public function recordLogin(User $user): void
    {
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
            'current_ip' => request()->ip(),
        ]);
        
        // Add to login history
        $loginHistory = $user->login_history ?? [];
        $loginHistory[] = [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toIso8601String(),
        ];
        
        // Keep only last 50 login records
        $loginHistory = array_slice($loginHistory, -50);
        $user->update(['login_history' => $loginHistory]);
        
        // Create session record
        $this->createUserSession($user);
    }

    /**
     * Create user session record
     */
    protected function createUserSession(User $user): UserSession
    {
        // Mark previous sessions as not current
        UserSession::where('user_id', $user->id)
            ->where('is_current', true)
            ->update(['is_current' => false]);
        
        $deviceInfo = $this->getDeviceInfo();
        
        return UserSession::create([
            'user_id' => $user->id,
            'device_type' => $deviceInfo['device_type'],
            'device_name' => $deviceInfo['device_name'],
            'browser' => $deviceInfo['browser'],
            'os' => $deviceInfo['os'],
            'ip_address' => request()->ip(),
            'country' => $this->getCountryFromIP(request()->ip()),
            'city' => null, // Would need GeoIP service
            'is_current' => true,
            'last_active_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);
    }

    /**
     * Get device information from user agent
     */
    protected function getDeviceInfo(): array
    {
        $userAgent = request()->userAgent();
        
        $deviceType = 'desktop';
        $deviceName = 'Unknown Device';
        $browser = 'Unknown Browser';
        $os = 'Unknown OS';
        
        // Device type
        if (preg_match('/mobile|android|iphone|ipad|phone/i', $userAgent)) {
            $deviceType = 'mobile';
            if (preg_match('/ipad/i', $userAgent)) {
                $deviceType = 'tablet';
            }
        } elseif (preg_match('/tablet|iPad/i', $userAgent)) {
            $deviceType = 'tablet';
        }
        
        // Browser
        if (preg_match('/chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/edge/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/opera|opr/i', $userAgent)) {
            $browser = 'Opera';
        }
        
        // OS
        if (preg_match('/windows/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/mac/i', $userAgent)) {
            $os = 'macOS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/ios|iphone|ipad/i', $userAgent)) {
            $os = 'iOS';
        }
        
        // Device name
        if (preg_match('/iphone/i', $userAgent)) {
            $deviceName = 'iPhone';
        } elseif (preg_match('/ipad/i', $userAgent)) {
            $deviceName = 'iPad';
        } elseif (preg_match('/android/i', $userAgent)) {
            $deviceName = 'Android Device';
        }
        
        return [
            'device_type' => $deviceType,
            'device_name' => $deviceName,
            'browser' => $browser,
            'os' => $os,
        ];
    }

    /**
     * Get country from IP address (simplified - would need GeoIP service in production)
     */
    protected function getCountryFromIP(string $ip): ?string
    {
        // This is a placeholder - in production, use a GeoIP service
        return null;
    }

    /**
     * Generate OTP for phone authentication
     */
    public function generatePhoneOTP(User $user): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP (in production, use Redis with expiration)
        cache()->put("phone_otp_{$user->id}", [
            'otp' => Hash::make($otp),
            'attempts' => 0,
            'expires_at' => now()->addMinutes(10),
        ], 600); // 10 minutes
        
        // Send OTP via SMS (integrate with SMS provider)
        // $this->sendSMS($user->phone, "Your verification code is: {$otp}");
        
        Log::info('Phone OTP generated', ['user_id' => $user->id, 'expires' => now()->addMinutes(10)]);
        
        return $otp; // In production, don't return OTP - send via SMS
    }

    /**
     * Verify phone OTP
     */
    public function verifyPhoneOTP(User $user, string $otp): bool
    {
        $cached = cache()->get("phone_otp_{$user->id}");
        
        if (!$cached) {
            return false;
        }
        
        if (now()->gt($cached['expires_at'])) {
            cache()->forget("phone_otp_{$user->id}");
            return false;
        }
        
        if (!Hash::check($otp, $cached['otp'])) {
            $cached['attempts']++;
            cache()->put("phone_otp_{$user->id}", $cached, 600);
            
            // Lock after 5 failed attempts
            if ($cached['attempts'] >= 5) {
                cache()->forget("phone_otp_{$user->id}");
                return false;
            }
            
            return false;
        }
        
        // Success - mark phone as verified
        $user->update([
            'phone_verified_at' => now(),
            'is_verified' => true,
            'verification_level' => max($user->verification_level, 1),
        ]);
        
        cache()->forget("phone_otp_{$user->id}");
        
        return true;
    }

    /**
     * Send magic login link
     */
    public function sendMagicLink(string $email): ?User
    {
        $user = User::where('email', strtolower($email))->first();
        
        if (!$user) {
            // Don't reveal if user exists
            return null;
        }
        
        $token = Str::random(64);
        
        // Store token (use Redis in production)
        cache()->put("magic_link_{$token}", [
            'user_id' => $user->id,
            'expires_at' => now()->addMinutes(30),
        ], 1800); // 30 minutes
        
        // Generate magic link URL
        $url = route('auth.magic-login.verify', ['token' => $token]);
        
        // Send email (integrate with mail service)
        // Mail::to($user)->send(new MagicLoginLink($url));
        
        Log::info('Magic link sent', ['user_id' => $user->id, 'expires' => now()->addMinutes(30)]);
        
        return $user;
    }

    /**
     * Verify magic login link
     */
    public function verifyMagicLink(string $token): ?User
    {
        $cached = cache()->get("magic_link_{$token}");
        
        if (!$cached) {
            return null;
        }
        
        if (now()->gt($cached['expires_at'])) {
            cache()->forget("magic_link_{$token}");
            return null;
        }
        
        $user = User::find($cached['user_id']);
        
        if (!$user) {
            return null;
        }
        
        // Delete token after use
        cache()->forget("magic_link_{$token}");
        
        // Log the user in
        Auth::login($user);
        $this->recordLogin($user);
        
        return $user;
    }

    /**
     * Enable two-factor authentication
     */
    public function enableTwoFactor(User $user, string $method): array
    {
        $secret = Str::random(32);
        
        $user->update([
            'two_factor_enabled' => true,
            'two_factor_method' => $method,
            'two_factor_secret' => encrypt($secret),
        ]);
        
        // Return secret for user to store in their authenticator app
        return [
            'secret' => $secret,
            'method' => $method,
        ];
    }

    /**
     * Verify two-factor code
     */
    public function verifyTwoFactor(User $user, string $code): bool
    {
        if (!$user->two_factor_enabled || !$user->two_factor_secret) {
            return false;
        }
        
        $secret = decrypt($user->two_factor_secret);
        
        // For TOTP (time-based one-time password)
        if ($user->two_factor_method === 'authenticator') {
            return $this->verifyTOTP($secret, $code);
        }
        
        // For SMS OTP
        if ($user->two_factor_method === 'sms') {
            return $this->verifyPhoneOTP($user, $code);
        }
        
        return false;
    }

    /**
     * Verify TOTP code (simplified - use library in production)
     */
    protected function verifyTOTP(string $secret, string $code): bool
    {
        // In production, use PHPGangsta/GoogleAuthenticator library
        // This is a placeholder implementation
        return hash_equals($secret, $code); // Simplified - should use proper TOTP
    }

    /**
     * Get user sessions
     */
    public function getUserSessions(User $user): array
    {
        return UserSession::where('user_id', $user->id)
            ->orderBy('last_active_at', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Terminate a user session
     */
    public function terminateSession(User $user, int $sessionId): bool
    {
        $session = UserSession::where('id', $sessionId)
            ->where('user_id', $user->id)
            ->first();
        
        if ($session) {
            $session->delete();
            return true;
        }
        
        return false;
    }

    /**
     * Terminate all other sessions
     */
    public function terminateAllOtherSessions(User $user): void
    {
        UserSession::where('user_id', $user->id)
            ->where('is_current', false)
            ->delete();
        
        // Mark current as only session
        UserSession::where('user_id', $user->id)
            ->update(['is_current' => true]);
    }

    /**
     * Check if user can authenticate (account status)
     */
    public function canAuthenticate(User $user): bool
    {
        if ($user->account_status === 'suspended') {
            return false;
        }
        
        if ($user->account_status === 'banned') {
            return false;
        }
        
        return true;
    }

    /**
     * Get login form fields based on input type
     */
    public function getLoginFields(string $inputType): array
    {
        $fields = ['identifier' => 'required', 'password' => 'required'];
        
        switch ($inputType) {
            case 'email':
                $fields['identifier'] = 'required|email';
                break;
            case 'phone':
                $fields['identifier'] = 'required|string';
                break;
            case 'username':
                $fields['identifier'] = 'required|string|min:3|max:30';
                break;
        }
        
        return $fields;
    }
}
