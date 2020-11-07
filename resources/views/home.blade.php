
@extends('layouts.app')

@section('jumbotron')
    {{--@include('partials.home.video_embed')--}}

@endsection

@section('content')

    @include('partials.pages.home.ilm')

    @include('partials.home.blog')
    @include('partials.quote_of_the_day')

@endsection