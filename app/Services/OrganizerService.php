<?php
namespace App\Services;

use App\Http\Requests\OrganizerSearchRequest;
use App\Http\Requests\OrganizerStoreRequest;
use App\Models\Organizer;
use App\Repositories\OrganizerRepository;

class OrganizerService
{
    private OrganizerRepository $organizerRepository;

    /**
     * OrganizerService constructor.
     *
     * @param \App\Repositories\OrganizerRepository $organizerRepository
     */
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
    public function createOrganizer(OrganizerStoreRequest $data): Organizer
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
    public function updateOrganizer(OrganizerStoreRequest $data, int $organizerId): Organizer
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
    public function getById(int $organizerId): Organizer
    {
        return $this->organizerRepository->getById($organizerId);
    }

    /**
     * Get all the Organizers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOrganizers(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->organizerRepository->getAll($recordsPerPage, $searchParameters);
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
    public function getNumberOrganizersCreatedLastThirtyDays(): int
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
    private function storeImages(Organizer $organizer, OrganizerStoreRequest $data): void
    {
        /*if($data->file('photos')) {
            foreach ($data->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $organizer->addMedia($photo)->toMediaCollection('post');
                }
            }
        }*/

        if ($data->file('introimage')) {
            $introimage = $data->file('introimage');
            if ($introimage->isValid()) {
                $organizer->addMedia($introimage)->toMediaCollection('introimage');
            }
        }

        if ($data['introimage_delete'] == 'true') {
            $mediaItems = $organizer->getMedia('introimage');
            if (!is_null($mediaItems[0])) {
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
    public function getThumbsUrls(int $organizerId): array
    {
        $thumbUrls = [];

        $organizer = $this->getById($organizerId);
        foreach ($organizer->getMedia('organizer') as $photo) {
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }

    /**
     * Get the organizer search parameters
     *
     * @param \App\Http\Requests\OrganizerSearchRequest $request
     *
     * @return array
     */
    public function getSearchParameters(OrganizerSearchRequest $request): array
    {
        $searchParameters = [];
        $searchParameters['name'] = $request->name ?? null;
        $searchParameters['surname'] = $request->surname ?? null;
        $searchParameters['email'] = $request->email ?? null;

        return $searchParameters;
    }
}
