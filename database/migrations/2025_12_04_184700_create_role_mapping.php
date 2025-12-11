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
        // User–role mapping (many-to-many)
        /*Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')
            ->references('role_id')
            ->on('roles')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->foreignId('user_id')
            ->references('user_id')
            ->on('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->primary(['role_id', 'user_id']);
        });

        // Role–permission mapping (many-to-many)
        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignId('role_id')
            ->references('role_id')
            ->on('roles')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->foreignId('permission_id')
            ->references('permission_id')
            ->on('permissions')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->primary(['role_id', 'permission_id']);
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('role_user');
    }
};