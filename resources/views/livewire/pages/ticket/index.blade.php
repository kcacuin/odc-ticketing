<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="mr-10 text-left font-semibold text-lg text-white dark:text-gray-200 leading-tight">
                {{ __('Ticket List') }}
            </h2>
            <div class="flex gap-4">
                <a
                    wire:navigate
                    href="/tickets/create"
                    class="w-full md:w-auto flex items-center justify-center py-1.5 px-4 text-xs font-medium text-blue-secondary focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <x-svg-icon
                        class="-scale-75  text-blue-secondary group-hover:text-white"
                        name="add"
                        />
                    <span class="ml-1.5">
                        Add New Incident
                    </span>
                </a>
            </div>
        </div>
    </x-slot>
    @livewire('ticket-list')
</x-app-layout>

@push('styles')
<link href="{{ asset('css/pikaday.css') }}" rel="stylesheet">
@endpush
