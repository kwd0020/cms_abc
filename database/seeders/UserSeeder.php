<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{

        // 1) Global system admin (tenant_id = null)
        User::factory()->systemAdmin()->create([
            'user_email' => 'admin@example.com',
        ]);
        $tenants = Tenant::all();
        $roles = Role::whereIn('role_slug', ['manager', 'agent', 'support_person', 'consumer'])->get();

        User::factory()
            ->count(20)
            ->state(fn () => [
                'tenant_id' => $tenants->random()->tenant_id,
                'role_id'   => $roles->random()->role_id,
            ])
            ->create();
        }
}
