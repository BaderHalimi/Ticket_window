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
        Schema::table('merchant_chats', function (Blueprint $table) {
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
            $table->json('additional_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchant_chats', function (Blueprint $table) {
            //
        });
    }
};
