@extends('layouts.app')

@section('title')Confirmed@endsection

@section('content')

    @include('partials.messages')

    <div class="mt-10 md:mt-24 px-4 md:px-0 h-80 max-w-2xl mx-auto">
        <h2 class="  text-3xl leading-9 tracking-tight font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
            Confirmed
        </h2>
        <p class="mt-3 text-xl leading-7 text-gray-500 sm:mt-4">
            Your bodywork has been scheduled with Davide Casiraghi. <br>
            A calendar invitation has been sent to your email address. <br><br>

            If it's your fist session or it's a while you don't receive a bodywork from me please fill <a class="textLink" href="get-a-treatment" >this intake form</a>.
        </p>
    </div>

@endsection
