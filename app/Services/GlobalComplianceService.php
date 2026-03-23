<?php

namespace App\Services;

use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

/**
 * Global Compliance Service
 * Based on Section 3.3 of the Requirements Document
 * Handles platform compliance across different jurisdictions
 */
class GlobalComplianceService
{
    /**
     * Jurisdiction configurations
     */
    public const JURISDICTIONS = [
        // Europe - GDPR
        'EU' => [
            'name' => 'European Union',
            'privacy_law' => 'GDPR',
            'tax_treaty' => true,
            'vat_required' => true,
            'data_residency' => 'EU',
            'currency' => 'EUR',
            'regulations' => [
                'gdpr' => [
                    'name' => 'General Data Protection Regulation',
                    'data_subject_rights' => ['access', 'rectification', 'erasure', 'portability', 'restriction', 'objection'],
                    'consent_required' => true,
                    'data_protection_officer' => true,
                    'breach_notification_days' => 72,
                ],
                'eprivacy' => [
                    'name' => 'ePrivacy Directive',
                    'cookies_consent' => true,
                    'marketing_emails_opt_in' => true,
                ],
                'consumer_rights' => [
                    'name' => 'Consumer Rights Directive',
                    'withdrawal_days' => 14,
                    'refund_required' => true,
                ],
                'vat_moss' => [
                    'name' => 'VAT MOSS',
                    'digital_services_tax' => true,
                ],
            ],
        ],
        
        // UK
        'GB' => [
            'name' => 'United Kingdom',
            'privacy_law' => 'UK GDPR',
            'tax_treaty' => true,
            'vat_required' => true,
            'data_residency' => 'UK',
            'currency' => 'GBP',
            'regulations' => [
                'uk_gdpr' => [
                    'name' => 'UK GDPR & Data Protection Act 2018',
                    'data_subject_rights' => ['access', 'rectification', 'erasure', 'portability', 'restriction', 'objection'],
                    'ico_registration' => true,
                    'breach_notification_days' => 72,
                ],
                'consumer_rights' => [
                    'name' => 'Consumer Rights Act 2015',
                    'withdrawal_days' => 14,
                ],
            ],
        ],
        
        // USA - Multiple jurisdictions
        'US' => [
            'name' => 'United States',
            'privacy_law' => 'State-level',
            'tax_treaty' => false,
            'vat_required' => false,
            'sales_tax' => true,
            'currency' => 'USD',
            'regulations' => [
                'ccpa' => [
                    'name' => 'California Consumer Privacy Act (CCPA/CPRA)',
                    'states' => ['CA'],
                    'right_to_know' => true,
                    'right_to_delete' => true,
                    'right_to_opt_out' => true,
                    'non_discrimination' => true,
                ],
                'vcpa' => [
                    'name' => 'Virginia Consumer Data Protection Act',
                    'states' => ['VA'],
                ],
                'cpa' => [
                    'name' => 'Colorado Privacy Act',
                    'states' => ['CO'],
                ],
                'ctdpa' => [
                    'name' => 'Connecticut Data Privacy Act',
                    'states' => ['CT'],
                ],
                'ucpa' => [
                    'name' => 'Utah Consumer Privacy Act',
                    'states' => ['UT'],
                ],
                'coppa' => [
                    'name' => 'Children\'s Online Privacy Protection Act',
                    'age_verification' => 13,
                    'parental_consent' => true,
                ],
                'ada' => [
                    'name' => 'Americans with Disabilities Act',
                    'accessibility_required' => true,
                ],
                'fdcpa' => [
                    'name' => 'Fair Debt Collection Practices Act',
                    'debt_collection' => true,
                ],
            ],
        ],
        
        // Canada
        'CA' => [
            'name' => 'Canada',
            'privacy_law' => 'PIPEDA',
            'tax_treaty' => true,
            'gst_required' => true,
            'data_residency' => 'CA',
            'currency' => 'CAD',
            'regulations' => [
                'pipeda' => [
                    'name' => 'Personal Information Protection and Electronic Documents Act',
                    'consent_required' => true,
                    'breach_notification' => true,
                ],
                'qc_private_sector' => [
                    'name' => 'Quebec Private Sector Privacy Act',
                    'province' => 'QC',
                ],
                'casl' => [
                    'name' => 'Canadian Anti-Spam Legislation',
                    'email_consent' => true,
                    'unsubscribe_required' => true,
                ],
                'airbnb_tax' => [
                    'name' => 'Short-term Rental Taxes',
                    'provincial_taxes' => true,
                    'municipal_taxes' => true,
                ],
            ],
        ],
        
        // Australia
        'AU' => [
            'name' => 'Australia',
            'privacy_law' => 'Privacy Act',
            'tax_treaty' => true,
            'gst_required' => true,
            'data_residency' => 'AU',
            'currency' => 'AUD',
            'regulations' => [
                'privacy_act' => [
                    'name' => 'Privacy Act 1988',
                    'australian_privacy_principles' => true,
                    'data_storage' => 'AU',
                ],
                'consumer_law' => [
                    'name' => 'Australian Consumer Law',
                    'refund_rights' => true,
                    'unfair_terms' => true,
                ],
                'short_stay' => [
                    'name' => 'Short-term Rental Legislation',
                    'state_regulations' => true,
                ],
            ],
        ],
        
        // Japan
        'JP' => [
            'name' => 'Japan',
            'privacy_law' => 'APPI',
            'tax_treaty' => true,
            'consumption_tax' => true,
            'data_residency' => 'JP',
            'currency' => 'JPY',
            'regulations' => [
                'appi' => [
                    'name' => 'Act on Protection of Personal Information',
                    'consent_required' => true,
                    'third_party_transfer' => true,
                ],
                'jpa' => [
                    'name' => 'Japan Package Tours Act',
                    'travel_operators' => true,
                ],
            ],
        ],
        
        // Singapore
        'SG' => [
            'name' => 'Singapore',
            'privacy_law' => 'PDPA',
            'tax_treaty' => true,
            'gst_required' => false,
            'currency' => 'SGD',
            'regulations' => [
                'pdpa' => [
                    'name' => 'Personal Data Protection Act',
                    'consent_required' => true,
                    'notification_obligation' => true,
                ],
                'mas_guidelines' => [
                    'name' => 'MAS Guidelines for Payment Services',
                    'psd2_equivalent' => true,
                ],
            ],
        ],
        
        // India
        'IN' => [
            'name' => 'India',
            'privacy_law' => 'DPDPA',
            'tax_treaty' => true,
            'gst_required' => true,
            'currency' => 'INR',
            'regulations' => [
                'dpdpa' => [
                    'name' => 'Digital Personal Data Protection Act 2023',
                    'consent_required' => true,
                    'data_fiduciary' => true,
                ],
                'it_act' => [
                    'name' => 'Information Technology Act',
                    'cyber_law' => true,
                ],
                'rbi_guidelines' => [
                    'name' => 'RBI Guidelines for Payment Aggregators',
                ],
            ],
        ],
        
        // Brazil
        'BR' => [
            'name' => 'Brazil',
            'privacy_law' => 'LGPD',
            'tax_treaty' => true,
            'icms_required' => true,
            'currency' => 'BRL',
            'regulations' => [
                'lgpd' => [
                    'name' => 'Lei Geral de Proteção de Dados',
                    'consent_required' => true,
                    'data_subject_rights' => true,
                ],
                'procon' => [
                    'name' => 'PROCON Consumer Protection',
                    'consumer_rights' => true,
                ],
            ],
        ],
        
        // China
        'CN' => [
            'name' => 'China',
            'privacy_law' => 'PIPL',
            'tax_treaty' => true,
            'vat_required' => true,
            'data_residency' => 'CN',
            'currency' => 'CNY',
            'regulations' => [
                'pipl' => [
                    'name' => 'Personal Information Protection Law',
                    'consent_required' => true,
                    'cross_border_transfer' => true,
                    'security_assessment' => true,
                ],
                'cybersecurity_law' => [
                    'name' => 'Cybersecurity Law',
                    'data_localization' => true,
                ],
                'icp_license' => [
                    'name' => 'ICP License',
                    'website_registration' => true,
                ],
            ],
        ],
        
        // UAE
        'AE' => [
            'name' => 'United Arab Emirates',
            'privacy_law' => 'Federal Decree-Law',
            'tax_treaty' => true,
            'vat_required' => true,
            'currency' => 'AED',
            'regulations' => [
                'data_law' => [
                    'name' => 'Federal Decree-Law on Processing Personal Data',
                    'consent_required' => true,
                ],
                'vat' => [
                    'name' => 'VAT Registration',
                    'threshold' => 375000,
                ],
            ],
        ],
        
        // South Africa
        'ZA' => [
            'name' => 'South Africa',
            'privacy_law' => 'POPIA',
            'tax_treaty' => true,
            'vat_required' => true,
            'currency' => 'ZAR',
            'regulations' => [
                'popia' => [
                    'name' => 'Protection of Personal Information Act',
                    'information_officer' => true,
                    'data_subjects_rights' => true,
                ],
            ],
        ],
        
        // Nigeria
        'NG' => [
            'name' => 'Nigeria',
            'privacy_law' => 'NDPR',
            'tax_treaty' => true,
            'vat_required' => true,
            'currency' => 'NGN',
            'regulations' => [
                'ndpr' => [
                    'name' => 'Nigeria Data Protection Regulation',
                    'consent_required' => true,
                    'data_protection_officer' => true,
                ],
            ],
        ],
        
        // Kenya
        'KE' => [
            'name' => 'Kenya',
            'privacy_law' => 'DPA',
            'tax_treaty' => true,
            'vat_required' => true,
            'currency' => 'KES',
            'regulations' => [
                'data_protection_act' => [
                    'name' => 'Data Protection Act 2019',
                    'data_commissioner' => true,
                ],
            ],
        ],
        
        // Ghana
        'GH' => [
            'name' => 'Ghana',
            'privacy_law' => 'NDPC',
            'tax_treaty' => true,
            'vat_required' => true,
            'currency' => 'GHS',
            'regulations' => [
                'ndpc' => [
                    'name' => 'Data Protection Commission',
                    'registration_required' => true,
                ],
            ],
        ],
        
        // Gambia
        'GM' => [
            'name' => 'Gambia',
            'privacy_law' => 'None',
            'tax_treaty' => true,
            'vat_required' => false,
            'currency' => 'GMD',
            'regulations' => [
                'local_laws' => [
                    'name' => 'General Consumer Protection',
                ],
            ],
        ],
    ];

