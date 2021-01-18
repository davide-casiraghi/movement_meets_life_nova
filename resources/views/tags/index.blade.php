@extends('layouts.backend')

@section('title')
    @lang('views.tag_management')
@endsection

@section('content')

    @include('partials.forms.button',[
        'title' => 'Add tag',
        'url' => route('tags.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($tags as $tag)
                @include('partials.tag.indexItem', [
                    'tag' => $tag
                ])
            @endforeach
        </ul>
    </div>

   {{--<div class="my-5">
        {{ $tags->links() }}
    </div>--}}


@endsection
