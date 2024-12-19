<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->unsignedBigInteger('assignee_id')->nullable();
        $table->foreign('assignee_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropForeign(['assignee_id']);
        $table->dropColumn('assignee_id');
    });
}
};