    /**
     * Tax rates by jurisdiction
     */
    public const TAX_RATES = [
        'EU' => ['vat' => 20, 'varies' => true], // Varies by country (17-27%)
        'GB' => ['vat' => 20],
        'US' => ['sales_tax' => 'varies', 'lodging_tax' => 'varies'],
        'CA' => ['gst' => 5, 'pst' => 'varies', 'hst' => 'varies'],
        'AU' => ['gst' => 10],
        'JP' => ['consumption_tax' => 10],
        'SG' => ['gst' => 9, 'seller_stamp_duty' => true],
        'IN' => ['gst' => 18, 'tds' => 1],
        'BR' => ['icms' => 'varies', 'iss' => 'varies'],
        'CN' => ['vat' => 13],
        'AE' => ['vat' => 5],
        'ZA' => ['vat' => 15],
        'NG' => ['vat' => 7.5],
        'KE' => ['vat' => 16],
        'GH' => ['vat' => 15],
        'GM' => ['vat' => 0],
    ];

    /**
     * Age restrictions by jurisdiction
     */
    public const AGE_RESTRICTIONS = [
        'US' => ['min_booking_age' => 18, 'alcohol_age' => 21],
        'GB' => ['min_booking_age' => 18],
        'EU' => ['min_booking_age' => 18],
        'AU' => ['min_booking_age' => 18],
        'JP' => ['min_booking_age' => 18],
        'CA' => ['min_booking_age' => 18, 'alcohol_age' => 19],
        'SG' => ['min_booking_age' => 18],
    ];

