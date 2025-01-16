<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123'),
            'role' => 1, // admin
        ]);

        User::create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => Hash::make('password123'),
            'role' => 5, // manager
        ]);

        User::create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => Hash::make('password123'),
            'role' => 9, // user
        ]);
    }
}
