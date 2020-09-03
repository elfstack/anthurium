<?php

namespace App\Models;

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
        return Configuration::find($key)->update([
            'value' => $value
        ]);
    }

    public static function getGroup(string $group)
    {
        $configurations = Configuration::where('key', 'like', $group.'\_%')
            ->orWhere('key', $group)
            ->get();

        $configurations = self::getReadable($configurations);

        return $configurations->keyBy('key')->transform(function ($item) {
            $value = $item->value;
            if ($item->value !== null) {
                settype($value, $item->type);
            }
            return $value;
        })->toArray();
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
}
