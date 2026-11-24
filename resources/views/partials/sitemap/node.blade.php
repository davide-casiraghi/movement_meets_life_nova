<ul class="space-y-1 {{ $root ? '' : 'ml-5 border-l border-gray-200 pl-4 mt-1' }}">
    @foreach($children as $name => $node)
        <li class="text-sm">
            @if($node['url'])
                <a href="{{ $node['url'] }}" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">{{ $name }}</a>
            @else
                <span class="font-medium text-gray-900">{{ $name }}</span>
            @endif

            @if(count($node['children']))
                @include('partials.sitemap.node', ['children' => $node['children'], 'root' => false])
            @endif
        </li>
    @endforeach
</ul>
