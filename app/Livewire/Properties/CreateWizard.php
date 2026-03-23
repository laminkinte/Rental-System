<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class CreateWizard extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 7;

    // Step 1: Property Type & Capacity
    public $type = '';
    public $guest_capacity = 2;
    public $bedrooms = 1;
    public $bathrooms = 1;
    public $size_sqm = '';

    // Step 2: Location
    public $address = '';
    public $city = '';
    public $latitude = '';
    public $longitude = '';
    public $location_privacy = 'exact';

    // Step 3: Photos
    public $uploadedPhotos = [];
    public $photos = [];

    // Step 4: Amenities
    public $amenities = [];

    // Step 5: Availability
    public $min_stay = 1;
    public $max_stay = 30;
    public $check_in_time = '15:00';
    public $check_out_time = '11:00';
    public $early_check_in = false;
    public $late_check_out = false;
    public $self_check_in = false;

    // Step 6: Pricing
    public $base_price = '';
    public $cleaning_fee = '';
    public $extra_guest_fee = '';
    public $weekly_discount = '';
    public $monthly_discount = '';
    public $security_deposit = '';
    public $instant_book = false;

    // Step 7: Title, Description & Rules
    public $title = '';
    public $description = '';
    public $cancellation_policy = 'flexible';
    public $pet_policy = 'allowed';
    public $smoking_policy = 'allowed';
    public $house_rules = '';

    public function mount()
    {
        // Check if user is a host
        $user = Auth::user();
        if (!$user || !$user->is_host) {
            $this->redirect(route('dashboard'), navigate: true);
        }
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'type' => 'required|string',
            'guest_capacity' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:1',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'base_price' => 'required|numeric|min:1',
        ];
    }

    public function nextStep()
    {
        if ($this->currentStep < $this->totalSteps) {
            $this->validateStep();
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->validate([
                    'type' => 'required|string',
                    'guest_capacity' => 'required|integer|min:1',
                    'bedrooms' => 'required|integer|min:0',
                    'bathrooms' => 'required|integer|min:1',
                ]);
                break;
            case 2:
                $this->validate([
                    'address' => 'required|string|max:255',
                    'city' => 'required|string|max:100',
                ]);
                break;
            case 3:
                // Photos are optional
                break;
            case 4:
                // Amenities are optional
                break;
            case 5:
                // Availability is optional
                break;
            case 6:
                $this->validate([
                    'base_price' => 'required|numeric|min:1',
                ]);
                break;
            case 7:
                $this->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required|string|min:20',
                ]);
                break;
        }
    }

    public function uploadPhotos()
    {
        $this->validate([
            'uploadedPhotos.*' => 'image|max:5120',
        ]);

        foreach ($this->uploadedPhotos as $photo) {
            $path = $photo->store('properties', 'public');
            $this->photos[] = asset('storage/' . $path);
        }

        $this->uploadedPhotos = [];
    }

    public function removePhoto($index)
    {
        if (isset($this->photos[$index])) {
            array_splice($this->photos, $index, 1);
        }
    }

    public function submit()
    {
        $this->validate();

        try {
            // Set default coordinates for Gambia if not provided
            $latitude = $this->latitude ?: (13.443182 + (rand(-100, 100) / 10000));
            $longitude = $this->longitude ?: (-15.310139 + (rand(-100, 100) / 10000));

            $property = Property::create([
                'host_id' => Auth::id(),
                'title' => $this->title,
                'description' => $this->description,
                'property_type' => $this->type,
                'gambia_category' => null,
                'address' => $this->address,
                'city' => $this->city,
                'country' => 'Gambia',
                'latitude' => $latitude,
                'longitude' => $longitude,
                'guest_capacity' => $this->guest_capacity,
                'bedrooms' => $this->bedrooms,
                'beds' => $this->bedrooms,
                'bathrooms' => $this->bathrooms,
                'base_price' => $this->base_price,
                'cleaning_fee' => $this->cleaning_fee ?: 0,
                'weekly_discount' => $this->weekly_discount ?: 0,
                'monthly_discount' => $this->monthly_discount ?: 0,
                'extra_guest_fee' => $this->extra_guest_fee ?: 0,
                'security_deposit' => $this->security_deposit ?: 0,
                'images' => array_map(function($photo) {
                    return str_replace(asset('storage/'), '', $photo);
                }, $this->photos),
                'amenities' => $this->amenities,
                'min_nights' => $this->min_stay,
                'max_nights' => $this->max_stay,
                'check_in_time' => $this->check_in_time,
                'check_out_time' => $this->check_out_time,
                'instant_book' => $this->instant_book,
                'cancellation_policy' => $this->cancellation_policy,
                'house_rules' => $this->house_rules,
                'is_active' => false, // Pending review
            ]);

            Log::info('Property created successfully', ['property_id' => $property->id]);

            return redirect()->route('host.dashboard')
                           ->with('success', 'Property listed successfully! It will be reviewed by an admin.');

        } catch (\Exception $e) {
            Log::error('Property creation failed', ['error' => $e->getMessage()]);
            $this->addError('general', 'Failed to create property: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.properties.create-wizard');
    }
}
