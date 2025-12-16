<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'ticket_title' => fake()->word(),
            'ticket_category' => $this->faker->randomElement([
                'Billing',
                'Technical',
                'Query',
            ]),
            'ticket_description' => fake()->paragraph(),

            'ticket_status' => $this->faker->randomElement([
                'OPEN',
                'IN_PROGRESS',
                'RESOLVED',
                'CLOSED',
            ]),

            'ticket_priority' => $this->faker->randomElement([
                'low',
                'medium',
                'high',
                'urgent',
            ]),       
        ];
    }

    public function forUser(User $user): static
            {
                return $this->state(fn () => [
                    'user_id' => $user->user_id,
                    'tenant_id' => $user->tenant_id,
                ]);
            }
}
