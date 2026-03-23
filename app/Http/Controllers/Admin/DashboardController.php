<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic statistics
        $stats = [
            'total_users' => User::count(),
            'total_properties' => Property::count(),
            'total_bookings' => Booking::count(),
            'total_reviews' => Review::count(),
            'active_properties' => Property::where('is_active', true)->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'verified_properties' => Property::where('verified_listing', true)->count(),
        ];

        // Recent activity
        $recentBookings = Booking::with(['user', 'property'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $recentProperties = Property::with('host')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentProperties', 'recentUsers'));
    }

    public function users()
    {
        $users = User::with('profile')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function properties()
    {
        $properties = Property::with('host')->paginate(20);
        return view('admin.properties.index', compact('properties'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'property'])->paginate(20);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function reviews()
    {
        $reviews = Review::with(['reviewer', 'reviewee', 'booking'])->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function verifyProperty(Property $property)
    {
        $property->update(['verified_listing' => true]);
        return back()->with('success', 'Property verified successfully');
    }

    public function unverifyProperty(Property $property)
    {
        $property->update(['verified_listing' => false]);
        return back()->with('success', 'Property verification removed');
    }

    public function activateProperty(Property $property)
    {
        $property->update(['is_active' => true]);
        return back()->with('success', 'Property activated successfully');
    }

    public function deactivateProperty(Property $property)
    {
        $property->update(['is_active' => false]);
        return back()->with('success', 'Property deactivated successfully');
    }
}
