@extends('layouts.backend')

@section('title')
    Global Search
@endsection

@section('content')

    <div>
        <b>{{ $searchResults->count() }} results found for "{{ request('keyword') }}"</b>
    </div>


    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($searchResults->groupByType() as $type => $modelSearchResults)

                <h2>{{ ucfirst($type) }}</h2>

                @foreach($modelSearchResults as $searchResult)
                    @include('partials.globalSearch.indexItem', [
                        'searchResult' => $searchResult
                    ])
                @endforeach
            @endforeach
        </ul>
    </div>
@endsection