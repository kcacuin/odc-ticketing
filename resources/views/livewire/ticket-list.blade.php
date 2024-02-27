<div class="odc-main-con-height p-4">
    <div class="h-full flex flex-col justify-between relative overflow-hidden sm:rounded-lg">
        {{-- <form method="GET" action="#" class="max-w-2xl mb-4"> --}}
            {{-- @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif --}}
            <div class="max-w-2xl mb-4">
                <div class="flex">
                    <input
                        type="text"
                        wire:model.live.debounce.250ms="filters.search"
                        class="block py-2.5 w-full z-20 text-xs text-gray-900 rounded-s shadow border-white border-e border-e-gray-light focus:ring-odc-blue-400 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-odc-blue-400"
                        placeholder="Find incident..."
                        {{-- value="{{ request('search') }}" --}}
                    />
                    <button wire:click.prevent="$toggle('showFilters')" class="flex items-center gap-2 bg-white py-2.5 px-5 text-xs whitespace-nowrap text-blue-secondary rounded-e-md rounded-l-none shadow hover:bg-gray-100">
                        @if ($showFilters)
                            Hide
                        @endif
                        Advance Search...
                    </button>
                </div>
            </div>
        {{-- </form> --}}
        <div>
            @if ($showFilters)
                <div class="bg-white p-4 rounded shadow flex relative mb-4">
                    <div class="w-1/2 pr-2 space-y-4">
                        <x-input.group inline for="filter-date-min" label="Minimum Date">
                            <x-input.date wire:model.live.blur='filters.date-min' id="filter-date-min" placeholder="MM/DD/YYYY"/>
                        </x-input.group>
                        <x-input.group inline for="filter-date-max" label="Maximum Date">
                            <x-input.date wire:model.live.blur='filters.date-max' id="filter-date-max" placeholder="MM/DD/YYYY"/>
                        </x-input.group>
                    </div>
                    <div class="w-1/2 pr-2 space-y-4">
                        <x-input.group inline for="filter-status" label="Status">
                            <x-input.select wire:model.live.blur='filters.status' id="filter-status">
                                <option value="" disabled>Select Status...</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                        <x-button.link wire:click='resetFilters' class="absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
                    </div>
                </div>
            @endif
        </div>

        <div class="relative overflow-auto h-full bg-white rounded">
            <x-table.table>
                <x-slot name="head">
                    <x-table.heading class="px-4 py-1.5 text-center">
                        <div class="flex items-center">
                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-odc-blue-400 bg-gray-100 border-gray-300 rounded focus:ring-odc-blue-400 dark:focus:ring-odc-blue-400 dark:ring-offset-odc-blue-400 dark:focus:ring-offset-odc-blue-400 focus:ring-2 dark:bg-odc-blue-400 dark:border-odc-blue-400">
                            {{-- <input wire:model='selectPage' id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-odc-blue-400 bg-gray-100 border-gray-300 rounded focus:ring-odc-blue-400 dark:focus:ring-odc-blue-400 dark:ring-offset-odc-blue-400 dark:focus:ring-offset-odc-blue-400 focus:ring-2 dark:bg-odc-blue-400 dark:border-odc-blue-400"> --}}
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </x-table.heading>
                    <x-table.heading class="px-2 py-1.5" sortable wire:click="sortBy('date_received')" :direction="$sortField === 'date_received' ? $sortDirection : null">
                        <div class="flex flex-col">
                            <span>Ticket No. /</span>
                            <span class="whitespace-nowrap">Date Received</span>
                        </div>
                    </x-table.heading>
                    <x-table.heading class="py-1.5" sortable wire:click.prevent.live="sortBy('title')" :direction="$sortField === 'title' ? $sortDirection : null">
                        <div class="flex flex-col">
                            <span>Issue Title /</span>
                            <span>Concern</span>
                        </div>
                    </x-table.heading>
                    <x-table.heading class="py-1.5" sortable wire:click.prevent.live="sortBy('requested_by')" :direction="$sortField === 'requested_by' ? $sortDirection : null">
                        <div class="flex flex-col">
                            <span>Requested By /</span>
                            <span>Client</span>
                        </div>
                    </x-table.heading>
                    <x-table.heading class="px-2 py-1.5" sortable wire:click.prevent.live="sortBy('product')" :direction="$sortField === 'product' ? $sortDirection : null">
                        Product
                    </x-table.heading>
                    <x-table.heading class="px-2 py-1.5 text-center" sortable wire:click.prevent.live="sortBy('status_id')" :direction="$sortField === 'status_id' ? $sortDirection : null">
                        Status
                    </x-table.heading>
                    <x-table.heading class="px-2 py-1.5" sortable wire:click.prevent.live="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">
                        Supported By
                    </x-table.heading>
                    <x-table.heading class="px-4 py-1.5 text-center">
                        Action
                    </x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @forelse ($tickets as $ticket)
                    <x-table.row wire:key="{{ $ticket->id }}" wire:loading.class.delay='opacity-35 animate-pulse'>
                        <x-table.cell class="w-4 px-4 py-1">
                            <div class="flex items-center">
                                <input id="{{ $ticket->id }}" value="{{ $ticket->id }}" type="checkbox" class="w-4 h-4 text-odc-blue-400 bg-gray-100 border-gray-300 rounded focus:ring-odc-blue-400 dark:focus:ring-odc-blue-400 dark:ring-offset-odc-blue-400 dark:focus:ring-offset-odc-blue-400 focus:ring-2 dark:bg-odc-blue-400 dark:border-odc-blue-400">
                                {{-- <input wire:model='selectedTicket' id="{{ $ticket->id }}" value="{{ $ticket->id }}" type="checkbox" class="w-4 h-4 text-odc-blue-400 bg-gray-100 border-gray-300 rounded focus:ring-odc-blue-400 dark:focus:ring-odc-blue-400 dark:ring-offset-odc-blue-400 dark:focus:ring-offset-odc-blue-400 focus:ring-2 dark:bg-odc-blue-400 dark:border-odc-blue-400"> --}}
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </x-table.cell>
                        <x-table.cell class="px-4 py-1 text-gray-500 whitespace-nowrap dark:text-white">
                            <div class="flex flex-col">
                                <a class="text-odc-blue-800 font-bold underline" href="{{ route('tickets.show', $ticket) }}">
                                    {{ $ticket->number }}
                                </a>
                                <span>
                                    {{ $ticket->date_received }}
                                </span>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex flex-col">
                                <span class="font-bold text-odc-blue-800">{{ $ticket->title }}</span>
                                <span>{!! Illuminate\Support\Str::words($ticket->issue, 8, '...') !!}</span>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex flex-col">
                                <span class="font-bold text-odc-blue-800">
                                    {{ $ticket->requested_by }}
                                </span>
                                <span>
                                    {{ $ticket->client }}
                                </span>
                            </div>
                        </x-table.cell>
                        <x-table.cell class="px-4 py-1">
                            {{ $ticket->product }}
                        </x-table.cell>
                        <x-table.cell class="px-4 py-1 text-left">
                            <x-badge class="bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-800 dark:bg-{{ $ticket->status_color }}-900 dark:text-{{ $ticket->status_color }}-300">{{ $ticket->status->name }}</x-badge>
                        </x-table.cell>
                        <x-table.cell class="px-4 py-1">
                            {{ $ticket->user->first_name . ' ' . $ticket->user->last_name }}
                        </x-table.cell>
                        <x-table.cell class="px-4 py-1 text-center align-middle">
                            <div class="hidden sm:flex sm:items-center sm:justify-center sm:ms-auto">
                                <x-dropdown align="right" width="w-40">
                                    <x-slot name="trigger" class="flex items-center justify-center text-center">
                                        <span class="text-blue-secondary text-2xl tracking-tighter cursor-pointer select-none">
                                            {{ '••' }}
                                        </span>
                                    </x-slot>

                                    <x-slot name="content">
                                        <ul class="py-2 text-xs text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefault">
                                            <li>
                                                <x-dropdown-link href="{{ route('tickets.show', $ticket) }}"
                                                class="group flex items-center px-4 py-2 hover:text-white
                                                hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <x-svg-icon
                                                        class="scale-90 text-blue-secondary group-hover:text-white"
                                                        name="view"
                                                        />
                                                    <span class="ml-3 text-xs text-blue-secondary group-hover:text-white">
                                                        View
                                                    </span>
                                                </x-dropdown-link>
                                            </li>
                                            <li>
                                                <x-dropdown-link href="/tickets/{{ $ticket->id }}/edit"
                                                class="group flex items-center px-4 py-2 hover:text-white
                                                hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <x-svg-icon
                                                        class="scale-90 text-blue-secondary group-hover:text-white"
                                                        name="edit"
                                                        />
                                                    <span class="ml-3 text-xs text-blue-secondary group-hover:text-white">
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
                                                    <x-dropdown-link href="#" x-on:click="document.getElementById('delete').submit()"
                                                    class="group flex items-center px-4 py-2 hover:text-white
                                                    hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                    dark:hover:bg-gray-600 dark:hover:text-white">
                                                        <x-svg-icon
                                                            class="scale-90 text-blue-secondary group-hover:text-white"
                                                            name="trash"
                                                            />
                                                        <span class="ml-3 text-xs text-blue-secondary group-hover:text-white">
                                                            Trash
                                                        </span>
                                                    </x-dropdown-link>
                                                </form>
                                            </li>
                                        </ul>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    @empty
                </x-slot>
                <x-slot name="body">
                    <x-table.row wire:loading.class.delay='opacity-35 animate-pulse'>
                        <x-table.cell class="w-4 px-4 py-4 opacity-75 animate-pulse" colspan="8">
                            <div class="flex items-center justify-center gap-1">
                                <x-svg-icon name="ticket" class="scale-75"/>
                                <span class="font-base font-bold">No tickets found...</span>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    @endforelse
                </x-slot>
            </x-table.table>
        </div>
        <div class="h-16 w-full flex items-center justify-between bg-gradient-to-br from-blue-primary to-blue-secondary">
            <span class="ml-5 inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                <span class="me-1">{{ $tickets->count() }}</span>
                <span>Total Tickets</span>
            </span>
            <div class="mr-5 flex flex-col items-center my-2">
                {{ $tickets->links('livewire::tailwind') }}
        </div>
    </div>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
@endpush
