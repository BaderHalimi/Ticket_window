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
        Schema::table('pays_histories', function (Blueprint $table) {

            $table->foreignId('wallet_id')->nullable()->constrained('merchant_wallets')->onDelete('set null')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pays_histories', function (Blueprint $table) {
            // $table->dropForeign(['wallet_id']);
            // $table->dropColumn('wallet_id');
        });
    }
};
