<?php

namespace App\Http\Controllers;

use App\Services\PostCategoryService;
use App\Services\PostService;
use App\Services\QuoteService;
use App\Services\StaticPageService;
use App\Services\TestimonialService;

class HomeController extends Controller
{
    private const CAROUSEL_POSTS_NUMBER = 12;

    private PostService $postService;
    private PostCategoryService $postCategoryService;
    private StaticPageService $staticPageService;
    private TestimonialService $testimonialService;
    private QuoteService $quoteService;

  /**
   * Create a new controller instance.
   *
   * @param  PostService  $postService
   * @param  PostCategoryService  $postCategoryService
   * @param  StaticPageService  $staticPageService
   * @param  TestimonialService  $testimonialService
   * @param  \App\Services\QuoteService  $quoteService
   */
    public function __construct(
        PostService $postService,
        PostCategoryService $postCategoryService,
        StaticPageService $staticPageService,
        TestimonialService $testimonialService,
        QuoteService $quoteService
    ) {
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
        $this->staticPageService = $staticPageService;
        $this->testimonialService = $testimonialService;
        $this->quoteService = $quoteService;
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
        $lastPosts = $this->postService->getPosts(3, ['status' => 'published']);
        $testimonials = $this->testimonialService->getTestimonials(null, ['status' => 'published']);

        // Blog carousel at the bottom of the page: latest blog posts with an intro image
        $carouselPosts = $this->postService->getPosts(null, [
            'status' => 'published',
            'categoryId' => $this->postCategoryService->getIdByCategoryName('blog'),
            'hasIntroImage' => true,
        ])->take(self::CAROUSEL_POSTS_NUMBER);

        return view('home', [
            'lastPosts' => $lastPosts,
            'videoIntro' => $videoIntro,
            'testimonials' => $testimonials,
            'carouselPosts' => $carouselPosts,
            'quote' => $this->quoteService->getQuoteOfTheDay('frontend'),
        ]);
    }
}
