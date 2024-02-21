{{-- @props(['status', ]) --}}

@php
    $classes = 'text-xs font-medium me-2 px-2.5 py-0.5 rounded whitespace-nowrap'
@endphp

<span {!! $attributes->merge(['class' => $classes]) !!}>
    {{ $slot }}
</span>
