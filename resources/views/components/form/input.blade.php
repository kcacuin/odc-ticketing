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
    $classes = 'block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
    ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0';
    $errorClasses = 'block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-red-primary border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none ring-0 placeholder:select-none focus:border-red-primary focus:ring-0';
@endphp

<x-form.field>
    <div class="relative">
        <input {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}
        {!! $attributes->merge(['class' => $classes . ($errors->has($name) ? $errorClasses : ''), 'value' => old($name)]) !!}
            type="{{ $type }}"
            name="{{ $name }}"
            placeholder="placeholder"
        >
        <x-form.label name="{{ $name }}" labelname="{{ $labelname }}" />
    </div>
    <x-form.error name="{{ $name }}" />
</x-form.field>
