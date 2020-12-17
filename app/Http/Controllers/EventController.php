<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Services\EventCategoryService;
use App\Services\EventService;
use App\Services\OrganizerService;
use App\Services\TeacherService;
use App\Services\VenueService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private $eventService;
    private $eventCategoryService;
    private $venueService;
    private $teacherService;
    private $organizerService;

    public function __construct(
        EventService $eventService,
        EventCategoryService $eventCategoryService,
        VenueService $venueService,
        TeacherService $teacherService,
        OrganizerService $organizerService
    )
    {
        $this->eventService = $eventService;
        $this->eventCategoryService = $eventCategoryService;
        $this->venueService = $venueService;
        $this->teacherService = $teacherService;
        $this->organizerService = $organizerService;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $eventCategories = $this->eventCategoryService->getEventCategories();

        return view('events.create', [
            'eventCategories' => $eventCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\EventStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(EventStoreRequest $request)
    {
        $this->eventService->createEvent($request);

        return redirect()->route('events.index')
            ->with('success','Event updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $eventId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $eventId)
    {
        $event = $this->eventService->getById($eventId);

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $eventId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $eventId)
    {
        $event = $this->eventService->getById($eventId);

        $eventCategories = $this->eventCategoryService->getEventCategories();
        $venues = $this->venueService->getVenues();
        $teachers = $this->teacherService->getTeachers();
        $organizers = $this->organizerService->getOrganizers();

        return view('events.edit', [
            'event' => $event,
            'eventCategories' => $eventCategories,
            'venues' => $venues,
            'teachers' => $teachers,
            'organizers' => $organizers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\EventStoreRequest $request
     * @param int $eventId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EventStoreRequest $request, int $eventId)
    {
        dd($request->all());

        $this->eventService->updateEvent($request, $eventId);

        return redirect()->route('events.index')
            ->with('success','Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $eventId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $eventId)
    {
        $this->eventService->deleteEvent($eventId);

        return redirect()->route('events.index')
            ->with('success','Event deleted successfully');
    }


}
