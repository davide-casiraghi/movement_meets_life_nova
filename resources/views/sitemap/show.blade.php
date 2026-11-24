@extends('layouts.backend')

@section('title')
    Sitemap
@endsection

@section('subTitle')
    @if($updatedAt)
        {{ $total }} URLs, last updated {{ $updatedAt->format('d/m/Y H:i') }}.
    @endif
@endsection

@section('content')

    <div class="bg-white shadow-sm overflow-hidden sm:rounded-md p-6">
        @if($total === 0)
            <p class="text-sm text-gray-500">
                The sitemap has not been generated yet. Use "Update sitemap" in the menu to create it.
            </p>
        @else
            @if($tree['url'])
                <p class="text-sm mb-3">
                    <a href="{{ $tree['url'] }}" target="_blank" rel="noopener" class="font-medium text-indigo-600 hover:underline">/ (home)</a>
                </p>
            @endif

            @include('partials.sitemap.node', ['children' => $tree['children'], 'root' => true])
        @endif
    </div>

@endsection
