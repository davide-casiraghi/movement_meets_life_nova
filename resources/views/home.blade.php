
@extends('layouts.app')

@section('jumbotron')
    {{--@include('partials.pages.home.video_embed')--}}
    {{--@include('partials.pages.home.jumboIntro')--}}
@endsection

@section('fb-tags')
    <x-social-meta
            :title="{{ __('general.website_name') }}"
            :description="{{ __('general.website_description') }}"
            :image="{{asset('images/static_pages/hp-intro-image.jpg')}}"
    />
@endsection

@section('content')

    @include('partials.pages.home.ilm')

    @include('partials.pages.home.contact_improvisation')

    {{--@include('partials.blocks.imageCallToAction', [
            'title' => 'Contact Improvisation',
            'body' => 'Contact Improvisation dance is liberating, creative and fun. It’s about exploring movement, balance, weight, physical contact and communication, involving two or more persons at the time.',
            'button_text' => 'More about CI',
            'button_url' => route('staticPages.contactImprovisation'),
            'image_url' => asset('storage/static_pages/SlovakiaZlinaWorkshop.jpg'),
            'image_alignment' => 'left',
            'extraClasses' => 'mt-5 md:mt-14 px-6 md:px-0',
    ])--}}

    {{--@include('partials.pages.home.blog.block')--}}

    @include('partials.pages.home.testimonials.block')

    @include('partials.quote_of_the_day')

@endsection
