<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $postService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PostService $postService
    )
    {
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

        return view('home', [
            'posts' => $posts,
        ]);
    }
}
