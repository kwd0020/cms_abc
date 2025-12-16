<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Tenant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function systemAdmin(): static{
        $role = Role::where('role_slug', 'system_admin')->firstOrFail();

        return $this->state(fn () => [
            'role_id'   => $role->role_id,
            'tenant_id' => null,
        ]);
    }
    
    public function definition(): array
    {
        return [
            'user_name' => fake()->name(),
            'user_email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->unique()->numerify('07#########'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_active' => true,
            // don’t set role_id/tenant_id here; set via states/for() below
        ];
    }

    public function forTenant(Tenant $tenant): static
    {
        return $this->state(fn () => ['tenant_id' => $tenant->tenant_id]);
    }

    public function withRole(Role $role): static
    {
        return $this->state(fn () => ['role_id' => $role->role_id]);
    }
}
