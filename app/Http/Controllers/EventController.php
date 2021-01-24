<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventSearchRequest;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Services\EventCategoryService;
use App\Services\EventRepetitionService;
use App\Services\EventService;
use App\Services\OrganizerService;
use App\Services\TeacherService;
use App\Services\VenueService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\CheckPermission;
use Illuminate\View\View;

class EventController extends Controller
{
    use CheckPermission;

    private EventService $eventService;
    private EventCategoryService $eventCategoryService;
    private VenueService $venueService;
    private TeacherService $teacherService;
    private OrganizerService $organizerService;
    private EventRepetitionService $eventRepetitionService;

    public function __construct(
        EventService $eventService,
        EventCategoryService $eventCategoryService,
        VenueService $venueService,
        TeacherService $teacherService,
        OrganizerService $organizerService,
        EventRepetitionService $eventRepetitionService
    ) {
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
     * @param \App\Http\Requests\EventSearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(EventSearchRequest $request): View
    {
        $this->checkPermission('events.view');

        $searchParameters = $this->eventService->getSearchParameters($request);
        $events = $this->eventService->getEvents(20, $searchParameters);
        $eventsCategories = $this->eventCategoryService->getEventCategories();
        $statuses = Event::PUBLISHING_STATUS;

        return view('events.index', [
            'events' => $events,
            'eventsCategories' => $eventsCategories,
            'searchParameters' => $searchParameters,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create(): View
    {
        $this->checkPermission('events.create');

        $eventCategories = $this->eventCategoryService->getEventCategories();
        $venues = $this->venueService->getVenues();
        $teachers = $this->teacherService->getTeachers();
        $organizers = $this->organizerService->getOrganizers();

        $eventDateTimeParameters['multipleDates'] = null;
        $eventDateTimeParameters['repeatUntil'] = null;

        return view('events.create', [
            'eventCategories' => $eventCategories,
            'venues' => $venues,
            'teachers' => $teachers,
            'organizers' => $organizers,
            'eventDateTimeParameters' => $eventDateTimeParameters,
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
    public function store(EventStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('events.create');

        $event = $this->eventService->createEvent($request->all());

        $this->eventService->storeImages($event, $request);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $eventId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function show(int $eventId): View
    {
        $event = $this->eventService->getById($eventId);

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $eventId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(int $eventId): View
    {
        $this->checkPermission('posts.edit');

        $event = $this->eventService->getById($eventId);

        $eventCategories = $this->eventCategoryService->getEventCategories();
        $venues = $this->venueService->getVenues();
        $teachers = $this->teacherService->getTeachers();
        $organizers = $this->organizerService->getOrganizers();

        $eventFirstRepetition = $this->eventRepetitionService->getFirstByEventId($event->id);
        $eventDateTimeParameters = $this->eventService->getEventDateTimeParameters($event, $eventFirstRepetition);

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
    public function update(EventStoreRequest $request, int $eventId): RedirectResponse
    {
        $this->checkPermission('posts.edit');

        $event = $this->eventService->updateEvent($request->all(), $eventId);

        $this->eventService->storeImages($event, $request);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $eventId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $eventId): RedirectResponse
    {
        $this->eventService->deleteEvent($eventId);

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully');
    }

    /**
     * Return the HTML of the monthly select dropdown - inspired by - https://www.theindychannel.com/calendar
     * - Used by the AJAX in the event repeat view -
     * - The HTML contain a <select></select> with four <options></options>.
     *
     * @param  \Illuminate\Http\Request  $request  - Just the day
     * @return string
     */
    public function calculateMonthlySelectOptions(Request $request): string
    {
        $date = $request['day'];

        return $this->eventService->getMonthlySelectOptions($date);
    }
}
