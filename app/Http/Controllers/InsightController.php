<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsightSearchRequest;
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
        $insights = $this->insightService->getInsights();
        return view('insights.index', [
            'insights' => $insights,
            'searchParameters' => $searchParameters,
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
