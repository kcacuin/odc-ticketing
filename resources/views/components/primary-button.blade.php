@php
    $classes = 'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-200 rounded-md font-semibold text-xs text-blue-primary dark:text-gray-800 uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none  focus:ring-0 focus:shadow-lg focus:shadow-odc-blue-600 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150';
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
    {{ $slot }}
</button>
