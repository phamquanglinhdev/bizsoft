<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::upper(Str::random(1) . rand(1, 10000)),
            'program' => fake()->words(5, true),
            'pricing' => rand(3, 10) * 1000000,
            'duration' => rand(1, 10) * 100,
            'session' => rand(2, 20),
            'status' => rand(0, 2),
            'schedule' => [
                [
                    'week_day' => 'Monday',
                    'start' => '19:00',
                    'end' => '19:50',
                ],
                [
                    'week_day' => 'Wednesday',
                    'start' => '19:00',
                    'end' => '19:50',
                ],
                [
                    'week_day' => 'Friday',
                    'start' => '19:00',
                    'end' => '19:50',
                ],
            ]
        ];
    }
}
