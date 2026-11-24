@php
    $itemKindClasses = $kind === 'mobile' ? 'text-base' : 'text-sm';
    $iconKindClasses = $kind === 'mobile' ? 'mr-4' : 'mr-3';
@endphp

<form action="{{ $url }}" method="POST">
    @csrf
    <button type="submit" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 font-medium rounded-md w-full text-left {{ $itemKindClasses }}">
        <svg class="text-gray-400 group-hover:text-gray-300 h-6 w-6 {{ $iconKindClasses }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            {!! $heroIconPath !!}
        </svg>
        {{ $label }}
    </button>
</form>
