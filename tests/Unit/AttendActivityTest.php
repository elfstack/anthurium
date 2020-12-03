<?php

namespace Tests\Unit;

use App\Exceptions\AlreadyProcessedException;
use App\Exceptions\InactiveActivityException;
use App\Exceptions\NotAdmittedException;
use App\Exceptions\NotCheckedInException;
use App\Models\Activity;
use App\Models\User;
use App\Models\UserGroup;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Tests\TestCase;

class AttendActivityTest extends TestCase
{
    use InteractsWithDatabase;

    private function getUser(): User
    {
        $user = factory(User::class)->create();
        $user->setUserGroup(UserGroup::find(1));

        return $user;
    }

    private function getActivity(): Activity
    {
        $activity = factory(Activity::class)->create([
            'starts_at' => Carbon::now()->addHour(),
            'ends_at' => Carbon::now()->addHours(2),
            'is_published' => true,
        ]);

        $activity->setUserGroup([1,2]);

        return $activity;
    }


    /**
     * @return array
     */
    public function test_user_is_approved_participant()
    {
        $activity = $this->getActivity();
        $user = $this->getUser();

        $activity->addParticipant($user);
        $participation = $activity->participations($user);
        $participation->admit();

        $this->assertEquals('admitted', $participation->getParticipationStatusAttribute());

        return [$activity, $user];
    }

    /**
     * @depends test_user_is_approved_participant
     * @return array
     */
    public function test_activity_is_ongoing(array $obj): array
    {
        $activity = $obj[0];

        $activity->starts_at = Carbon::now()->subHour(1);

        $this->assertEquals('ongoing', $activity->getStatus());

        return $obj;
    }

    /**
     * Check in participant
     *
     * @depends test_activity_is_ongoing
     * @param array $obj
     */
    public function test_check_in_user(array $obj): array
    {
        $activity = $obj[0];
        $user = $obj[1];

        $participation = $activity->participations($user);
        $participation->checkIn();
        $this->assertNotNull($participation->arrived_at);

        return $obj;
    }

    /**
     * Check out participant
     *
     * @depends test_check_in_user
     * @param array $obj
     */
    public function test_check_out_user(array $obj): void
    {
        $activity = $obj[0];
        $user = $obj[1];

        $participation = $activity->participations($user);
        $participation->checkOut();

        $this->assertNotNull($participation->left_at);
    }

    /**
     * Check in while not started
     *
     * @depends test_user_is_approved_participant
     * @param array $obj
     */
    public function test_cannot_check_in_upcoming_activity(array $obj): void
    {
        $this->expectException(InactiveActivityException::class);
        $activity = $obj[0];
        $user = $obj[1];
        $activity->starts_at = Carbon::now()->addHour(1);
        $this->assertEquals('upcoming', $activity->getStatus());

        $activity->participations($user)->checkIn();
    }

    /**
     * Check in while not admitted
     */
    public function test_cannot_check_in_rejected_participant(): void
    {
        $this->expectException(NotAdmittedException::class);
        $user = $this->getUser();
        $activity = $this->getActivity();
        $activity->addParticipant($user);

        $activity->starts_at = Carbon::now()->subHour();
        $participation = $activity->participations($user);
        $participation->reject();
        $participation->checkIn();
    }

    /**
     * Check out while not checked in
     * @depends test_user_is_approved_participant
     * @param array $obj
     */
    public function test_cannot_check_out_before_check_in(array $obj): void
    {
        $this->expectException(NotCheckedInException::class);

        $activity = $obj[0];
        $user = $obj[1];

        $participation = $activity->participations($user);
        $participation->checkOut();
    }

//    public function test_get_otp(): void
//    {
//        $otp = unserialize($this->participation->otp());
//        $this->assertArrayHasKey('id', $otp);
//        $this->assertArrayHasKey('expires', $otp);
//        $this->assertArrayHasKey('signature', $otp);
//    }
}
