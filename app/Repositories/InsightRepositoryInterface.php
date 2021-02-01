<?php

namespace App\Repositories;

interface InsightRepositoryInterface
{
    public function getAll();

    public function getById($insightId);

    public function store(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);
}
