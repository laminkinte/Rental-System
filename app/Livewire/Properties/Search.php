<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public $search = '';
    public $location = '';
    public $check_in = '';
    public $check_out = '';
    public $gambia_category = '';
    public $min_price = '';
    public $max_price = '';
    public $guest_capacity = '';
    public $bedrooms = '';
    public $bathrooms = '';
    public $amenities = [];
    public $instant_book = false;
    public $verified_only = false;
    public $sort_by = 'created_at';
    public $sort_direction = 'desc';
    public $viewMode = 'grid';

    protected $queryString = [
        'search' => ['except' => ''],
        'location' => ['except' => ''],
        'gambia_category' => ['except' => ''],
        'min_price' => ['except' => ''],
        'max_price' => ['except' => ''],
        'guest_capacity' => ['except' => ''],
        'bedrooms' => ['except' => ''],
        'bathrooms' => ['except' => ''],
        'amenities' => ['except' => []],
        'instant_book' => ['except' => false],
        'verified_only' => ['except' => false],
        'sort_by' => ['except' => 'created_at'],
        'sort_direction' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingLocation()
    {
        $this->resetPage();
    }

    public function updatingGambiaCategory()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'location', 'gambia_category', 'min_price', 'max_price', 'guest_capacity', 'bedrooms', 'bathrooms', 'amenities', 'instant_book', 'verified_only']);
        $this->resetPage();
    }

    public function toggleAmenity($amenity)
    {
        if (in_array($amenity, $this->amenities)) {
            $this->amenities = array_diff($this->amenities, [$amenity]);
        } else {
            $this->amenities[] = $amenity;
        }
        $this->resetPage();
    }

    public function sortBy($column)
    {
        if ($this->sort_by === $column) {
            $this->sort_direction = $this->sort_direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort_by = $column;
            $this->sort_direction = 'asc';
        }
        $this->resetPage();
    }

    public function render()
    {
        $properties = Property::query()
            ->where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%')
                      ->orWhere('city', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->location, function ($query) {
                $query->where(function ($q) {
                    $q->where('city', 'like', '%' . $this->location . '%')
                      ->orWhere('address', 'like', '%' . $this->location . '%');
                });
            })
            ->when($this->gambia_category, function ($query) {
                $query->where('gambia_category', $this->gambia_category);
            })
            ->when($this->min_price, function ($query) {
                $query->where('base_price', '>=', $this->min_price);
            })
            ->when($this->max_price, function ($query) {
                $query->where('base_price', '<=', $this->max_price);
            })
            ->when($this->guest_capacity, function ($query) {
                $query->where('guest_capacity', '>=', $this->guest_capacity);
            })
            ->when($this->bedrooms, function ($query) {
                $query->where('bedrooms', '>=', $this->bedrooms);
            })
            ->when($this->bathrooms, function ($query) {
                $query->where('bathrooms', '>=', $this->bathrooms);
            })
            ->when($this->amenities, function ($query) {
                foreach ($this->amenities as $amenity) {
                    $query->where($amenity, true);
                }
            })
            ->when($this->instant_book, function ($query) {
                $query->where('instant_book', true);
            })
            ->when($this->verified_only, function ($query) {
                $query->where('verified_listing', true);
            })
            ->with('host')
            ->orderBy($this->sort_by, $this->sort_direction)
            ->paginate(12);

        $gambiaCategories = [
            'beachfront_villa' => 'Beachfront Villa',
            'island_resort' => 'Island Resort',
            'eco_lodge' => 'Eco Lodge',
            'cultural_homestay' => 'Cultural Homestay',
            'urban_apartment' => 'Urban Apartment',
            'traditional_compound' => 'Traditional Compound',
            'boutique_hotel' => 'Boutique Hotel',
            'guest_house' => 'Guest House',
            'camping_site' => 'Camping Site',
            'river_lodge' => 'River Lodge',
        ];

        $amenityOptions = [
            'running_water' => 'Running Water',
            'electricity' => 'Electricity',
            'wifi' => 'WiFi',
            'air_conditioning' => 'Air Conditioning',
            'kitchen_access' => 'Kitchen Access',
            'parking' => 'Parking',
            'pool' => 'Swimming Pool',
            'terrace' => 'Terrace',
            'garden' => 'Garden',
            'security_guard' => 'Security Guard',
        ];

        return view('livewire.properties.search', [
            'properties' => $properties,
            'gambiaCategories' => $gambiaCategories,
            'amenityOptions' => $amenityOptions,
        ]);
    }
}