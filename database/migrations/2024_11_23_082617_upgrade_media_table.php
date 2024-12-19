<?php

use Awcodes\Curator\Facades\Curator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $table_name = app(config('curator.model'))->getTable();

        if (!Schema::hasColumn($table_name, 'visibility')) {
            Schema::table($table_name, function (Blueprint $table) {
                $table->string('visibility')->default('public')->after('disk');
            });
        }
    }

    public function down(): void
    {
        $table_name = app(config('curator.model'))->getTable();

        if (Schema::hasColumn($table_name, 'visibility')) {
            Schema::table($table_name, function(Blueprint $table) {
                $table->dropColumn('visibility');
            });
        }
    }
};
