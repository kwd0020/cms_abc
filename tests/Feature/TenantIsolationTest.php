<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TenantSeeder;
use App\Models\Tenant;
use App\Models\Role;
use App\Models\User;
use App\Models\Ticket;


class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();

        // Run the two required seeder before each test
        $this->seed([RoleSeeder::class, TenantSeeder::class]);
    }

    public function test_user_cannot_view_other_tenant_user(): void
    {
        $roleManager = Role::where('role_slug', 'manager')->firstOrFail();
        $tenantA = Tenant::where('tenant_name', 'Barclays')->firstOrFail();
        $tenantB = Tenant::where('tenant_name', 'Vodafone')->firstOrFail();

        $userA = User::factory()->create([
            'tenant_id' => $tenantA->tenant_id,
            'role_id'   => $roleManager->role_id,
        ]);

        $userB = User::factory()->create([
            'tenant_id' => $tenantB->tenant_id,
            'role_id'   => $roleManager->role_id,
        ]);

        $this->actingAs($userA);

        $this->get(route('users.show', $userB->user_id))
        ->assertNotFound();
    }

    public function test_user_index_only_shows_same_tenant_users(): void{
      
        $roleManager = Role::where('role_slug', 'manager')->firstOrFail();
        $tenantA = Tenant::where('tenant_name', 'Barclays')->firstOrFail();
        $tenantB = Tenant::where('tenant_name', 'Vodafone')->firstOrFail();

        $userA = User::factory()->create([
            'tenant_id' => $tenantA->tenant_id,
            'role_id'   => $roleManager->role_id,
            'user_email'=> 'a@example.com',
        ]);

        $userB = User::factory()->create([
            'tenant_id' => $tenantB->tenant_id,
            'role_id'   => $roleManager->role_id,
            'user_email'=> 'b@example.com',
        ]);

        $this->actingAs($userA);

        $response = $this->get(route('users.index'));

        $response->assertOk();
        $response->assertSee('a@example.com');
        $response->assertDontSee('b@example.com');
    }

    public function test_user_cannot_view_other_tenant_ticket(): void{
        $roleAgent = Role::where('role_slug', 'agent')->firstOrFail();
        $tenantA = Tenant::where('tenant_name', 'Barclays')->firstOrFail();
        $tenantB = Tenant::where('tenant_name', 'Vodafone')->firstOrFail();

        $userA = User::factory()->create([
            'tenant_id' => $tenantA->tenant_id,
            'role_id'   => $roleAgent->role_id,
        ]);

        $userB = User::factory()->create([
        'tenant_id' => $tenantB->tenant_id,
        'role_id' => $roleAgent->role_id,
        ]);

        $ticketB = Ticket::factory()->forUser($userB)->create();

        $this->actingAs($userA)
            ->get(route('tickets.show', $ticketB->ticket_id))
            ->assertNotFound();
    }

    public function test_ticket_store_ignores_tenant_id_from_request(): void{
        $roleConsumer = Role::where('role_slug', 'consumer')->firstOrFail();
        $tenantA = Tenant::where('tenant_name', 'Barclays')->firstOrFail();
        $tenantB = Tenant::where('tenant_name', 'Vodafone')->firstOrFail();

        $userA = User::factory()->create([
            'tenant_id' => $tenantA->tenant_id,
            'role_id'   => $roleConsumer->role_id,
        ]);

        $this->actingAs($userA);

        $this->post(route('tickets.store'), [
            'ticket_title' => 'Test',
            'ticket_description' => 'Test desc',
            'ticket_category' => 'Billing',
            'ticket_priority' => 'low',

            // attacker tries to override:
            'tenant_id' => $tenantB->tenant_id,
        ])->assertRedirect();

        $this->assertDatabaseHas('tickets', [
            'ticket_title' => 'Test',
            'tenant_id' => $tenantA->tenant_id, // must be tenantA, not tenantB
            'user_id' => $userA->user_id,
        ]);
    }
}
    
