<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Services\StaticPageService;
use App\Services\TestimonialService;

class HomeController extends Controller
{
    private PostService $postService;
    private StaticPageService $staticPageService;
    private TestimonialService $testimonialService;

    /**
     * Create a new controller instance.
     *
     * @param  PostService  $postService
     * @param  StaticPageService  $staticPageService
     * @param  TestimonialService  $testimonialService
     */
    public function __construct(
        PostService $postService,
        StaticPageService $staticPageService,
        TestimonialService $testimonialService
    ) {
        $this->postService = $postService;
        $this->staticPageService = $staticPageService;
        $this->testimonialService = $testimonialService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = $this->postService->getPosts();

        $videoIntro = $this->staticPageService->getStaticImageHtml('1');

        $lastPosts = $this->postService->getPosts(3);

        $testimonials = $this->testimonialService->getTestimonials(3);

        return view('home', [
            'lastPosts' => $lastPosts,
            'videoIntro' => $videoIntro,
            'testimonials' => $testimonials
        ]);
    }
}
