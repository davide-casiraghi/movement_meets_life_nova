
@extends('layouts.app')

@section('content')
    <div class="text-lg max-w-prose mx-auto mb-6 mt-6">

        <img src="/storage/{{$post->introimage}}" alt="{{$post->introimage_alt}}">
        <h2 class="mt-2 mb-8 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">{{ $post->title }}</h2>

        <h3 class="text-lg leading-7 text-gray-500 mb-5">{!! $post->intro_text !!}</h3>


        <div class="prose text-gray-500">
            {!! $post->body !!}
        </div>

        <div>
            @foreach($post->getMedia('gallery') as $image)
                <img src="{{$image->getUrl('thumb')}}" alt="">
                <br>
                @if($image->hasCustomProperty('description'))
                    {{$image->getCustomProperty('description')}}
                @endif

            @endforeach
        </div>



    </div>

@endsection


