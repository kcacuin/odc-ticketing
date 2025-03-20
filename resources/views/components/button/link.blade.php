<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'text-cool-gray-700 text-xs leading-5 font-medium whitespace-nowrap focus:outline-none focus:text-cool-gray-800 focus:underline transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
    ]) }}
>
    {{ $slot }}
</button>
