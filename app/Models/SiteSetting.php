<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    public static function get(string $key, $default = null)
    {
        $settings = Cache::remember('site_settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    public static function getAll(): array
    {
        return Cache::remember('site_settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function set(string $key, $value, string $type = 'text'): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value, 'type' => $type]);
        Cache::forget('site_settings');
    }

    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings');
    }
}
