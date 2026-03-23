<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Notification;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MobileApiController extends Controller
{
    /**
     * Get authenticated user profile
     */
    public function getProfile(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        
        return response()->json([
            'success' => true,
            'user' => $user->load(['properties', 'wallet', 'bookings'])
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user->fresh()
        ]);
    }

    /**
     * Get all properties for the host
     */
    public function getProperties(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        
        $properties = Property::where('host_id', $user->id)
            ->with(['bookings', 'reviews'])
            ->get();

        return response()->json([
            'success' => true,
            'properties' => $properties
        ]);
    }

    /**
     * Get property details
     */
    public function getProperty($propertyId): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        
        $property = Property::with(['bookings', 'reviews', 'amenities', 'photos'])
            ->findOrFail($propertyId);

        if ($property->host_id !== $user->id && !$user->is_admin) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'property' => $property
        ]);
    }

    /**
     * Create new property listing
     */
    public function createProperty(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:entire_place,private_room,shared_room,unique_space,boutique_hotel,serviced_apartment',
            'guest_capacity' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:1',
            'address' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'base_price' => 'required|numeric|min:0',
            'amenities' => 'nullable|array',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $property = Property::create([
            'host_id' => $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'guest_capacity' => $validated['guest_capacity'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'base_price' => $validated['base_price'],
            'amenities' => $validated['amenities'] ?? [],
            'status' => 'pending',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('properties/' . $property->id, 'public');
                $property->photos()->create(['path' => $path]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Property created successfully',
            'property' => $property->load('photos')
        ], 201);
    }

    /**
     * Get user bookings
     */
    public function getBookings(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        
        $bookings = Booking::where('user_id', $user->id)
            ->orWhereHas('property', function($query) use ($user) {
                $query->where('host_id', $user->id);
            })
            ->with(['property', 'user', 'reviews'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'bookings' => $bookings
        ]);
    }

    /**
     * Get booking details
     */
    public function getBooking($bookingId): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        
        $booking = Booking::with(['property', 'user', 'reviews'])
            ->findOrFail($bookingId);

        if ($booking->user_id !== $user->id && $booking->property->host_id !== $user->id) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'booking' => $booking
        ]);
    }

    /**
     * Create a booking
     */
    public function createBooking(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'check_in' => 'required|date_format:Y-m-d|after:today',
            'check_out' => 'required|date_format:Y-m-d|after:check_in',
            'guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        /** @var Property $property */
        $property = Property::findOrFail($validated['property_id']);

        // Check availability
        $conflict = Booking::where('property_id', $property->id)
            ->where('check_in', '<', $validated['check_out'])
            ->where('check_out', '>', $validated['check_in'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($conflict) {
            return response()->json([
                'success' => false,
                'error' => 'Property not available for selected dates'
            ], 422);
        }

        // Calculate total price
        $days = (strtotime($validated['check_out']) - strtotime($validated['check_in'])) / (60 * 60 * 24);
        $totalPrice = $property->base_price * $days;

        $booking = Booking::create([
            'property_id' => $validated['property_id'],
            'user_id' => $user->id,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests'],
            'special_requests' => $validated['special_requests'] ?? null,
            'total_price' => $totalPrice,
            'status' => 'pending_payment',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'booking' => $booking->load('property'),
            'payment_required' => true
        ], 201);
    }

    /**
     * Get user reviews
     */
    public function getReviews(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        
        $reviews = Review::where('reviewee_id', $user->id)
            ->with('reviewer')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'reviews' => $reviews
        ]);
    }

    /**
     * Create a review
     */
    public function createReview(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
            'category_ratings' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        /** @var Booking $booking */
        $booking = Booking::with('property')->findOrFail($validated['booking_id']);

        if ($booking->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        // Check if review already exists
        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return response()->json([
                'success' => false,
                'error' => 'Review already exists for this booking'
            ], 422);
        }

        $review = Review::create([
            'booking_id' => $booking->id,
            'reviewer_id' => $user->id,
            'reviewee_id' => $booking->property->host_id,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'category_ratings' => $validated['category_ratings'] ?? [],
            'verified_stay' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review created successfully',
            'review' => $review->load('reviewer')
        ], 201);
    }

    /**
     * Search properties
     */
    public function searchProperties(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'city' => 'nullable|string|max:255',
            'type' => 'nullable|in:entire_place,private_room,shared_room,unique_space,boutique_hotel,serviced_apartment',
            'guest_capacity' => 'nullable|integer|min:1',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'check_in' => 'nullable|date_format:Y-m-d',
            'check_out' => 'nullable|date_format:Y-m-d|after:check_in',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $query = Property::where('status', 'active');

        if (!empty($validated['city'])) {
            $query->where('city', 'LIKE', '%' . $validated['city'] . '%');
        }

        if (!empty($validated['type'])) {
            $query->where('type', $validated['type']);
        }

        if (!empty($validated['guest_capacity'])) {
            $query->where('guest_capacity', '>=', $validated['guest_capacity']);
        }

        if (!empty($validated['min_price']) && !empty($validated['max_price'])) {
            $query->whereBetween('base_price', [$validated['min_price'], $validated['max_price']]);
        }

        if (!empty($validated['check_in']) && !empty($validated['check_out'])) {
            // Exclude properties with conflicting bookings
            $query->whereDoesntHave('bookings', function($q) use ($validated) {
                $q->where('check_in', '<', $validated['check_out'])
                  ->where('check_out', '>', $validated['check_in'])
                  ->where('status', '!=', 'cancelled');
            });
        }

        $properties = $query->with(['reviews', 'photos'])
            ->paginate(20);

        return response()->json([
            'success' => true,
            'properties' => $properties
        ]);
    }

    /**
     * Get notifications
     */
    public function getNotifications(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markNotificationRead($notificationId): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        
        $notification = Notification::findOrFail($notificationId);

        if ($notification->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 403);
        }

        $notification->update([
            'is_read' => true, 
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    /**
     * Get user wallet
     */
    public function getWallet(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'balance' => 0, 
                'currency' => 'USD', 
                'tier' => 'basic',
                'transaction_history' => []
            ]
        );

        return response()->json([
            'success' => true,
            'wallet' => $wallet
        ]);
    }

    /**
     * Health check endpoint
     */
    public function health(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'API is running',
            'version' => '1.0.0',
            'timestamp' => now()->toIso8601String()
        ]);
    }
}