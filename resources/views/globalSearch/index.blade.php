@extends('layouts.backend')

@section('title')
    Global Search
@endsection

@section('content')

    <div class="mb-3">
        <b>{{ $searchResults->count() }} results found for "{{ request('keyword') }}"</b>
    </div>

    <div class="mt-5">
        @foreach($searchResults->groupByType() as $type => $modelSearchResults)
            <h2 class="mb-2">{{ ucfirst($type) }}</h2>
            <div class="bg-white shadow overflow-hidden sm:rounded-md mb-5">
                <ul class="divide-y divide-gray-200">
                    @foreach($modelSearchResults as $searchResult)
                        @include('partials.globalSearch.indexItem', [
                            'searchResult' => $searchResult
                        ])
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

@endsection