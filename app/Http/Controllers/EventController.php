<?php

namespace App\Http\Controllers;

use App\Services\EventCategoryService;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private $eventService;
    private $eventCategoryService;

    public function __construct(
        EventService $eventService,
        EventCategoryService $eventCategoryService
    )
    {
        $this->eventService = $eventService;
        $this->eventCategoryService = $eventCategoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $events = $this->eventService->getEvents(20);

        return view('events.index', [
            'events' => $events,
        ]);
    }


}
