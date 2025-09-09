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
        Schema::create('senoirs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Link to tenant (family/facility)
            $table->unsignedBigInteger('family_owner_id');
            $table->foreign('family_owner_id')->references('id')->on('family_owners')->onDelete('cascade');

            // Extra senior-specific details
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('medical_condition')->nullable();
            $table->string('primary_doctor')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->boolean('has_dementia')->default(false);
            $table->boolean('has_alzheimer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senoirs');
    }
};
