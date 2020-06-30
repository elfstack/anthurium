<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipationDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_participation_details()
    {
        $user = factory(User::class)->create();
        $activity = factory(Activity::class)->create([
            'is_published' => true,
            'starts_at' => Carbon::now()->addHour(),
            'ends_at' => Carbon::now()->addHours(2)
        ]);

        $user->participate($activity);

        $participation = $activity->participations($user);

        $response = $this->get('/api/participations/'.$participation->getKey());

        $response->assertStatus(200);
        $response->assertJson([
            'participation' => $participation->toArray()
        ]);
    }
}
