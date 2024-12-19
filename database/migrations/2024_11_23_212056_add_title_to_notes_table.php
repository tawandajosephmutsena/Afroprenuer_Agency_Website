<?php

// First Migration: Add title to notes table
// Create with: php artisan make:migration add_title_to_notes_table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->string('title')->after('id')->nullable();
        });

        // Generate titles for existing notes
        DB::table('notes')->whereNull('title')->chunkById(100, function ($notes) {
            foreach ($notes as $note) {
                DB::table('notes')
                    ->where('id', $note->id)
                    ->update([
                        'title' => 'Note ' . Str::limit(strip_tags($note->content), 30),
                    ]);
            }
        });

        // Make title required after populating existing records
        Schema::table('notes', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};