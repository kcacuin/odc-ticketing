<div class="odc-main-con-height px-6 py-8">
    <div class="h-full flex flex-col justify-between relative rounded-b-md overflow-hidden sm:rounded-lg">
        {{-- ***** Search, Filter & Create Incident Button --}}
        <div x-data="{ expanded: false }" class="mt-4">
            <div class="mb-4 flex justify-between ">
                <div class="  inline-flex space-x-4">
                    <div class="flex w-3/4">
                        <input
                            type="text"
                            wire:model.live.debounce.150ms="filters.search"
                            class="py-2.5 w-[40rem] text-xs placeholder:text-slate-500 rounded-s-md bg-white text-slate-900 shadow border-s-slate-300 border-slate-300 border-e border-e-slate-light focus:ring-odc-blue-400 dark:bg-slate-700 dark:border-s-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:border-odc-blue-400"
                            placeholder="Find incident..."
                            {{-- value="{{ request('search') }}" --}}
                        />
                        <button x-on:click.prevent="expanded = ! expanded" class="flex items-center gap-2 bg-white py-2.5 px-5 text-xs font-bold whitespace-nowrap text-blue-secondary rounded-e-md border border-slate-300 rounded-l-none shadow hover:bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                            </svg>
                            <p x-text="expanded ? 'Hide' : 'Advance Search...'" x-transition></p>
                            {{-- @if ($showFilters)
                                Hide
                            @endif
                            Advance Search... --}}
                        </button>
                    </div>
                    <div class="flex items-center space-x-2 ">
                        <x-input.group borderless paddingless for="perPage" label="Per Page">
                            <x-input.select wire:model.lazy="perPage" id="perPage" class="shadow">
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </x-input.select>
                        </x-input.group>
    
                        {{--
                            TODO:
                                Phase 2 - Bulk Actions: Export to CSV and Bulk Delete
                            TODO
                        --}}
                        {{-- <x-dropdown.dropdown label="Bulk Actions">
                            <x-dropdown.item type="button" wire:click="exportSelected" class="group flex items-center px-4 py-2 space-x-2 text-xs text-blue-secondary hover:text-white
                            hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                            dark:hover:bg-slate-600 dark:hover:text-white">
                                <x-svg-icon class="scale-90" name="download"/>
                                <span>Export</span>
                            </x-dropdown.item>
    
                            <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')" class="group flex items-center px-4 py-2 space-x-2 text-xs text-blue-secondary hover:text-white
                            hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                            dark:hover:bg-slate-600 dark:hover:text-white">
                                <x-svg-icon class="scale-90" name="trash"/>
                                <span>Delete</span>
                            </x-dropdown.item>
                        </x-dropdown.dropdown> --}}
    
                        {{-- <livewire:import-transactions /> --}}
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a
                        wire:navigate
                        href="{{ route('tickets.create') }}"
                        class="w-full flex items-center justify-center px-4 whitespace-nowrap text-xs font-medium text-white focus:outline-none bg-odc-blue-800 
                        rounded-md border border-gray-200 hover:bg-odc-blue-900 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <x-svg-icon
                            class="-scale-75  group-hover:text-opacity-5"
                            name="add"
                            />
                        <span class="ml-1.5">
                            Create Incident
                        </span>
                    </a>
                </div>
            </div>

            {{-- * Filters --}}

            <div x-show="expanded" x-collapse>
                {{-- @if ($showFilters) --}}
                    <div class="p-4 bg-white border border-slate-300 rounded shadow flex relative mb-4">
                        <div class="w-1/2 pr-2 space-y-4">
                            <x-input.group inline for="filter-date-min" label="Start Date">
                                <x-input.date name='filters.date-min' id="filter-date-min" placeholder="MM/DD/YYYY"/>
                            </x-input.group>
                            <x-input.group inline for="filter-date-max" label="End Date">
                                <x-input.date name='filters.date-max' id="filter-date-max" placeholder="MM/DD/YYYY"/>
                            </x-input.group>
                        </div>
                        <div class="w-1/2 pr-2 space-y-4">
                            <x-input.group inline for="filter-status" label="Status">
                                <x-input.select wire:model.live='filters.status' id="filter-status">
                                    <option value="" disabled>Select Status...</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                            <x-button.link wire:click='resetFilters' class="absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
                        </div>
                    </div>
                {{-- @endif --}}
            </div>
        </div>
        
        {{-- ***** Table ***** --}}
        <div class="border h-full bg-white border-slate-300 rounded-t-md overflow-clip">
            <div class="__table relative overflow-auto h-full  snap-mandatory snap-y">
                <x-table.table>
                    <x-slot name="head">
                        <x-table.heading class="px-4 py-1.5 text-center">
                            <div class="flex items-center">
                                <x-input.checkbox wire:model="selectPage" />
                            </div>
                        </x-table.heading>
                        <x-table.heading class="px-2 py-1.5" sortable multi-column wire:click="sortBy('date_received')" :direction="$sorts['date_received'] ?? null">
                            <div class="flex flex-col">
                                <span>Ticket No. /</span>
                                <span class="whitespace-nowrap">Date Received</span>
                            </div>
                        </x-table.heading>
                        <x-table.heading class="py-1.5" sortable multi-column wire:click.prevent.live="sortBy('title')" :direction="$sorts['title'] ?? null">
                            <div class="flex flex-col">
                                <span>Issue Title /</span>
                                <span>Concern</span>
                            </div>
                        </x-table.heading>
                        <x-table.heading class="py-1.5" sortable multi-column wire:click.prevent.live="sortBy('requested_by')" :direction="$sorts['requested_by'] ?? null">
                            <div class="flex flex-col">
                                <span>Requested By /</span>
                                <span>Client</span>
                            </div>
                        </x-table.heading>
                        <x-table.heading class="px-2 py-1.5" sortable multi-column wire:click.prevent.live="sortBy('product')" :direction="$sorts['product'] ?? null">
                            Product
                        </x-table.heading>
                        <x-table.heading class="px-2 py-1.5 text-center" sortable multi-column wire:click.prevent.live="sortBy('status_id')" :direction="$sorts['status_id'] ?? null">
                            Status
                        </x-table.heading>
                        <x-table.heading class="px-2 py-1.5" sortable multi-column wire:click.prevent.live="sortBy('user_id')" :direction="$sorts['user_id'] ?? null">
                            Supported By
                        </x-table.heading>
                        <x-table.heading class="px-4 py-1.5 text-center">
                            Action
                        </x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        {{-- @if ($selectPage)
                        <x-table.row class="bg-white" wire:key="row-message">
                            <x-table.cell colspan="8">
                                @unless ($selectAll)
                                <div>
                                    <span>You have selected <strong>{{ $tickets->count() }}</strong> transactions, do you want to select all <strong>{{ $tickets->total() }}</strong>?</span>
                                    <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                </div>
                                @else
                                <span>You are currently selecting all <strong>{{ $tickets->total() }}</strong> transactions.</span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                        @endif --}}
                        @forelse ($tickets as $ticket)
                        
                        <x-table.row wire:key="{{ $ticket->id }}" wire:loading.class.delay='opacity-35 animate-pulse'>
                            <x-table.cell class="w-4 px-4 py-1">
                                <div class="flex items-center">
                                    <x-input.checkbox wire:model="selected" value="{{ $ticket->id }}" />
                                </div>
                            </x-table.cell>
                            <x-table.cell class="px-4 py-1 whitespace-nowrap dark:text-white">
                                <div class="flex flex-col">
                                    <a class="text-slate-600 font-bold underline" href="{{ route('tickets.show', $ticket) }}">
                                        {{ $ticket->number }}
                                    </a>
                                    <span class="text-slate-500">
                                        {{ $ticket->date_received }}
                                    </span>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-600">{{ $ticket->title }}</span>
                                    <div class="text-slate-500">{!! clean(Illuminate\Support\Str::words($ticket->issue->toPlainText(), 8, '...')) !!}</div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-600">
                                        {{ $ticket->requested_by }}
                                    </span>
                                    <span class="text-slate-500">
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
                                    {{-- @php
                                        $reversedTickets = $tickets->reverse(); 
                                        $slicedTickets = $reversedTickets->slice(0, 4); 
                                        $isBottom = $reversedTickets->search($ticket) >= $reversedTickets->count() - 4;
                                    @endphp --}}
                                    <x-dropdown
                                        width="w-40"
                                    >
                                        <x-slot name="trigger" class="flex items-center justify-center text-center">
                                            <span class="text-blue-secondary text-2xl tracking-tighter cursor-pointer select-none">
                                                {{ '••' }}
                                            </span>
                                        </x-slot>
    
                                        <x-slot name="content">
                                            <ul class="py-2 text-xs text-slate-700 dark:text-slate-200" aria-labelledby="dropdownDefault">
                                                <li>
                                                    <x-dropdown-link href="{{ route('tickets.show', $ticket->number) }}"
                                                    class="group flex items-center px-4 py-2 hover:text-white
                                                    hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                    dark:hover:bg-slate-600 dark:hover:text-white">
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
                                                    <x-dropdown-link href="{{ route('tickets.edit', $ticket->number) }}"
                                                    class="group flex items-center px-4 py-2 hover:text-white
                                                    hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                    dark:hover:bg-slate-600 dark:hover:text-white">
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
                                                    <button 
                                                        wire:click="delete({{ $ticket->id }})"
                                                        type="button"
                                                        class="w-full text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out group flex items-center px-4 py-2 hover:text-white
                                                        hover:bg-gradient-to-br hover:from-odc-red-600 hover:to-odc-red-500
                                                        dark:hover:bg-slate-600 dark:hover:text-white">
                                                        <x-svg-icon
                                                            class="scale-90 text-blue-secondary group-hover:text-white"
                                                            name="trash"
                                                            />
                                                        <span class="ml-3 text-xs text-blue-secondary group-hover:text-white">
                                                            Delete
                                                        </span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </x-slot>
                                    </x-dropdown>
                                    
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @empty
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
        </div>

        {{-- ***** Table Footer ***** --}}
        {{-- <div class="h-16 w-full flex items-center justify-between  bg-gradient-to-br from-blue-primary to-blue-secondary"> --}}
        <div class="h-16 w-full flex rounded-b-lg items-center justify-between bg-slate-50 border-t-0 border border-slate-300 ">
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

    {{-- ***** Delete Modal ***** --}}
    <div x-data="{ open: @entangle('showDeleteModal') }"> 
        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                <div x-cloak @click.prevent="modelOpen = false" x-show="open"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"
                ></div>

                <div x-cloak x-show="open"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block w-full max-w-lg p-2 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
                >
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 w-12 h-12 text-red-primary dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <div class="mb-3 flex flex-col">
                            <h1 class="text-xl font-extrabold text-gray-800 ">Are you sure you want to delete this incident?</h1>
                            <div>
                                <code class="text-slate-500 px-20 rounded py-1 bg-slate-100">{{ $id }}</code>
                            </div>
                        </div>
                        <div class="space-x-4">
                            <x-primary-button @click="open = false" wire:loading.attr="disabled" type="button"  class="border border-slate-300">No, cancel</x-primary-button>
                            <button wire:click="confirmDelete" wire:loading.attr="disabled" type="submit" class="px-3 py-2 text-xs tracking-widest text-white uppercase transition-colors duration-200 transform bg-odc-red-600 rounded-md dark:bg-odc-red-700 dark:hover:bg-odc-red-800 dark:focus:bg-odc-red-800 hover:bg-odc-red-700 focus:outline-none focus:bg-odc-red-600 focus:ring focus:ring-odc-red-400 focus:ring-opacity-50">
                                <span>Yes, delete it</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>