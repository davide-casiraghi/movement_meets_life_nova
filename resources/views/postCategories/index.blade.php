@extends('layouts.backend')

@section('content')

    @include('partials.forms.button',[
        'title' => 'Add category',
        'url' => route('postCategories.create'),
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
            @foreach($postsCategories as $postsCategory)
                @include('partials.postCategory.indexItem', [
                    'postsCategory' => $postsCategory
                ])
            @endforeach
        </ul>
    </div>

   {{--<div class="my-5">
        {{ $postsCategories->links() }}
    </div>--}}


@endsection
