<?php
namespace App\Services;

use App\Http\Requests\VenueStoreRequest;
use App\Models\Venue;
use App\Repositories\VenueRepository;

class VenueService {
    private $venueRepository;

    public function __construct(
        VenueRepository $venueRepository
    ) {
        $this->venueRepository = $venueRepository;
    }

    /**
     * Create a venue
     *
     * @param \App\Http\Requests\VenueStoreRequest $data
     *
     * @return \App\Models\Venue
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createVenue(VenueStoreRequest $data)
    {
        $venue = $this->venueRepository->store($data);

        $venue->setStatus('pending');

        $this->storeImages($venue, $data);

        return $venue;
    }

    /**
     * Update the Venue
     *
     * @param \App\Http\Requests\VenueStoreRequest $data
     * @param int $venueId
     *
     * @return \App\Models\Venue
     */
    public function updateVenue(VenueStoreRequest $data, int $venueId)
    {
        $venue = $this->venueRepository->update($data, $venueId);

        $this->storeImages($venue, $data);

        return $venue;
    }

    /**
     * Return the venue from the database
     *
     * @param $venueId
     *
     * @return \App\Models\Venue
     */
    public function getById(int $venueId)
    {
        return $this->venueRepository->getById($venueId);
    }

    /**
     * Get all the Venues.
     *
     * @return iterable
     */
    public function getVenues(int $recordsPerPage = null)
    {
        return $this->venueRepository->getAll($recordsPerPage);
    }

    /**
     * Delete the venue from the database
     *
     * @param int $venueId
     */
    public function deleteVenue(int $venueId): void
    {
        $this->venueRepository->delete($venueId);
    }

    /**
     * Get the number of venue created in the last 30 days.
     *
     * @return int
     */
    public function getNumberVenuesCreatedLastThirtyDays()
    {
        return Venue::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param \App\Models\Venue $venue
     * @param \App\Http\Requests\VenueStoreRequest $data
     *
     * @return void
     */
    private function storeImages(Venue $venue, VenueStoreRequest $data):void {

        if($data->file('introimage')) {
            $introimage = $data->file('introimage');
            if ($introimage->isValid()) {
                $venue->addMedia($introimage)->toMediaCollection('introimage');
            }
        }

        if($data['introimage_delete'] == 'true'){
            $mediaItems = $venue->getMedia('introimage');
            if(!is_null($mediaItems[0])){
                $mediaItems[0]->delete();
            }
        }


    }

    /**
     * Return an array with the thumb images ulrs
     *
     * @param int $venueId
     *
     * @return array
     */
    public function getThumbsUrls(int $venueId): array{
        $thumbUrls = [];

        $venue = $this->getById($venueId);
        foreach($venue->getMedia('venue') as $photo){
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }

}