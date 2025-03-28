@props([
    'label',
    'for',
    'error' => false,
    'helpText' => false,
    'inline' => false,
    'paddingless' => false,
    'borderless' => false,
])

@if($inline)
    <div>
        <label for="{{ $for }}" class="block text-xs font-medium leading-5 text-text whitespace-nowrap">{{ $label }}</label>

        <div class="mt-1 relative rounded-md shadow-sm">
            {{ $slot }}

            @if ($error)
                <div class="mt-1 text-red-500 text-xs">{{ $error }}</div>
            @endif

            @if ($helpText)
                <p class="mt-2 text-xs text-gray-500">{{ $helpText }}</p>
            @endif
        </div>
    </div>
@else
    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start {{ $borderless ? '' : ' sm:border-t ' }} sm:border-border {{ $paddingless ? '' : ' sm:py-5 ' }}">
        <label for="{{ $for }}" class="block text-xs font-medium leading-5 text-text whitespace-nowrap sm:mt-px sm:pt-2">
            {{ $label }}
        </label>

        <div class="mt-1 sm:mt-0 sm:col-span-2">
            {{ $slot }}

            @if ($error)
                <div class="mt-1 text-red-500 text-xs">{{ $error }}</div>
            @endif

            @if ($helpText)
                <p class="mt-2 text-xs text-gray-500">{{ $helpText }}</p>
            @endif
        </div>
    </div>
@endif
