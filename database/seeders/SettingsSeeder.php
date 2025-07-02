<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         if (Settings::count() == 0) {
            Settings::create([
            'bname' => 'Abusidiq Digital Concept',
            'email' => 'abusidiqdigitals@example.com',
            'phone' => '+44 123 456 7890',
            'currency' => 'GBP',
            ]);
        }
    }
}
