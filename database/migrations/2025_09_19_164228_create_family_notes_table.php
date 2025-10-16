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
        Schema::create('family_notes', function (Blueprint $table) {
            $table->id();
            $table->integer('family_owner_id'); // Owner who creates the note
            $table->integer('family_member_id');
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['note', 'feedback'])->default('note'); // differentiate
            $table->enum('visibility', ['private', 'family'])->default('family'); // owner only or whole family
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_notes');
    }
};
