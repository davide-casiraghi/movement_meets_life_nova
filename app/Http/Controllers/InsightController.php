<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\InsightSearchRequest;
use App\Http\Requests\InsightStoreRequest;
use App\Models\Insight;
use App\Services\InsightService;
use App\Services\TagService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InsightController extends Controller
{
    use CheckPermission;

    private InsightService $insightService;
    private TagService $tagService;

    /**
     * InsightController constructor.
     * @param  InsightService  $insightService
     * @param  TagService  $tagService
     */
    public function __construct(
        InsightService $insightService,
        TagService $tagService
    ) {
        $this->insightService = $insightService;
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  InsightSearchRequest  $request
     *
     * @return View
     */
    public function index(InsightSearchRequest $request)
    {
        $this->checkPermission('insights.view');

        $searchParameters = Helper::getSearchParameters($request, Insight::SEARCH_PARAMETERS);

        $insights = $this->insightService->getInsights(20, $searchParameters);
        $statuses = Insight::PUBLISHING_STATUS;

        return view('insights.index', [
            'insights' => $insights,
            'searchParameters' => $searchParameters,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $this->checkPermission('insights.create');

        $tags = $this->tagService->getTags();

        return view('insights.create', [
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InsightStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(InsightStoreRequest $request)
    {
        $this->checkPermission('insights.create');

        $this->insightService->createInsight($request);

        return redirect()->route('insights.index')
            ->with('success', 'Insight updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Insight  $insight
     * @return View
     */
    public function show(Insight $insight)
    {
        $this->checkPermission('insights.view');

        $insight['body'] = $this->insightService->getInsightBody($insight);

        return view('insights.show', compact('insight'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Insight  $insight
     * @return View
     */
    public function edit(Insight $insight)
    {
        $this->checkPermission('insights.edit');

        $tags = $this->tagService->getTags();

        return view('insights.edit', [
            'insight' => $insight,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  InsightStoreRequest  $request
     * @param  Insight  $insight
     * @return RedirectResponse
     */
    public function update(InsightStoreRequest $request, Insight $insight)
    {
        $this->checkPermission('insights.edit');

        $this->insightService->updateInsight($request, $insight);

        return redirect()->route('insights.index')
            ->with('success', 'Insight updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Insight  $insight
     * @return RedirectResponse
     */
    public function destroy(Insight $insight): RedirectResponse
    {
        $this->checkPermission('insights.delete');

        $this->insightService->deleteInsight($insight->id);

        return redirect()->route('insights.index')
            ->with('success', 'Insight deleted successfully');
    }

    /**
     * Post the insight on Twitter
     *
     * @param  Insight  $insight
     * @return RedirectResponse
     */
    public function twitter(Insight $insight): RedirectResponse
    {
        $this->insightService->sendInsightToTwitter($insight);

        return back()->with('success', 'Insight tweeted successfully');
    }


    /**
     * Display a listing of the resource. (Insights feed)
     *
     * @return View
     */
    public function feed()
    {
        $insights = $this->insightService->getInsights(5, [
            'is_published' => 1,
        ]);

        return view('insights.feed', [
            'insights' => $insights,
        ]);
    }

}
