<?php

namespace App\Livewire\Profiles;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $username;
    public $bio;
    public $avatar;
    public $country;
    public $preferred_language;
    public $preferred_currency;
    
    // Host-specific fields
    public $is_host;
    public $host_experience_years;
    public $host_response_time;
    
    // New: Host application status
    public $host_application_pending = false;
    
    // Tab state
    public $activeTab = 'basic';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->username = $user->username ?? '';
        $this->bio = $user->bio ?? '';
        $this->country = $user->country ?? '';
        $this->preferred_language = $user->preferred_language ?? 'en';
        $this->preferred_currency = $user->preferred_currency ?? 'GMD';
        $this->is_host = $user->is_host ?? false;
        
        if ($user->profile) {
            $this->host_experience_years = $user->profile->host_experience_years ?? 0;
            $this->host_response_time = $user->profile->host_response_time ?? 'within_a_day';
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'username' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:1000',
            'country' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'username' => $this->username,
            'bio' => $this->bio,
            'country' => $this->country,
            'preferred_language' => $this->preferred_language,
            'preferred_currency' => $this->preferred_currency,
        ]);

        // Update or create profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'host_experience_years' => $this->host_experience_years ?? 0,
                'host_response_time' => $this->host_response_time ?? 'within_a_day',
            ]
        );

        session()->flash('success', 'Profile updated successfully!');
    }

    public function becomeHost()
    {
        $user = Auth::user();
        
        // Set user as host
        $user->update(['is_host' => true]);
        
        // Create or update profile with host info
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'host_experience_years' => 0,
                'host_response_time' => 'within_a_day',
            ]
        );

        $this->is_host = true;
        
        session()->flash('success', 'You are now a host! You can start listing your properties.');
    }

    public function leaveHosting()
    {
        $user = Auth::user();
        $user->update(['is_host' => false]);
        $this->is_host = false;
        
        session()->flash('success', 'You have left the host program. You can rejoin anytime.');
    }

    public function render()
    {
        return view('livewire.profiles.edit');
    }
}
