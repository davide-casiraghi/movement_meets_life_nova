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

        $event->title = $data['title'] ?? null;
        $event->category_id = $data['category_id'] ?? null;
        $event->intro_text = $data['intro_text'] ?? null;

        $event->body = $data['body'] ?? null;
        $event->before_content = $data['before_content'] ?? null;
        $event->after_content = $data['after_content'] ?? null;

        $event->featured = $data['featured'] ?? 0;
        $event->publish_at = $data['publish_at'] ?? null;
        $event->publish_until = $data['publish_until'] ?? null;

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
     */
    public function update(EventStoreRequest $data, int $id)
    {
        $event = $this->getById($id);

        $event->title = $data['title'] ?? null;
        $event->category_id = $data['category_id'] ?? null;
        $event->intro_text = $data['intro_text'] ?? null;

        $event->body = $data['body'] ?? null;
        $event->before_content = $data['before_content'] ?? null;
        $event->after_content = $data['after_content'] ?? null;

        $event->featured = $data['featured'] ?? 0;
        $event->publish_at = $data['publish_at'] ?? null;
        $event->publish_until = $data['publish_until'] ?? null;

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