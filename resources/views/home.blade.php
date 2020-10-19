
@extends('layouts.app')

@section('content')
    @include('partials.home.video_embed')

    <h1 class="text-4xl font-bold text-red-500 text-center">Hello word!</h1>
    <img src="http://lorempixel.com/g/800/600/" alt="">

    @include('partials.home.blog')





@endsection