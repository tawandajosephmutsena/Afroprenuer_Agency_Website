<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('accessibility_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('reduced_motion')->default(false);
            $table->boolean('high_contrast')->default(false);
            $table->string('font_size')->default('normal');
            $table->string('font_family')->default('sans');
            $table->string('color_scheme')->default('default');
            $table->json('notification_preferences')->nullable();
            $table->boolean('break_reminders')->default(true);
            $table->integer('break_interval')->default(25);
            $table->json('productive_hours')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accessibility_preferences');
    }
};