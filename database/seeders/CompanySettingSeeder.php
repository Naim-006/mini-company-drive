<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanySetting::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Mini Company Inc.',
                'tagline' => 'Smart business solutions built for growth',
                'email' => 'support@minicompany.test',
                'phone' => '+1 (800) 555-0199',
                'address' => '450 Innovation Parkway, Suite 300, Silicon Oasis, CA 94016',
                'about_summary' => 'Mini Company Inc. is a leading provider of software development, enterprise cloud integrations, and business consultancy services.',
                'about_mission' => 'To accelerate our clients digital transformation through reliable, high-performance software and dedicated engineering excellence.',
                'about_vision' => 'To be the most trusted technology ally for emerging and established enterprises around the globe.',
                'opening_hours' => 'Mon - Fri: 8:30 AM - 5:30 PM PST',
            ]
        );
    }
}
