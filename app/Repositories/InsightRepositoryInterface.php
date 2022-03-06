<?php

namespace App\Repositories;

use App\Models\Insight;
use Illuminate\Support\Collection;

interface InsightRepositoryInterface
{
    public function getAll(int $recordsPerPage = null, array $searchParameters = null);

    public function getById($insightId);

    public function store(array $data);

    public function update(array $data, Insight $insight);

    public function delete(int $id);

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  \App\Models\Insight  $insight
     * @param  array  $data
     *
     * @return \App\Models\Insight
     */
    public function assignDataAttributes(Insight $insight, array $data): Insight;

    /**
     * Get the last 5 Insights.
     *
     * @param  int  $numberOfInsights
     *
     * @return Collection
     */
    public function getLatest(int $numberOfInsights): Collection;
}