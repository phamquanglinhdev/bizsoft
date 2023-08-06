<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => "HS" . rand(0, 9) . rand(0, 9) . rand(0, 9) . Str::random(5),
            "name" => fake()->lastName() . " " . fake()->lastName() . " " . fake()->firstName(),
            "gender" => rand(0, 1),
            "birthday" => Carbon::now()->toDate(),
            "phone" => fake()->phoneNumber(),
            "parent" => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->address(),
            'email_verified_at' => now(),
            'password' => Hash::make("12345"),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
