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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade');  // Foreign key to clients
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');  // Foreign key to services
            $table->date('completion_date')->nullable();
            $table->boolean('status')->default(true);
            $table->string('url')->nullable();
            $table->json('gallery')->nullable();  // Store gallery as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};