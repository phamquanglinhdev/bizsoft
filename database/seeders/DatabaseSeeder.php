<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table("classrooms")->truncate();
        User::query()->create([
            "name" => "Administrator",
            "avatar" => "https://i.pinimg.com/736x/4d/47/59/4d4759f61e13927c5f5b39a4cc66af70.jpg",
            "email" => 'bizsoft@live.com',
            "password" => Hash::make("12345"),
            "phone" => "+840904800240",
            "birthday" => Carbon::create("2002", "1", "7"),
            "role" => "admin",
        ]);
        Student::factory(5000)->create();
        Teacher::factory(50)->create();
        Classroom::factory(20)->create();
    }
}
