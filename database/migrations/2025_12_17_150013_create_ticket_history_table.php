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
        Schema::create('ticket_history', function (Blueprint $table) {
            $table->id('history_id');

            $table->foreignId('tenant_id')
                ->references('tenant_id')->on('tenants')
                ->cascadeOnDelete();

            $table->foreignId('ticket_id')
                ->references('ticket_id')->on('tickets')
                ->cascadeOnDelete();

            $table->foreignId('changed_by_user_id')
                ->nullable()
                ->references('user_id')->on('users')
                ->nullOnDelete();

            $table->enum('from_status', ['OPEN','IN_PROGRESS','RESOLVED','CLOSED'])->nullable();
            $table->enum('to_status',   ['OPEN','IN_PROGRESS','RESOLVED','CLOSED'])->nullable();

            $table->text('ticket_comment')->nullable();
            $table->text('resolution_note')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_history');
    }
};
