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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_owner_id');
            $table->string('card_last_four', 4); // ****1234
            $table->string('card_brand'); // Visa, Mastercard, Amex
            $table->string('expiry_month', 2);
            $table->string('expiry_year', 4);
            $table->boolean('is_primary')->default(false);
            $table->string('gateway_token')->nullable(); // Stripe token
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
