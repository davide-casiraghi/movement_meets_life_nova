@extends('layouts.backend')

@section('title')
    <div class="md:grid md:grid-cols-6 md:gap-6 mb-6">
        <div class="md:col-span-3">
            @lang('event.events_management')
        </div>

        <div class="md:col-span-3">
            <div class="float-right">
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
                     'title' => 'Event Categories',
                     'url' => route('eventCategories.index'),
                     'color' => 'yellow',
                     'icon' => '',
                     'size' => 1,
                     'extraClasses' => 'mb-4',
                     'kind' => 'white',
                     'target' => '_self',
                 ])

                @include('partials.forms.button',[
                 'title' => 'Teachers',
                 'url' => route('teachers.index'),
                 'color' => 'yellow',
                 'icon' => '',
                 'size' => 1,
                 'extraClasses' => 'mb-4',
                 'kind' => 'primary',
                 'target' => '_self',
                ])

                @include('partials.forms.button',[
                 'title' => 'Organizers',
                 'url' => route('organizers.index'),
                 'color' => 'yellow',
                 'icon' => '',
                 'size' => 1,
                 'extraClasses' => 'mb-4',
                 'kind' => 'primary',
                 'target' => '_self',
                ])
            </div>
        </div>
    </div>

@endsection

@section('content')

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
