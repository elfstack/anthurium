<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Guest;
use App\Models\User;
use App\Notifications\GuestVerifyEmail;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ParticipantEnrollActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Activity
     */
    private Activity $activity;

    protected function setUp(): void
    {
        parent::setUp();

        $this->activity = factory(Activity::class)->create([
            'is_published' => true,
            'starts_at' => Carbon::now()->addHours(2),
            'ends_at' => Carbon::now()->addHours(5)
        ]);
    }

    public function test_user_enroll_activity()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->postJson(
            "/api/activities/{$this->activity->id}/enroll"
        );

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'enrolled'
        ]);

        $isParticipant = $user->isParticipant($this->activity);
        $this->assertTrue($isParticipant);
    }

    public function test_guest_enroll_activity()
    {
        Notification::fake();

        $this->activity->is_public = true;
        $this->activity->save();

        $response = $this->postJson(
            "/api/activities/{$this->activity->id}/enroll",
            [
                'name' => 'Jane Doe',
                'email' => 'janedoe@example.com'
            ]
        );

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'email-sent'
        ]);

        $guest = Guest::where('email', 'janedoe@example.com')->first();

        Notification::assertSentTo($guest, GuestVerifyEmail::class);
    }

    public function test_user_enroll_inactive_activity()
    {
        $this->activity->is_published = false;
        $this->activity->save();

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->postJson(
            "/api/activities/{$this->activity->id}/enroll"
        );

        $response->assertStatus(500);
    }

    public function test_guest_enroll_non_public_activity()
    {
        $response = $this->postJson(
            "/api/activities/{$this->activity->id}/enroll",
            [
                'name' => 'Jane Doe',
                'email' => 'janedoe@example.com'
            ]
        );

        $response->assertStatus(404);
    }

    public function test_guest_confirm_enrollment()
    {
        $guest = factory(Guest::class)->create();

        Notification::fake();

        $url = URL::temporarySignedRoute(
            'app.guest.enroll',
            \Illuminate\Support\Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'guest' => $guest->getKey(),
                'activity' => $this->activity->getKey()
            ]
        );

        $response = $this->get($url);
        $response->assertStatus(200);

        $isParticipant = $guest->isParticipant($this->activity);
        $this->assertTrue($isParticipant);
    }
}
