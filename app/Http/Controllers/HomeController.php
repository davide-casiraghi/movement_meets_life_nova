<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private PostService $postService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\PostService $postService
     */
    public function __construct(
        PostService $postService
    ) {
        $this->postService = $postService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = $this->postService->getPosts();

        $lastPosts = $this->postService->getPosts(3);

        return view('home', [
            'lastPosts' => $lastPosts,
        ]);
    }
}
