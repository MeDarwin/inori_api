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
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'email'    => fake()->unique()->safeEmail(),
            'nis_nip'  => fake()->unique()->numberBetween(1000, 999999999999999999),
            'nisn'  => fake()->unique()->numberBetween(1000000000, 9999999999),
            'role'     => fake()->randomElement(['member', 'admin', 'club_leader', 'osis', 'club_mentor']),
            'password' => static::$password ??= Hash::make('password123'),
        ];
    }
}
