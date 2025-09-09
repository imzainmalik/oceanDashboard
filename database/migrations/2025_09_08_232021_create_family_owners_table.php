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
        Schema::create('family_owners', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->enum('plan', ['standard', 'family_plus'])->default('standard');

            // Family Owner
            $table->unsignedBigInteger('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('users');


            // Primary Senior of owner (optional)
            $table->integer('senior_id');
            // $table->foreign('senior_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_owners');
    }
};
