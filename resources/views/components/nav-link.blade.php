@props(['active'])

@php
$classes = ($active ?? false)
            ? "group flex items-center overflow-hidden justify-start w-full mb-1 pl-5 p-2 rounded-sm text-red-primary font-medium transition-colors duration-200 odc-glass-active
            dark:from-gray-700 dark:to-gray-800"
            :"group odc-glass flex items-center overflow-hidden justify-start w-full mb-1 pl-5 p-2 rounded-sm font-medium text-white transition-colors duration-100 dark:text-gray-200";
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} wire:navigate>
    {{ $slot }}
</a>
