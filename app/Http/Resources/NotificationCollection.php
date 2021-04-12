<?php

namespace App\Http\Resources;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;

class NotificationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function (DatabaseNotification $notification) {
                $title = '';
                $description = '';
                $type = '';

                switch ($notification->type) {
                    case 'App\Notifications\MemberApplicationResult':
                        $title = 'Member Application';
                        $description = 'Member Application '.ucfirst($notification->data['result']);
                        break;

                    case 'App\Notifications\ActivityEnrollmentStatusUpdated' :
                        $type = 'activity-enrollment-status-update';
                        $title = Activity::find($notification->data['activity_id'])->name;
                        $description = 'You have '.$notification->data['status'].' to this activity';
                        break;
                }

                return [
                    'id' => $notification->id,
                    'title' => $title,
                    'type' => $type,
                    'description' => $description,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at
                ];
            })
        ];
    }
}
