<?php

use App\Models\FilamentGeneralSettings\GeneralSettings;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        if (is_array($key)) {
            return app(GeneralSettings::class)->fill($key)->save();
        }

        $value = app(GeneralSettings::class)->get($key, $default);

        if (is_null($value) || $value === '') {
            return $default;
        }

        return $value;
    }
}