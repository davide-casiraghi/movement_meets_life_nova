<div class="bg-gray-100 flex flex-col mb-8">
    <div class="relative py-3 max-w-xl mx-auto">
        <h3 class="text-3xl text-center text-gray-700 font-bold">Quote of the day</h3>
        @isset($quote)
            <div>
                <div class="text-3xl text-indigo-500 text-left leading-tight h-3">“</div>
                <div class="text-center text-xl italic text-gray-500">
                    {{$quote->description}}
                </div>
                <div class="text-3xl text-indigo-500 text-right leading-tight h-3 -mt-3">”</div>
            </div>
            <div class="text-md text-indigo-500 font-bold text-center mt-3">
                {{$quote->author}}
            </div>
        @endisset
        @if(empty($quote))
            <p>No quotes found</p>
        @endif
    </div>
</div>