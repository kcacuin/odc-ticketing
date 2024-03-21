<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="mr-10 text-left font-semibold text-xl text-white dark:text-gray-200 leading-tight">
                {{ __('Ticket List') }}
            </h2>
        </div>
    </x-slot>
    @section('title', 'Ticket List')
    @livewire('ticket-list')
    <x-flash-message key="create-ticket-success" icon="check-circle"/>
</x-app-layout>
