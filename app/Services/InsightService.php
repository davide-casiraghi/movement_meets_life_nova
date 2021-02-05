<?php


namespace App\Services;


use App\Http\Requests\InsightSearchRequest;
use App\Http\Requests\InsightStoreRequest;
use App\Models\Insight;
use App\Repositories\InsightRepositoryInterface;

class InsightService
{
    private $insightRepository;

    /**
     * InsightService constructor.
     */
    public function __construct(InsightRepositoryInterface $insightRepository)
    {
        $this->insightRepository = $insightRepository;
    }

    /**
     * Get all the Insights
     *
     * @return mixed
     */
    public function getInsights(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->insightRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Get the Insight by id
     *
     * @param $insightId
     * @return mixed
     */
    public function getInsightById($insightId)
    {
        return $this->insightRepository->getById($insightId);
    }

    /**
     * Create a new Insight
     *
     * @param  InsightStoreRequest  $request
     * @return mixed
     */
    public function createInsight(InsightStoreRequest $request)
    {
        $insight = $this->insightRepository->store($request->all());
        $this->storeImages($insight, $request);

        return $insight;
    }

    /**
     * Update the Insight
     *
     * @param  InsightStoreRequest  $request
     * @param  int  $isightId
     * @return mixed
     */
    public function updateInsight(InsightStoreRequest $request, int $isightId)
    {
        return $this->insightRepository->update($request->all(), $isightId);
    }

    /**
     * Delete the Insight from the database
     *
     * @param  int  $insightId
     */
    public function deleteInsight(int $insightId)
    {
        $this->insightRepository->delete($insightId);
    }

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param \App\Models\Post $post
     * @param \App\Http\Requests\PostStoreRequest $data
     *
     * @return void
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function storeImages(Insight $insight, InsightStoreRequest $data): void
    {
        if ($data->file('introimage')) {
            $introimage = $data->file('introimage');
            if ($introimage->isValid()) {
                $insight->addMedia($introimage)->toMediaCollection('introimage');
            }
        }

        if ($data['introimage_delete'] == 'true') {
            $mediaItems = $insight->getMedia('introimage');
            if (!is_null($mediaItems[0])) {
                $mediaItems[0]->delete();
            }
        }
    }

    /**
     * Get the post search parameters
     *
     * @param \App\Http\Requests\PostSearchRequest $request
     *
     * @return array
     */
    public function getSearchParameters(InsightSearchRequest $request): array
    {
        $searchParameters = [];
        $searchParameters['title'] = $request->title ?? null;

        return $searchParameters;
    }

    public function getInsightBody($insight)
    {
        $insightBody = $insight->body;

//        $insightBody = $this->accordionService->snippetsToHTML($insightBody);
//        $insightBody = $this->galleryService->snippetsToHTML($insightBody);
//        $insightBody = $this->glossaryService->markGlossaryTerms($insightBody);

        return $insightBody;
    }
}
