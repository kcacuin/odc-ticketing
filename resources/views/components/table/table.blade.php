<table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
    {{-- <div class="relative w-full overflow-hidden">
        <thead class="w-full overflow-hidden rounded-md text-white bg-slate-50  dark:bg-gray-700 dark:text-gray-400">
            <thead class="w-full text-white bg-gradient-to-br from-blue-primary to-blue-secondary dark:bg-gray-700 dark:text-gray-400">
            
            <tr>
                {{ $head }}
            </tr>
        </thead>
    </div> --}}
    <thead class=" bg-slate-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            {{ $head }}
        </tr>
    </thead>
    <tbody>
        {{ $body }}
    </tbody>
</table>
