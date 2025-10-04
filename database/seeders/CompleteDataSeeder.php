<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Journey;
use App\Models\TravelRequest;
use App\Models\AppConfiguration;
use App\Models\ReportTemplate;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CompleteDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'nik' => 100001,
            'name' => 'Administrator',
            'email' => 'admin@voyagehub.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $users = [
            [
                'nik' => 200001,
                'name' => 'Ahmad Suryadi',
                'email' => 'ahmad.suryadi@company.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'nik' => 200002,
                'name' => 'Siti Nurhasanah',
                'email' => 'siti.nurhasanah@company.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'nik' => 200003,
                'name' => 'Budi Hartono',
                'email' => 'budi.hartono@company.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'nik' => 200004,
                'name' => 'Dewi Sartika',
                'email' => 'dewi.sartika@company.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
        ];

        $createdUsers = [];
        foreach ($users as $userData) {
            $createdUsers[] = User::create($userData);
        }

        // 2. Seed App Configurations
        $configs = [
            [
                'organization_id' => 1,
                'key' => 'app_name',
                'value' => 'PT Maju Bersama - VoyageHub',
            ],
            [
                'organization_id' => 1,
                'key' => 'primary_color',
                'value' => '#2563eb',
            ],
            [
                'organization_id' => 1,
                'key' => 'secondary_color',
                'value' => '#64748b',
            ],
            [
                'organization_id' => 1,
                'key' => 'logo_path',
                'value' => '/images/company-logo.png',
            ],
            [
                'organization_id' => 1,
                'key' => 'footer_text',
                'value' => '© 2025 PT Maju Bersama. All rights reserved.',
            ],
        ];

        foreach ($configs as $config) {
            AppConfiguration::create($config);
        }

        // 3. Seed Travel Requests
        $travelRequests = [
            [
                'user_id' => $createdUsers[0]->id,
                'purpose' => 'Meeting with Client',
                'destination' => 'Jakarta',
                'start_date' => '2025-01-15',
                'end_date' => '2025-01-17',
                'budget' => 3000000.00,
                'status' => 'approved',
                'notes' => 'Important client meeting for new project',
                'approved_by' => $admin->id,
                'approved_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_id' => $createdUsers[1]->id,
                'purpose' => 'Training Workshop',
                'destination' => 'Bandung',
                'start_date' => '2025-02-01',
                'end_date' => '2025-02-03',
                'budget' => 2500000.00,
                'status' => 'pending',
                'notes' => 'Professional development training',
                'approved_by' => null,
                'approved_at' => null,
            ],
            [
                'user_id' => $createdUsers[2]->id,
                'purpose' => 'Site Inspection',
                'destination' => 'Surabaya',
                'start_date' => '2025-01-25',
                'end_date' => '2025-01-27',
                'budget' => 4000000.00,
                'status' => 'approved',
                'notes' => 'Monthly site inspection',
                'approved_by' => $admin->id,
                'approved_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_id' => $createdUsers[3]->id,
                'purpose' => 'Conference Attendance',
                'destination' => 'Bali',
                'start_date' => '2025-03-10',
                'end_date' => '2025-03-12',
                'budget' => 5500000.00,
                'status' => 'rejected',
                'notes' => 'International tech conference',
                'approved_by' => $admin->id,
                'approved_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($travelRequests as $request) {
            TravelRequest::create($request);
        }

        // 4. Seed Journeys (for approved travel requests)
        $journeys = [
            [
                'user_id' => $createdUsers[0]->id,
                'title' => 'Client Meeting - Jakarta',
                'destination' => 'Jakarta',
                'start_date' => '2025-01-15',
                'end_date' => '2025-01-17',
                'transport' => 'Flight',
                'accommodation' => 'Hotel Meridien',
                'budget' => 3000000.00,
                'notes' => 'Successful client meeting, secured new contract',
            ],
            [
                'user_id' => $createdUsers[2]->id,
                'title' => 'Site Inspection - Surabaya',
                'destination' => 'Surabaya',
                'start_date' => '2025-01-25',
                'end_date' => '2025-01-27',
                'transport' => 'Train',
                'accommodation' => 'Hotel Tunjungan',
                'budget' => 4000000.00,
                'notes' => 'Site inspection completed, all facilities in good condition',
            ],
            [
                'user_id' => $createdUsers[0]->id,
                'title' => 'Market Research - Yogyakarta',
                'destination' => 'Yogyakarta',
                'start_date' => '2024-12-20',
                'end_date' => '2024-12-22',
                'transport' => 'Car',
                'accommodation' => 'Hotel Phoenix',
                'budget' => 2200000.00,
                'notes' => 'Market research for expansion opportunities',
            ],
            [
                'user_id' => $createdUsers[1]->id,
                'title' => 'Vendor Meeting - Medan',
                'destination' => 'Medan',
                'start_date' => '2024-12-10',
                'end_date' => '2024-12-12',
                'transport' => 'Flight',
                'accommodation' => 'Hotel Cambridge',
                'budget' => 3500000.00,
                'notes' => 'Negotiated better terms with key vendor',
            ],
            [
                'user_id' => $createdUsers[3]->id,
                'title' => 'Team Building - Bogor',
                'destination' => 'Bogor',
                'start_date' => '2024-11-25',
                'end_date' => '2024-11-26',
                'transport' => 'Bus',
                'accommodation' => 'Resort Puncak',
                'budget' => 1800000.00,
                'notes' => 'Team building activities successfully completed',
            ],
        ];

        foreach ($journeys as $journey) {
            Journey::create($journey);
        }

        // 5. Seed Report Templates
        $reportTemplates = [
            [
                'organization_id' => 1,
                'name' => 'Default Excel Report',
                'type' => 'excel',
                'template_path' => '/templates/org1/default.xlsx',
                'is_default' => true,
            ],
            [
                'organization_id' => 1,
                'name' => 'Monthly PDF Report',
                'type' => 'pdf',
                'template_path' => '/templates/org1/monthly.pdf',
                'is_default' => false,
            ],
            [
                'organization_id' => 1,
                'name' => 'Detailed Excel Report',
                'type' => 'excel',
                'template_path' => '/templates/org1/detailed.xlsx',
                'is_default' => false,
            ],
        ];

        foreach ($reportTemplates as $template) {
            ReportTemplate::create($template);
        }
    }
}