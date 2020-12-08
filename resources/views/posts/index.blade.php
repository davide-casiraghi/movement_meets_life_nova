@extends('layouts.backend')

@section('content')
    
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
