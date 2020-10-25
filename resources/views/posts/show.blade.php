
@extends('layouts.app')

@section('content')


    @if($post->hasMedia('introimage'))
        <div class="bg-fixed relative" style="background-image: url('{{$post->getMedia('introimage')[0]->getUrl()}}');">
            <div class="container mx-auto px-6 py-40 max-w-prose relative z-10">
                <h2 class="text-4xl font-bold mb-2 text-white">
                    {{ $post->title }}
                </h2>
                <h3 class="text-2xl mb-8 text-gray-200">
                    {!! $post->intro_text !!}
                </h3>
                <div class="row">
                    <div class="col">
                        <div class="text-base text-gray-200">{{ $post->created_at->format('M j, Y') }}</div>
                    </div>
                    <div class="col">
                        <div class="text-base text-gray-200 float-right">Reading time: {{ $post->reading_time() }}</div>
                    </div>
                </div>




            </div>

            <div class="opacity-25 bg-black flex items-center h-full w-full flex-wrap z-0 top-0 right-0 absolute">.opacity-75</div>

         {{--   <div class="expanded fixed inset-0 bg-black bg-opacity-50 w-full h-full flex items-start justify-center pt-12 z-10">
                <input type="text" class="border-r border-gray">
            </div>--}}
        </div>
        {{--https://www.digitalocean.com/community/tutorials/build-a-beautiful-landing-page-with-tailwind-css--}}
    @endif


    <div class="text-lg max-w-prose mx-auto mb-6 mt-6">

        @if(!$post->hasMedia('introimage'))
            <h2 class="mt-2 mb-8 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">{{ $post->title }}</h2>
            <h3 class="text-lg leading-7 text-gray-500 mb-5">{!! $post->intro_text !!}</h3>
        @endif

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


