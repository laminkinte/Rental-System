<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $title;
    public $description;
    public $type = 'entire_place';
    public $guest_capacity = 1;
    public $bedrooms = 1;
    public $bathrooms = 1;
    public $size_sqm;
    public $address;
    public $latitude;
    public $longitude;
    public $city;
    public $country;
    public $base_price;
    public $currency = 'USD';
    public $amenities = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|in:entire_place,private_room,shared_room,unique_space,boutique_hotel,serviced_apartment',
        'guest_capacity' => 'required|integer|min:1',
        'bedrooms' => 'required|integer|min:0',
        'bathrooms' => 'required|integer|min:1',
        'address' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'city' => 'required|string',
        'country' => 'required|string',
        'base_price' => 'required|numeric|min:0',
        'currency' => 'required|string|size:3',
    ];

    public function save()
    {
        $this->validate();

        Property::create([
            'host_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'guest_capacity' => $this->guest_capacity,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'size_sqm' => $this->size_sqm,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'city' => $this->city,
            'country' => $this->country,
            'base_price' => $this->base_price,
            'currency' => $this->currency,
            'amenities' => $this->amenities,
            'rules' => $this->rules,
        ]);

        session()->flash('message', 'Property created successfully!');

        return redirect()->route('properties.index');
    }

    public function render()
    {
        return view('livewire.properties.create');
    }
}