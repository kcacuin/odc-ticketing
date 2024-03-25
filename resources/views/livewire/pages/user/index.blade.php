<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="mr-10 text-left font-semibold text-xl text-white dark:text-gray-200 leading-tight">
                {{ __('User List') }}
            </h2>
        </div>
    </x-slot>
    @section('title', 'User List')
    @livewire('user-list')
    
    <x-flash-message key="create-user-success" icon="check-circle"/>
    <x-flash-message key="update-user-success" icon="check-circle"/>
    <x-flash-message key="delete-user-success" icon="check-circle"/>
</x-app-layout>