<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nik' => '1234567890',
            'name' => 'John Doe',
        ]);

        DB::table('users')->insert([
            'nik' => '0987654321',
            'name' => 'Jane Smith',
        ]);
    }
}
