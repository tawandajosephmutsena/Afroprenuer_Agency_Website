<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table("articles", function (Blueprint $table) {
            if (!Schema::hasColumn("articles", "featured_image_id")) {
                $table
                    ->foreignId("featured_image_id")
                    ->nullable()
                    ->constrained("media")
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table("articles", function (Blueprint $table) {
            if (Schema::hasColumn("articles", "featured_image_id")) {
                $table->dropConstrainedForeignId("featured_image_id");
            }
        });
    }
};
