<?php

namespace App\Repositories;

use App\Models\Testimonial;

interface TestimonialRepositoryInterface
{

    /**
     * Get all Testimonials.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(
        int $recordsPerPage = null,
        array $searchParameters = null
    );

    /**
     * Get Testimonial by id
     *
     * @param $testimonialId
     *
     * @return Testimonial
     */
    public function getById($testimonialId): Testimonial;

    /**
     * Store Testimonial
     *
     * @param $data
     *
     * @return Testimonial
     */
    public function store(array $data): Testimonial;

    /**
     * Update Testimonial
     *
     * @param array $data
     * @param int $id
     *
     * @return Testimonial
     */
    public function update(array $data, int $id): Testimonial;

    /**
     * Delete Testimonial
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Testimonial $testimonial
     * @param array $data
     *
     * @return \App\Models\Testimonial
     */
    public function assignDataAttributes(
        Testimonial $testimonial,
        array $data
    ): Testimonial;

}