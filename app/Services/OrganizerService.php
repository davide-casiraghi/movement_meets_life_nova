<?php
namespace App\Services;

use App\Http\Requests\OrganizerStoreRequest;
use App\Models\Organizer;
use App\Repositories\OrganizerRepository;

class OrganizerService {
    private $organizerRepository;

    public function __construct(
        OrganizerRepository $organizerRepository
    ) {
        $this->organizerRepository = $organizerRepository;
    }

    /**
     * Create a organizer
     *
     * @param \App\Http\Requests\OrganizerStoreRequest $data
     *
     * @return \App\Models\Organizer
     */
    public function createOrganizer(OrganizerStoreRequest $data)
    {
        $organizer = $this->organizerRepository->store($data);

        $organizer->setStatus('published');

        $this->storeImages($organizer, $data);

        return $organizer;
    }

    /**
     * Update the Organizer
     *
     * @param \App\Http\Requests\OrganizerStoreRequest $data
     * @param int $organizerId
     *
     * @return \App\Models\Organizer
     */
    public function updateOrganizer(OrganizerStoreRequest $data, int $organizerId)
    {
        $organizer = $this->organizerRepository->update($data, $organizerId);

        $this->storeImages($organizer, $data);

        return $organizer;
    }

    /**
     * Return the organizer from the database
     *
     * @param $organizerId
     *
     * @return \App\Models\Organizer
     */
    public function getById(int $organizerId)
    {
        return $this->organizerRepository->getById($organizerId);
    }

    /**
     * Get all the Organizers.
     *
     * @return iterable
     */
    public function getOrganizers(int $recordsPerPage = null)
    {
        return $this->organizerRepository->getAll($recordsPerPage);
    }

    /**
     * Delete the organizer from the database
     *
     * @param int $organizerId
     */
    public function deleteOrganizer(int $organizerId): void
    {
        $this->organizerRepository->delete($organizerId);
    }

    /**
     * Get the number of organizer created in the last 30 days.
     *
     * @return int
     */
    public function getNumberOrganizersCreatedLastThirtyDays()
    {
        return Organizer::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param \App\Models\Organizer $organizer
     * @param \App\Http\Requests\OrganizerStoreRequest $data
     *
     * @return void
     */
    private function storeImages(Organizer $organizer, OrganizerStoreRequest $data):void {
        /*if($data->file('photos')) {
            foreach ($data->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $organizer->addMedia($photo)->toMediaCollection('post');
                }
            }
        }*/

        if($data->file('introimage')) {
            $introimage = $data->file('introimage');
            if ($introimage->isValid()) {
                $organizer->addMedia($introimage)->toMediaCollection('introimage');
            }
        }

        if($data['introimage_delete'] == 'true'){
            $mediaItems = $organizer->getMedia('introimage');
            if(!is_null($mediaItems[0])){
                $mediaItems[0]->delete();
            }
        }


    }

    /**
     * Return an array with the thumb images ulrs
     *
     * @param int $organizerId
     *
     * @return array
     */
    public function getThumbsUrls(int $organizerId): array{
        $thumbUrls = [];

        $organizer = $this->getById($organizerId);
        foreach($organizer->getMedia('organizer') as $photo){
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }

}