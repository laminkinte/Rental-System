<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'phone' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'guest',
            'is_verified' => fake()->boolean(70),
            'verification_level' => fake()->numberBetween(1, 3),
            'profile_completed' => fake()->boolean(80),
            'preferred_language' => 'en',
            'preferred_currency' => 'USD',
        ];
    }

    public function guest(): static
    {
        return $this->state(fn (array $attributes) => ['role' => 'guest']);
    }

    public function host(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'host',
            'is_host' => true,
            'host_verified' => true,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => ['role' => 'admin']);
    }

    public function superhost(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'host',
            'is_host' => true,
            'host_verified' => true,
            'superhost' => true,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
