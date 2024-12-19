<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("articles", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("slug")->unique();
            $table->text("excerpt")->nullable();
            $table->longText("content");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("featured_image")->nullable();
            $table->string("seo_title")->nullable();
            $table->text("seo_description")->nullable();
            $table->json("seo_keywords")->nullable();
            $table->boolean("is_published")->default(false);
            $table->timestamp("published_at")->nullable();
            $table->timestamps();
        });

        Schema::create("categories", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->timestamps();
        });

        Schema::create("tags", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->timestamps();
        });

        Schema::create("article_category", function (Blueprint $table) {
            $table->foreignId("article_id")->constrained()->onDelete("cascade");
            $table
                ->foreignId("category_id")
                ->constrained()
                ->onDelete("cascade");
            $table->primary(["article_id", "category_id"]);
        });

        Schema::create("article_tag", function (Blueprint $table) {
            $table->foreignId("article_id")->constrained()->onDelete("cascade");
            $table->foreignId("tag_id")->constrained()->onDelete("cascade");
            $table->primary(["article_id", "tag_id"]);
        });

        Schema::create("comments", function (Blueprint $table) {
            $table->id();
            $table->foreignId("article_id")->constrained()->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->text("content");
            $table->boolean("is_approved")->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("comments");
        Schema::dropIfExists("article_tag");
        Schema::dropIfExists("article_category");
        Schema::dropIfExists("tags");
        Schema::dropIfExists("categories");
        Schema::dropIfExists("articles");
    }
};
