<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class NotificationResource extends JsonResource
{

    public static $wrap = 'notification';
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $title = '<unknown notification>';
        $description = '<no description available>';

        switch ($this->type) {
            case 'App\Notifications\MemberApplicationResult':
                $title = 'Member Application '.Str::ucfirst($this->data['result']);
                $description = $title;
                break;
        }

        return [
            'title' => $title,
            'description' => $description,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at
        ];
    }
}
