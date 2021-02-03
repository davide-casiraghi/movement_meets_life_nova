<?php


namespace App\Repositories;

use App\Models\Insight;
use Carbon\Carbon;

class InsightRepository implements InsightRepositoryInterface
{
    public function getAll(
        int $recordsPerPage = null,
        array $searchParameters = null
    )
    {
        $query = Insight::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['title'])) {
                $query->where(
                    'title',
                    'like',
                    '%' . $searchParameters['title'] . '%'
                );
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage);
        } else {
            $results = $query->get();
        }

        return $results;
    }

    public function getById($insightId)
    {
        return Insight::findOrFail($insightId);
    }

    public function store(array $data)
    {
        $insight = new Insight();
        $insight = self::assignDataAttributes($insight, $data);

        $insight->save();

        return $insight->fresh();
    }

    public function update(array $data, int $id)
    {
        $insight = $this->getById($id);
        $insight = self::assignDataAttributes($insight, $data);

        $insight->update();

        return $insight;
    }

    public function delete(int $id)
    {
        Insight::destroy($id);
    }
}
