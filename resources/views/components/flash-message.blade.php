@props([
    'key',
    'icon',
])

@php
    $classes = 'fixed z-50 flex items-center w-full max-w-80 p-4 space-x-2 text-sm text-gray-500 text-odc-blue-800 border border-odc-blue-300 rounded-lg bg-odc-blue-50 dark:bg-gray-800 dark:text-odc-blue-400 dark:border-odc-blue-800 shadow top-[100px] right-5 dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800';
@endphp

@if (session()->has($key))
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 4000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-full"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-full"
    id="toast-top-right"
    {{ $attributes->merge(['class' => $classes])}} role="alert">
        {{-- <span class="sr-only">Info</span> --}}
        <div class="flex flex-col">
            <div class="flex items-center text-odc-blue-600">
                <x-svg-icon name="{{ $icon }}" class="flex-shrink-0 inline scale-75 me-2" aria-hidden="true"/>
                <span class="font-medium">{{ session( $key ) }}</span>
            </div>
            <span class="ml-8">{{ $slot }}</span>
        </div>
    </div>
@endif
