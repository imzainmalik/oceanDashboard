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
        Schema::create('emergency_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('uploader_id');   // who uploaded the file
            $table->string('original_name');
            $table->string('disk_path');                 // stored path in storage/app/...
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->boolean('is_private')->default(true); // visibility control
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_documents');
    }
};
