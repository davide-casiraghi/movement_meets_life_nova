<?php

namespace App\Repositories;

use App\Models\Testimonial;

class TestimonialRepository implements TestimonialRepositoryInterface {

    /**
     * Get all Posts.
     *
     * @return iterable
     */
    public function getAll()
    {
        return Testimonial::all();
    }

    /**
     * Get Testimonial by id
     *
     * @param $testimonialId
     * @return Testimonial
     */
    public function getById($testimonialId)
    {
        return Testimonial::findOrFail($testimonialId);
    }

    /**
     * Store Testimonial
     *
     * @param $data
     * @return Testimonial
     */
    public function store($data)
    {
        $testimonial = new Testimonial();

        $testimonial->feedback = $data['feedback'] ?? null;
        $testimonial->first_name = $data['first_name'] ?? null;
        $testimonial->last_name = $data['last_name'] ?? null;
        $testimonial->profession = $data['profession'] ?? null;
        $testimonial->country = $data['country'] ?? null;
        $testimonial->publish_agreement =  ($data['publish_agreement'] == 'on') ? 1 : 0;
        $testimonial->personal_data_agreement =  ($data['personal_data_agreement'] == 'on') ? 1 : 0;
        $testimonial->save();

        $testimonial->setStatus('Pending');

        return $testimonial->fresh();
    }
}