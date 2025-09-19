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
        Schema::create('pool_votings', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('voting_pool_id');
            $table->unsignedBigInteger('user_id'); // voter
            $table->enum('choice', ['yes','no','abstain']);
            $table->text('comment')->nullable(); 

            $table->unique(['voting_pool_id','user_id']); // user can vote once
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pool_votings');
    }
};
