<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'tenant_name' => 'Barclays',
            'tenant_service' => 'Banking',
        ]);

        Tenant::create([
            'tenant_name' => 'Vodafone',
            'tenant_service' => 'Telecom',
        ]);

        Tenant::create([
            'tenant_name' => 'Three',
            'tenant_service' => 'Telecom',
        ]);

        
    }
}
