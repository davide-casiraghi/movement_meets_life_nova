<?php

namespace App\Repositories;

use App\Models\Testimonial;

interface TestimonialRepositoryInterface {

    /**
     * Get all Posts.
     *
     * @return iterable
     */
    public function getAll();

    /**
     * Get Testimonial by id
     *
     * @param $testimonialId
     *
     * @return Testimonial
     */
    public function getById($testimonialId);

    /**
     * Store Testimonial
     *
     * @param $data
     *
     * @return Testimonial
     */
    public function store($data);

}