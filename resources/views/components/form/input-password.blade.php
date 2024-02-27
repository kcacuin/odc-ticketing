@props([
    'disabled' => false,
    'readonly' => false,
    'value' => null,
    'name',
    'wireModel' => 'text',
    'type' => 'text',
    'labelname'
])

@php
    $classes = 'block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
    ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0';
    $errorClasses = 'block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-red-primary border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none ring-0 placeholder:select-none focus:border-red-primary focus:ring-0';
@endphp

<div class="flex items-center justify-between gap-4">
    <div class="relative flex-1 col-span-4" x-data="{ show: true }">
        <input  {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}
                {!! $attributes->merge(['class' => $classes  . ($errors->has($name) ? $errorClasses : '')]) !!}
                id="{{ $name }}"
                :type="show ? '{{ $name }}' : 'text'"
                name="{{ $name }}"
                wire:model='{{ $wireModel }}'
                required autocomplete="{{ $name }}" />

        <button type="button" class="flex absolute inset-y-0 right-0 items-center px-3 focus:ring-0 focus:ring-offset-0" @click="show = !show" :class="{'hidden': !show, 'block': show }">
            <x-svg-icon  name="eye-open" class="fill-transparent text-white stroke-white" />
        </button>
        <button type="button" class="flex absolute inset-y-0 right-0 items-center pr-3 focus:ring-0 focus:ring-offset-0" @click="show = !show" :class="{'block': !show, 'hidden': show }">
            <x-svg-icon name="eye-close" class="fill-transparent text-white stroke-white"  />
        </button>
        <x-form.label name="{{ $name }}" labelname="{{ $labelname }}" />
        <x-form.error name="{{ $name }}" />
    </div>
    <x-primary-button wire:click="generatePassword" type="button">Generate</x-primary-button>
</div>
