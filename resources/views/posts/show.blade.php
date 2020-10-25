
@extends('layouts.app')

@section('content')
    <div class="text-lg max-w-prose mx-auto mb-6 mt-6">

        {{--<img src="/storage/{{$post->introimage}}" alt="{{$post->introimage_alt}}">--}}

        @if($post->hasMedia('introimage'))
            <img src="{{$post->getMedia('introimage')[0]->getUrl()}}" alt="">
        @endif

        <h2 class="mt-2 mb-8 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">{{ $post->title }}</h2>

        <h3 class="text-lg leading-7 text-gray-500 mb-5">{!! $post->intro_text !!}</h3>


        <div class="prose text-gray-500">
            {!! $post->body !!}
        </div>



        @if($post->hasMedia('gallery'))
            <div class='lifeGallery'>
                @foreach($post->getMedia('gallery') as $image)


                <div class='item'>
                    @php $imageLink = $image->getUrl(); @endphp

                    @if($image->hasCustomProperty('youtube_url'))
                        @php $imageLink = $image->getCustomProperty('youtube_url'); @endphp
                    @elseif($image->hasCustomProperty('vimeo_url'))
                        @php $imageLink = $image->getCustomProperty('vimeo_url'); @endphp
                    @endif

                        <a href='{{$imageLink}}' data-fancybox='images' data-caption='{{$image->getCustomProperty('description')}}<br>{{$image->getCustomProperty('credits')}}'>
                            <img src='{{$image->getUrl('thumb')}}' alt='{{$image->getCustomProperty('description')}}' />
                            @if($image->hasCustomProperty('youtube_url') or $image->hasCustomProperty('vimeo_url'))
                                <i class='far fa-play-circle' style="position: absolute;top: calc(50% - 25px);left: calc(50% - 25px); color: hsla(0,0%,100%,.8);font-size: 50px;"></i>
                            @endif
                        </a>
                        @if($image->hasCustomProperty('description'))
                        <div class="jg-caption">
                            {{$image->getCustomProperty('description')}}
                        </div>
                        @endif
                </div>
                @endforeach
            </div>
        @endif



    </div>
@endsection


