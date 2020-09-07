<?php

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configurations = collect([
            'registration' => true,
            'registration.form_id' => [ 'integer', null ]
        ]);

        $configurations->each(function ($value, $key) {
            Configuration::create([
                'key' => $key,
                'type' => is_array($value) ? $value[0] : gettype($value),
                'value' => is_array($value) ? $value[1] : $value
            ]);
        });
    }
}
