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
            // Site Config
            'site.orgname' => 'Your Organisation',
            // User Registration
            'member.registration.default_user_group' => 'guest', // default is guest
            // Member Application
            'member.application.open' => true,
            // INFO: this shall be determined by DataCollection with registration tags
//            'member.application.data_collection_id' => 1, // cached
//            'member.application.data_collection_form_name' => ''  // cached
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
