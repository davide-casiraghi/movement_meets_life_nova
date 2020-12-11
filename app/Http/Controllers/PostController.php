<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Services\PostCategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $postService;
    private $postCategoryService;

    public function __construct(
        PostService $postService,
        PostCategoryService $postCategoryService
    )
    {
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts = $this->postService->getPosts(20);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->postCategoryService->getPostCategories();

        return view('posts.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PostStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $this->postService->createPost($request);

        return redirect()->route('posts.index')
            ->with('success','Post updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Post $post)
    {
        $post['body'] = $this->postService->getPostBody($post);

         //dd($post->getMedia('gallery'));

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $postId)
    {
        $post = $this->postService->getById($postId);

        $categories = $this->postCategoryService->getPostCategories();
        return view('posts.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\PostStoreRequest $request
     * @param int $postId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostStoreRequest $request, int $postId)
    {
        $this->postService->updatePost($request, $postId);

        return redirect()->route('posts.index')
            ->with('success','Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function blog()
    {
        $posts = $this->postService->getPosts(20);

        return view('posts.blog', [
            'posts' => $posts,
        ]);
    }
}