<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void {
        // Exclude system admin from having tickets.
        $users = User::whereNotNull('tenant_id')->get();

        foreach ($users as $user) {
            Ticket::factory()
                ->count(5)
                ->forUser($user)
                ->create();
        }
    }
}
