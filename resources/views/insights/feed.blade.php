@extends('layouts.app')

@section('title')@lang('post.blog_title')@endsection

@section('content')

    <div class="max-w-2xl mx-auto px-8 lg:px-0 md:mt-6">

        <div class="leading-6 pt-6 pb-8 text-black border-b border-solid border-gray-200">
            <h1 class="sm:text-4xl md:text-6xl border-solid box-border font-extrabold text-3xl m-0 text-gray-900 tracking-tight mb-2">
                Insights diary
            </h1>
            <p class="border-solid box-border text-lg m-0 text-gray-500">
                A stream of insights from my daily practices encounters.
            </p>
        </div>

        <div class="w-8/12 m-auto my-20">
            <ul role="list" class="-mb-8">
                @forelse($insights as $insight)
                    @include('partials.insights.feedItem')
                @empty
                    <li>No insights found</li>
                @endforelse
            </ul>
        </div>

        <div class="my-5">
            {{ $insights->links() }}
        </div>

    </div>

@endsection
