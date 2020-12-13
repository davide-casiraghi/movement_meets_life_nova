<?php

namespace App\Http\Controllers;

use App\Http\Requests\GlossaryStoreRequest;
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
        $glossaries = $this->glossaryService->getGlossaries();

        return view('glossaries.index', [
            'glossaries' => $glossaries,
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
     * @param \App\Http\Requests\GlossaryStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GlossaryStoreRequest $request)
    {
        $this->glossaryService->createTag($request);

        return redirect()->route('glossaries.index')
            ->with('success','Tag created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $glossaryId
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $glossaryId)
    {
        $glossary = $this->glossaryService->getById($glossaryId);

        return view('glossaries.edit', [
            'glossary' => $glossary,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\GlossaryStoreRequest $request
     * @param int $glossaryId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GlossaryStoreRequest $request, int $glossaryId)
    {
        $this->glossaryService->updateGlossary($request, $glossaryId);

        return redirect()->route('glossaries.index')
            ->with('success','Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $glossaryId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $glossaryId)
    {
        $this->glossaryService->deleteGlossary($glossaryId);

        return redirect()->route('glossaries.index')
            ->with('success','Tag deleted successfully');
    }
}