    /**
     * Check if a property is compliant for a jurisdiction
     */
    public function checkPropertyCompliance(Property $property, string $jurisdiction): array
    {
        $compliance = [
            'jurisdiction' => $jurisdiction,
            'compliant' => true,
            'issues' => [],
            'requirements' => [],
        ];

        $config = self::JURISDICTIONS[$jurisdiction] ?? null;

        if (!$config) {
            $compliance['compliant'] = false;
            $compliance['issues'][] = 'Unknown jurisdiction';
            return $compliance;
        }

        // Check regulatory requirements
        foreach ($config['regulations'] ?? [] as $key => $regulation) {
            $requirement = $this->checkRegulationCompliance($property, $regulation, $key);
            if (!empty($requirement)) {
                $compliance['requirements'][$key] = $requirement;
            }
        }

        // Verify property meets local requirements
        $localRequirements = $this->getLocalRequirements($property, $jurisdiction);
        foreach ($localRequirements as $req) {
            if (!$req['met']) {
                $compliance['compliant'] = false;
                $compliance['issues'][] = $req['message'];
            }
        }

        return $compliance;
    }

    /**
     * Check specific regulation compliance
     */
    protected function checkRegulationCompliance(Property $property, array $regulation, string $type): array
    {
        $requirements = [];

        switch ($type) {
            case 'gdpr':
            case 'uk_gdpr':
            case 'pdpa':
            case 'lgpd':
            case 'pipeda':
            case 'appi':
            case 'dpdpa':
            case 'pipl':
                // Privacy compliance requirements
                $requirements[] = [
                    'type' => 'privacy',
                    'required' => true,
                    'description' => $regulation['name'],
                    'details' => [
                        'data_encryption' => true,
                        'consent_mechanism' => true,
                        'data_deletion' => true,
                        'breach_notification' => true,
                    ],
                ];
                break;

            case 'ccpa':
            case 'vcpa':
            case 'cpa':
                // California/VA/Colorado privacy requirements
                $requirements[] = [
                    'type' => 'privacy',
                    'required' => true,
                    'description' => $regulation['name'],
                    'details' => [
                        'do_not_sell' => true,
                        'privacy_policy' => true,
                        'request_handling' => true,
                    ],
                ];
                break;

            case 'coppa':
                // Children's privacy
                $requirements[] = [
                    'type' => 'age_verification',
                    'required' => true,
                    'min_age' => $regulation['age_verification'] ?? 13,
                    'description' => $regulation['name'],
                ];
                break;

            case 'ada':
                // Accessibility
                $requirements[] = [
                    'type' => 'accessibility',
                    'required' => true,
                    'description' => $regulation['name'],
                    'details' => [
                        'wheelchair_accessible' => $property->accessible ?? false,
                        'service_animals' => true,
                    ],
                ];
                break;
        }

        return $requirements;
    }

