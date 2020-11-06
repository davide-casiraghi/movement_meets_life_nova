<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialStoreRequest;
use App\Services\TestimonialService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    private $testimonialService;

    public function __construct(TestimonialService $testimonialService) {
        $this->testimonialService = $testimonialService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request) {
        return view('testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TestimonialStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TestimonialStoreRequest $request)
    {
        $this->testimonialService->createTestimonial($request);

        return redirect()->route('testimonials.create')
            ->with('success', 'Thanks for your testimony!');
    }



}
