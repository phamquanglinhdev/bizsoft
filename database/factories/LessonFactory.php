<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'session' => rand(1, 90),
            'classroom_id' => '11',
            'teacher_id' => '5077',
            'title' => fake()->words(10),
            'day' => Carbon::now(),
            'start' => "19:00",
            'end' => "19:40",
            'attendances' => "[]",
            'hour_salary' => 200000,
            'exercises' => null,
        ];
    }
}
