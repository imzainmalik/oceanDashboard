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
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('payer_id');
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_method'); // zelle, cash_app, card, etc.
            $table->string('confirmation_number');
            $table->string('receipt_path'); // uploaded file proof
            $table->enum('status', ['submitted', 'approved', 'declined'])->default('submitted');
            $table->text('owner_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_payments');
    }
};
