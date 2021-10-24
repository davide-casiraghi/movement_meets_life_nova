<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\InsightSearchRequest;
use App\Http\Requests\InsightStoreRequest;
use App\Models\Insight;
use App\Services\InsightService;
use App\Services\TagService;
use App\Traits\CheckPermission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;

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
     * @param \App\Http\Requests\InsightSearchRequest $request
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($insightId)
    {
        $this->checkPermission('insights.view');

        $insight = $this->insightService->getInsightById($insightId);

        $insight['body'] = $this->insightService->getInsightBody($insight);

        return view('insights.show', compact('insight'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $insightId
     * @return \Illuminate\Http\Response
     */
    public function edit($insightId)
    {
        $this->checkPermission('insights.edit');

        $insight = $this->insightService->getInsightById($insightId);
        $tags = $this->tagService->getTags();

        return view('insights.edit', [
            'insight' => $insight,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $insightId
     * @return \Illuminate\Http\Response
     */
    public function update(InsightStoreRequest $request, $insightId)
    {
        $this->checkPermission('insights.edit');

        $this->insightService->updateInsight($request, $insightId);

        return redirect()->route('insights.index')
            ->with('success', 'Insight updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $insightId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $insightId): RedirectResponse
    {
        $this->checkPermission('insights.delete');

        $this->insightService->deleteInsight($insightId);

        return redirect()->route('insights.index')
            ->with('success', 'Insight deleted successfully');
    }

    /**
     * Post the insight on Twitter
     *
     * @param int $insightId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function twitter(int $insightId): RedirectResponse
    {
        $insight = $this->insightService->getInsightById($insightId);
        $this->insightService->sendInsightToTwitter($insight);

        return back()->with('success', 'Insight tweeted successfully');
    }


    /**
     * Display a listing of the resource. (Insights feed)
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
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
