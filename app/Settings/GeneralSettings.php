<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    // Define properties to store logo and favicon URLs
    public string $logo;
    public string $favicon;

    // Group the settings to make it manageable and distinguishable
    public static function group(): string
    {
        return 'general';
    }
}