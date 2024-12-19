<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class InsertDefaultLogoFaviconSettings extends Migration
{
    public function up()
    {
        DB::table('settings')->insert([
            [
                'group' => 'general',
                'name' => 'logo',
                'payload' => '/storage/app/public/assets/site_logo.png',
            ],
            [
                'group' => 'general',
                'name' => 'favicon',
                'payload' => '/storage/app/public/assets/site_favicon.ico',
            ]
        ]);
    }

    public function down()
    {
        DB::table('settings')->where('group', 'general')
            ->whereIn('name', ['logo', 'favicon'])
            ->delete();
    }
}