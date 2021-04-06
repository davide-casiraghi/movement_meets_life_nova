<?php

namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\InsightSearchRequest;
use App\Http\Requests\InsightStoreRequest;
use App\Models\Insight;
use App\Repositories\InsightRepositoryInterface;
use Illuminate\Support\Collection;

class InsightService
{
    private InsightRepositoryInterface $insightRepository;
    private NotificationService $notificationService;

    /**
     * InsightService constructor.
     *
     * @param \App\Repositories\InsightRepositoryInterface $insightRepository
     */
    public function __construct(
        InsightRepositoryInterface $insightRepository,
        NotificationService $notificationService
    ) {
        $this->insightRepository = $insightRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * Get all the Insights
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getInsights(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->insightRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Get the Insight by id
     *
     * @param int $insightId
     * @return Insight
     */
    public function getInsightById(int $insightId): Insight
    {
        return $this->insightRepository->getById($insightId);
    }

    /**
     * Create a new Insight
     *
     * @param  InsightStoreRequest  $request
     * @return Insight
     */
    public function createInsight(InsightStoreRequest $request): Insight
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
     * @return Insight
     */
    public function updateInsight(InsightStoreRequest $request, int $insightId): Insight
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
    public function deleteInsight(int $insightId): void
    {
        $this->insightRepository->delete($insightId);
    }

    /**
     * Return the body of the insight
     *
     * @param \App\Models\Insight $insight
     *
     * @return string
     */
    public function getInsightBody(Insight $insight): string
    {
        $insightBody = $insight->body;

//        $insightBody = $this->accordionService->snippetsToHTML($insightBody);
//        $insightBody = $this->galleryService->snippetsToHTML($insightBody);
//        $insightBody = $this->glossaryService->markGlossaryTerms($insightBody);

        return $insightBody;
    }

    /**
     * Get all the Insights
     *
     * @param int $numberOfInsights
     *
     * @return Collection
     */
    public function getLatestInsights(int $numberOfInsights): Collection
    {
        return $this->insightRepository->getLatest($numberOfInsights);
    }

    /**
     * Get all the Insights
     *
     * @param  \App\Models\Insight  $insight
     *
     * @return bool
     */
    public function sendInsightToTwitter(Insight $insight): bool
    {
        $data = $insight->toArray();
        return $this->notificationService->sendTwitterInsight($data, $insight);
    }
}
