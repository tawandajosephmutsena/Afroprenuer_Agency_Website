<?php

namespace App\Models\FilamentGeneralSettings;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    protected $table = 'general_settings';

    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        $setting = static::firstOrCreate(['key' => $key]);
        $setting->value = $value;
        $setting->save();
        return $setting;
    }
}
