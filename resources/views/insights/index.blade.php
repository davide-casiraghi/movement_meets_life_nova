@extends('layouts.backend')

@section('title')
    @lang('views.insight_management')
@endsection

@section('buttons')

    @include('partials.forms.button',[
        'title' => 'Add insight',
        'url' => route('insights.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])

    @include('partials.forms.button',[
     'title' => 'Tags',
     'url' => route('tags.index'),
     'color' => 'yellow',
     'icon' => '',
     'size' => 1,
     'extraClasses' => 'mb-4',
     'kind' => 'white',
     'target' => '_self',
 ])

@endsection

@section('content')

    @include('partials.insights.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($insights as $insight)
                @include('partials.insights.indexItem', [
                    'insight' => $insight
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $insights->links() }}
    </div>

@endsection
