<?php

namespace App\Actions;

use App\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CreateEventItemsAction
{

    /**
     * Create event items from based on event
     * @param \App\Event $event
     * @return \Illuminate\Support\Collection
     */
    public function execute(Event $event) : Collection
    {
        $items = [];
        $startDate = Carbon::parse($event->date_from);
        $endDate = Carbon::parse($event->date_to);

        // loop from start date to end date
        while ($startDate->lessThanOrEqualTo($endDate)) {
            // check if the day is allowed to create event item
            if ($event->days[strtolower($startDate->shortEnglishDayOfWeek)]) {
                array_push($items, [
                    'title' => $event->title,
                    'date' => $startDate->toDateString(),
                ]);
            }
            $startDate->addDay();
        }

        return $event->eventItems()->createMany($items);
    }
}
