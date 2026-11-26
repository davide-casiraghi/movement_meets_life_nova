@extends('layouts.app')

@section('title')@lang('static_pages.footer.whatsapp_unavailable_title')@endsection

@section('content')
    <div class="max-w-2xl mx-auto px-8 lg:px-0 my-16 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
            @lang('static_pages.footer.whatsapp_unavailable_title')
        </h1>
        <p class="text-lg text-gray-500 mb-8">
            @lang('static_pages.footer.whatsapp_unavailable_text')
        </p>
        <a href="{{ route('contact.index') }}" class="font-medium rounded-md text-white px-4 py-2 bg-primary-600 hover:bg-primary-500 transition ease-in-out duration-150">
            @lang('static_pages.footer.contact_me')
        </a>
    </div>
@endsection
