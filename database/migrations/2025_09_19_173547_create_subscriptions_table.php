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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_owner_id');
            $table->string('plan'); // standard, family_plus, etc
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['active','expired','cancelled'])->default('active');
            $table->boolean('is_recurring')->default(true); // ✅ no AFTER
            $table->unsignedBigInteger('payment_method_id')->nullable(); // ✅ no AFTER
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('payment_gateway')->default('stripe');
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
