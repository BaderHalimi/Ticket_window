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
        Schema::create('merchantwithdraws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('status')->default('pending'); 
            $table->string('transaction_id')->nullable();
            $table->json('additional_data')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchantwithdraws');
    }
};
