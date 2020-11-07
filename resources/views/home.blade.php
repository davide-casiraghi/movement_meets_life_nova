
@extends('layouts.app')

@section('jumbotron')
    {{--@include('partials.pages.home.video_embed')--}}

@endsection

@section('content')

    @include('partials.pages.home.ilm')

    @include('partials.pages.home.blog.block')
    @include('partials.quote_of_the_day')

@endsection