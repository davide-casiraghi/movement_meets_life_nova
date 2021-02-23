<?php


namespace App\Repositories;

use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventRepository implements EventRepositoryInterface
{

    /**
     * Get all Events.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \App\Models\Event[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Event::orderBy('title', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['title'])) {
                $query->where(
                    'title',
                    'like',
                    '%' . $searchParameters['title'] . '%'
                );
            }
            if (!empty($searchParameters['eventCategoryId'])) {
                $query->where('event_category_id', $searchParameters['eventCategoryId']);
            }
            if (!empty($searchParameters['startDate'])) {
                $startDate = Carbon::createFromFormat(
                    'd/m/Y',
                    $searchParameters['startDate']
                );
                $query->where('created_at', '>=', $startDate);
            }
            if (!empty($searchParameters['endDate'])) {
                $endDate = Carbon::createFromFormat(
                    'd/m/Y',
                    $searchParameters['endDate']
                );
                $query->where('created_at', '<=', $endDate);
            }
            if (!empty($searchParameters['status'])) {
                $query->currentStatus($searchParameters['status']);
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Event by id
     *
     * @param int $eventId
     * @return Event
     */
    public function getById(int $eventId): Event
    {
        return Event::findOrFail($eventId);
    }

    /**
     * Store Event
     *
     * @param array $data
     *
     * @return Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(array $data): Event
    {
        $event = new Event();
        $event = self::assignDataAttributes($event, $data);

        // Creator - Logged user id or 1 for factories
        $event->user_id = !is_null(Auth::id()) ? Auth::id() : 1;

        $event->save();

        self::syncManyToMany($event, $data);

        $event->setStatus('published');

        return $event->fresh();
    }

    /**
     * Update Event
     *
     * @param array $data
     * @param int $id
     *
     * @return Event
     */
    public function update(array $data, int $id): Event
    {
        $event = $this->getById($id);
        $event = self::assignDataAttributes($event, $data);

        $event->update();

        self::syncManyToMany($event, $data);

        $status = (isset($data['status'])) ? 'published' : 'unpublished';
        if ($event->publishingStatus() != $status) {
            $event->setStatus($status);
        }

        return $event;
    }

    /**
     * Delete Event
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Event::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Event $event
     * @param array $data
     *
     * @return \App\Models\Event
     */
    public function assignDataAttributes(Event $event, array $data): Event
    {
        $event->event_category_id = $data['event_category_id'];
        $event->venue_id = $data['venue_id'];

        $event->title = $data['title'];
        $event->description = $data['description'];
        $event->contact_email = $data['contact_email'];
        $event->website_event_link = $data['website_event_link'];
        $event->facebook_event_link = $data['facebook_event_link'];
        $event->repeat_type = $data['repeat_type'];

        switch ($data['repeat_type']) {
            case 1: // No Repeat
                $event->repeat_until = null;
                break;
            case 2: // Weekly
                if (array_key_exists('repeat_weekly_on', $data)) {
                    $event->repeat_weekly_on = implode(',', array_keys($data['repeat_weekly_on']));
                }
                $event->repeat_until = Carbon::createFromFormat('d/m/Y', $data['repeat_until']);
                break;
            case 3: // Monthly
                $event->on_monthly_kind = $data['on_monthly_kind'] ?? null;
                $event->repeat_until = Carbon::createFromFormat('d/m/Y', $data['repeat_until']);
                break;
            case 4: // Multiple days
                $event->multiple_dates = $data['multiple_dates'] ?? null;
                $event->repeat_until = null;
                break;
        }

        return $event;
    }


    /**
     * Sync the many-to-many relatioships
     *
     * @param \App\Models\Event $event
     * @param array $data
     *
     * @return void
     */
    public function syncManyToMany(Event $event, array $data): void
    {
        $event->teachers()->sync($data['teacher_ids'] ?? null);
        $event->organizers()->sync($data['organizer_ids'] ?? null);
    }
}
