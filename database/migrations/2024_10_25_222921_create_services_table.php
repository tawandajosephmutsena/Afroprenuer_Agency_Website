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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Service name
            $table->text('description')->nullable(); // Detailed service description
            $table->decimal('price', 10, 2); // Price of the service
            $table->integer('duration')->nullable(); // Duration of the service in days
            $table->string('service_type')->nullable(); // E.g., SEO, Branding, Social Media
            $table->string('target_audience')->nullable(); // Target audience (e.g., SMEs, startups)
            $table->text('deliverables')->nullable(); // Key deliverables of the service
            $table->boolean('status')->default(true); // Whether service is active or inactive
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};