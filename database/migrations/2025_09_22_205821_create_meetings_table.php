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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('senior_id');
            $table->unsignedBigInteger('created_by'); // who created (senior/family owner)
            $table->string('topic');
            $table->text('agenda')->nullable();
            $table->dateTime('start_time');
            $table->integer('duration')->default(30); // minutes
            $table->string('zoom_meeting_id')->nullable();
            $table->string('join_url')->nullable();
            $table->string('start_url')->nullable();
            $table->enum('status', ['scheduled', 'cancelled', 'completed'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
