@props(['name', 'labelname'])

@php
    $classes = 'absolute px-2 text-[0.8rem] text-blue-200 bg-blue-secondary rounded transform -translate-y-[3.7rem] translate-x-4 transition duration-300 peer-focus:absolute peer-focus:after:content-["*"] peer-focus:px-2 peer-focus:text-[0.8rem] peer-focus:text-blue-200 peer-focus:bg-blue-secondary peer-focus:rounded peer-focus:transform peer-focus:-translate-y-[3.7rem] peer-focus:translate-x-2 peer-placeholder-shown:text-white peer-placeholder-shown:text-sm peer-placeholder-shown:-translate-y-[2.2rem] peer-placeholder-shown:px-0 peer-placeholder-shown:bg-transparent';
    $errorClasses = 'absolute px-2 text-[0.8rem] text-red-200 bg-odc-red-800 rounded transform -translate-y-[3.5rem] translate-x-4 transition duration-300 peer-focus:absolute peer-focus:px-2 peer-focus:text-[0.8rem] peer-focus:text-red-200 peer-focus:bg-odc-red-800 peer-focus:rounded peer-focus:transform peer-focus:-translate-y-[3.5rem] peer-focus:translate-x-2 peer-placeholder-shown:text-white peer-placeholder-shown:text-sm peer-placeholder-shown:-translate-y-[2.2rem] peer-placeholder-shown:px-0 peer-placeholder-shown:bg-transparent';
@endphp

<label {{ $attributes->merge(['class' => $classes . ($errors->has($name) ? $errorClasses : '')]) }} for="{{ $name }}" >
    {{ $labelname }}
</label>