    /**
     * Get local requirements for a property in a jurisdiction
     */
    protected function getLocalRequirements(Property $property, string $jurisdiction): array
    {
        $requirements = [];

        switch ($jurisdiction) {
            case 'US':
                // Check state-specific requirements
                if (in_array($property->state, ['CA', 'NY', 'SF', 'LA'])) {
                    $requirements[] = [
                        'met' => !empty($property->license_number),
                        'message' => 'Short-term rental license required in ' . $property->state,
                    ];
                }
                break;

            case 'AU':
                // State-specific regulations
                if (in_array($property->state, ['NSW', 'VIC', 'QLD'])) {
                    $requirements[] = [
                        'met' => $property->registration_number !== null,
                        'message' => 'Registration required in ' . $property->state,
                    ];
                }
                break;

            case 'JP':
                // Japan hotel business law
                $requirements[] = [
                    'met' => $property->innkeeper_liability_insurance ?? false,
                    'message' => 'Innkeeper liability insurance required in Japan',
                ];
                break;

            case 'SG':
                // Additional requirements
                $requirements[] = [
                    'met' => $property->fire_safety_certificate ?? false,
                    'message' => 'Fire safety certificate required',
                ];
                break;
        }

        return $requirements;
    }

    /**
     * Calculate applicable taxes for a booking
     */
    public function calculateTaxes(Booking $booking, string $jurisdiction): array
    {
        $taxConfig = self::TAX_RATES[$jurisdiction] ?? [];
        $taxes = [];

        foreach ($taxConfig as $taxType => $rate) {
            $taxAmount = 0;

            if ($rate === 'varies') {
                // Would need location-specific calculation
                $taxAmount = 0;
            } elseif (is_numeric($rate)) {
                $taxAmount = $booking->subtotal * ($rate / 100);
            }

            $taxes[$taxType] = [
                'rate' => $rate,
                'amount' => $taxAmount,
                'jurisdiction' => $jurisdiction,
            ];
        }

        return $taxes;
    }

