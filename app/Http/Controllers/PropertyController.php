<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        return view('livewire.properties.create-wizard');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::with('host.profile')->where('is_active', true);

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('guests')) {
            $query->where('guest_capacity', '>=', $request->guests);
        }

        $properties = $query->paginate(20);

        return response()->json($properties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $property = Property::create([
            'host_id' => $request->user()->id,
            ...$request->only([
                'title', 'description', 'type', 'guest_capacity', 'bedrooms', 'bathrooms',
                'address', 'latitude', 'longitude', 'city', 'country', 'base_price', 'currency'
            ]),
            'amenities' => $request->amenities ?? [],
            'photos' => $request->photos ?? [],
            'rules' => $request->rules ?? [],
        ]);

        return response()->json($property, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return response()->json($property->load('host.profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        if ($property->host_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $property->update($request->only([
            'title', 'description', 'type', 'guest_capacity', 'bedrooms', 'bathrooms',
            'address', 'latitude', 'longitude', 'city', 'country', 'base_price', 'currency',
            'amenities', 'photos', 'rules', 'instant_book'
        ]));

        return response()->json($property);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        if ($property->host_id !== request()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $property->delete();

        return response()->json(['message' => 'Property deleted']);
    }
}
