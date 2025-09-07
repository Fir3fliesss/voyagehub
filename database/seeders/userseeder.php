<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
public function run(): void
{
// Admin
User::create([
'nik' => 123456,
'name' => 'Admin User',
'email' => 'admin@example.com',
'password' => Hash::make('password'), // default password
'role' => 'admin',
]);

// User Biasa
User::create([
'nik' => 654321,
'name' => 'John Doe',
'email' => 'john@example.com',
'password' => Hash::make('password'),
'role' => 'user',
]);

User::create([
'nik' => 987654,
'name' => 'Jane Smith',
'email' => 'jane@example.com',
'password' => Hash::make('password'),
'role' => 'user',
]);
}
}
