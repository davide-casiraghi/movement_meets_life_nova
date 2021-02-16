
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

    @include('partials.blocks.rightImageCallToAction', [
            'title' => 'Contact Improvisation',
            'body' => 'Contact Improvisation dance is liberating, creative and fun. It’s about exploring movement, balance, weight, physical contact and communication, involving two or more persons at the time.',
            'button_text' => 'More about CI',
            'button_url' => route('staticPages.contactImprovisation'),
            'image_url' => 'https://dummyimage.com/720x600/F3F4F7/8693ac',
            'image_alignment' => 'left',
            'extraClasses' => 'mt-5 md:mt-0 px-6 md:px-0',
    ])

    @include('partials.pages.home.blog.block')

    @include('partials.quote_of_the_day')

@endsection
