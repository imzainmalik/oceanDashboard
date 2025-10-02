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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');     // task creator
            $table->integer('assignee_id');  // person responsible
            $table->string('title');
            $table->enum('type', ['medical', 'non-medical']);
            $table->text('details')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'need_outside_help'])->default('pending');
            $table->timestamps(); 
            // $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('assignee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
