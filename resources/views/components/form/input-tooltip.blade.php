@props([
    'disabled' => false,
    'readonly' => false,
    'name',
    'wireModel' => '',
    'type' => '',
    'labelname',
    'tooltip',
])

@php
    $classes = 'block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-primary-background rounded-lg border-border border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
    ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0';
    $errorClasses = 'block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-primary-background rounded-lg border-red-primary border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none ring-0 placeholder:select-none focus:border-red-primary focus:ring-0';
@endphp

<x-form.field>
    <div class="relative">
        <input {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}
        {!! $attributes->merge(['class' => $classes . ($errors->has($name) ? $errorClasses : ''), 'value' => old($name)]) !!}
            wire:model="{{ $wireModel }}"
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            placeholder="placeholder"
        >
        <x-form.label name="{{ $name }}" labelname="{{ $labelname }}" />
        <div class="absolute top-0 right-3 translate-y-1/2">
            <div x-data="{ tooltip: false }" class="relative z-[999] inline-flex">
                <x-svg-icon class="text-slate-500 scale-75 transition-colors hover:text-slate-400" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" name="info-circle" />
                <div x-cloak x-show.transition.origin.top="tooltip">
                    <div class="info-tooltip absolute z-[999] max-w-2xl ring-1 ring-slate-400 whitespace-nowrap -top-2 left-1/2 p-2 -mt-1 text-sm font-medium leading-tight text-white transform -translate-x-1/2 -translate-y-full bg-gray-dark rounded-lg shadow-lg">
                    {{ $tooltip }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-form.error name="{{ $name }}" />
</x-form.field>
