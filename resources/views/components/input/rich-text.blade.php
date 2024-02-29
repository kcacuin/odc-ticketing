{{-- @props([
    'initialValue' => '',
    'value',
    'name',
])

@php
    $classes = "form-textarea block w-full min-h-60 rounded-md border-slate-400 focus:shadow-sm focus:shadow-odc-blue-400 focus:border-odc-blue-800 transition duration-150 ease-in-out sm:text-sm sm:leading-5";
    $errorClasses = "form-textarea block w-full min-h-60 rounded-md border-slate-400 focus:shadow-sm focus:shadow-odc-blue-400 focus:border-odc-blue-800 transition duration-150 ease-in-out sm:text-sm sm:leading-5 border-2 border-red-primary focus:border-red-primary"
@endphp

<div
    class="rounded-md shadow-sm"
    x-data="{
        {{-- value: @entangle($attributes->wire('model')), --}}
        {{-- value: '{{ $value }}', --}}
        isFocused() { return document.activeElement !== this.$refs.trix },
        setValue() { this.$refs.trix.editor.loadHTML(this.value) },
    }"
    x-init="setValue(); $watch('value', () => isFocused() && setValue())"
    x-on:trix-change="value = $event.target.value"
    {{ $attributes->whereDoesntStartWith('wire:model') }}
    wire:ignore
>
    <input id="x" value="{{ $initialValue }}" name="{{ $name }}" type="hidden">
    <trix-editor
        x-ref="trix"
        value="{{ $initialValue }}"
        name="{{ $name }}"
        input="x"
        @trix-attachment-add="uploadTrixImage($event.attachment)"
        {!! $attributes->merge(['class' => $classes . ($errors->has($name) ? $errorClasses : ''), 'value' => old($name)]) !!}
        >{{ nl2br($slot ?? old($name)) }}</trix-editor>
</div> --}}
