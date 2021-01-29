@extends('layouts.backend')

@section('title')
    @lang('views.testimonials_management')
@endsection

@section('content')

    @include('partials.forms.button',[
        'title' => 'Add testimonial',
        'url' => route('testimonials.create'),
        'color' => 'indigo',
        'icon' => '',
        'size' => 1,
        'extraClasses' => 'mb-4',
        'kind' => 'primary',
        'target' => '_self',
    ])

    @include('partials.testimonials.searchBar')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($testimonials as $testimonial)
                @include('partials.testimonials.indexItem', [
                    'testimonial' => $testimonial
                ])
            @endforeach
        </ul>
    </div>

    <div class="my-5">
        {{ $testimonials->links() }}
    </div>


@endsection
