@props([
    'disabled' => false,
    'readonly' => false,
    'value' => null,
    'name',
    'wireModel' => '',
    'type' => '',
    'labelname',
    // 'xModel'
])

@php
    // $classes = 'block mt-1 w-full peer h-[3rem] px-6 text-base text-slate-400 bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none placeholder:select-none'
    $classes = 'block mt-1 w-full peer h-[3rem] px-6 text-sm text-slate-300 bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
    ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0';
@endphp

<x-form.field class="flex relative">
    {{-- <div class="flex relative"> --}}
        <div>
            <input {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {!! $attributes->merge(['class' => $classes]) !!}
                wire:model="{{ $wireModel }}"
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $name }}"
                placeholder="placeholder"
                {{-- x-model="{{ $xModel }}" --}}
                {{ $attributes(['value' => $value ?? old($name)]) }}
            >
            <x-form.label name="{{ $name }}" labelname="{{ $labelname }}" />
            <x-form.error name="{{ $name }}" />

        </div>
        <div class="overflow-hidden absolute right-2 -top-1 translate-y-1/2">
            <a type="button" @click.prevent="navigator.clipboard.writeText(input), showMsg = true, setTimeout(() => showMsg = false, 1000)" class="group inline-flex items-center justify-center text-lg font-normal text-center text-slate-500 truncate rounded-b transition-colors hover:text-slate-400">
                <button x-on:click.prevent id="clipboard" class="p-2 text-xs font-medium">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                    </svg>
                    <span id="success-icon" class="hidden items-center">
                        <svg class="w-3.5 h-3.5 text-blue-700 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                        </svg>
                    </span>
                </button>
            </a>
        </div>
        {{-- </div> --}}
</x-form.field>
<div x-show="showMsg" @click.away="showMsg = false" class="fixed bottom-5 right-5 z-20 overflow-hidden bg-green-100 border border-green-300 rounded" style="display: none;">
    <p class="p-3 flex items-center justify-center text-green-600">Copied to Clipboard</p>
</div>
