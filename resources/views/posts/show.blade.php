@extends('layouts.app')

@section('javascript-document-ready')
    @parent

    Tipped.create('.api-example', {
    //size: 'x-small',
    //showOn: 'click'
    inline: 'glossary-definition-33', //id of the content of the tooltip
    skin: 'light',
    radius: false,
    padding: false,
    position: 'topleft',
    size: 'large'
    });

    var termId = "";
    var definitionId = "";
    $('.has-glossary-term').each(function (i) {
        termId = "#glossary-term-"+i;
        definitionId = "glossary-definition-"+i;
        console.log(definitionId);
        Tipped.create(termId, { //id of the element on which display the tooltip on hover
            inline: definitionId, //id of the content of the tooltip
            skin: 'light',
            radius: false,
            padding: false,
            position: 'topleft',
            size: 'large'
        });

    });



    Tipped.create('#demo-html', { //id of the element  on which display the tooltip on hover
    inline: 'thayer-tooltip-content', //id of the content of the tooltip
    skin: 'light',
    radius: false,
    padding: false,
    position: 'topleft',
    size: 'large'
    });
@stop

@section('jumbotron')
    @if($post->hasMedia('introimage'))

        <div class="bg-fixed relative" style="background-image: url('{{$post->getMedia('introimage')[0]->getUrl()}}');">
            <div class="container mx-auto px-6 py-40 max-w-prose relative z-10">
                <h2 class="text-4xl font-bold mb-2 text-white">
                    {{ $post->title }}
                </h2>
                <h3 class="text-2xl mb-8 text-white">
                    {!! $post->intro_text !!}
                </h3>

                <div class="grid grid-flow-col auto-cols-max md:auto-cols-min">
                    <div class="text-base text-white">{{ $post->created_at->format('M j, Y') }}</div>
                    <div class="text-base text-white">
                        <div class="float-right">
                            Reading time: {{ $post->reading_time() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="opacity-25 bg-black flex items-center h-full w-full flex-wrap z-0 top-0 right-0 absolute"></div>
        </div>
        {{--https://www.digitalocean.com/community/tutorials/build-a-beautiful-landing-page-with-tailwind-css--}}
    @endif
@endsection

@section('content')

    @include('partials.messages')


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

            {{-- test --}}
            <span class='api-example' title="1">One</span>

            <form method="POST" action="{{ route('postComments.store') }}" >
                @csrf

                <input type="hidden" name="post_id" value="{{ $post->id }}">

                <div class="rounded-md shadow-sm">
                    <label for="comment_body" class="block text-sm font-medium leading-5 text-gray-700">Your comment</label>
                    <textarea name='body' id="comment_body" rows="3" class="form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">{{ old('body') }}</textarea>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <label for="comment_email" class="block text-sm font-medium leading-5 text-gray-700">Your email</label>
                    <input name='email' value="{{ old('email') }}" id="comment_email" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="you@example.com">
                </div>

                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex justify-end">
                        <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                Save
                            </button>
                        </span>
                    </div>
                </div>

            </form>
    </div>
@endsection


