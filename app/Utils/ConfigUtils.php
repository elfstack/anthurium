<?php

namespace App\Utils;

use App\Models\Configuration;

class ConfigUtils {

    public static function set($key, $value)
    {
        Configuration::set($key, $value);
    }

    /**
     * Get config value by key
     *
     * @param $key
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public static function get($key, $default=null)
    {
        $value = Configuration::getConfig($key);

        if (isset($value)) {
            return $value;
        }

        if (isset($default)) {
            return $default;
        }

        throw new \Exception('key not found');
    }
}
