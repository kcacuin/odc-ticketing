@props([
    'disabled' => false,
    'readonly' => false,
    'name',
    'wireModel' => '',
    'labelname',
])

@php
    // $classes = 'block mt-1 w-full peer h-[3rem] px-6 text-base text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none placeholder:select-none'
    $classes = 'text-white bg-gray-dark border border-gray-200 px-6 w-full rounded-lg border-opacity-75 border-2';

    $labelClasses = 'absolute px-2 text-[0.8rem] text-blue-200 bg-blue-secondary rounded transform -translate-y-[0.5rem] translate-x-4 transition duration-300 peer-focus:absolute peer-focus:px-2 peer-focus:text-[0.8rem] peer-focus:text-blue-200 peer-focus:bg-blue-secondary peer-focus:rounded peer-focus:transform peer-focus:-translate-y-[0.5rem] peer-focus:translate-x-2 peer-placeholder-shown:text-white peer-placeholder-shown:text-sm peer-placeholder-shown:-translate-y-[2.2rem] peer-placeholder-shown:px-0 peer-placeholder-shown:bg-transparent'

@endphp
{{--
<x-form.field>
    <textarea {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {!! $attributes->merge(['class' => $classes]) !!}
            name="{{ $name }}"
            id="{{ $name }}"
            required
            {{ $attributes }}
            wire:model="{{ $wireModel }}"
    >{{ nl2br($slot ?? old($name)) }}</textarea>

    <x-form.label name="{{ $name }}" labelname="{{ $labelname }}"/>

    <x-form.error name="{{ $name }}"/>
</x-form.field> --}}

<x-form.field>
    <label class="{{ $labelClasses }}" for="{{ $name }}" >
        {{ $labelname }}
    </label>

    <textarea {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {!! $attributes->merge(['class' => $classes]) !!}
            name="{{ $name }}"
            id="{{ $name }}"
            required
            {{ $attributes }}
            wire:model="{{ $wireModel }}"
    >{{ nl2br($slot ?? old($name)) }}</textarea>

    <x-form.error name="{{ $name }}"/>
</x-form.field>

