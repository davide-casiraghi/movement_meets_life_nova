<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagSearchRequest;
use App\Http\Requests\TagStoreRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\View\View;

class TagController extends Controller
{
    private TagService $tagService;

    public function __construct(
        TagService $tagService
    ) {
        $this->tagService = $tagService;
    }

    /**
     * Display the resource.
     *
     * @param int $tagId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function show(int $tagId): View
    {
        $tag = Tag::find($tagId);
        $posts = $tag->posts()->get();

        return view('tags.show', [
            'tag' => $tag,
            'posts' => $posts,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\TagSearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(TagSearchRequest $request)
    {
        $searchParameters = $this->tagService->getSearchParameters($request);
        $tags = $this->tagService->getTags(20, $searchParameters);

        return view('tags.index', [
            'tags' => $tags,
            'searchParameters' => $searchParameters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
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
    public function store(TagStoreRequest $request): RedirectResponse
    {
        $this->tagService->createTag($request);

        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $tagId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(int $tagId)
    {
        $tag = $this->tagService->getById($tagId);
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        return view('tags.edit', [
            'tag' => $tag,
            'countriesAvailableForTranslations' => $countriesAvailableForTranslations,
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
    public function update(TagStoreRequest $request, int $tagId): RedirectResponse
    {
        $this->tagService->updateTag($request, $tagId);

        return redirect()->route('tags.index')
            ->with('success', 'Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $tagId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $tagId): RedirectResponse
    {
        $this->tagService->deleteTag($tagId);

        return redirect()->route('tags.index')
            ->with('success', 'Tag deleted successfully');
    }
}
