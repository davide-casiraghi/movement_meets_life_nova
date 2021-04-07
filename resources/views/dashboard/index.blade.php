@extends('layouts.backend')

@section('title')
    Dashboard
@endsection

@section('content')

    <!-- STATS -->
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Last 30 days
        </h3>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Total Subscribers
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        71,897
                    </dd>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Avg. Open Rate
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        58.16%
                    </dd>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Avg. Click Rate
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        24.57%
                    </dd>
                </div>
            </div>
        </dl>
    </div>


    <div class="mt-8">
        <div class="md:grid md:grid-cols-6 md:gap-6">

            {{-- Glossary terms to complete --}}
            <div class="md:col-span-2">
                <h2 class="mb-4">Glossary terms to complete</h2>
                <ul class="bg-white overflow-hidden shadow rounded-lg p-6">
                    @forelse($unpublishedGlossaryTerms as $glossaryTerm)
                        <li><a class="textLink" href="{{route('glossaries.edit', $glossaryTerm->id)}}">{{$glossaryTerm->term}}</a></li>
                    @empty
                        <li>There are not glossary terms to complete.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Latest insights --}}
            <div class="md:col-span-4">
                <div class="mb-4">
                    <h2 class="mb-4">Inspiration</h2>
                    <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                        <div class="italic mb-2">{{$quote->description}}</div>
                        {{$quote->author}}
                    </div>
                </div>

                <div>
                    <h2 class="mb-4">Latest insights</h2>
                    <ul class="bg-white overflow-hidden shadow rounded-lg p-6">
                        @forelse($latestInsights as $insight)
                            <li><a class="textLink" href="{{route('insights.edit', $insight->id)}}">{{$insight->title}}</a></li>
                        @empty
                            <li>There are no insights</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
