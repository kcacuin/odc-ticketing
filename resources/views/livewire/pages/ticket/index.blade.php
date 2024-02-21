<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="mr-10 text-left font-semibold text-xl text-white dark:text-gray-200 leading-tight">
                {{ __('Ticket List') }}
            </h2>
            <a
                wire:navigate
                href="{{ route('tickets.create')}}"
                class="w-full md:w-auto flex items-center justify-center py-1.5 px-4 text-sm font-medium text-blue-secondary focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                <x-svg-icon
                    class="-scale-75  text-blue-secondary group-hover:text-white"
                    name="add"
                    />
                <span class="ml-1.5">
                    Add New Ticket
                </span>
            </a>
        </div>
    </x-slot>

    <div class="odc-main-con-height p-4 bg-white">
        <div class="h-full flex flex-col justify-between bg-white relative overflow-hidden shadow-md sm:rounded-lg">
            <div class="relative overflow-auto h-full bg-white">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <div class="relative w-full">
                        <thead class="w-full text-xs text-white uppercase bg-gradient-to-br from-blue-primary to-blue-secondary dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-red bg-gray-100 border-gray-300 rounded focus:ring-red dark:focus:ring-red dark:ring-offset-red dark:focus:ring-offset-red focus:ring-2 dark:bg-red dark:border-red">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ticket No.
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Supported By
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date Received
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Requested By
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Client
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Issue/Concern
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
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
                                    <input id="{{ $ticket->id }}" type="checkbox" class="w-4 h-4 text-red bg-gray-100 border-gray-300 rounded focus:ring-red dark:focus:ring-red dark:ring-offset-red dark:focus:ring-offset-red focus:ring-2 dark:bg-red dark:border-red">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td scope="row" class="px-6 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $ticket->ticket_number }}
                            </td>
                            <td class="px-6 py-1">
                                {{ $ticket->user->first_name . ' ' . $ticket->user->last_name }}
                            </td>
                            <td scope="row" class="px-6 py-1  dark:text-white">
                                {{ $ticket->date_received }}
                            </td>
                            <td scope="row" class="px-6 py-1  dark:text-white">
                                {{ $ticket->requested_by }}
                            </td>
                            <td class="px-6 py-1">
                                {{ $ticket->client }}
                            </td>
                            <td class="px-6 py-1">
                                {!! Illuminate\Support\Str::limit($ticket->issue, 25) !!}
                            </td>
                            <td class="px-6 py-1">
                                {{ $ticket->product }}
                            </td>
                            <td class="px-6 py-1 text-white">
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
                            <td class="px-6 py-1">

                                <div class="hidden sm:flex sm:items-center sm:ms-6">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <span class="text-blue-secondary text-3xl tracking-tighter cursor-pointer select-none">
                                                {{ '••' }}
                                            </span>
                                        </x-slot>

                                        <x-slot name="content">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
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
                                                    <x-dropdown-link href="#" class="group flex items-center px-4 py-2
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
                                                    <x-dropdown-link href="#" class="group flex items-center px-4 py-2
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
                <span class="ml-5 inline-flex items-center bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                    <span class="me-1">{{ $tickets->count() }}</span>
                    <span>Total Tickets</span>
                </span>
                <div class="mr-5 flex flex-col items-center">
                    {{ $tickets->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
