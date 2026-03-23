<?php

namespace App\Livewire\Wallet;

use App\Models\Wallet;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class WalletManager extends Component
{
    use WithPagination;

    public $selectedTab = 'overview'; // overview, transactions, add-funds, payment-methods
    public $addFundsAmount = '';
    public $paymentMethod = 'card';
    public $currency = 'USD';
    public $bankName = '';
    public $accountNumber = '';
    public $accountHolder = '';
    public $mobileMoneyNumber = '';
    public $serviceProvider = 'mtn'; // mtn, wave, mpesa, vodafone

    protected $rules = [
        'addFundsAmount' => 'required|numeric|min:1|max:100000',
        'currency' => 'required|in:USD,EUR,GBP,MWK,GMD,KES,GHS,XOF',
        'bankName' => 'nullable|string',
        'accountNumber' => 'nullable|string',
        'mobileMoneyNumber' => 'nullable|string|regex:/^[0-9\+]{7,15}$/',
    ];

    public function selectTab($tab)
    {
        $this->selectedTab = $tab;
    }

    /**
     * Get the current user's wallet
     * 
     * @return Wallet
     */
    public function getWallet()
    {
        $userId = Auth::id();
        
        return Wallet::firstOrCreate(
            ['user_id' => $userId],
            [
                'balance' => 0, 
                'currency' => 'USD', 
                'tier' => 'basic',
                'transaction_history' => []
            ]
        );
    }

    public function addFunds()
    {
        $this->validate([
            'addFundsAmount' => 'required|numeric|min:1|max:100000',
            'paymentMethod' => 'required|in:card,bank_transfer,mobile_money',
        ]);

        $wallet = $this->getWallet();

        if ($this->paymentMethod === 'card') {
            // Redirect to Stripe payment
            return redirect()->route('wallet.stripe-payment', [
                'amount' => $this->addFundsAmount,
                'currency' => $wallet->currency,
            ]);
        } elseif ($this->paymentMethod === 'bank_transfer') {
            $this->validate([
                'bankName' => 'required|string',
                'accountNumber' => 'required|string',
            ]);

            // Create bank transfer pending transaction
            $this->addTransaction('pending', 'bank_transfer', $this->addFundsAmount, [
                'bank_name' => $this->bankName,
                'account_number' => $this->accountNumber,
                'account_holder' => $this->accountHolder ?: Auth::user()->name,
            ]);

            session()->flash('info', 'Bank transfer initiated. You will receive confirmation in 2-3 business days.');
            
            // Reset form fields
            $this->bankName = '';
            $this->accountNumber = '';
            $this->accountHolder = '';
        } elseif ($this->paymentMethod === 'mobile_money') {
            $this->validate([
                'mobileMoneyNumber' => 'required|string',
                'serviceProvider' => 'required|in:mtn,wave,mpesa,vodafone,intelmoney',
            ]);

            // Initialize mobile money payment
            $this->initiateMobileMoneyPayment();
        }

        $this->addFundsAmount = '';
    }

    public function initiateMobileMoneyPayment()
    {
        $wallet = $this->getWallet();

        $providers = [
            'mtn' => ['country' => 'GM', 'code' => '220'],
            'wave' => ['country' => 'SN', 'code' => '221'],
            'mpesa' => ['country' => 'KE', 'code' => '254'],
            'vodafone' => ['country' => 'GH', 'code' => '233'],
            'intelmoney' => ['country' => 'GM', 'code' => '220-intel'],
        ];

        $provider = $providers[$this->serviceProvider] ?? $providers['mtn'];

        // TODO: Integrate with actual mobile money provider API
        // This is a placeholder for future integration with:
        // - M-Pesa (Safaricom - Kenya)
        // - Wave (Senegal)
        // - MTN Mobile Money (Multiple countries)
        // - Vodafone Cash (Ghana)
        // - Intel Money (Gambia)

        $this->addTransaction('processing', 'mobile_money', $this->addFundsAmount, [
            'provider' => $this->serviceProvider,
            'phone' => $this->mobileMoneyNumber,
            'country' => $provider['country'],
        ]);

        // Reset mobile money fields
        $this->mobileMoneyNumber = '';

        session()->flash('success', 'Mobile money payment initiated. Check your phone for confirmation.');
    }

    /**
     * Add a transaction to the wallet history
     * 
     * @param string $status
     * @param string $type
     * @param float $amount
     * @param array $metadata
     * @return void
     */
    public function addTransaction($status, $type, $amount, $metadata = [])
    {
        $wallet = $this->getWallet();
        $history = $wallet->transaction_history ?? [];

        $transaction = [
            'id' => uniqid('txn_', true),
            'type' => $type,
            'status' => $status,
            'amount' => $amount,
            'balance_before' => $wallet->balance,
            'balance_after' => $status === 'completed' ? $wallet->balance + $amount : $wallet->balance,
            'metadata' => $metadata,
            'created_at' => now()->toIso8601String(),
        ];

        $history[] = $transaction;

        if ($status === 'completed') {
            $wallet->update([
                'balance' => $wallet->balance + $amount,
                'transaction_history' => $history,
            ]);
        } else {
            $wallet->update(['transaction_history' => $history]);
        }
    }

    /**
     * Transfer funds from current user to a host
     * 
     * @param float $amount
     * @param int $hostId
     * @return void
     */
    public function transferToHost($amount, $hostId)
    {
        $wallet = $this->getWallet();

        if ($wallet->balance < $amount) {
            $this->addError('balance', 'Insufficient wallet balance');
            return;
        }

        // Deduct from guest wallet
        $this->addTransaction('completed', 'transfer_out', $amount, [
            'recipient_id' => $hostId,
            'type' => 'host_payment',
        ]);

        // Update wallet balance directly
        $wallet->balance -= $amount;
        $wallet->save();

        // Add to host wallet
        $hostWallet = Wallet::firstOrCreate(
            ['user_id' => $hostId],
            [
                'balance' => 0, 
                'currency' => $wallet->currency, 
                'tier' => 'host',
                'transaction_history' => []
            ]
        );

        $hostHistory = $hostWallet->transaction_history ?? [];
        $hostHistory[] = [
            'id' => uniqid('txn_', true),
            'type' => 'transfer_in',
            'status' => 'completed',
            'amount' => $amount,
            'balance_before' => $hostWallet->balance,
            'balance_after' => $hostWallet->balance + $amount,
            'metadata' => ['sender_id' => Auth::id()],
            'created_at' => now()->toIso8601String(),
        ];

        $hostWallet->update([
            'balance' => $hostWallet->balance + $amount,
            'transaction_history' => $hostHistory,
        ]);

        session()->flash('success', 'Payment sent successfully');
    }

    /**
     * Withdraw funds from wallet
     * 
     * @param float $amount
     * @return void
     */
    public function withdrawFunds($amount)
    {
        $wallet = $this->getWallet();

        if ($wallet->balance < $amount) {
            $this->addError('balance', 'Insufficient balance for withdrawal');
            return;
        }

        $paymentMethods = $wallet->payment_methods ?? [];
        
        $this->addTransaction('processing', 'withdrawal', $amount, [
            'method' => !empty($paymentMethods) ? $paymentMethods[0] : 'bank_transfer',
        ]);

        session()->flash('info', 'Withdrawal request submitted. Funds will be transferred in 3-5 business days.');
    }

    public function render()
    {
        $wallet = $this->getWallet();
        
        // Get transaction history and paginate
        $transactions = collect($wallet->transaction_history ?? [])
            ->sortByDesc('created_at')
            ->values()
            ->toArray();
        
        // Manual pagination since we're working with an array
        $page = request()->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $items = array_slice($transactions, $offset, $perPage);
        
        $paginatedTransactions = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            count($transactions),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.wallet.wallet-manager', [
            'wallet' => $wallet,
            'transactions' => $paginatedTransactions,
        ]);
    }
}