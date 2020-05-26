<?php

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Activity::class, 20)->states('upcoming')->create();
        factory(Activity::class, 20)->states('ongoing')->create();
        factory(Activity::class, 50)->states('past')->create();
    }
}
