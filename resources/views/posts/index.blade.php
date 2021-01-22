@extends('layouts.backend')

@section('title')
    @lang('views.post_management')
@endsection

@section('buttons')
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

@endsection

@section('content')

    {{-- Search bar - Posts --}}
    <form id="searchPostsForm" method="get" action="#" class="mb-4">
        <div class="md:grid md:grid-cols-6 md:gap-2">
            {{-- Title --}}
            <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
                @include('partials.forms.input', [
                                'label' => __('views.title'),
                                'name' => 'title',
                                'placeholder' => 'Post title',
                                'value' => old('title', $searchParameters['title']),
                                'required' => false,
                                'disabled' => false,
                        ])
            </div>

            {{-- Category --}}
            <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
                @include('partials.forms.select', [
                            'label' => __('views.category'),
                            'name' => 'categoryId',
                            'placeholder' => __('views.select_category'),
                            'records' => $categories,
                            'selected' =>  old('categoryId', $searchParameters['categoryId']),
                            'required' => false,
                        ])
            </div>

            {{-- Creation date before --}}
            <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
                @include('partials.forms.inputDatePicker',[
                    'class' => 'datepicker past',
                    'label' => __('event.date_start'),
                    'placeholder' => __('general.select_date'),
                    'name' => 'startDate',
                    'value' =>  old('startDate', $searchParameters['startDate']),
                    'required' => false,
                ])
            </div>

            {{-- Creation date after --}}
            <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
                @include('partials.forms.inputDatePicker',[
                    'class' => 'datepicker past',
                    'label' => __('event.date_end'),
                    'placeholder' => __('general.select_date'),
                    'name' => 'endDate',
                    'value' =>  old('endDate', $searchParameters['endDate']),
                    'required' => false,
                ])
            </div>

            {{-- Status --}}
            <div class="md:col-span-2 lg:col-span-1 mb-2 md:mb-0">
                @include('partials.forms.select_status', [
                           'label' => __('views.status'),
                           'name' => 'status',
                           'placeholder' => __('views.select_status'),
                           'records' => $statuses,
                           'selected' =>  old('status', $searchParameters['status']),
                           'required' => false,
                       ])
            </div>

            {{-- Search / Reset buttons --}}
            <div class="md:col-span-2 lg:col-span-1 flex items-end justify-end mt-4 md:mt-0 mb-2">

                    @include('partials.forms.button_submit',[
                             'title' => __('general.search'),
                             'color' => 'indigo',
                             'icon' => '',
                             'size' => 2,
                             'extraClasses' => 'mr-2',
                             'kind' => 'primary',
                         ])

                    @include('partials.forms.button',[
                         'title' => 'Reset',
                         'url' => route('posts.index'),
                         'color' => 'yellow',
                         'icon' => '',
                         'size' => 2,
                         'extraClasses' => '',
                         'kind' => 'white',
                         'target' => '_self',
                     ])

            </div>


        </div>
        {{--<div class="md:grid md:grid-cols-6 md:gap-6 mb-4">

            --}}{{-- Search / Reset buttons --}}{{--
            <div class="md:col-span-6"> --}}{{-- md:mt-0 --}}{{--
                <div class="float-right">

                    @include('partials.forms.button_submit',[
                         'title' => __('general.search'),
                         'color' => 'indigo',
                         'icon' => '',
                         'size' => 2,
                         'extraClasses' => 'mb-4',
                         'kind' => 'primary',
                     ])

                    @include('partials.forms.button',[
                         'title' => 'Reset',
                         'url' => route('posts.index'),
                         'color' => 'yellow',
                         'icon' => '',
                         'size' => 2,
                         'extraClasses' => 'mb-4',
                         'kind' => 'white',
                         'target' => '_self',
                     ])

                </div>
            </div>
        </div>--}}
    </form>

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
