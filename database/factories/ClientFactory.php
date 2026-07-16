<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->cliente(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->numerify('555########'),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'id_type' => fake()->randomElement(['INE', 'Pasaporte', 'Licencia', 'Otro']),
            'id_number' => fake()->bothify('###########'),
            'nationality' => 'Mexicana',
        ];
    }
}
