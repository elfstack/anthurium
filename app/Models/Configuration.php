<?php

namespace App\Models;

use App\Exceptions\NoSuchConfigKeyException;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    public $table = 'configurations';

    public $timestamps = false;

    protected $primaryKey = 'key';

    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        'key' => 'string'
    ];

    /**
     * Update configuration
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public static function set(string $key, string $value)
    {
        // TODO: error handling
        return Configuration::find($key)->update([
            'value' => $value
        ]);
    }

    public static function all($columns = ['*'])
    {
        $configurations = self::getReadable(parent::all($columns));
        return self::getKeyValuePair($configurations);
    }

    private static function getKeyValuePair($configurations)
    {
        return $configurations->keyBy('key')->transform(function ($item) {
            $value = $item->value;
            if ($item->value !== null) {
                settype($value, $item->type);
            }
            return $value;
        })->toArray();
    }

    public static function getConfigs($configKeys) {
        return self::getKeyValuePair(self::findMany($configKeys));
    }

    /**
     * @param $key
     * @return mixed
     * @throws NoSuchConfigKeyException
     */
    public static function getConfig($key) {
        $item = self::find($key);
        if ($item == null) {
            throw new NoSuchConfigKeyException();
        }
        $value = $item->value;

        if ($item->value != null) {
            settype($value, $item->type);
        }

        return $value;
    }

    /**
     * @param $configurations
     * @return mixed
     */
    public static function getReadable($configurations) {
        $readableConfigurations = [];
        $configurations->each(function ($item) use (&$readableConfigurations) {
            if ($item->key === 'registration_form_id') {
                $config = new Configuration();
                $config->key = 'registration_form_id_repr';
                $config->type = 'string';
                $config->value = Form::find($item->value)->title;
                array_push($readableConfigurations, $config);
            }
        });

        return $configurations->concat($readableConfigurations);
    }

    public static function lastUpdatedAt() {
        // TODO: rvm
    }
}
