
@extends('layouts.app')

@section('content')
    <div class="text-lg max-w-prose mx-auto mb-6 mt-6">

        <img src="/storage/{{$post->introimage}}" alt="{{$post->introimage_alt}}">
        <h2 class="mt-2 mb-8 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">{{ $post->title }}</h2>

        <h3 class="text-lg leading-7 text-gray-500 mb-5">{!! $post->intro_text !!}</h3>


        <div class="prose text-gray-500">
            {!! $post->body !!}
        </div>
    </div>





    <div class="accordion flex flex-col items-center justify-center h-screen">
        <!--  Panel 1  -->
        <div class="w-1/2">
            <input type="checkbox" name="panel" id="panel-1" class="hidden">
            <label for="panel-1" class="relative block bg-black text-white p-4 shadow border-b border-grey">Panel 1</label>
            <div class="accordion__content overflow-hidden bg-grey-lighter">
                <h2 class="accordion__header pt-4 pl-4">Header</h2>
                <p class="accordion__body p-4" id="panel1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
                    adipisicing elit. Lorem ipsum dolor sit amet.</p>
            </div>
        </div>
        <!-- Panel 2 -->
        <div class="w-1/2">
            <input type="checkbox" name="panel" id="panel-2" class="hidden">
            <label for="panel-2" class="relative block bg-black text-white p-4 shadow border-b border-grey">Panel 2</label>
            <div class="accordion__content overflow-hidden bg-grey-lighter">
                <h2 class="accordion__header pt-4 pl-4">Header</h2>
                <p class="accordion__body p-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
                    adipisicing elit. Lorem ipsum dolor sit amet.</p>
            </div>
        </div>
        <!--  Panel 3  -->
        <div class="w-1/2">
            <input type="checkbox" name="panel" id="panel-3" class="hidden">
            <label for="panel-3" class="relative block bg-black text-white p-4 shadow border-b border-grey">Panel 3</label>
            <div class="accordion__content overflow-hidden bg-grey-lighter">
                <h2 class="accordion__header pt-4 pl-4">Header</h2>
                <p class="accordion__body p-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto possimus at a cum saepe molestias modi illo facere ducimus voluptatibus praesentium deleniti fugiat ab error quia sit perspiciatis velit necessitatibus.Lorem ipsum dolor sit amet, consectetur
                    adipisicing elit. Lorem ipsum dolor sit amet.</p>
            </div>
        </div>
    </div>

@endsection

