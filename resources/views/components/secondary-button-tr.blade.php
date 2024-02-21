<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-secondary-blue hover:text-slate-300 dark:text-gray-800 uppercase tracking-widest  dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:ring-0 focus:ring-offset-0 focus:outline-none transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
