<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="mr-10 text-left font-semibold text-lg text-white dark:text-gray-200 leading-tight">
                {{ __('Ticket List') }}
            </h2>
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
    </x-slot>

    <div class="odc-main-con-height p-4 bg-white">
        <div class="h-full flex flex-col justify-between bg-white relative overflow-hidden shadow-md sm:rounded-lg">
            <div class="relative overflow-auto h-full bg-white">
                <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <div class="relative w-full">
                        <thead class="w-full text-white bg-gradient-to-br from-blue-primary to-blue-secondary dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input wire:model='selectAll' id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-odc-blue-400 bg-gray-100 border-gray-300 rounded focus:ring-odc-blue-400 dark:focus:ring-odc-blue-400 dark:ring-offset-odc-blue-400 dark:focus:ring-offset-odc-blue-400 focus:ring-2 dark:bg-odc-blue-400 dark:border-odc-blue-400">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <div class="flex flex-col">
                                        <span>Ticket No. /</span>
                                        <span>Date Received</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <div class="flex flex-col">
                                        <span>Issue Title /</span>
                                        <span>Concern</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <div class="flex flex-col">
                                        <span>Requested By /</span>
                                        <span>Client</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    Product
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    Supported By
                                </th>
                                <th scope="col" class="px-4 py-3 text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                    </div>
                    <tbody>
                        @foreach ($tickets as $ticket)
                        <tr key="{{ $ticket->id }}" class="bg-white border-b border-gray-primary dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 px-4 py-1">
                                <div class="flex items-center">
                                    <input wire:model='selectedTicket' id="{{ $ticket->id }}" value="{{ $ticket->id }}" type="checkbox" class="w-4 h-4 text-odc-blue-400 bg-gray-100 border-gray-300 rounded focus:ring-odc-blue-400 dark:focus:ring-odc-blue-400 dark:ring-offset-odc-blue-400 dark:focus:ring-offset-odc-blue-400 focus:ring-2 dark:bg-odc-blue-400 dark:border-odc-blue-400">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td scope="row" class="px-4 py-1 text-gray-500 whitespace-nowrap dark:text-white">
                                <div class="flex flex-col">
                                    <a class="text-odc-blue-800 font-bold underline" href="{{ route('tickets.show', $ticket) }}">
                                        {{ $ticket->number }}
                                    </a>
                                    <span>
                                        {{ $ticket->date_received }}
                                    </span>
                                </div>
                            </td>
                            {{-- <td scope="row" class="px-4 py-1  dark:text-white">
                            </td> --}}
                            <td class="px-4 py-1">
                                {!! Illuminate\Support\Str::words($ticket->issue, 5, '...') !!}
                            </td>

                            <td scope="row" class="px-4 py-1  dark:text-white">
                                <div class="flex flex-col">
                                    <span class="font-bold text-odc-blue-800">
                                        {{ $ticket->requested_by }}
                                    </span>
                                    <span>
                                        {{ $ticket->client }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-1">
                                {{ $ticket->product }}
                            </td>
                            <td class="px-4 py-1 text-white">
                                @switch($ticket->status->name)
                                    @case('Open')
                                        <x-badge class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">{{ $ticket->status->name }}</x-badge>
                                        @break
                                    @case('Pending')
                                        <x-badge class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">{{ $ticket->status->name }}</x-badge>
                                        @break
                                    @case('In-progress')
                                        <x-badge class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">{{ $ticket->status->name }}</x-badge>
                                        @break
                                    @case('In-review')
                                        <x-badge class="bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">{{ $ticket->status->name }}</x-badge>
                                        @break
                                    @case('Closed')
                                        <x-badge class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">{{ $ticket->status->name }}</x-badge>
                                        @break

                                    <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">{{ $ticket->status->name }}</span>
                                    @default
                                @endswitch
                            </td>
                            <td class="px-4 py-1">
                                {{ $ticket->user->first_name . ' ' . $ticket->user->last_name }}
                            </td>
                            <td class="px-4 py-1 text-center align-middle">
                                <div class="hidden sm:flex sm:items-center sm:justify-center sm:ms-auto">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger" class="flex items-center justify-center text-center">
                                            <span class="text-blue-secondary text-2xl tracking-tighter cursor-pointer select-none">
                                                {{ '••' }}
                                            </span>
                                        </x-slot>

                                        <x-slot name="content">
                                            <ul class="py-2 text-xs text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                                                <li>
                                                    <x-dropdown-link href="{{ route('tickets.show', $ticket) }}" class="group flex items-center px-4 py-2
                                                    hover:text-white
                                                    hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                    dark:hover:bg-gray-600 dark:hover:text-white">
                                                        <x-svg-icon
                                                            class="text-blue-secondary group-hover:text-white"
                                                            name="view"
                                                            />
                                                        <span class="ml-3 text-blue-secondary group-hover:text-white">
                                                            View
                                                        </span>
                                                    </x-dropdown-link>
                                                </li>
                                                <li>
                                                    <x-dropdown-link href="/tickets/{{ $ticket->id }}/edit" class="group flex items-center px-4 py-2
                                                    hover:text-white
                                                    hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                    dark:hover:bg-gray-600 dark:hover:text-white">
                                                        <x-svg-icon
                                                            class="text-blue-secondary group-hover:text-white"
                                                            name="edit"
                                                            />
                                                        <span class="ml-3 text-blue-secondary group-hover:text-white">
                                                            Edit
                                                        </span>
                                                    </x-dropdown-link>
                                                </li>
                                                <li>
                                                    <form id="delete" method="POST" action="/tickets/{{ $ticket->id }}"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        {{-- <button class="w-full px-4 py-2">
                                                            <x-svg-icon
                                                                class="text-blue-secondary group-hover:text-white"
                                                                name="trash"
                                                                />
                                                            <span class="ml-3 text-blue-secondary group-hover:text-white">
                                                                Trash
                                                            </span>
                                                        </button> --}}
                                                        <x-dropdown-link href="#" x-on:click="document.getElementById('delete').submit()" class="group flex items-center px-4 py-2
                                                        hover:text-white
                                                        hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                        dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <x-svg-icon
                                                                class="text-blue-secondary group-hover:text-white"
                                                                name="trash"
                                                                />
                                                            <span class="ml-3 text-blue-secondary group-hover:text-white">
                                                                Trash
                                                            </span>
                                                        </x-dropdown-link>
                                                    </form>
                                                </li>
                                            </ul>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="h-16 w-full flex items-center justify-between bg-gradient-to-br from-blue-primary to-blue-secondary">
                <span class="ml-5 inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                    <span class="me-1">{{ $tickets->count() }}</span>
                    <span>Total Tickets</span>
                </span>
                <div class="mr-5 flex flex-col items-center">
                    {{ $tickets->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
</x-app-layout>
