<?php

namespace App\Http\Controllers\Api;

use App\EventItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventItem as EventItemResource;

class EventItemController extends Controller
{
    /**
     * Display a listing of event items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = EventItem::with('event')->get();

        return EventItemResource::collection($items);
    }
}
