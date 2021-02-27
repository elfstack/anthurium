<?php

namespace App\Events\User;

use App\Models\DataCollectionResponse;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MembershipApplied
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var DataCollectionResponse collected form response
     */
    public $dataCollectionResponse;

    /**
     * Create a new event instance.
     *
     * @param DataCollectionResponse $response
     */
    public function __construct(DataCollectionResponse $response)
    {
        $this->dataCollectionResponse = $response;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
