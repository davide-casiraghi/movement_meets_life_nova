<?php


namespace App\Services;


use App\Http\Requests\InsightStoreRequest;
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
    public function getInsights()
    {
        return $this->insightRepository->getAll();
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
        return $this->insightRepository->store($request->all());
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
}
