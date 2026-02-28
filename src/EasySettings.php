<?php

namespace LiveControls\EasySettings;

use Illuminate\Support\Facades\Cache;
use LiveControls\EasySettings\Models\EasySettingsModel;

class EasySettings
{
    /**
     * Sets the setting with a certain key and value to the database.
     *
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public static function set(string $key, mixed $value): bool
    {
        self::forget($key);
        return EasySettingsModel::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        ) ? true : false;
    }

    /**
     * Gets the setting with a certain key from the database or returns a default value.
     *
     * @param string $key
     * @param mixed $default
     * @param integer|null|null $cacheForSeconds
     * @return mixed
     */
    public static function get(string $key, mixed $default = null, int|null $cacheForSeconds = null): mixed
    {
        if(!empty($cacheForSeconds)){
            return Cache::remember('easy-settings-'.$key, $cacheForSeconds, function() use($key, $default){
                return EasySettingsModel::find($key) ?? $default;
            });
        }
        return EasySettingsModel::find($key) ?? $default;
    }

    /**
     * Forgets the setting in case it was stored inside the cache.
     *
     * @param string $key
     * @return void
     */
    public static function forget(string $key): void
    {
        Cache::forget('easy-settings-'.$key);
    }
}