<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/search', function () {
    return view('search');
})->name('properties.search');

Route::get('/properties/create', \App\Livewire\Properties\CreateWizard::class)->name('properties.create');

Route::get('/properties/{property}', \App\Livewire\Properties\Show::class)->name('properties.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('/magic-link', function () {
        return view('auth.magic-link');
    })->name('auth.magic_link');

    Route::get('/magic-login/{token}', function ($token) {
        $userId = cache()->pull('magic-login:' . $token);

        if (!$userId) {
            return redirect()->route('login')->withErrors(['identifier' => 'Magic link expired or invalid.']);
        }

        $user = App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login')->withErrors(['identifier' => 'Invalid magic link.']);
        }

        Auth::login($user);

        // Redirect based on user role
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard')->with('success', 'Logged in successfully.');
        }
        
        if ($user->isHost()) {
            return redirect('/host/dashboard')->with('success', 'Logged in successfully.');
        }

        return redirect('/')->with('success', 'Logged in successfully.');
    })->name('auth.magic_login.token');

    Route::get('/otp-login', function () {
        return view('auth.otp-login');
    })->name('auth.otp_login');

    Route::get('/auth/redirect/{provider}', [App\Http\Controllers\AuthController::class, 'redirectToProvider'])
        ->name('auth.redirect');

    Route::get('/auth/callback/{provider}', [App\Http\Controllers\AuthController::class, 'handleProviderCallback'])
        ->name('auth.callback');
});

Route::middleware('auth')->group(function () {
    // Dashboard - User dashboard with personalized content
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Properties - My Properties page (hosts see theirs, admin sees all)
    Route::get('/properties', \App\Livewire\Properties\MyProperties::class)->name('properties.index');
    
    // Profile & Account
    Route::get('/profile/edit', function () {
        return view('profiles.edit');
    })->name('profiles.edit');

    Route::get('/account/verification', \App\Livewire\Account\VerificationManager::class)->name('account.verification');

    // Notifications
    Route::get('/notifications', function () {
        return view('livewire.notifications.notification-center');
    })->name('notifications.index');

    // Bookings
    Route::get('/bookings', \App\Livewire\Bookings\Index::class)->name('bookings.index');
    
    Route::get('/bookings/create/{property}', function (App\Models\Property $property) {
        return view('bookings.create', compact('property'));
    })->name('bookings.create');

    Route::get('/bookings/{booking}', function (App\Models\Booking $booking) {
        if ($booking->user_id !== Auth::id() && $booking->property->host_id !== Auth::id()) {
            abort(403);
        }
        return view('bookings.show', compact('booking'));
    })->name('bookings.show');

    Route::get('/bookings/{booking}/payment', function (App\Models\Booking $booking) {
        return view('bookings.payment', compact('booking'));
    })->name('bookings.payment');

    Route::get('/bookings/{booking}/confirmation', function (App\Models\Booking $booking) {
        return view('bookings.confirmation', compact('booking'));
    })->name('booking.confirmation');

    // Group Bookings
    Route::get('/group-bookings', \App\Livewire\Bookings\GroupBookingCreator::class)->name('group-bookings.create');

    Route::get('/group-bookings/{groupBooking}', function () {
        return view('livewire.bookings.group-booking-show');
    })->name('group-bookings.show');

    // Wallet
    Route::get('/wallet', \App\Livewire\Wallet\WalletManager::class)->name('wallet.index');

    // Host Dashboard
    Route::get('/host/dashboard', \App\Livewire\Host\Dashboard::class)->name('host.dashboard');

    // Host Reports - accessible to hosts
    Route::get('/host/reports', \App\Livewire\Host\HostReports::class)->name('host.reports');

    // Messaging - Index page lists conversations
    Route::get('/messages', \App\Livewire\Messages\Index::class)->name('messages.index');

    // Messaging - Chat with specific user
    Route::get('/messages/{user}', \App\Livewire\Messages\ChatBox::class)->name('messages.show');

    // Reviews
    Route::get('/reviews/create/{booking}', function () {
        return view('livewire.reviews.create-review');
    })->name('reviews.create');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\AdminDashboard::class)->name('dashboard');

        Route::get('/users', \App\Livewire\Admin\UserManagement::class)->name('users');
        Route::get('/properties', \App\Livewire\Properties\MyProperties::class)->name('properties');
        Route::get('/bookings', \App\Livewire\Bookings\Index::class)->name('bookings');
        Route::get('/reviews', [App\Http\Controllers\Admin\DashboardController::class, 'reviews'])->name('reviews');
        Route::get('/settings', \App\Livewire\Admin\SettingsManager::class)->name('settings');

        // Reports
        Route::get('/reports', \App\Livewire\Admin\Reports::class)->name('reports');

        // Host Reports
        Route::get('/host/reports', \App\Livewire\Host\HostReports::class)->name('host.reports');

        // Property management actions - using Livewire component methods
        Route::post('/properties/{property}/verify', [\App\Http\Controllers\Admin\DashboardController::class, 'verifyProperty'])->name('properties.verify');
        Route::post('/properties/{property}/unverify', [\App\Http\Controllers\Admin\DashboardController::class, 'unverifyProperty'])->name('properties.unverify');
        Route::post('/properties/{property}/activate', [\App\Http\Controllers\Admin\DashboardController::class, 'activateProperty'])->name('properties.activate');
        Route::post('/properties/{property}/deactivate', [\App\Http\Controllers\Admin\DashboardController::class, 'deactivateProperty'])->name('properties.deactivate');
    });
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
