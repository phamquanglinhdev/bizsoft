<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => "GV" . rand(0, 9) . rand(0, 9) . rand(0, 9) . Str::random(5),
            "name" => fake()->lastName() . " " . fake()->lastName() . " " . fake()->firstName(),
            "gender" => rand(0, 1),
            "birthday" => Carbon::now()->toDate(),
            "phone" => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail() . "gv",
            'address' => fake()->address(),
            'email_verified_at' => now(),
            'password' => Hash::make("12345"),
            'remember_token' => Str::random(10),
        ];
    }
}
