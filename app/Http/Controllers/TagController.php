<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagStoreRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $tagService;

    public function __construct(
        TagService $tagService
    )
    {
        $this->tagService = $tagService;
    }

    public function show($tagId){
        $tag = Tag::find($tagId);
        $posts = $tag->posts()->get();

        return view('tags.show',[
            'tag' => $tag,
            'posts' => $posts,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tags = $this->tagService->getTags();

        return view('tags.index', [
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TagStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TagStoreRequest $request)
    {
        $this->tagService->createTag($request);

        return redirect()->route('tags.index')
            ->with('success','Tag created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $tagId
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $tagId)
    {
        $tag = $this->tagService->getById($tagId);

        return view('tags.edit', [
            'tag' => $tag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\TagStoreRequest $request
     * @param int $tagId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagStoreRequest $request, int $tagId)
    {
        $this->tagService->updateTag($request, $tagId);

        return redirect()->route('tags.index')
            ->with('success','Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $tagId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $tagId)
    {
        $this->tagService->deleteTag($tagId);

        return redirect()->route('tags.index')
            ->with('success','Tag deleted successfully');
    }
}
