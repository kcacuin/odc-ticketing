<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-transparent dark:bg-gray-800 border border-blue-secondary dark:border-gray-500 rounded-md font-semibold text-xs text-blue-secondary dark:text-blue-secondary uppercase tracking-widest shadow-sm hover:bg-blue-secondary hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
