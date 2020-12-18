<?php


namespace App\Repositories;

use App\Http\Requests\EventRepetitionStoreRequest;
use App\Models\EventRepetition;
use Illuminate\Support\Facades\Auth;


class EventRepetitionRepository {

    /**
     * Get all EventRepetitions.
     *
     * @return \App\Models\EventRepetition[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null)
    {
        if($recordsPerPage){
            return EventRepetition::paginate($recordsPerPage);
        }
        return EventRepetition::all();
    }

    /**
     * Get EventRepetition by id
     *
     * @param $eventRepetitionId
     * @return EventRepetition
     */
    public function getById($eventRepetitionId)
    {
        return EventRepetition::findOrFail($eventRepetitionId);
    }

    /**
     * Get the event first repetition
     *
     * @param $eventId
     *
     * @return EventRepetition
     */
    public function getFirstByEventId($eventId)
    {
        return EventRepetition::select('id', 'start_repeat', 'end_repeat')
            ->where('event_id', '=', $eventId)
            ->first();

       /* DB::table('event_repetitions')
            ->select('id', 'start_repeat', 'end_repeat')
            ->where('event_id', '=', $event->id)
            ->first();*/
    }

    /**
     * Store EventRepetition
     *
     * @param \App\Http\Requests\EventRepetitionStoreRequest $data
     *
     * @return EventRepetition
     */
    public function store(EventRepetitionStoreRequest $data)
    {
        $eventRepetition = new EventRepetition();

        $eventRepetition->title = $data['title'] ?? null;
        $eventRepetition->category_id = $data['category_id'] ?? null;
        $eventRepetition->created_by = Auth::id();
        $eventRepetition->intro_text = $data['intro_text'] ?? null;

        $eventRepetition->body = $data['body'] ?? null;
        $eventRepetition->before_content = $data['before_content'] ?? null;
        $eventRepetition->after_content = $data['after_content'] ?? null;

        $eventRepetition->featured = $data['featured'] ?? 0;
        $eventRepetition->publish_at = $data['publish_at'] ?? null;
        $eventRepetition->publish_until = $data['publish_until'] ?? null;

        $eventRepetition->save();

        //$alert->setStatus(($data['send_as_sms'] == 'on') ? 'approved' : 'pending');

        return $eventRepetition->fresh();
    }

    /**
     * Update EventRepetition
     *
     * @param \App\Http\Requests\EventRepetitionStoreRequest $data
     * @param int $id
     *
     * @return EventRepetition
     */
    public function update(EventRepetitionStoreRequest $data, int $id)
    {
        $eventRepetition = $this->getById($id);

        $eventRepetition->title = $data['title'] ?? null;
        $eventRepetition->category_id = $data['category_id'] ?? null;
        $eventRepetition->intro_text = $data['intro_text'] ?? null;

        $eventRepetition->body = $data['body'] ?? null;
        $eventRepetition->before_content = $data['before_content'] ?? null;
        $eventRepetition->after_content = $data['after_content'] ?? null;

        $eventRepetition->featured = $data['featured'] ?? 0;
        $eventRepetition->publish_at = $data['publish_at'] ?? null;
        $eventRepetition->publish_until = $data['publish_until'] ?? null;

        $eventRepetition->update();

        if($eventRepetition->wasChanged()){
            $eventRepetition->setStatus('updated', Auth::id());
        }

        return $eventRepetition;
    }

    /**
     * Delete EventRepetition
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        EventRepetition::destroy($id);
    }


}