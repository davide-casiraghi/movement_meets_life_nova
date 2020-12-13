<?php

namespace App\Http\Controllers;

use App\Models\Glossary;
use App\Services\GlossaryService;
use Illuminate\Http\Request;

class GlossaryController extends Controller
{
    private $glossaryService;

    public function __construct(
        GlossaryService $glossaryService
    )
    {
        $this->glossaryService = $glossaryService;
    }
    
    public function show($glossaryTermId){
        $glossaryTerm = Glossary::find($glossaryTermId);

        return view('glossary.show',[
            'glossaryTerm' => $glossaryTerm,
            //'posts' => $posts,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $tags = $this->glossaryService->getTags();

        return view('glossaries.index', [
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
        return view('glossaries.create');
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
        $this->glossaryService->createTag($request);

        return redirect()->route('glossaries.index')
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
        $tag = $this->glossaryService->getById($tagId);

        return view('glossaries.edit', [
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
        $this->glossaryService->updateTag($request, $tagId);

        return redirect()->route('glossaries.index')
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
        $this->glossaryService->deleteTag($tagId);

        return redirect()->route('glossaries.index')
            ->with('success','Tag deleted successfully');
    }
}
