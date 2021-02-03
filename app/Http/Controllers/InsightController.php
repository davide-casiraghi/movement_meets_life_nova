<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsightSearchRequest;
use App\Models\Insight;
use App\Services\InsightService;
use Illuminate\Http\Request;

class InsightController extends Controller
{
    private $insightService;

    /**
     * InsightController constructor.
     */
    public function __construct(InsightService $insightService)
    {
        $this->insightService = $insightService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InsightSearchRequest $request)
    {
        $searchParameters = $this->insightService->getSearchParameters($request);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($insightId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $insightId
     * @return \Illuminate\Http\Response
     */
    public function edit($insightId)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $insightId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $insightId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $insightId
     * @return \Illuminate\Http\Response
     */
    public function destroy($insightId)
    {
        //
    }
}
