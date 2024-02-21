@props([
    'disabled' => false,
    'readonly' => false,
    // 'value' => null,
    'name',
    'wireModel' => '',
    'type' => '',
    'labelname'
])

@php
    $classes = 'block mt-1 w-full peer h-[3rem] px-6 text-base text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none placeholder:select-none'
@endphp

<x-form.field>
    <input {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}
    {!! $attributes->merge(['class' => $classes, 'value' => old($name)]) !!}
        wire:model="{{ $wireModel }}"
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="placeholder"
    >
    @error('{{ $name }}')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
    {{-- @error('{{ $name }}')
    <div class='flex text-sm text-pink-600 dark:text-pink-400'>
        <span class="mt-[1px] mr-1">
            <svg aria-hidden="true" fill="currentColor" focusable="false" width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
        </span>
        <span> {{ $message }} </span>
    </div>
    @enderror --}}
    {{-- <x-form.error name="{{ $name }}" /> --}}

    <x-form.label name="{{ $name }}" labelname="{{ $labelname }}" />
</x-form.field>
