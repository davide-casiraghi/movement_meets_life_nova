<div class=" bg-gray-100 flex flex-col">
    <div class="relative py-3 max-w-xl mx-auto">
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
    </div>
</div>