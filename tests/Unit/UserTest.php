<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Activity;
use App\Models\Participant;
use App\Models\Attendance;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $activity;

    protected $user;

    protected $participant;

    protected function setUp() : void {

        parent::setUp();

        // TODO: Not sure whether eloquent will hold intermediate relation data
        // So use database for this unit test

        $this->activity = Activity::create([
            'name' => 'Test',
            'starts_at' => now(),
            'ends_at' => now(),
            'content' => 'Test content',
            'quota' => 1
        ]);

        $this->user = factory(User::class)->create();
    }

    public function testUserIsNotParticipantOfActivity() {
        $this->assertFalse($this->user->isParticipant($this->activity));
    }

    public function testUserNotParticipantToCheckIn()
    {
        $this->expectException(\App\Exceptions\UserNotParticipatedException::class);

        $this->user->checkin($this->activity);
    }

    public function testUserEnroll()
    {
        $enroll = $this->user->enroll($this->activity);

        $this->assertTrue($enroll);

        $this->assertDatabaseHas('participants', [
            'user_id' => $this->user->id,
            'activity_id' => $this->activity->id
        ]);
    }

     public function testUserDuplicateEnroll()
     {
        $this->user->enroll($this->activity);

        $enroll = $this->user->enroll($this->activity);

        $this->assertFalse($enroll);
    }

    public function testUserIsParticipantOfActivity() {
        $this->addUserToParticipant();

        $this->assertTrue($this->user->isParticipant($this->activity));
    }

    public function testUserCheckIn()
    {
        $this->addUserToParticipant();

        $attendance = $this->user->checkin($this->activity);

        $this->assertDatabaseHas('attendance', [
            'arrived_at' => now(),
            'user_id' => $this->user->id
        ]);

        $this->assertDatabaseHas('participants', [
            'user_id' => $this->user->id,
            'activity_id' => $this->activity->id,
            'attendance_id' => $attendance->id
        ]);
    }

    public function testUserDuplicateCheckIn()
    {
        $this->addUserToParticipant();

        $this->expectException(\App\Exceptions\UserAlreadyCheckedInException::class);

        $this->user->checkin($this->activity);
        $this->user->checkin($this->activity);
    }

    public function testUserDrop() {
        $this->addUserToParticipant();
        $this->user->drop($this->activity);

        $this->assertDatabaseMissing('participants', [
            'user_id' => $this->user->id,
            'activity_id' => $this->activity->id
        ]);
    }

    private function addUserToParticipant() : void {
        $this->participant = Participant::create([
            'user_id' => $this->user->id,
            'activity_id' => $this->activity->id
        ]);
    }

}
