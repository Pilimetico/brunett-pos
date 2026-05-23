<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'description'];

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Get all company settings as a key-value associative array.
     */
    public static function getCompanySettings()
    {
        return self::where('group', 'company')->pluck('value', 'key')->toArray();
    }
}

