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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles', 'id')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions', 'id')->cascadeOnDelete();
            $table->json('additional_data')->default(json_encode([])); // Optional additional data for role-permission pairs
            $table->unique(['role_id', 'permission_id'], 'role_permission_unique'); // Ensure unique role-permission pairs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
