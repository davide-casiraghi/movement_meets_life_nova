@extends('layouts.backend')

@section('content')

    @include('partials.forms.button',[
        'title' => 'Add post',
        'url' => route('posts.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])

   @include('partials.forms.button',[
        'title' => 'Categories',
        'url' => route('postCategories.index'),
        'color' => 'yellow',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'white',
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

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($posts as $post)
                @include('partials.posts.indexItem', [
                    'post' => $post
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $posts->links() }}
    </div>


@endsection
