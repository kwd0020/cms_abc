<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Multi-tenant: each ticket belongs to one tenant (bank/telecom/etc.)
            $table->foreignId('tenant_id')->constrained('tenants');

            
            $table->foreignId('consumer_id')->constrained('users');

            
            $table->foreignId('current_assignee_id')->nullable()->constrained('users');

            // Table Classes
            $table->string('ticket_category');      
            $table->string('ticket_title');        
            $table->text('ticket_description');     
            $table->enum('ticket_status', [
                'OPEN',
                'IN_PROGRESS',
                'RESOLVED',
                'CLOSED',
            ])->index();
            $table->enum('ticket_priority', [
                'low',
                'medium',
                'high',
                'urgent',
            ])->nullable();

            //Ticket Timestamps
            $table->timestamp('ticket_opened_at');
            $table->timestamp('ticket_resolved_at')->nullable();
            $table->timestamp('ticket_closed_at')->nullable();
            $table->timestamps();
            
            $table->index(['tenant_id', 'consumer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};