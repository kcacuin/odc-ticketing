@props(['active'])

@php
$classes = ($active ?? false)
            ? 'group flex items-center overflow-hidden justify-start w-full pl-5 p-2 my-1 text-red-primary font-medium transition-colors duration-200 rounded-lg odc-glass-active
            dark:from-gray-700 dark:to-gray-800'
            : 'group odc-glass flex items-center overflow-hidden justify-start w-full pl-5 p-2 my-2 font-medium text-white transition-colors duration-100 rounded-lg dark:text-gray-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} wire:navigate>
    {{ $slot }}
</a>
