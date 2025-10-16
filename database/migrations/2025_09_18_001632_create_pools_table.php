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
        Schema::create('pools', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('owner_id'); 
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['open', 'closed', 'final_decision'])->default('open');
            $table->dateTime('voting_expires_at')->nullable();
            $table->unsignedBigInteger('final_decision_by')->nullable();
            $table->text('final_decision_notes')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pools');
    }
};
