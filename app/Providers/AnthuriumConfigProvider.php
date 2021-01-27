<?php

namespace App\Providers;

use App\Models\Configuration;
use Illuminate\Support\ServiceProvider;

class AnthuriumConfigProvider extends ServiceProvider
{

    /**
     * @var array cached configs
     */

    // TODO: use file cache for optimisation
    // TODO: add test cases
    private $cachedConfigs = [];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('anthurium-config', function ($app) {
            return $this;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    public function set($key, $value)
    {
        Configuration::set($key, $value);
        $this->cache($key, $value);
    }

    /**
     * Get config value by key
     *
     * @param $key
     * @param null $default
     * @return mixed
     * @throws \Exception
     */
    public function get($key, $default=null)
    {
        if (array_key_exists($key, $this->cachedConfigs)) {
            return $this->cachedConfigs[$key];
        }

        $value = Configuration::getConfig($key);

        if (isset($value)) {
            $this->cache($key, $value);
            return $value;
        }

        if (isset($default)) {
            return $default;
        }

        throw new \Exception('key not found');
    }

    private function cache($key, $value)
    {
        $this->cachedConfigs[$key] = $value;
    }
}
