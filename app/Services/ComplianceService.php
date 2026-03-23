<?php

namespace App\Services;

use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;

class ComplianceService
{
    /**
     * GDPR Compliance - Data Export
     */
    public static function exportUserData($userId)
    {
        $user = User::findOrFail($userId);

        if (auth()->id() !== $userId && !auth()->user()->is_admin) {
            throw new \Exception('Unauthorized');
        }

        $data = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'username' => $user->username,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
            'profile' => $user->only(['bio', 'location', 'preferences']),
            'bookings' => $user->bookings()->with('property')->get()->toArray(),
            'properties' => $user->properties()->get()->toArray(),
            'reviews_given' => $user->reviewsGiven()->get()->toArray(),
            'reviews_received' => $user->reviewsReceived()->get()->toArray(),
            'payments' => $user->payments()->get()->toArray(),
            'notifications' => $user->notifications()->get()->toArray(),
            'wallet' => $user->wallet()->first()?->toArray(),
            'messages' => [
                'sent' => $user->messagesSent()->get()->toArray(),
                'received' => $user->messagesReceived()->get()->toArray(),
            ],
        ];

        return $data;
    }

    /**
     * GDPR Compliance - User Deletion
     */
    public static function deleteUserData($userId)
    {
        $user = User::findOrFail($userId);

        if (auth()->id() !== $userId && !auth()->user()->is_admin) {
            throw new \Exception('Unauthorized');
        }

        // Anonymize rather than delete (for audit trail)
        $user->update([
            'name' => 'Deleted User',
            'email' => 'deleted_' . $user->id . '@deleted.local',
            'phone' => null,
            'username' => 'deleted_' . $user->id,
            'bio' => null,
            'avatar' => null,
            'deleted_at' => now(),
        ]);

        // Delete sensitive data
        $user->notifications()->delete();
        $user->messagesSent()->delete();
        $user->messagesReceived()->delete();
        $user->wallet()->delete();

        // Log GDPR deletion
        \Log::info("User $userId data deleted per GDPR request");

        return true;
    }

    /**
     * CCPA Compliance - Know Your Rights
     */
    public static function getCCPAUserRights($userId)
    {
        $user = User::findOrFail($userId);

        return [
            'access_right' => [
                'description' => 'Right to Know',
                'description_long' => 'You have the right to request what personal data we have collected about you',
                'available' => true,
                'action' => '/api/compliance/access',
            ],
            'deletion_right' => [
                'description' => 'Right to Delete',
                'description_long' => 'You have the right to request deletion of your personal data',
                'available' => true,
                'action' => '/api/compliance/delete',
            ],
            'opt_out_right' => [
                'description' => 'Right to Opt-Out',
                'description_long' => 'You have the right to opt-out of the sale of your personal data',
                'available' => true,
                'action' => '/api/compliance/opt-out-sale',
            ],
            'correction_right' => [
                'description' => 'Right to Correct',
                'description_long' => 'You have the right to request correction of inaccurate personal data',
                'available' => true,
                'action' => '/api/compliance/correct',
            ],
            'portability_right' => [
                'description' => 'Right to Data Portability',
                'description_long' => 'You have the right to receive and reuse your data across services',
                'available' => true,
                'action' => '/api/compliance/port',
            ],
        ];
    }

    /**
     * Get regional regulations and requirements
     */
    public static function getRegionalRules($country)
    {
        $regulations = [
            'US' => [
                'privacy_law' => 'CCPA, State Laws',
                'payment_methods' => ['credit_card', 'debit_card', 'paypal', 'apple_pay', 'google_pay'],
                'currency' => ['USD'],
                'tax_requirements' => true,
                'age_verification' => 18,
                'consent_requirements' => ['marketing', 'analytics'],
                'data_residency' => 'US'
            ],
            'GB' => [
                'privacy_law' => 'GDPR, UK GDPR, UK DPA 2018',
                'payment_methods' => ['credit_card', 'debit_card', 'paypal', 'apple_pay', 'google_pay', 'ideal'],
                'currency' => ['GBP', 'EUR'],
                'tax_requirements' => true,
                'age_verification' => 16,
                'consent_requirements' => ['marketing', 'analytics', 'cookies'],
                'data_residency' => 'UK/EU',
            ],
            'EU' => [
                'privacy_law' => 'GDPR, ePrivacy Directive',
                'payment_methods' => ['credit_card', 'debit_card', 'paypal', 'apple_pay', 'google_pay', 'ideal', 'sepa'],
                'currency' => ['EUR'],
                'tax_requirements' => true,
                'age_verification' => 16,
                'consent_requirements' => ['marketing', 'analytics', 'cookies', 'cookie_consent'],
                'data_residency' => 'EU',
                'right_to_be_forgotten' => true,
                'data_access_deadline' => 30, // days
            ],
            'GM' => [ // Gambia
                'privacy_law' => 'Data Protection Act 2013',
                'payment_methods' => ['credit_card', 'debit_card', 'mtn_mobile_money', 'wave', 'bank_transfer'],
                'currency' => ['GMD', 'USD'],
                'tax_requirements' => true,
                'age_verification' => 18,
                'consent_requirements' => ['marketing'],
                'data_residency' => 'West Africa',
            ],
            'SN' => [ // Senegal
                'privacy_law' => 'CNIL Regulations',
                'payment_methods' => ['credit_card', 'debit_card', 'wave', 'bank_transfer'],
                'currency' => ['XOF', 'USD'],
                'tax_requirements' => true,
                'age_verification' => 18,
                'consent_requirements' => ['marketing'],
                'data_residency' => 'West Africa',
            ],
            'KE' => [ // Kenya
                'privacy_law' => 'KDMA, Data Protection Act',
                'payment_methods' => ['credit_card', 'debit_card', 'mpesa', 'bank_transfer'],
                'currency' => ['KES', 'USD'],
                'tax_requirements' => true,
                'age_verification' => 18,
                'consent_requirements' => ['marketing'],
                'data_residency' => 'East Africa',
            ],
            'GH' => [ // Ghana
                'privacy_law' => 'Data Protection Act 2012',
                'payment_methods' => ['credit_card', 'debit_card', 'vodafone_cash', 'bank_transfer'],
                'currency' => ['GHS', 'USD'],
                'tax_requirements' => true,
                'age_verification' => 18,
                'consent_requirements' => ['marketing'],
                'data_residency' => 'West Africa',
            ],
        ];

        return $regulations[$country] ?? $regulations['GM']; // Default to Gambia
    }

    /**
     * Generate Privacy Policy based on jurisdiction
     */
    public static function generatePrivacyPolicy($country)
    {
        $rules = self::getRegionalRules($country);

        return [
            'title' => 'Privacy Policy - JubbaStay',
            'country' => $country,
            'last_updated' => now()->toDateString(),
            'applicable_law' => $rules['privacy_law'],
            'sections' => [
                'introduction' => 'We respect your privacy and are committed to protecting your personal data.',
                'data_we_collect' => [
                    'account_information' => 'Name, email, phone, username',
                    'payment_information' => 'Payment method, transaction history (encrypted)',
                    'booking_information' => 'Travel dates, preferences, booking history',
                    'communication_data' => 'Messages, reviews, support tickets',
                    'device_information' => 'Device type, OS, IP address',
                ],
                'data_usage' => 'We use your data to provide services, improve platform, prevent fraud, and comply with law.',
                'data_rights' => self::getCCPAUserRights(auth()->id()),
                'data_residency' => $rules['data_residency'],
                'retention_period' => '7 years or as required by law',
                'third_party_sharing' => 'We share data only with service providers, payment processors, and when required by law.',
                'cookies' => 'We use cookies for authentication, analytics, and preferences.',
                'contact' => 'privacy@jubbastay.com',
            ],
        ];
    }

    /**
     * Generate Terms of Service based on jurisdiction
     */
    public static function generateTermsOfService($country)
    {
        return [
            'title' => 'Terms of Service - JubbaStay',
            'country' => $country,
            'effective_date' => now()->toDateString(),
            'version' => '1.0.0',
            'sections' => [
                'acceptance' => 'By using JubbaStay, you accept these terms and our privacy policy.',
                'user_accounts' => 'You are responsible for account security. You agree not to share passwords or access.',
                'acceptable_use' => 'You agree not to use the platform for illegal activities, discrimination, harassment, or fraud.',
                'guest_responsibilities' => [
                    'Respect property rules and house policies',
                    'Do not damage property or belongings',
                    'Follow check-in and check-out times',
                    'Report issues immediately',
                ],
                'host_responsibilities' => [
                    'Maintain accurate property descriptions',
                    'Keep property clean and safe',
                    'Respond to messages within 24 hours',
                    'Honor confirmed bookings',
                    'Comply with local laws and regulations',
                ],
                'cancellation_policy' => 'Cancellation policies vary by listing. Review before booking.',
                'dispute_resolution' => 'Disputes will be resolved through our platform process or arbitration.',
                'liability' => 'JubbaStay is provided "as-is" without warranties.',
                'governing_law' => 'These terms are governed by the laws of ' . $country,
            ],
        ];
    }

    /**
     * Check compliance for payment transaction
     */
    public static function checkPaymentCompliance($booking, $payment)
    {
        $user = $booking->user;
        $property = $booking->property;
        $rules = self::getRegionalRules($property->country);

        $compliance_check = [
            'valid' => true,
            'warnings' => [],
            'issues' => [],
        ];

        // Check age verification
        if ($user->age_verified_at === null && $rules['age_verification'] > 0) {
            $compliance_check['issues'][] = 'Age verification required for this jurisdiction';
            $compliance_check['valid'] = false;
        }

        // Check payment method is allowed
        if (!in_array($payment->method, $rules['payment_methods'])) {
            $compliance_check['issues'][] = 'Payment method not available in this region';
            $compliance_check['valid'] = false;
        }

        // Check currency
        if (!in_array($payment->currency, $rules['currency'])) {
            $compliance_check['warnings'][] = 'Currency conversion may apply';
        }

        // Check data residency
        if (!self::isDataResidencyCompliant($user, $property, $rules['data_residency'])) {
            $compliance_check['warnings'][] = 'Data residency compliance is being maintained';
        }

        return $compliance_check;
    }

    /**
     * Check data residency compliance
     */
    public static function isDataResidencyCompliant($user, $property, $requiredResidency)
    {
        // TODO: Implement actual data residency checks
        // This would verify data is stored in compliant regions
        return true;
    }

    /**
     * Log compliance-sensitive action
     */
    public static function logComplianceAction($action, $userId, $metadata = [])
    {
        \Log::channel('compliance')->info('Compliance Action', [
            'action' => $action,
            'user_id' => $userId,
            'timestamp' => now()->toIso8601String(),
            'metadata' => $metadata,
        ]);
    }
}
