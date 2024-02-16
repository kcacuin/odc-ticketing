@props([
    'disabled' => false,
    'readonly' => false,
    'value' => null,
    'name',
    'wireModel' => '',
    'type' => '',
    'labelname'
])

@php
    $classes = 'block mt-1 w-full peer h-[3rem] px-6 text-base text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none placeholder:select-none'
@endphp

<x-form.field>
    <input {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {!! $attributes->merge(['class' => $classes]) !!}
        wire:model="{{ $wireModel }}"
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="placeholder"
        {{ $attributes(['value' => $value ?? old($name)]) }}
    >

    <x-form.label name="{{ $name }}" labelname="{{ $labelname }}" />

    <x-form.error name="{{ $name }}" />
</x-form.field>
