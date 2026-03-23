<?php

namespace App\Livewire\Admin;

use App\Models\SiteSetting;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingsManager extends Component
{
    use WithFileUploads;

    public $activeTab = 'general';
    public $settings = [];
    
    // General
    public $site_name;
    public $tagline;
    public $description;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $country;
    
    // Branding
    public $logo;
    public $favicon;
    public $primary_color;
    public $secondary_color;
    public $accent_color;
    
    // Locale
    public $currency;
    public $currency_symbol;
    public $date_format;
    public $time_format;
    public $timezone;
    public $language;
    
    // Booking
    public $min_booking_amount;
    public $max_booking_amount;
    public $min_guests;
    public $max_guests;
    public $default_check_in;
    public $default_check_out;
    
    // Fees
    public $service_fee_percent;
    public $host_fee_percent;
    public $payment_processing_fee;
    
    // Social
    public $facebook_url;
    public $twitter_url;
    public $instagram_url;
    public $linkedin_url;
    public $youtube_url;
    
    // SEO
    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->site_name = SiteSetting::get('site_name', 'Connect & Stay');
        $this->tagline = SiteSetting::get('tagline', 'Connect & Stay');
        $this->description = SiteSetting::get('description', '');
        $this->email = SiteSetting::get('email', '');
        $this->phone = SiteSetting::get('phone', '');
        $this->address = SiteSetting::get('address', '');
        $this->city = SiteSetting::get('city', '');
        $this->country = SiteSetting::get('country', '');
        
        $this->primary_color = SiteSetting::get('primary_color', '#FF385C');
        $this->secondary_color = SiteSetting::get('secondary_color', '#00A699');
        $this->accent_color = SiteSetting::get('accent_color', '#FF5A5F');
        
        $this->currency = SiteSetting::get('currency', 'USD');
        $this->currency_symbol = SiteSetting::get('currency_symbol', '$');
        $this->date_format = SiteSetting::get('date_format', 'M d, Y');
        $this->time_format = SiteSetting::get('time_format', 'h:i A');
        $this->timezone = SiteSetting::get('timezone', 'UTC');
        $this->language = SiteSetting::get('language', 'en');
        
        $this->min_booking_amount = SiteSetting::get('min_booking_amount', 10);
        $this->max_booking_amount = SiteSetting::get('max_booking_amount', 10000);
        $this->min_guests = SiteSetting::get('min_guests', 1);
        $this->max_guests = SiteSetting::get('max_guests', 20);
        $this->default_check_in = SiteSetting::get('default_check_in', '15:00');
        $this->default_check_out = SiteSetting::get('default_check_out', '11:00');
        
        $this->service_fee_percent = SiteSetting::get('service_fee_percent', 5);
        $this->host_fee_percent = SiteSetting::get('host_fee_percent', 3);
        $this->payment_processing_fee = SiteSetting::get('payment_processing_fee', 2.9);
        
        $this->facebook_url = SiteSetting::get('facebook_url', '');
        $this->twitter_url = SiteSetting::get('twitter_url', '');
        $this->instagram_url = SiteSetting::get('instagram_url', '');
        $this->linkedin_url = SiteSetting::get('linkedin_url', '');
        $this->youtube_url = SiteSetting::get('youtube_url', '');
        
        $this->meta_title = SiteSetting::get('meta_title', '');
        $this->meta_description = SiteSetting::get('meta_description', '');
        $this->meta_keywords = SiteSetting::get('meta_keywords', '');
    }

    public function saveGeneral()
    {
        $this->saveSettings([
            'site_name' => $this->site_name,
            'tagline' => $this->tagline,
            'description' => $this->description,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
        ]);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => 'General settings saved!']);
    }

    public function saveBranding()
    {
        $this->saveSettings([
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'accent_color' => $this->accent_color,
        ]);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Branding settings saved!']);
    }

    public function saveLocale()
    {
        $this->saveSettings([
            'currency' => $this->currency,
            'currency_symbol' => $this->currency_symbol,
            'date_format' => $this->date_format,
            'time_format' => $this->time_format,
            'timezone' => $this->timezone,
            'language' => $this->language,
        ]);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Locale settings saved!']);
    }

    public function saveBooking()
    {
        $this->saveSettings([
            'min_booking_amount' => $this->min_booking_amount,
            'max_booking_amount' => $this->max_booking_amount,
            'min_guests' => $this->min_guests,
            'max_guests' => $this->max_guests,
            'default_check_in' => $this->default_check_in,
            'default_check_out' => $this->default_check_out,
        ]);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Booking settings saved!']);
    }

    public function saveFees()
    {
        $this->saveSettings([
            'service_fee_percent' => $this->service_fee_percent,
            'host_fee_percent' => $this->host_fee_percent,
            'payment_processing_fee' => $this->payment_processing_fee,
        ]);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Fee settings saved!']);
    }

    public function saveSocial()
    {
        $this->saveSettings([
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
        ]);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Social settings saved!']);
    }

    public function saveSeo()
    {
        $this->saveSettings([
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
        ]);
        
        $this->dispatch('notify', ['type' => 'success', 'message' => 'SEO settings saved!']);
    }

    private function saveSettings(array $settings)
    {
        foreach ($settings as $key => $value) {
            SiteSetting::set($key, $value);
        }
    }

    public function resetToDefaults()
    {
        $defaults = SiteSetting::defaults();
        
        foreach ($defaults as $key => $config) {
            SiteSetting::set($key, $config[0], $config[1] ?? 'string', $config[2] ?? 'general');
        }
        
        $this->loadSettings();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Settings reset to defaults!']);
    }

    public function render()
    {
        return view('livewire.admin.settings-manager');
    }
}
