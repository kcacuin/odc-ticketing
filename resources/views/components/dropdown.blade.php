@props(['align' => 'right', 'width' => '', 'contentClasses' => 'py-1 bg-white dark:bg-gray-700'])

@php
switch ($align) {
    case 'top':
        $alignmentClasses = 'top-0 right-0 translate-y-10';
        break;
    case 'bottom':
        $alignmentClasses = 'bottom-0 right-0 -translate-y-10';
        break;
}

// switch ($width) {
//     case '48':
//         $width = 'w-48';
//         break;
//     case '42':
//         $width = 'w-42';
//         break;
// }
@endphp

<div 
    x-data="{ open: false }"
    @click.outside="open = false" 
    @close.stop="open = false"
    x-id="['dropdown-button']"
    class="relative __dropdown" 
    >

    <div @click="open = ! open" :id="$id('dropdown-button')">
        {{ $trigger }}
    </div>

    <div x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"\
        :id="$id('dropdown-button')"
        class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg right-0 __panel"
        {{-- class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}" --}}
        role="menu" aria-orientation="vertical" aria-labelledby="options-menu"
        style="display: none;"
        @click="open = false"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let dropdown = document.querySelector('.__dropdown');
            let tableContainer = document.querySelector('.__table');
            let panel = document.querySelector('.__panel');
    
            if (dropdown && tableContainer && panel) {
                let dropdownRect = dropdown.getBoundingClientRect();
                let tableRect = tableContainer.getBoundingClientRect();
                let containerHeight = tableContainer.offsetHeight;
                let scrollTop = tableContainer.scrollTop;
    
                // Calculate the position of the dropdown relative to the container
                let dropdownPosition = dropdownRect.top - tableRect.top + scrollTop;
    
                // Calculate the position of the dropdown relative to the bottom of the container
                let dropdownPositionFromBottom = containerHeight - dropdownRect.bottom + tableRect.top + scrollTop;
    
                // Determine if the panel will touch the bottom of the table
                let willTouchBottom = dropdownPositionFromBottom < panel.offsetHeight;
    
                if (willTouchBottom) {
                    // Add bottom-full class to the panel
                    // dropdown.classList.add('bg-pink-400');
                    panel.classList.add('bottom-full');
                    panel.classList.remove('top-full');
                } else {
                    // Add top-full class to the panel
                    // dropdown.classList.add('bg-green-400');
                    panel.classList.add('top-full');
                    panel.classList.remove('bottom-full');
                }
            }
        });
    </script>
</div>
