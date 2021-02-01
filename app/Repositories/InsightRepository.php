<?php


namespace App\Repositories;

use App\Models\Insight;

class InsightRepository implements InsightRepositoryInterface
{
    public function getAll()
    {
        return Insight::all();
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
