@props(['name', 'labelname'])

@php
    $classes = 'absolute px-2 text-[0.8rem] text-blue-200 bg-blue-secondary rounded transform -translate-y-[3.5rem] translate-x-4 transition duration-300 peer-focus:absolute peer-focus:px-2 peer-focus:text-[0.8rem] peer-focus:text-blue-200 peer-focus:bg-blue-secondary peer-focus:rounded peer-focus:transform peer-focus:-translate-y-[3.5rem] peer-focus:translate-x-2 peer-placeholder-shown:text-white peer-placeholder-shown:text-sm peer-placeholder-shown:-translate-y-[2.2rem] peer-placeholder-shown:px-0 peer-placeholder-shown:bg-transparent';
    $errorClasses = 'absolute px-2 text-[0.8rem] text-red-200 bg-red-primary rounded transform -translate-y-[3.5rem] translate-x-4 transition duration-300 peer-focus:absolute peer-focus:px-2 peer-focus:text-[0.8rem] peer-focus:text-red-200 peer-focus:bg-red-primary peer-focus:rounded peer-focus:transform peer-focus:-translate-y-[3.5rem] peer-focus:translate-x-2 peer-placeholder-shown:text-white peer-placeholder-shown:text-sm peer-placeholder-shown:-translate-y-[2.2rem] peer-placeholder-shown:px-0 peer-placeholder-shown:bg-transparent';
@endphp

<label {{ $attributes->merge(['class' => $classes . ($errors->has($name) ? $errorClasses : '')]) }} for="{{ $name }}" >
    {{ $labelname }}
</label>

{{--
<div>
    <div x-data="{ tooltip: false }" class="relative z-30 inline-flex">
        <div x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="rounded-md px-3 py-2 bg-indigo-500 text-white cursor-pointer shadow">
            Hover over me
        </div>
        <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
            <div class="absolute top-0 z-10 w-32 p-2 -mt-1 text-sm leading-tight text-white transform -translate-x-1/2 -translate-y-full bg-orange-500 rounded-lg shadow-lg">
            Hi, I am Tooltip
            </div>
            <svg class="absolute z-10 w-6 h-6 text-orange-500 transform -translate-x-12 -translate-y-3 fill-current stroke-current" width="8" height="8">
            <rect x="12" y="-10" width="8" height="8" transform="rotate(45)" />
            </svg>
        </div>
    </div>
</div> --}}
