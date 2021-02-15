
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
            'body' => 'Deploy your mvp in minutes, not days. WT offers you a a wide selection swapable sections for your landing page.You are going to have fun building it, I did..',
            'button_text' => 'More about CI',
            'button_url' => route('staticPages.contactImprovisation'),
            'image_url' => 'https://dummyimage.com/720x600/F3F4F7/8693ac',
            'image_alignment' => 'left',
    ])

    @include('partials.pages.home.blog.block')

    @include('partials.quote_of_the_day')

@endsection