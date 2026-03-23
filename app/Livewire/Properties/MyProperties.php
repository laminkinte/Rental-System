<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MyProperties extends Component
{
    use WithPagination;

    public $search = '';
    public $status = ''; // 'all', 'active', 'inactive'

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        
        // Start query based on user role
        if ($user->isAdmin()) {
            // Admin sees all properties
            $query = Property::with('host.profile');
        } else {
            // Hosts see only their own properties
            $query = Property::where('host_id', $user->id)->with('host.profile');
        }

        // Apply filters
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status === 'active') {
            $query->where('is_active', true);
        } elseif ($this->status === 'inactive') {
            $query->where('is_active', false);
        }

        $properties = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('livewire.properties.my-properties', compact('properties'));
    }
}
