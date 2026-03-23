<?php

namespace App\Livewire;

use App\Models\Property;
use App\Models\SiteSetting;
use Livewire\Component;

class Home extends Component
{
    public $heroSearch = '';
    public $heroLocation = '';
    public $heroCheckIn = '';
    public $heroCheckOut = '';
    public $heroGuests = '';
    
    public function mount()
    {
        $this->heroGuests = '';
    }
    
    public function search()
    {
        $params = [];
        
        if ($this->heroLocation) {
            $params['location'] = $this->heroLocation;
        }
        if ($this->heroCheckIn) {
            $params['check_in'] = $this->heroCheckIn;
        }
        if ($this->heroCheckOut) {
            $params['check_out'] = $this->heroCheckOut;
        }
        if ($this->heroGuests) {
            $params['guest_capacity'] = $this->heroGuests;
        }
        
        return redirect()->route('properties.search', $params);
    }
    
    public function render()
    {
        $siteName = SiteSetting::get('site_name', 'JubbaStay');
        $tagline = SiteSetting::get('tagline', 'Connect & Stay');
        
        $featuredProperties = Property::where('is_active', true)
            ->where('verified_listing', true)
            ->with('host')
            ->orderBy('quality_score', 'desc')
            ->limit(8)
            ->get();
        
        $categories = [
            ['name' => 'Beachfront Villa', 'icon' => '🏖️', 'count' => Property::where('gambia_category', 'beachfront_villa')->where('is_active', true)->count()],
            ['name' => 'Eco Lodge', 'icon' => '🌿', 'count' => Property::where('gambia_category', 'eco_lodge')->where('is_active', true)->count()],
            ['name' => 'Urban Apartment', 'icon' => '🏙️', 'count' => Property::where('gambia_category', 'urban_apartment')->where('is_active', true)->count()],
            ['name' => 'Cultural Homestay', 'icon' => '🏡', 'count' => Property::where('gambia_category', 'cultural_homestay')->where('is_active', true)->count()],
            ['name' => 'Island Resort', 'icon' => '🏝️', 'count' => Property::where('gambia_category', 'island_resort')->where('is_active', true)->count()],
            ['name' => 'Guest House', 'icon' => '🛖', 'count' => Property::where('gambia_category', 'guest_house')->where('is_active', true)->count()],
        ];
        
        $stats = [
            'properties' => Property::where('is_active', true)->count(),
            'guests' => \App\Models\Booking::count(),
            'hosts' => Property::distinct('host_id')->count('host_id'),
            'rating' => Property::avg('quality_score') ?? 4.8,
        ];

        return view('livewire.home', [
            'featuredProperties' => $featuredProperties,
            'categories' => $categories,
            'stats' => $stats,
            'siteName' => $siteName,
            'tagline' => $tagline,
        ]);
    }
}
