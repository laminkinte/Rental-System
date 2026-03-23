<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'profile_type' => 'required|in:guest,host,experience_provider,corporate',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $profile = Profile::create([
            'user_id' => $user->id,
            'type' => $request->profile_type,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'profile' => $profile,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'profile' => $user->profile,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'profile' => $request->user()->profile,
        ]);
    }

    /**
     * Redirect the user to the social provider authentication page.
     */
    public function redirectToProvider(Request $request, string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.
     */
    public function handleProviderCallback(Request $request, string $provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404);
        }

        $socialUser = Socialite::driver($provider)->stateless()->user();
        $email = $socialUser->getEmail();

        // Find or create user
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'username' => $socialUser->getNickname() ? Str::slug($socialUser->getNickname()) : null,
                'password' => Hash::make(Str::random(16)),
            ]
        );

        // Ensure profile exists
        if (!$user->profile) {
            Profile::create([
                'user_id' => $user->id,
                'type' => 'guest',
                'first_name' => $socialUser->getName() ?: 'Guest',
                'last_name' => '',
            ]);
        }

        Auth::login($user);

        return redirect()->intended('/');
    }
}

