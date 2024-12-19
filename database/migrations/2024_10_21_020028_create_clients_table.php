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
        Schema::create('clients', function (Blueprint $table) {
      $table->id();

            // Client's name (either personal or company name)
            $table->string('name');

            // Client's email
            $table->string('email')->unique();

            // Client's phone number
            $table->string('phone')->nullable();

            // Client's physical address
            $table->string('address')->nullable();

            // Client's website URL (optional)
            $table->string('website')->nullable();

            // Timestamps (created_at, updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
