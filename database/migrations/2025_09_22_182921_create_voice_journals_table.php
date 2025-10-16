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
        Schema::create('voice_journals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('senior_id');
            $table->unsignedBigInteger('created_by'); // caregiver / senior / family member
            $table->string('title')->nullable();
            $table->string('file_path'); // store audio file
            $table->text('transcription')->nullable(); // optional speech-to-text
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voice_journals');
    }
};
