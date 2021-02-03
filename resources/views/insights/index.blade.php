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

@endsection

@section('content')

    @include('partials.insights.searchBar')


@endsection
