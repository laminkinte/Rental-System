<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $city = '';
    public $guests = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Property::with('host.profile')->where('is_active', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->city) {
            $query->where('city', 'like', '%' . $this->city . '%');
        }

        if ($this->guests) {
            $query->where('guest_capacity', '>=', $this->guests);
        }

        $properties = $query->paginate(12);

        return view('livewire.properties.index', compact('properties'));
    }
}