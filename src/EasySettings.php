<?php

namespace LiveControls\EasySettings;

use Exception;
use Illuminate\Support\Facades\Cache;
use LiveControls\EasySettings\Models\EasySettingsModel;

final class EasySettings
{
    /**
     * The prefix used for settings stored inside the cache
     *
     * @var string
     */
    private static string $cachePrefix = "easy-settings";

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
     * @param integer|null $cacheForSeconds If set to NULL it will cache forever, if set to 0 it will not cache
     * @return mixed
     */
    public static function get(string $key, mixed $default = null, int|null $cacheForSeconds = 0): mixed
    {
        if($cacheForSeconds === 0){
            return EasySettingsModel::find($key)?->value ?? $default;
        }else if($cacheForSeconds !== null){
            return Cache::remember(self::$cachePrefix.'-'.$key, $cacheForSeconds, fn () => EasySettingsModel::find($key)?->value ?? $default);
        }
        return Cache::rememberForever(self::$cachePrefix.'-'.$key, fn () => EasySettingsModel::find($key)?->value ?? $default);
    }

    /**
     * Forgets the setting in case it was stored inside the cache.
     *
     * @param string $key
     * @return void
     */
    public static function forget(string $key): void
    {
        Cache::forget(self::$cachePrefix.'-'.$key);
    }

    /**
     * Deletes the setting from the database and forgets it inside the cache.
     *
     * @param string $key
     * @return void
     */
    public static function delete(string $key): void
    {
        $model = EasySettingsModel::find($key);
        if(is_null($model)){
            return;
        }
        if(!$model->delete()){
            throw new Exception("Couldn't delete EasySetting with key \"{$key}\"!");
        }
        self::forget($key);
    }
}