    /**
     * Check user data processing compliance
     */
    public function checkUserDataCompliance(User $user, string $jurisdiction): array
    {
        $compliance = [
            'jurisdiction' => $jurisdiction,
            'compliant' => true,
            'issues' => [],
            'required_consents' => [],
        ];

        $config = self::JURISDICTIONS[$jurisdiction] ?? null;

        if (!$config) {
            return $compliance;
        }

        // Check consent requirements
        foreach ($config['regulations'] ?? [] as $key => $regulation) {
            if (isset($regulation['consent_required']) && $regulation['consent_required']) {
                $consentStatus = $this->getConsentStatus($user, $key);
                $compliance['required_consents'][$key] = $consentStatus;

                if (!$consentStatus['obtained']) {
                    $compliance['compliant'] = false;
                    $compliance['issues'][] = "Missing consent for: {$regulation['name']}";
                }
            }
        }

        return $compliance;
    }

    /**
     * Get user consent status for a regulation
     */
    protected function getConsentStatus(User $user, string $regulation): array
    {
        // Check user's consent history
        $consents = $user->consents ?? [];

        return [
            'obtained' => isset($consents[$regulation]),
            'date' => $consents[$regulation]['date'] ?? null,
            'method' => $consents[$regulation]['method'] ?? null,
        ];
    }

    /**
     * Handle data subject request
     */
    public function handleDataSubjectRequest(User $user, string $requestType): array
    {
        $result = [
            'success' => false,
            'message' => '',
            'data' => null,
        ];

        switch ($requestType) {
            case 'access':
                // Provide all personal data
                $result['success'] = true;
                $result['data'] = $this->getUserDataExport($user);
                $result['message'] = 'Data export ready';
                break;

            case 'rectification':
                // Allow data correction
                $result['success'] = true;
                $result['message'] = 'Data correction form provided';
                break;

            case 'erasure':
                // Delete personal data (right to be forgotten)
                $result['success'] = $this->deleteUserData($user);
                $result['message'] = $result['success'] 
                    ? 'Data erasure initiated' 
                    : 'Cannot complete erasure - legal obligation';
                break;

            case 'portability':
                // Provide data in machine-readable format
                $result['success'] = true;
                $result['data'] = $this->getPortableData($user);
                $result['message'] = 'Data export ready in JSON format';
                break;

            case 'restriction':
                // Restrict processing
                $result['success'] = $user->update(['processing_restricted' => true]);
                $result['message'] = 'Processing restricted';
                break;

            case 'objection':
                // Object to processing
                $result['success'] = $user->update(['objected_processing' => true]);
                $result['message'] = 'Objection recorded';
                break;

            default:
                $result['message'] = 'Unknown request type';
        }

        return $result;
    }

