@props([
    'disabled' => false,
    'readonly' => false,
    'name',
    'wireModel' => '',
    'type' => '',
    'labelname',
    'tooltip'
])

@php
    $classes = 'peer block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-e-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
    ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0';
    $errorClasses = 'peer block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-red-primary border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none ring-0 placeholder:select-none focus:border-red-primary focus:ring-0';
@endphp

<x-form.field>
    <div class="relative">
        <div class="flex rounded-md shadow-sm ">
            <span class="inline-flex items-center px-3 rounded-l-md border-2 border-r-0 border-opacity-75 bg-gray-dark text-slate-500 sm:text-xs peer-focus:shadow-md peer-focus:shadow-odc-blue-700">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 2C5.44772 2 5 2.44772 5 3V4H4C2.89543 4 2 4.89543 2 6V16C2 17.1046 2.89543 18 4 18H16C17.1046 18 18 17.1046 18 16V6C18 4.89543 17.1046 4 16 4H15V3C15 2.44772 14.5523 2 14 2C13.4477 2 13 2.44772 13 3V4H7V3C7 2.44772 6.55228 2 6 2ZM6 7C5.44772 7 5 7.44772 5 8C5 8.55228 5.44772 9 6 9H14C14.5523 9 15 8.55228 15 8C15 7.44772 14.5523 7 14 7H6Z"/>
                </svg>
            </span>
            <input {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}
            {!! $attributes->merge(['class' => $classes . ($errors->has($name) ? $errorClasses : ''), 'value' => old($name)]) !!}
                wire:model="{{ $wireModel }}"
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $name }}"
                placeholder="placeholder"
            >
        </div>
        <x-form.label name="{{ $name }}" labelname="{{ $labelname }}" />
    </div>
    <x-form.error name="{{ $name }}" />
</x-form.field>
