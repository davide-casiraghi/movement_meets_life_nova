<div>
    <h2 class="mb-4">Variants</h2>
   <ul wire:sortable="reorder" class="overflow-hidden rounded shadow divide-y">
       @foreach($variants as $variant)
           <li wire:sortable.item="{{$variant['id']}}" wire:key="{{$variant['id']}}" class="w-64 p-4 bg-gray-300">
               <div class="flex justify-between">
                   <span>
                       {{ $variant['title'] }}
                   </span>
                   <div wire:sortable.handle>
                       {{--<svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>--}}
                       <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                   </div>
               </div>

           </li>
       @endforeach
   </ul>
</div>




