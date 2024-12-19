<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Due to SQLite limitations, we need to recreate the table
        Schema::create('comments_new', function (Blueprint $table) {
            // Copy existing columns
            $table->id();
            $table->text('content');
            $table->timestamps();

            // Add new polymorphic columns
            $table->string('commentable_type');
            $table->unsignedBigInteger('commentable_id');

            // Add index to the polymorphic relationship
            $table->index(['commentable_type', 'commentable_id']);
        });

        // Copy the data
        DB::statement("
            INSERT INTO comments_new (id, content, created_at, updated_at, commentable_type, commentable_id)
            SELECT id, content, created_at, updated_at, 'App\\Models\\Article', article_id
            FROM comments
            WHERE article_id IS NOT NULL
        ");

        // Drop the old table
        Schema::drop('comments');

        // Rename the new table
        Schema::rename('comments_new', 'comments');
    }

    public function down(): void
    {
        // Create temporary table with old structure
        Schema::create('comments_old', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->unsignedBigInteger('article_id')->nullable();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->timestamps();
        });

        // Copy data back
        DB::statement("
            INSERT INTO comments_old (id, content, article_id, created_at, updated_at)
            SELECT id, content, commentable_id, created_at, updated_at
            FROM comments
            WHERE commentable_type = 'App\\Models\\Article'
        ");

        // Drop the new table
        Schema::drop('comments');

        // Rename old table back
        Schema::rename('comments_old', 'comments');
    }
};
