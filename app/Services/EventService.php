<?php
namespace App\Services;

use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Repositories\EventRepository;

class EventService {
    private $eventRepository;

    public function __construct(
        EventRepository $eventRepository
    ) {
        $this->eventRepository = $eventRepository;
    }
    
    /**
     * Create a event
     *
     * @param \App\Http\Requests\EventStoreRequest $data
     *
     * @return \App\Models\Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createEvent(EventStoreRequest $data)
    {
        $event = $this->eventRepository->store($data);

        $event->setStatus('pending');

        $this->storeImages($event, $data);

        return $event;
    }

    /**
     * Update the Event
     *
     * @param \App\Http\Requests\EventStoreRequest $data
     * @param int $eventId
     *
     * @return \App\Models\Event
     */
    public function updateEvent(EventStoreRequest $data, int $eventId)
    {
        $event = $this->eventRepository->update($data, $eventId);

        $this->storeImages($event, $data);

        return $event;
    }

    /**
     * Return the event from the database
     *
     * @param $eventId
     *
     * @return \App\Models\Event
     */
    public function getById(int $eventId)
    {
        return $this->eventRepository->getById($eventId);
    }

    /**
     * Get all the Events.
     *
     * @return iterable
     */
    public function getEvents(int $recordsPerPage = null)
    {
        return $this->eventRepository->getAll($recordsPerPage);
    }

    /**
     * Delete the event from the database
     *
     * @param int $eventId
     */
    public function deleteEvent(int $eventId): void
    {
        $this->eventRepository->delete($eventId);
    }

    /**
     * Get the number of event created in the last 30 days.
     *
     * @return int
     */
    public function getNumberEventsCreatedLastThirtyDays()
    {
        return Event::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param \App\Models\Event $event
     * @param \App\Http\Requests\EventStoreRequest $data
     *
     * @return void
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function storeImages(Event $event, EventStoreRequest $data):void {
        /*if($data->file('photos')) {
            foreach ($data->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $event->addMedia($photo)->toMediaCollection('event');
                }
            }
        }*/

        if($data->file('introimage')) {
            $introimage = $data->file('introimage');
            if ($introimage->isValid()) {
                $event->addMedia($introimage)->toMediaCollection('introimage');
            }
        }

        if($data['introimage_delete'] == 'true'){
            $mediaItems = $event->getMedia('introimage');
            if(!is_null($mediaItems[0])){
                $mediaItems[0]->delete();
            }
        }


    }

    /**
     * Return an array with the thumb images ulrs
     *
     * @param int $eventId
     *
     * @return array
     */
    public function getThumbsUrls(int $eventId): array{
        $thumbUrls = [];

        $event = $this->getById($eventId);
        foreach($event->getMedia('event') as $photo){
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }


    /**
     * Return an array with the event data related to:
     * - date and time start
     * - date and time end
     * - repeat until
     * - multiple dates
     *
     * @param $event
     * @param $eventFirstRepetition
     *
     * @return array
     */
    public function getEventDateTimeParameters($event, $eventFirstRepetition)
    {
        $dateTime = [];
        $dateTime['dateStart'] = (isset($eventFirstRepetition->start_repeat)) ? date('d/m/Y', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['dateEnd'] = (isset($eventFirstRepetition->end_repeat)) ? date('d/m/Y', strtotime($eventFirstRepetition->end_repeat)) : '';
        $dateTime['timeStart'] = (isset($eventFirstRepetition->start_repeat)) ? date('g:i A', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['timeEnd'] = (isset($eventFirstRepetition->end_repeat)) ? date('g:i A', strtotime($eventFirstRepetition->end_repeat)) : '';
        $dateTime['repeatUntil'] = date('d/m/Y', strtotime($event->repeat_until));
        $dateTime['multipleDates'] = $event->multiple_dates;

        return $dateTime;
    }




}