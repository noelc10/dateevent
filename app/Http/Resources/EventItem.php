<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Event as EventResource;

class EventItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'event_id' => $this->event_id,
            'title'    => $this->title,
            'date'     => $this->date,
            'event'    => new EventResource($this->whenLoaded('event')),
        ];
    }
}
