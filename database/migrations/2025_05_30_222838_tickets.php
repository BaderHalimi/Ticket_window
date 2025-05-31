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
        Schema::create("tickets",function(Blueprint $table){
            $table->id();
            $table->integer("user_id");
            $table->enum("status",['deny','allow','pending'])->default("pending");
            $table->string("title",255);
            $table->string("description",1024);
            $table->integer("staff_id")->nullable();
            $table->timestamps();
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
