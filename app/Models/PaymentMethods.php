<?php

namespace App\Models;

/**
 * Global Payment Methods Configuration
 * Based on Section 3.2 of the Requirements Document
 */
class PaymentMethods
{
    /**
     * Payment method categories
     */
    public const CATEGORIES = [
        'card' => 'Credit/Debit Card',
        'bank_transfer' => 'Bank Transfer',
        'digital_wallet' => 'Digital Wallet',
        'crypto' => 'Cryptocurrency',
        'local' => 'Local Payment Methods',
        'buy_now_pay_later' => 'Buy Now Pay Later',
        'voucher' => 'Vouchers & Credits',
    ];

    /**
     * Card payment methods
     */
    public const CARDS = [
        // International Cards
        'visa' => [
            'name' => 'Visa',
            'type' => 'credit_debit',
            'currency' => ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'JPY', 'CNY', 'INR', 'BRL'],
            'regions' => ['global'],
            'logo' => 'visa.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.4],
        ],
        'mastercard' => [
            'name' => 'Mastercard',
            'type' => 'credit_debit',
            'currency' => ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'JPY', 'CNY', 'INR', 'BRL'],
            'regions' => ['global'],
            'logo' => 'mastercard.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
        ],
        'amex' => [
            'name' => 'American Express',
            'type' => 'credit',
            'currency' => ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'JPY'],
            'regions' => ['US', 'CA', 'UK', 'AU', 'JP'],
            'logo' => 'amex.png',
            'fees' => ['consumer' => 0, 'merchant' => 2.5],
        ],
        'discover' => [
            'name' => 'Discover',
            'type' => 'credit_debit',
            'currency' => ['USD'],
            'regions' => ['US', 'CA', 'UK'],
            'logo' => 'discover.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.6],
        ],
        
        // Regional Cards
        'jcb' => [
            'name' => 'JCB',
            'type' => 'credit_debit',
            'currency' => ['JPY', 'USD', 'EUR'],
            'regions' => ['JP', 'US', 'KR', 'TW', 'TH', 'SG', 'HK'],
            'logo' => 'jcb.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
        ],
        'unionpay' => [
            'name' => 'UnionPay',
            'type' => 'credit_debit',
            'currency' => ['CNY', 'USD', 'EUR', 'GBP', 'JPY', 'HKD'],
            'regions' => ['CN', 'HK', 'MO', 'SG', 'US', 'EU'],
            'logo' => 'unionpay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.2],
        ],
        'diners_club' => [
            'name' => 'Diners Club',
            'type' => 'credit',
            'currency' => ['USD', 'EUR', 'GBP'],
            'regions' => ['global'],
            'logo' => 'diners.png',
            'fees' => ['consumer' => 0, 'merchant' => 2.0],
        ],
        
        // Debit Cards
        'visa_debit' => [
            'name' => 'Visa Debit',
            'type' => 'debit',
            'currency' => ['USD', 'EUR', 'GBP', 'AUD', 'CAD'],
            'regions' => ['UK', 'EU', 'AU', 'CA'],
            'logo' => 'visa-debit.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.2],
        ],
        'maestro' => [
            'name' => 'Maestro',
            'type' => 'debit',
            'currency' => ['EUR', 'GBP', 'USD'],
            'regions' => ['UK', 'EU'],
            'logo' => 'maestro.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.2],
        ],
        
        // Prepaid Cards
        'prepaid_visa' => [
            'name' => 'Visa Prepaid',
            'type' => 'prepaid',
            'currency' => ['USD', 'EUR', 'GBP'],
            'regions' => ['global'],
            'logo' => 'visa-prepaid.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
        ],
        'prepaid_mastercard' => [
            'name' => 'Mastercard Prepaid',
            'type' => 'prepaid',
            'currency' => ['USD', 'EUR', 'GBP'],
            'regions' => ['global'],
            'logo' => 'mc-prepaid.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
        ],
    ];

    /**
     * Digital wallets
     */
    public const DIGITAL_WALLETS = [
        'paypal' => [
            'name' => 'PayPal',
            'type' => 'digital_wallet',
            'currency' => ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'JPY', 'CNY', 'INR', 'BRL', 'ZAR', 'SEK', 'NOK', 'DKK', 'CHF'],
            'regions' => ['global'],
            'logo' => 'paypal.png',
            'fees' => ['consumer' => 0, 'merchant' => 2.9 + 0.30],
            'features' => ['buyer_protection', 'seller_protection', 'payout_instant'],
        ],
        'apple_pay' => [
            'name' => 'Apple Pay',
            'type' => 'digital_wallet',
            'currency' => ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'JPY', 'CNY', 'INR', 'BRL'],
            'regions' => ['US', 'CA', 'UK', 'EU', 'AU', 'JP', 'CN'],
            'logo' => 'apple-pay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
            'features' => ['secure_element', 'biometric', 'contactless'],
        ],
        'google_pay' => [
            'name' => 'Google Pay',
            'type' => 'digital_wallet',
            'currency' => ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'JPY', 'INR', 'SGD', 'HKD'],
            'regions' => ['US', 'CA', 'UK', 'EU', 'AU', 'JP', 'IN', 'SG', 'HK'],
            'logo' => 'google-pay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
            'features' => ['contactless', 'loyalty', 'offers'],
        ],
        'samsung_pay' => [
            'name' => 'Samsung Pay',
            'type' => 'digital_wallet',
            'currency' => ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'JPY', 'KRW', 'CNY', 'INR'],
            'regions' => ['US', 'CA', 'UK', 'EU', 'AU', 'JP', 'KR', 'CN', 'IN'],
            'logo' => 'samsung-pay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
            'features' => ['mst_contactless', 'biometric'],
        ],
        'alipay' => [
            'name' => 'Alipay',
            'type' => 'digital_wallet',
            'currency' => ['CNY', 'USD', 'EUR', 'GBP', 'JPY', 'HKD', 'TWD', 'KRW'],
            'regions' => ['CN', 'HK', 'MO', 'US', 'EU', 'JP', 'KR', 'AU'],
            'logo' => 'alipay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.2],
            'features' => ['qr_code', 'credit_score', 'installments'],
        ],
        'wechat_pay' => [
            'name' => 'WeChat Pay',
            'type' => 'digital_wallet',
            'currency' => ['CNY', 'USD', 'EUR', 'GBP', 'JPY', 'HKD', 'AUD', 'CAD'],
            'regions' => ['CN', 'HK', 'MO', 'US', 'EU', 'JP', 'AU', 'CA'],
            'logo' => 'wechat-pay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.0],
            'features' => ['qr_code', 'mini_program', 'red_envelope'],
        ],
        'line_pay' => [
            'name' => 'LINE Pay',
            'type' => 'digital_wallet',
            'currency' => ['JPY', 'TWD', 'THB', 'USD'],
            'regions' => ['JP', 'TW', 'TH', 'US'],
            'logo' => 'line-pay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
            'features' => ['qr_code', 'points', 'rewards'],
        ],
        'kakao_pay' => [
            'name' => 'KakaoPay',
            'type' => 'digital_wallet',
            'currency' => ['KRW', 'USD'],
            'regions' => ['KR', 'US'],
            'logo' => 'kakao-pay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
            'features' => ['qr_code', 'easy_transfer', 'financial_services'],
        ],
        'grab_pay' => [
            'name' => 'GrabPay',
            'type' => 'digital_wallet',
            'currency' => ['SGD', 'MYR', 'PHP', 'THB', 'IDR', 'VNĐ'],
            'regions' => ['SG', 'MY', 'PH', 'TH', 'ID', 'VN'],
            'logo' => 'grab-pay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
            'features' => ['qr_code', 'rewards', 'installments'],
        ],
        'go_pay' => [
            'name' => 'GoPay',
            'type' => 'digital_wallet',
            'currency' => ['IDR', 'USD'],
            'regions' => ['ID'],
            'logo' => 'gopay.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.0],
            'features' => ['qr_code', 'top_up', 'games'],
        ],
        'dana' => [
            'name' => 'DANA',
            'type' => 'digital_wallet',
            'currency' => ['IDR', 'USD'],
            'regions' => ['ID'],
            'logo' => 'dana.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.0],
            'features' => ['qr_code', 'insurance', 'invest'],
        ],
        'ovo' => [
            'name' => 'OVO',
            'type' => 'digital_wallet',
            'currency' => ['IDR', 'USD'],
            'regions' => ['ID'],
            'logo' => 'ovo.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.0],
            'features' => ['qr_code', 'rewards', 'installments'],
        ],
        'tru_money' => [
            'name' => 'TrueMoney',
            'type' => 'digital_wallet',
            'currency' => ['THB', 'USD'],
            'regions' => ['TH'],
            'logo' => 'truemoney.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.0],
            'features' => ['qr_code', 'top_up', 'bill_payment'],
        ],
        'm_pesa' => [
            'name' => 'M-Pesa',
            'type' => 'digital_wallet',
            'currency' => ['KES', 'TZS', 'GHS', 'EGP', 'RWF'],
            'regions' => ['KE', 'TZ', 'GH', 'EG', 'RW'],
            'logo' => 'mpesa.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
            'features' => ['mobile_money', 'airtime', 'bill_payment'],
        ],
        'airtel_money' => [
            'name' => 'Airtel Money',
            'type' => 'digital_wallet',
            'currency' => ['KES', 'UGX', 'TZS', 'MWK', 'NPR', 'LKR'],
            'regions' => ['KE', 'UG', 'TZ', 'MW', 'NP', 'LK'],
            'logo' => 'airtel-money.png',
            'fees' => ['consumer' => 0, 'merchant' => 1.5],
            'features' => ['mobile_money', 'international_remittance'],
        ],
    ];

    /**
     * Bank transfer methods
     */
    public const BANK_TRANSFERS = [
        'local_bank_transfer' => [
            'name' => 'Local Bank Transfer',
            'type' => 'bank_transfer',
            'regions' => ['global'],
            'fees' => ['consumer' => 0, 'merchant' => 0.5],
            'processing_time' => '1-3 business days',
        ],
        'wire_transfer' => [
            'name' => 'Wire Transfer (SWIFT)',
            'type' => 'bank_transfer',
            'regions' => ['global'],
            'fees' => ['consumer' => 15-50, 'merchant' => 0.3],
            'processing_time' => '2-5 business days',
        ],
        'sepa' => [
            'name' => 'SEPA Transfer',
            'type' => 'bank_transfer',
            'regions' => ['EU', 'EEA'],
            'fees' => ['consumer' => 0, 'merchant' => 0.2],
            'processing_time' => '1-2 business days',
        ],
        'ach' => [
            'name' => 'ACH Direct Debit',
            'type' => 'bank_transfer',
            'regions' => ['US'],
            'fees' => ['consumer' => 0, 'merchant' => 0.3],
            'processing_time' => '3-5 business days',
        ],
        'bacs' => [
            'name' => 'BACS Direct Credit',
            'type' => 'bank_transfer',
            'regions' => ['UK'],
            'fees' => ['consumer' => 0, 'merchant' => 0.2],
            'processing_time' => '3 business days',
        ],
        'interac' => [
            'name' => 'Interac e-Transfer',
            'type' => 'bank_transfer',
            'regions' => ['CA'],
            'fees' => ['consumer' => 0-1.50, 'merchant' => 0.5],
            'processing_time' => '15-30 minutes',
        ],
        'pix' => [
            'name' => 'PIX',
            'type' => 'bank_transfer',
            'regions' => ['BR'],
            'fees' => ['consumer' => 0, 'merchant' => 0.2],
            'processing_time' => 'Instant',
        ],
        'upi' => [
            'name' => 'UPI',
            'type' => 'bank_transfer',
            'regions' => ['IN'],
            'fees' => ['consumer' => 0, 'merchant' => 0.3],
            'processing_time' => 'Instant',
        ],
        'neft' => [
            'name' => 'NEFT',
            'type' => 'bank_transfer',
            'regions' => ['IN'],
            'fees' => ['consumer' => 0, 'merchant' => 0.3],
            'processing_time' => '1-2 hours to 24 hours',
        ],
        'rtgs' => [
            'name' => 'RTGS',
            'type' => 'bank_transfer',
            'regions' => ['IN'],
            'fees' => ['consumer' => 0, 'merchant' => 0.3],
            'processing_time' => 'Real-time',
        ],
        'instant_payment' => [
            'name' => 'Instant Payment (IP)',
            'type' => 'bank_transfer',
            'regions' => ['IN'],
            'fees' => ['consumer' => 0, 'merchant' => 0.3],
            'processing_time' => 'Instant',
        ],
    ];

    /**
     * Buy Now Pay Later methods
     */
    public const BNPL = [
        'klarna' => [
            'name' => 'Klarna',
            'type' => 'bnpl',
            'currency' => ['USD', 'EUR', 'GBP', 'SEK', 'NOK', 'DKK', 'FIN', 'DE', 'AT', 'NL', 'BE', 'CH'],
            'regions' => ['US', 'UK', 'EU', 'CH'],
            'logo' => 'klarna.png',
            'fees' => ['consumer' => 0, 'merchant' => 2.9],
            'options' => ['pay_later', 'pay_in_3', 'financing'],
        ],
        'afterpay' => [
            'name' => 'Afterpay',
            'type' => 'bnpl',
            'currency' => ['USD', 'AUD', 'NZD', 'CAD', 'GBP'],
            'regions' => ['US', 'AU', 'NZ', 'CA', 'UK'],
            'logo' => 'afterpay.png',
            'fees' => ['consumer' => 0, 'merchant' => 3.0],
            'options' => ['pay_in_4', 'pay_in_full'],
        ],
        'clearpay' => [
            'name' => 'Clearpay',
            'type' => 'bnpl',
            'currency' => ['GBP', 'EUR', 'AUD', 'NZD'],
            'regions' => ['UK', 'EU', 'AU', 'NZ'],
            'logo' => 'clearpay.png',
            'fees' => ['consumer' => 0, 'merchant' => 3.0],
            'options' => ['pay_in_4'],
        ],
        'affirm' => [
            'name' => 'Affirm',
            'type' => 'bnpl',
            'currency' => ['USD'],
            'regions' => ['US'],
            'logo' => 'affirm.png',
            'fees' => ['consumer' => 0, 'merchant' => 2.9],
            'options' => ['pay_in_3', 'pay_monthly', 'financing'],
        ],
        'sezzle' => [
            'name' => 'Sezzle',
            'type' => 'bnpl',
            'currency' => ['USD', 'CAD'],
            'regions' => ['US', 'CA'],
            'logo' => 'sezzle.png',
            'fees' => ['consumer' => 0, 'merchant' => 2.5],
            'options' => ['pay_in_4'],
        ],
        'zip' => [
            'name' => 'Zip',
            'type' => 'bnpl',
            'currency' => ['USD', 'AUD', 'NZD', 'GBP'],
            'regions' => ['US', 'AU', 'NZ', 'UK'],
            'logo' => 'zip.png',
            'fees' => ['consumer' => 0, 'merchant' => 2.5],
            'options' => ['pay_in_4', 'pay_monthly'],
        ],
        'atome' => [
            'name' => 'Atome',
            'type' => 'bnpl',
            'currency' => ['SGD', 'MYR', 'THB', 'IDR', 'VND'],
            'regions' => ['SG', 'MY', 'TH', 'ID', 'VN'],
            'logo' => 'atome.png',
            'fees' => ['consumer' => 0, 'merchant' => 2.5],
            'options' => ['pay_in_3'],
        ],
        'hoolah' => [
            'name' => 'Hoolah',
            'type' => 'bnpl',
            'currency' => ['SGD', 'MYR'],
            'regions' => ['SG', 'MY'],
            'logo' => 'hoolah.png',
            'fees' => ['consumer' => 0, 'merchant' => 2.5],
            'options' => ['pay_in_3'],
        ],
    ];

    /**
     * Cryptocurrency options
     */
    public const CRYPTOCURRENCY = [
        'bitcoin' => [
            'name' => 'Bitcoin',
            'symbol' => 'BTC',
            'type' => 'crypto',
            'network' => 'Bitcoin',
            'fees' => ['consumer' => 0, 'merchant' => 1.0],
            'logo' => 'btc.png',
        ],
        'ethereum' => [
            'name' => 'Ethereum',
            'symbol' => 'ETH',
            'type' => 'crypto',
            'network' => 'Ethereum',
            'fees' => ['consumer' => 0, 'merchant' => 1.0],
            'logo' => 'eth.png',
        ],
        'usdt' => [
            'name' => 'Tether',
            'symbol' => 'USDT',
            'type' => 'stablecoin',
            'network' => ['Ethereum', 'TRC20', 'Solana'],
            'fees' => ['consumer' => 0, 'merchant' => 0.5],
            'logo' => 'usdt.png',
        ],
        'usdc' => [
            'name' => 'USD Coin',
            'symbol' => 'USDC',
            'type' => 'stablecoin',
            'network' => ['Ethereum', 'Solana', 'Polygon'],
            'fees' => ['consumer' => 0, 'merchant' => 0.5],
            'logo' => 'usdc.png',
        ],
        'solana' => [
            'name' => 'Solana',
            'symbol' => 'SOL',
            'type' => 'crypto',
            'network' => 'Solana',
            'fees' => ['consumer' => 0, 'merchant' => 1.0],
            'logo' => 'sol.png',
        ],
        'binance_pay' => [
            'name' => 'Binance Pay',
            'symbol' => 'BPAY',
            'type' => 'crypto_wallet',
            'fees' => ['consumer' => 0, 'merchant' => 0.5],
            'logo' => 'binance-pay.png',
        ],
    ];

    /**
     * Vouchers and credits
     */
    public const VOUCHERS = [
        'platform_credit' => [
            'name' => 'Platform Credit',
            'type' => 'credit',
            'fees' => ['consumer' => 0, 'merchant' => 0],
        ],
        'gift_card' => [
            'name' => 'Gift Card',
            'type' => 'voucher',
            'fees' => ['consumer' => 0, 'merchant' => 0],
        ],
        'promo_code' => [
            'name' => 'Promo Code',
            'type' => 'discount',
            'fees' => ['consumer' => 0, 'merchant' => 0],
        ],
    ];

    /**
     * Get all payment methods for a region
     */
    public static function getMethodsForRegion(string $region): array
    {
        $methods = [];
        
        // Add cards available in region
        foreach (self::CARDS as $key => $card) {
            if (in_array($region, $card['regions']) || in_array('global', $card['regions'])) {
                $methods['card'][$key] = $card;
            }
        }
        
        // Add wallets available in region
        foreach (self::DIGITAL_WALLETS as $key => $wallet) {
            if (in_array($region, $wallet['regions'])) {
                $methods['digital_wallet'][$key] = $wallet;
            }
        }
        
        // Add bank transfers for region
        foreach (self::BANK_TRANSFERS as $key => $transfer) {
            if (in_array($region, $transfer['regions']) || in_array('global', $transfer['regions'])) {
                $methods['bank_transfer'][$key] = $transfer;
            }
        }
        
        return $methods;
    }

    /**
     * Get supported currencies
     */
    public static function getSupportedCurrencies(): array
    {
        return [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'GBP' => 'British Pound',
            'JPY' => 'Japanese Yen',
            'CNY' => 'Chinese Yuan',
            'AUD' => 'Australian Dollar',
            'CAD' => 'Canadian Dollar',
            'CHF' => 'Swiss Franc',
            'HKD' => 'Hong Kong Dollar',
            'SGD' => 'Singapore Dollar',
            'SEK' => 'Swedish Krona',
            'NOK' => 'Norwegian Krone',
            'DKK' => 'Danish Krone',
            'NZD' => 'New Zealand Dollar',
            'INR' => 'Indian Rupee',
            'MXN' => 'Mexican Peso',
            'BRL' => 'Brazilian Real',
            'KRW' => 'South Korean Won',
            'THB' => 'Thai Baht',
            'MYR' => 'Malaysian Ringgit',
            'IDR' => 'Indonesian Rupiah',
            'PHP' => 'Philippine Peso',
            'VND' => 'Vietnamese Dong',
            'ZAR' => 'South African Rand',
            'KES' => 'Kenyan Shilling',
            'GHS' => 'Ghanaian Cedi',
            'EGP' => 'Egyptian Pound',
            'TZS' => 'Tanzanian Shilling',
            'RWF' => 'Rwandan Franc',
        ];
    }

    /**
     * Currency symbols
     */
    public const CURRENCY_SYMBOLS = [
        'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'JPY' => '¥',
        'CNY' => '¥', 'AUD' => 'A$', 'CAD' => 'C$', 'CHF' => 'CHF',
        'HKD' => 'HK$', 'SGD' => 'S$', 'SEK' => 'kr', 'NOK' => 'kr',
        'DKK' => 'kr', 'NZD' => 'NZ$', 'INR' => '₹', 'MXN' => '$',
        'BRL' => 'R$', 'KRW' => '₩', 'THB' => '฿', 'MYR' => 'RM',
        'IDR' => 'Rp', 'PHP' => '₱', 'VND' => '₫', 'ZAR' => 'R',
        'KES' => 'KSh', 'GHS' => 'GH₵', 'EGP' => 'E£', 'TZS' => 'TSh',
    ];
}
