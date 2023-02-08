<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = [
            'email' => 'admin@bizsoft.com',
            'name' => 'Admin Biz software',
            'password' => 'password',
            'role' => 'admin',
            'avatar' => 'https://files.catbox.moe/mt8vsg.png',
        ];
        User::create($admin);
    }
}
