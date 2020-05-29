<?php

use App\Models\Activity;
use App\Models\Guest;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Seeder;

class ParticipationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activity = factory(Activity::class)->create();

        $this->command->info('Seeding participant on activity with id '.$activity->id);

        factory(User::class, 10)->create()->each(function (Participant $user) use ($activity) {
            $user->participate($activity);
        });

        factory(Guest::class, 10)->create()->each(function (Participant $user) use ($activity) {
            $user->participate($activity);
        });
    }
}
