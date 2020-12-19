<?php


namespace App\Repositories;

use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;


class EventRepository {

    /**
     * Get all Events.
     *
     * @return \App\Models\Event[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null)
    {
        if($recordsPerPage){
            return Event::paginate($recordsPerPage);
        }
        return Event::all();
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
     * @param \App\Http\Requests\EventStoreRequest $data
     *
     * @return Event
     */
    public function store(EventStoreRequest $data)
    {
        $event = new Event();

        $event->user_id = Auth::id();
        $event->event_category_id = $data['event_category_id'] ?? null;
        $event->venue_id = $data['venue_id'] ?? null;

        $event->title = $data['title'] ?? null;
        $event->description = $data['description'] ?? null;
        $event->contact_email = $data['contact_email'] ?? null;


        $event->website_event_link = $data['website_event_link'] ?? null;
        $event->facebook_event_link = $data['facebook_event_link'] ?? null;

        $event->repeat_type = $data['repeat_type'] ?? null;
        $event->repeat_until = $data['repeat_until'] ?? null;
        $event->repeat_weekly_on = $data['repeat_weekly_on'] ?? null;
        $event->repeat_monthly_on = $data['repeat_monthly_on'] ?? null;
        $event->on_monthly_kind = $data['on_monthly_kind'] ?? null;
        $event->multiple_dates = $data['multiple_dates'] ?? null;









        $event->save();

        //$alert->setStatus(($data['send_as_sms'] == 'on') ? 'approved' : 'pending');

        return $event->fresh();
    }

    /**
     * Update Event
     *
     * @param \App\Http\Requests\EventStoreRequest $data
     * @param int $id
     *
     * @return Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function update(EventStoreRequest $data, int $id)
    {
        $event = $this->getById($id);

        $event->event_category_id = $data['event_category_id'] ?? null;
        $event->venue_id = $data['venue_id'] ?? null;

        $event->title = $data['title'] ?? null;
        $event->description = $data['description'] ?? null;
        $event->contact_email = $data['contact_email'] ?? null;


        $event->website_event_link = $data['website_event_link'] ?? null;
        $event->facebook_event_link = $data['facebook_event_link'] ?? null;

        $event->repeat_type = $data['repeat_type'] ?? null;
        $event->repeat_until = $data['repeat_until'] ?? null;
        $event->repeat_weekly_on = $data['repeat_weekly_on'] ?? null;
        $event->repeat_monthly_on = $data['repeat_monthly_on'] ?? null;
        $event->on_monthly_kind = $data['on_monthly_kind'] ?? null;
        $event->multiple_dates = $data['multiple_dates'] ?? null;

        $event->update();

        if($event->wasChanged()){
            $event->setStatus('updated', Auth::id());
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