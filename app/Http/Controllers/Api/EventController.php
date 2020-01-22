<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Event;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use App\Actions\CreateEventItemsAction;
use App\Http\Resources\Event as EventResource;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EventResource::collection(Event::all());
    }

    /**
     * Store a newly created event.
     *
     * @param  App\Http\Requests\EventRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        // Use transaction for multiple table insert
        DB::beginTransaction();
        try {

            $event = Event::create($request->only(['title', 'date_from', 'date_to', 'days']));
            // Create Event Items from new event
            (new CreateEventItemsAction())->execute($event);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return (new EventResource($event))->response()->setStatusCode(201);
    }

    /**
     * Update the specified event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        // Use transaction for multiple table changes
        DB::beginTransaction();
        try {

            $event = Event::findOrFail($id);

            $event->update($request->only(['title', 'date_from', 'date_to', 'days']));

            // Remove all event items on current event
            $event->eventItems()->delete();
            // Create Event Items from updated event
            (new CreateEventItemsAction())->execute($event);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return new EventResource($event);
    }

    /**
     * Remove the specified event from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Use transaction for multiple table delete
        DB::beginTransaction();
        try {

            $event = Event::findOrFail($id);
            // Remove all event items on current event
            $event->eventItems()->delete();
            $event->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
