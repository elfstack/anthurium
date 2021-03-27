<?php

namespace App\Http\Resources;

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

                switch ($notification->type) {
                    case 'App\Notifications\MemberApplicationResult':
                        $title = 'Member Application '.ucfirst($notification->data['result']);
                        $description = $title;
                        break;
                }

                return [
                    'id' => $notification->id,
                    'title' => $title,
                    'description' => $description,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at
                ];
            })
        ];
    }
}
