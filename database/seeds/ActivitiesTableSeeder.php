<?php

use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Activity::class, 20)->states('upcoming')->create();
        factory(App\Models\Activity::class, 20)->states('ongoing')->create();
        factory(App\Models\Activity::class, 50)->states('past')->create();
    }
}
