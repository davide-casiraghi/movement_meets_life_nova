<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Services\EventCategoryService;
use App\Services\EventRepetitionService;
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
    private $eventRepetitionService;

    public function __construct(
        EventService $eventService,
        EventCategoryService $eventCategoryService,
        VenueService $venueService,
        TeacherService $teacherService,
        OrganizerService $organizerService,
        EventRepetitionService $eventRepetitionService
    )
    {
        $this->eventService = $eventService;
        $this->eventCategoryService = $eventCategoryService;
        $this->venueService = $venueService;
        $this->teacherService = $teacherService;
        $this->organizerService = $organizerService;
        $this->eventRepetitionService = $eventRepetitionService;
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

        $eventFirstRepetition = $this->eventRepetitionService->getFirstByEventId($event->id);
        $eventDateTimeParameters = $this->eventService->getEventDateTimeParameters($event, $eventFirstRepetition);




            /*DB::table('event_repetitions')
            ->select('id', 'start_repeat', 'end_repeat')
            ->where('event_id', '=', $event->id)
            ->first();*/

        return view('events.edit', [
            'event' => $event,
            'eventCategories' => $eventCategories,
            'venues' => $venues,
            'teachers' => $teachers,
            'organizers' => $organizers,
            'eventFirstRepetition' => $eventFirstRepetition,
            'eventDateTimeParameters' => $eventDateTimeParameters,
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
        $this->eventService->updateEvent($request, $eventId);
        $this->eventRepetitionService->updateEventRepetitions($request, $eventId);

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


    /**
     * Return the HTML of the monthly select dropdown - inspired by - https://www.theindychannel.com/calendar
     * - Used by the AJAX in the event repeat view -
     * - The HTML contain a <select></select> with four <options></options>.
     *
     * @param  \Illuminate\Http\Request  $request  - Just the day
     * @return string
     */
    public function calculateMonthlySelectOptions(Request $request)
    {
        return $this->eventService->getMonthlySelectOptions($request);
    }


}
