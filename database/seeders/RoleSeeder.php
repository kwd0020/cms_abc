<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'SystemAdmin',
            'description' => 'Configures and maintains the system while managing tenants, users and permissions within the system.',
        ]);

        Role::create([
            'name' => 'Manager',
            'description' => 'A staff member of one of the tenants that monitors performance of support persons and help desk agents',
        ]);

        Role::create([
            'name' => 'Agent',
            'description' => 'A staff member of one of the tenants that handles logging of complaints, assigning support persons to tickets and may also resolve tickets.',
        ]);

        Role::create([
            'name' => 'Support Person',
            'description' => 'A staff member of a tenant which resolves issues brought up by tickets.',
        ]);

        Role::create([
            'name' => 'Consumer',
            'description' => 'End user raising complaints.',
        ]);
    }
}
