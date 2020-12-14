@extends('layouts.backend')

@section('content')

    @include('partials.forms.button',[
        'title' => 'Add event',
        'url' => route('events.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])

    @include('partials.forms.button',[
         'title' => 'Categories',
         'url' => route('eventCategories.index'),
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
            @foreach($events as $event)
                @include('partials.events.indexItem', [
                    'event' => $event
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $events->links() }}
    </div>


@endsection
