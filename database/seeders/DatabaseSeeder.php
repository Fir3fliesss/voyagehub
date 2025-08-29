<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);


        // \App\Models\User::factory()->create([
        //     'nik' => '1234567890123456',
        //     'name' => 'Test User',
        // ]);

        // \App\Models\Journey::factory()->create([
        //     'user_id' => 1,
        //     'date' => '2025-08-04',
        //     'time' => '15:42:42',
        //     'location' => 'Jakarta',
        //     'temprature' => 25.0,
        // ]);

        \App\Models\Journey::factory(10)->create();
    }
}
