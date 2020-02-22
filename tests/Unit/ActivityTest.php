<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Activity;

class ActivityTest extends TestCase
{

    use RefreshDatabase;

    protected $activity;

    protected function setUp() : void {
        parent::setUp();

        $this->activity = Activity::create([
            'name' => 'Test',
            'starts_at' => now(),
            'ends_at' => now(),
            'content' => 'Test content',
            'quota' => 10
        ]);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testParticipantsPercentage()
    {
        $this->assertEquals($this->activity->participantsPercentage(), 0);
    }
}
