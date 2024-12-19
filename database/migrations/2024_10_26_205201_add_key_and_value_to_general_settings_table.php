<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->string('key')->nullable()->unique()->after('id'); // Set key as nullable to avoid SQLite constraint
            $table->text('value')->nullable()->after('key'); // No change to value, already nullable
        });
    }

    public function down()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn(['key', 'value']);
        });
    }
};