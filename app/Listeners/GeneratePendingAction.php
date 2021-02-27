<?php

namespace App\Listeners;

use App\Models\Action;
use App\Events\User\MembershipApplied;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GeneratePendingAction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param MembershipApplied $event
     * @return void
     */
    public function handle(MembershipApplied $event)
    {
        $response = $event->dataCollectionResponse;

        // FIXME: this is a temporary fix for duplicate creation
        if ($response->user->actions()->where('data_collection_response_id', $response->id)) {
            return;
        }

        Action::create([
            'user_id' => $response->user_id,
            'type' => 'member-application',
            'step' => 1,
            'meta' => [
                'data_collection_response_id' => $response->id,
                'user_id' => $response->user_id
            ]
        ]);
    }
}
