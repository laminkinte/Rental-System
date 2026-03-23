<!-- Wallet Manager View - Airbnb Style -->
<div class="max-w-5xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Wallet</h1>
        <p class="text-gray-500 mt-1">Manage your payments and funds</p>
    </div>

    <!-- Wallet Balance Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-gradient-to-br from-[#FF385C] to-[#FF5A5F] text-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <p class="text-sm opacity-90">Current Balance</p>
                <svg class="w-6 h-6 opacity-75" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                </svg>
            </div>
            <p class="text-4xl font-bold mt-2">${{ number_format($wallet->balance, 2) }}</p>
            <p class="text-xs opacity-75 mt-2">{{ $wallet->currency }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 text-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <p class="text-sm opacity-90">Account Tier</p>
                <svg class="w-6 h-6 opacity-75" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold mt-2 capitalize">{{ $wallet->tier }}</p>
            <p class="text-xs opacity-75 mt-2">
                @switch($wallet->tier)
                    @case('basic') 0% fees @break
                    @case('premium') -1% fees @break
                    @case('business') -2% fees @break
                    @case('host') Priority support @break
                @endswitch
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm text-gray-500">Account Status</p>
                <span class="w-3 h-3 rounded-full {{ $wallet->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $wallet->is_active ? 'Active' : 'Inactive' }}</p>
            <p class="text-xs text-gray-500 mt-2">
                @if($wallet->is_active)
                    Ready to transact
                @else
                    Verification required
                @endif
            </p>
        </div>
    </div>

    <!-- Tab Navigation - Airbnb Style -->
    <div class="flex border-b border-gray-200 mb-6 overflow-x-auto">
        @foreach(['overview', 'transactions', 'add-funds', 'payment-methods'] as $tab)
            <button wire:click="selectTab('{{ $tab }}')" 
                class="px-4 py-3 font-medium text-sm border-b-2 whitespace-nowrap transition-colors
                {{ $selectedTab === $tab 
                    ? 'border-[#FF385C] text-[#FF385C]' 
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                @switch($tab)
                    @case('overview') Overview @break
                    @case('transactions') Transactions @break
                    @case('add-funds') Add Funds @break
                    @case('payment-methods') Payment Methods @break
                @endswitch
            </button>
        @endforeach
    </div>

    <!-- Overview Tab -->
    @if($selectedTab === 'overview')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Wallet Overview</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-gray-500 text-sm">Total Received</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format(collect($transactions)->where('type', 'transfer_in')->sum('amount'), 2) }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-gray-500 text-sm">Total Sent</p>
                    <p class="text-2xl font-bold text-red-500">${{ number_format(collect($transactions)->where('type', 'transfer_out')->sum('amount'), 2) }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-gray-500 text-sm">This Month</p>
                    <p class="text-2xl font-bold text-[#FF385C]">${{ number_format(collect($transactions)->where('created_at', '>=', now()->subMonth())->sum('amount'), 2) }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-gray-500 text-sm">Transactions</p>
                    <p class="text-2xl font-bold text-gray-700">{{ count($transactions) }}</p>
                </div>
            </div>

            <div class="flex gap-3">
                <button wire:click="selectTab('add-funds')" class="bg-[#FF385C] hover:bg-[#E2324A] text-white px-6 py-2.5 rounded-lg font-semibold transition-colors">
                    Add Funds
                </button>
                <button wire:click="selectTab('payment-methods')" class="bg-white border border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                    Payment Methods
                </button>
            </div>
        </div>
    @endif

    <!-- Transactions Tab -->
    @if($selectedTab === 'transactions')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if(count($transactions) === 0)
                <div class="p-12 text-center">
                    <div class="text-5xl mb-4">💳</div>
                    <p class="text-gray-500">No transactions yet</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($transaction['created_at'])->format('MMM d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        @switch($transaction['type'])
                                            @case('transfer_in') bg-green-100 text-green-700 @break
                                            @case('transfer_out') bg-red-100 text-red-700 @break
                                            @case('mobile_money') bg-purple-100 text-purple-700 @break
                                            @default bg-gray-100 text-gray-700
                                        @endswitch
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $transaction['type'])) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction['metadata']['reason'] ?? '—' }}</td>
                                <td class="px-6 py-4 text-right font-semibold {{ $transaction['type'] === 'transfer_in' ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $transaction['type'] === 'transfer_in' ? '+' : '-' }}${{ number_format($transaction['amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                        @switch($transaction['status'])
                                            @case('completed') bg-green-100 text-green-700 @break
                                            @case('processing') bg-yellow-100 text-yellow-700 @break
                                            @case('pending') bg-gray-100 text-gray-700 @break
                                            @case('failed') bg-red-100 text-red-700 @break
                                        @endswitch
                                    ">
                                        {{ ucfirst($transaction['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endif

    <!-- Add Funds Tab -->
    @if($selectedTab === 'add-funds')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 max-w-lg">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Add Funds</h2>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" wire:model="addFundsAmount" placeholder="0.00" step="0.01" min="1"
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition-colors">
                    </div>
                    @error('addFundsAmount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                    <select wire:model="currency" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                        <option value="USD">USD - United States Dollar</option>
                        <option value="EUR">EUR - Euro</option>
                        <option value="GBP">GBP - British Pound</option>
                        <option value="GMD">GMD - Gambian Dalasi</option>
                        <option value="XOF">XOF - West African Franc</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#FF385C] hover:bg-pink-50 transition-colors"
                            @click="$wire.paymentMethod = 'card'">
                            <input type="radio" wire:model="paymentMethod" value="card" class="mr-3 text-[#FF385C]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-xl">💳</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Credit/Debit Card</p>
                                    <p class="text-xs text-gray-500">Visa, Mastercard</p>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#FF385C] hover:bg-pink-50 transition-colors"
                            @click="$wire.paymentMethod = 'mobile_money'">
                            <input type="radio" wire:model="paymentMethod" value="mobile_money" class="mr-3 text-[#FF385C]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="text-xl">📱</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Mobile Money</p>
                                    <p class="text-xs text-gray-500">M-Pesa, Wave, MTN</p>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#FF385C] hover:bg-pink-50 transition-colors"
                            @click="$wire.paymentMethod = 'bank_transfer'">
                            <input type="radio" wire:model="paymentMethod" value="bank_transfer" class="mr-3 text-[#FF385C]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-xl">🏦</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Bank Transfer</p>
                                    <p class="text-xs text-gray-500">Direct bank transfer</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                @if($paymentMethod === 'mobile_money')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Service Provider</label>
                        <select wire:model="serviceProvider" class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                            <option value="mtn">MTN Mobile Money</option>
                            <option value="wave">Wave</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="intelmoney">Intel Money (Gambia)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" wire:model="mobileMoneyNumber" placeholder="+220 XXX XXXX"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-gray-900 focus:ring-1 focus:ring-gray-900">
                        @error('mobileMoneyNumber') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                <button wire:click="addFunds" class="w-full bg-[#FF385C] hover:bg-[#E2324A] text-white py-3 rounded-xl font-semibold transition-colors">
                    Add Funds
                </button>
            </div>
        </div>
    @endif

    <!-- Payment Methods Tab -->
    @if($selectedTab === 'payment-methods')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Payment Methods</h2>
            <p class="text-gray-500 mb-6">Add payment methods for faster checkout</p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center cursor-pointer hover:border-[#FF385C] hover:bg-pink-50 transition-colors">
                    <div class="text-4xl mb-2">💳</div>
                    <p class="font-medium text-gray-700">Add Card</p>
                </div>

                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center cursor-pointer hover:border-[#FF385C] hover:bg-pink-50 transition-colors">
                    <div class="text-4xl mb-2">🏦</div>
                    <p class="font-medium text-gray-700">Bank Account</p>
                </div>

                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center cursor-pointer hover:border-[#FF385C] hover:bg-pink-50 transition-colors">
                    <div class="text-4xl mb-2">📱</div>
                    <p class="font-medium text-gray-700">Mobile Money</p>
                </div>

                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center cursor-pointer hover:border-[#FF385C] hover:bg-pink-50 transition-colors">
                    <div class="text-4xl mb-2">🪙</div>
                    <p class="font-medium text-gray-700">Crypto</p>
                </div>
            </div>
        </div>
    @endif
</div>
