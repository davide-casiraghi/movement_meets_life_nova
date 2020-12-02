
@extends('layouts.app')

@section('jumbotron')
    {{--@include('partials.pages.home.video_embed')--}}

@endsection

@section('content')


    <div>
        Reconnect with your body and your feelings. <br>
        Release tensions, find home in your body.<br><br>

        Bodywork, contact improvisation for everyBODY. <br><br>

    </div>

    @include('partials.pages.home.ilm')

    @include('partials.pages.home.blog.block')
    @include('partials.quote_of_the_day')

@endsection