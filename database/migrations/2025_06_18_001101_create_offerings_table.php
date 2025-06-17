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
        Schema::create('offerings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            //$table->integer('max_attendees')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('type', ['events', 'conference','restaurant','experiences'])->default('events');
            $table->string('category')->nullable();
            $table->json('additional_data')->nullable();
            $table->json('translations')->nullable();
            $table->boolean('has_chairs')->default(false);
            $table->integer('chairs_count')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offerings');
    }
};
