@props([
    'sortable' => null,
    'direction' => null,
])

<th scope="col" {{ $attributes->merge(['class' => 'px-2']) }} >
    @unless ($sortable)
        <span>{{ $slot }}</span>
    @else
        <button {{ $attributes->merge(['class' => 'group flex items-center space-x-1 text-left whitespace-nowrap']) }} >
            <span>{{ $slot }}</span>
            <span>
                @if ($direction === 'asc')
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                @elseif ($direction === 'desc')
                    <svg class="h-5 w-5 rotate-180" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                @else
                    <svg class="h-5 w-5 opacity-0 group-hover:opacity-100 transition-opacity duration-300" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                @endif
            </span>
        </button>
    @endif
</th>
