<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make("admin"),
            'role' => 'admin',
            'phone' => '08123456789',
            'bio' => 'An administrator',
        ])->create();

        User::factory([
            'name' => 'Member',
            'email' => 'member@member.com',
            'password' => Hash::make("member"),
            'role' => 'member',
            'phone' => '08123456789',
            'bio' => 'A member',
        ])->create();
    }
}
