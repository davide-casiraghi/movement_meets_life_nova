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
        ray('aaa');
        $query = Event::orderBy('created_at', 'desc');

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
            $results = $query->paginate($recordsPerPage);
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Event by id
     *
     * @param $eventId
     * @return Event
     */
    public function getById($eventId)
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

        $event->user_id = Auth::id();
        $event->event_category_id = $data['event_category_id'];

        $event->venue_id = $data['venue_id'];

        $event->title = $data['title'];
        $event->description = $data['description'];
        $event->contact_email = $data['contact_email'];

        $event->website_event_link = $data['website_event_link'];
        $event->facebook_event_link = $data['facebook_event_link'];

        $event->repeat_type = $data['repeat_type'];
        $event->repeat_until = $data['repeat_until'] ?? null;
        $event->repeat_weekly_on = $data['repeat_weekly_on'] ?? null;
        $event->on_monthly_kind = $data['on_monthly_kind'] ?? null;
        $event->multiple_dates = $data['multiple_dates'] ?? null;

        $event->save();

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

        $event->event_category_id = $data['event_category_id'];
        $event->venue_id = $data['venue_id'];

        $event->title = $data['title'];
        $event->description = $data['description'];
        $event->contact_email = $data['contact_email'];

        $event->website_event_link = $data['website_event_link'];
        $event->facebook_event_link = $data['facebook_event_link'];

        $event->repeat_type = $data['repeat_type'];
        $event->repeat_until = array_key_exists('repeat_type', $data) ? Carbon::createFromFormat('d/m/Y', $data['repeat_until']) : '';

        $event->repeat_weekly_on = $data['repeat_weekly_on'] ?? null;
        $event->on_monthly_kind = $data['on_monthly_kind'] ?? null;
        $event->multiple_dates = $data['multiple_dates'] ?? null;

        $event->update();

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
    public function delete(int $id)
    {
        Event::destroy($id);
    }
}
