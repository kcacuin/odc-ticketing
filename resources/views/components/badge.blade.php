@php
    $classes = 'text-[0.625rem] font-medium px-2.5 py-0.5 text-center rounded whitespace-nowrap'
@endphp

<span {!! $attributes->merge(['class' => $classes]) !!}>
    {{ $slot }}
</span>
