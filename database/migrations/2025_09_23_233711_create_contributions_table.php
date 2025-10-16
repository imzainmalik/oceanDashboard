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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->integer('family_owner_id'); // who contributed
            $table->integer('family_member_id'); // who contributed
            $table->integer('bill_id')->nullable(); // optional link to a bill
            $table->decimal('amount', 10, 2);
            $table->string('type')->default('contribution'); // contribution | shortfall
            $table->string('note')->nullable();
            $table->integer('is_deleted')->default(0)->comment('0=not deleted, 1=deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
