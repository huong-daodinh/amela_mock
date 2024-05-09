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
        $department_id = $this->faker->numberBetween(1,4);
        $phone = $this->faker->numerify('#########');
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'department_id' => $department_id,
            'password' => static::$password ??= Hash::make('password123'),
            'date_of_birth' => $this->faker->date(),
            'is_admin' => 0,
            'gender' => $this->faker->numberBetween(0,1),
            'address' => $this->faker->streetAddress(),
            'phone' => str_pad($phone, 10, '0', STR_PAD_LEFT),
            'status' => 0,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
