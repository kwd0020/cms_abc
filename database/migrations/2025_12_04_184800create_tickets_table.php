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
            $table->id('ticket_id');

            // Multi-tenant: each ticket belongs to one tenant (bank/telecom/etc.)
            $table->foreignId('tenant_id')
            ->references('tenant_id')
            ->on('tenants')
            ->cascadeOnDelete();

            
            $table->foreignId('user_id')
            ->references('user_id')
            ->on('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            
            //$table->foreignId('current_assignee_id')->nullable()->constrained('users');

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
            $table->timestamp('ticket_created_at')->useCurrent();
            $table->timestamp('ticket_updated_at')->useCurrent()->useCurrentOnUpdate()->nullable();
            $table->timestamps();
            
            $table->index(['tenant_id', 'user_id']);
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