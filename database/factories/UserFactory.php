<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'cliente',
            'status' => 'activo',
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function recepcionista(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'recepcionista',
        ]);
    }

    public function cliente(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'cliente',
        ]);
    }

    public function inactivo(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactivo',
        ]);
    }
}
