<?php

use App\Models\Activity;
use App\Models\Budget;
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
        $upcomingActivities = factory(Activity::class, 20)->states('upcoming')->create();
        factory(Activity::class, 20)->states('ongoing')->create();
        factory(Activity::class, 50)->states('past')->create();

        $upcomingActivities->each(function ($activity) {
            $budgets = factory(Budget::class, 30)->make();
            $activity->budgets()->saveMany($budgets);
        });
    }
}
