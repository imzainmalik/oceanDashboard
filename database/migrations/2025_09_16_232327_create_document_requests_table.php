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
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
        $table->integer('requester_id');   // who asked for doc (user)
            $table->integer('target_user_id'); // who should submit the doc (user)
            $table->string('title');                      // e.g. "Emergency Medical Directive"
            $table->text('message')->nullable();
            $table->datetime('expires_at');               // countdown deadline
            $table->enum('status', ['pending', 'submitted', 'expired', 'cancelled'])->default('pending');
            $table->integer('document_id')->nullable(); // FK to emergency_documents when submitted
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
