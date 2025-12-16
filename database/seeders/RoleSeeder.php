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
            'role_slug' => 'system_admin',
            'role_name' => 'SystemAdmin',
            'role_description' => 'Configures and maintains the system while managing tenants, users and permissions within the system.',
        ]);

        Role::create([
            'role_slug' => 'manager',
            'role_name' => 'Manager',
            'role_description' => 'A staff member of one of the tenants that monitors performance of support persons and help desk agents',
        ]);

        Role::create([
            'role_slug' => 'agent',
            'role_name' => 'Agent',
            'role_description' => 'A staff member of one of the tenants that handles logging of complaints, assigning support persons to tickets and may also resolve tickets.',
        ]);

        Role::create([
            'role_slug' => 'support_person',
            'role_name' => 'SupportPerson',
            'role_description' => 'A staff member of a tenant which resolves issues brought up by tickets.',
        ]);

        Role::create([
            'role_slug' => 'consumer',
            'role_name' => 'Consumer',
            'role_description' => 'End user raising complaints.',
        ]);
    }
}
