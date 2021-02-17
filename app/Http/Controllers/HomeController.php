<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Services\StaticPageService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private PostService $postService;
    private StaticPageService $staticPageService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\PostService $postService
     * @param \App\Services\StaticPageService $staticPageService
     */
    public function __construct(
        PostService $postService,
        StaticPageService $staticPageService
    ) {
        $this->postService = $postService;
        $this->staticPageService = $staticPageService;
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

        return view('home', [
            'lastPosts' => $lastPosts,
            'videoIntro' => $videoIntro,
        ]);
    }
}
