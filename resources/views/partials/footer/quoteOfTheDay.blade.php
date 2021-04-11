<div class="text-sm leading-5 font-semibold text-gray-400 tracking-wider uppercase mt-6">
    Quote of the day
</div>
<div class="text-base leading-6 text-gray-300 mt-4">
    @isset($quote)
        <div>
            <div class="text-6xl text-gray-500 text-left leading-tight h-3 font-serif mb-6" aria-hidden="true">“</div>
            <div class="text-center text-base italic text-gray-500">
                {{$quote->description}}
            </div>
            <div class="text-4xl text-gray-500 text-right leading-tight h-3 font-serif" aria-hidden="true">”</div>
        </div>
        <cite>
            <div class="text-md text-gray-500 font-bold text-center mt-3">
                {{$quote->author}}
            </div>
        </cite>
    @endisset
    @if(empty($quote))
        <p>No quotes found</p>
    @endif
</div>
