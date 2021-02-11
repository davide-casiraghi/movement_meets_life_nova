<?php


namespace App\Services;


use App\Helpers\ImageHelpers;
use App\Http\Requests\InsightSearchRequest;
use App\Http\Requests\InsightStoreRequest;
use App\Models\Insight;
use App\Repositories\InsightRepositoryInterface;

class InsightService
{
    private InsightRepositoryInterface $insightRepository;

    /**
     * InsightService constructor.
     *
     * @param \App\Repositories\InsightRepositoryInterface $insightRepository
     */
    public function __construct(InsightRepositoryInterface $insightRepository)
    {
        $this->insightRepository = $insightRepository;
    }

    /**
     * Get all the Insights
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
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
        ImageHelpers::storeImages($insight, $request, 'introimage');

        return $insight;
    }

    /**
     * Update the Insight
     *
     * @param  InsightStoreRequest  $request
     * @param  int  $insightId
     * @return mixed
     */
    public function updateInsight(InsightStoreRequest $request, int $insightId)
    {
        $insight = $this->insightRepository->update($request->all(), $insightId);

        ImageHelpers::storeImages($insight, $request, 'introimage');
        ImageHelpers::deleteImages($insight, $request, 'introimage');

        return $insight;
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
     * Get the post search parameters
     *
     * @param \App\Http\Requests\InsightSearchRequest $request
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