    /**
     * Export user data
     */
    protected function getUserDataExport(User $user): array
    {
        return [
            'profile' => $user->toArray(),
            'bookings' => $user->bookings->toArray(),
            'payments' => $user->payments->toArray(),
            'reviews' => $user->reviews->toArray(),
            'messages' => $user->messages->toArray(),
            'properties' => $user->properties->toArray(),
            'export_date' => now()->toIso8601String(),
        ];
    }

    /**
     * Get portable data format
     */
    protected function getPortableData(User $user): array
    {
        return [
            'personal_info' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'preferences' => [
                'preferred_currency' => $user->preferred_currency,
                'preferred_language' => $user->preferred_language,
                'timezone' => $user->timezone,
            ],
            'export_date' => now()->toIso8601String(),
        ];
    }

    /**
     * Delete user data (with exceptions)
     */
    protected function deleteUserData(User $user): bool
    {
        // Check legal retention requirements
        if ($user->hasActiveBookings()) {
            return false; // Keep data for ongoing transactions
        }

        if ($user->hasPendingPayments()) {
            return false; // Keep for financial records
        }

        // Anonymize instead of delete for analytics
        $user->update([
            'name' => 'Deleted User',
            'email' => 'deleted_' . $user->id . '@anonymized.local',
            'phone' => null,
            'avatar' => null,
            'deleted_at' => now(),
        ]);

        return true;
    }

    /**
     * Check if user can be served in jurisdiction
     */
    public function canServeInJurisdiction(User $user, string $jurisdiction): array
    {
        $config = self::JURISDICTIONS[$jurisdiction] ?? null;

        if (!$config) {
            return [
                'allowed' => false,
                'reason' => 'Unknown jurisdiction',
            ];
        }

        // Check sanctions
        if ($this->isSanctioned($user)) {
            return [
                'allowed' => false,
                'reason' => 'Sanctions compliance',
            ];
        }

        // Check age restrictions
        $ageConfig = self::AGE_RESTRICTIONS[$jurisdiction] ?? null;
        if ($ageConfig && isset($ageConfig['min_booking_age'])) {
            $minAge = $ageConfig['min_booking_age'];
            if ($user->age < $minAge) {
                return [
                    'allowed' => false,
                    'reason' => "Minimum age requirement: {$minAge} years",
                ];
            }
        }

        return ['allowed' => true];
    }

    /**
     * Check if user is sanctioned
     */
    protected function isSanctioned(User $user): bool
    {
        // Check against sanctions lists
        // This would integrate with external services
        return false;
    }

    /**
     * Generate compliance report for admin
     */
    public function generateComplianceReport(string $jurisdiction): array
    {
        $config = self::JURISDICTIONS[$jurisdiction] ?? null;

        if (!$config) {
            return ['error' => 'Unknown jurisdiction'];
        }

        return [
            'jurisdiction' => $jurisdiction,
            'regulations' => array_keys($config['regulations'] ?? []),
            'requirements' => [
                'privacy_law' => $config['privacy_law'] ?? null,
                'tax_required' => $config['vat_required'] ?? $config['gst_required'] ?? false,
                'data_residency' => $config['data_residency'] ?? null,
            ],
            'actions_required' => $this->getRequiredActions($jurisdiction),
        ];
    }

    /**
     * Get required compliance actions for jurisdiction
     */
    protected function getRequiredActions(string $jurisdiction): array
    {
        $actions = [];

        switch ($jurisdiction) {
            case 'EU':
            case 'GB':
                $actions = [
                    'Implement cookie consent banner',
                    'Add GDPR privacy policy',
                    'Set up data breach notification',
                    'Configure data portability',
                    'Add withdrawal/cancellation flow',
                ];
                break;

            case 'US':
                $actions = [
                    'Add "Do Not Sell" link',
                    'Implement CCPA privacy notice',
                    'Age verification for certain content',
                ];
                break;

            case 'CN':
                $actions = [
                    'Obtain ICP license',
                    'Set up data localization',
                    'Implement security assessment',
                ];
                break;
        }

        return $actions;
    }
}
