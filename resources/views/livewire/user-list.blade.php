<div class="odc-main-con-height px-6 py-8">
    <div class="h-full flex flex-col justify-between relative overflow-hidden sm:rounded">
        {{-- ***** Search, Filter & Create User Button --}}
        <div x-data="{ expanded: false }" class="mt-4">
            <div class="mb-4 flex justify-between ">
                <div class="inline-flex space-x-4">
                    <div class="flex w-3/4">
                        <input
                            type="text"
                            wire:model.live.debounce.150ms="filters.search"
                            class="py-2.5 w-[40rem] text-xs placeholder:text-slate-500 rounded-s-md bg-white text-slate-900 shadow border-s-slate-300 border-slate-300 border-e border-e-slate-light focus:ring-odc-blue-400 dark:bg-slate-700 dark:border-s-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:border-odc-blue-400"
                            placeholder="Find incident..."
                            {{-- value="{{ request('search') }}" --}}
                        />
                        <button disabled x-on:click.prevent="expanded = ! expanded" class="flex items-center gap-2 bg-white py-2.5 px-5 text-xs font-bold whitespace-nowrap text-blue-secondary rounded-e-md border border-slate-300 rounded-l-none shadow hover:bg-slate-100">
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
                            <x-input.select wire:model.lazy="perPage" id="perPage">
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
                    </div>
                </div>
                <div>
                    <button wire:click.prevent="create" type="button" class="py-2.5 w-full flex items-center justify-center px-4 whitespace-nowrap text-xs font-medium text-white focus:outline-none bg-odc-blue-800 
                    rounded-md border border-gray-200 hover:bg-odc-blue-900 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span class="ml-1.5">
                            Create User
                        </span>
                    </button>
                </div>
            </div>

            {{-- * Filters --}}

            <div x-show="expanded" x-collapse>
                {{-- @if ($showFilters) --}}
                    <div class="bg-white p-4 rounded shadow flex relative mb-4">
                        <div class="w-1/2 pr-2 space-y-4">
                            <x-input.group inline for="filter-date-min" label="Start Date">
                                <x-input.date name='filters.date-min' id="filter-date-min" placeholder="MM/DD/YYYY"/>
                            </x-input.group>
                            <x-input.group inline for="filter-date-max" label="End Date">
                                <x-input.date name='filters.date-max' id="filter-date-max" placeholder="MM/DD/YYYY"/>
                            </x-input.group>
                        </div>
                        <div class="w-1/2 pr-2 space-y-4">
                            {{-- <x-input.group inline for="filter-status" label="Status">
                                <x-input.select wire:model.live='filters.status' id="filter-status">
                                    <option value="" disabled>Select Status...</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group> --}}
                            <x-button.link wire:click='resetFilters' class="absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
                        </div>
                    </div>
                {{-- @endif --}}
            </div>
        </div>
        {{-- ***** Table ***** --}}
        <div class="border h-full bg-white border-slate-300 rounded-t-md overflow-clip">
            <div class="__table relative overflow-auto h-full snap-mandatory snap-y">
                <x-table.table>
                    <x-slot name="head">
                        <x-table.heading class="px-4 py-1.5 text-center">
                            <div class="flex items-center">
                                <x-input.checkbox wire:model="selectPage" />
                            </div>
                        </x-table.heading>
                        <x-table.heading class="px-1.5 py-1.5" sortable multi-column wire:click="sortBy('first_name')" :direction="$sorts['first_name'] ?? null">
                            Name
                        </x-table.heading>
                        <x-table.heading class="py-1.5" sortable multi-column wire:click.prevent.live="sortBy('email')" :direction="$sorts['email'] ?? null">
                            Email
                        </x-table.heading>
                        <x-table.heading class="py-1.5" sortable multi-column wire:click.prevent.live="sortBy('email_verified_at')" :direction="$sorts['email_verified_at'] ?? null">
                            Email Verified
                        </x-table.heading>
                        <x-table.heading class="py-1.5" sortable multi-column wire:click.prevent.live="sortBy('role_id')" :direction="$sorts['role_id'] ?? null">
                            Role
                        </x-table.heading>
                        <x-table.heading class="py-1.5" sortable multi-column wire:click.prevent.live="sortBy('last_login')" :direction="$sorts['last_login'] ?? null">
                            Last Active
                        </x-table.heading>
                        <x-table.heading class="px-4 py-1.5 text-center">
                            Action
                        </x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        {{-- TODO: Phase 2 --}}
                        {{-- @if ($selectPage)
                        <x-table.row class="bg-white" wire:key="row-message">
                            <x-table.cell colspan="8">
                                @unless ($selectAll)
                                <div>
                                    <span>You have selected <strong>{{ $users->count() }}</strong> transactions, do you want to select all <strong>{{ $users->total() }}</strong>?</span>
                                    <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                </div>
                                @else
                                <span>You are currently selecting all <strong>{{ $users->total() }}</strong> transactions.</span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                        @endif --}}
                        @forelse ($users as $user)
                        <x-table.row wire:key="{{ $user->id }}" wire:loading.class.delay='opacity-35 animate-pulse'>
                            <x-table.cell class="w-4 px-4 py-1">
                                <div class="flex items-center">
                                    <x-input.checkbox wire:model="selected" value="{{ $user->id }}" />
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex items-center space-x-2">
                                    <div>
                                        @if ($user->image)
                                            <div class="relative">
                                                <div class="w-10 h-10 rounded-full border border-slate-100 overflow-clip">
                                                    <img src="{{ asset("storage/" . $user->image) }}" alt="User Image" class="overflow-clip object-contain object-center h-full">
                                                </div>
                                            </div>
                                        @else
                                            <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                {{ strtoupper(substr($user->first_name, 0, 1)) . strtoupper(substr($user->last_name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-odc-blue-800">
                                            {{ $user->first_name . ' ' . $user->last_name }}
                                        </span>
                                        <span class="text-slate-500">
                                            {{ '@' . $user->username }}
                                        </span>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $user->email }}
                            </x-table.cell>
                            <x-table.cell>
                                @if ($user->email_verified_at)
                                <span class="inline-flex items-center space-x-2 text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                    </svg>
                                    <span>
                                        {{ $user->email_verified_at }}
                                    </span>
                                </span>
                                @else
                                <span class="inline-flex items-center space-x-2 text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                    </svg>
                                    <span>
                                        Waiting for verification
                                    </span>
                                </span>
                                @endif
                            </x-table.cell>
                            <x-table.cell>
                                {{ $user->role->name }}
                            </x-table.cell>
                            <x-table.cell>
                                @if ($user->last_login)
                                {{ $user->last_login }}
                                @else
                                {{ $user->role->name }} haven't logged in yet
                                @endif
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
                                            <ul class="py-2 text-xs text-slate-700 dark:text-slate-200" aria-labelledby="dropdownDefault">
                                                <li>
                                                    <button wire:click="edit({{ $user->id }})" type="button"
                                                        class="w-full text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out group flex items-center px-4 py-2 hover:text-white
                                                        hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                        dark:hover:bg-slate-600 dark:hover:text-white">
                                                        <x-svg-icon
                                                            class="scale-90 text-blue-secondary group-hover:text-white"
                                                            name="edit"
                                                            />
                                                        <span class="ml-3 text-xs text-blue-secondary group-hover:text-white">
                                                            Edit
                                                        </span>
                                                    </button>
                                                </li>
                                                <li>
                                                    <button 
                                                        wire:click="delete({{ $user->id }})"
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
                            <x-table.cell class="w-4 px-4 py-4 opacity-75 animate-pulse" colspan="7">
                                <div class="flex items-center justify-center gap-1">
                                    <x-svg-icon name="users" class="scale-75"/>
                                    <span class="font-base font-bold">No users found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @endforelse
                        {{-- @isset($users)
                            @forelse ($users as $user)
                                <x-table.row wire:key="{{ $user->id }}" wire:loading.class.delay='opacity-35 animate-pulse'>
                                    <x-table.cell class="w-4 px-4 py-1">
                                        <div class="flex items-center">
                                            <x-input.checkbox wire:model="selected" value="{{ $user->id }}" />
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <div class="flex items-center space-x-2">
                                            <div>
                                                @if ($user->image)
                                                    <div class="relative">
                                                        <div class="w-10 h-10 rounded-full overflow-clip">
                                                            <img src="{{ asset("storage/" . $user->image) }}" alt="User Image">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                        {{ strtoupper(substr($user->first_name, 0, 1)) . strtoupper(substr($user->last_name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-odc-blue-800">
                                                    {{ $user->first_name . ' ' . $user->last_name }}
                                                </span>
                                                <span class="text-slate-500">
                                                    {{ '@' . $user->username }}
                                                </span>
                                            </div>
                                        </div>
                                    </x-table.cell>
                                    <x-table.cell>
                                        {{ $user->email }}
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if ($user->email_verified_at)
                                        <span class="inline-flex items-center space-x-2 text-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                            </svg>
                                            <span>
                                                {{ $user->email_verified_at }}
                                            </span>
                                        </span>
                                        @else
                                        <span class="inline-flex items-center space-x-2 text-yellow-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                            </svg>
                                            <span>
                                                Waiting for verification
                                            </span>
                                        </span>
                                        @endif
                                    </x-table.cell>
                                    <x-table.cell>
                                        {{ $user->role->name }}
                                    </x-table.cell>
                                    <x-table.cell>
                                        @if ($user->last_login)
                                        {{ $user->last_login }}
                                        @else
                                        {{ $user->role->name }} haven't logged in yet
                                        @endif
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
                                                    <ul class="py-2 text-xs text-slate-700 dark:text-slate-200" aria-labelledby="dropdownDefault">
                                                        <li>
                                                            <button wire:click="edit({{ $user->id }})" type="button"
                                                                class="w-full text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out group flex items-center px-4 py-2 hover:text-white
                                                                hover:bg-gradient-to-br hover:from-blue-primary hover:to-blue-secondary
                                                                dark:hover:bg-slate-600 dark:hover:text-white">
                                                                <x-svg-icon
                                                                    class="scale-90 text-blue-secondary group-hover:text-white"
                                                                    name="edit"
                                                                    />
                                                                <span class="ml-3 text-xs text-blue-secondary group-hover:text-white">
                                                                    Edit
                                                                </span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button 
                                                                wire:click="delete({{ $user->id }})"
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
                                    <x-table.cell class="w-4 px-4 py-4 opacity-75 animate-pulse" colspan="7">
                                        <div class="flex items-center justify-center gap-1">
                                            <x-svg-icon name="user" class="scale-75"/>
                                            <span class="font-base font-bold">No users found...</span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                            @endforelse
                        @else
                            <x-table.row wire:loading.class.delay='opacity-35 animate-pulse'>
                                <x-table.cell class="w-4 px-4 py-4 opacity-75 animate-pulse" colspan="7">
                                    <div class="flex items-center justify-center gap-1">
                                        <x-svg-icon name="user" class="scale-75"/>
                                        <span class="font-base font-bold">No users found...</span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endisset --}}
                    </x-slot>
                </x-table.table>
            </div>
        </div>
        <div class="h-16 w-full flex rounded-b-lg items-center justify-between bg-slate-50 border-t-0 border border-slate-300 ">
            <span class="ml-5 inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                <span class="me-1">{{ $users->count() }}</span>
                <span>Total Users</span>
            </span>
            <div class="mr-5 flex flex-col items-center my-2">
                {{ $users->links('livewire::tailwind') }}
            </div>
        </div>
    </div>
    {{-- ***** Create Modal ***** --}}
    <div x-data="{ open: @entangle('showCreateModal') }">
        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                <div x-cloak @click.prevent="open = false" x-show="open"
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
                    class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
                >
                    <div class="flex items-center justify-between space-x-4">
                        <h1 class="text-xl font-medium text-gray-800 ">Create User</h1>
                    </div>
    
                    <p class="mt-2 text-base text-slate-500">
                        Kindly review the fields for user creation before submitting.
                    </p>
    
                    <div class="mt-5">
                        <form wire:submit.prevent="register" enctype="multipart/form-data">
                            
                            {{-- * User Image, First Name, Last Nama & Username --}}
                            <div 
                                x-data="{ uploading: false, progress: 10 }"
                                x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false"
                                x-on:livewire-upload-cancel="uploading = false"
                                x-on:livewire-upload-error="uploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                class="flex space-x-4"
                            >
                                <div class="flex flex-col space-y-2.5">
                                    <div class="min-w-64 min-h-64 w-64 h-64 border border-slate-200 rounded-full overflow-clip">
                                        @if ($newImage)
                                            <img src="{{ $newImage->temporaryUrl() }}" alt="newimage" class="overflow-clip object-contain object-center h-full">
                                        @elseif ($image)
                                            <img src="{{ asset('storage/' . $image) }}" alt="image" class="rounded-full overflow-clip object-cover">
                                        @else 
                                            <div class="relative inline-flex items-center justify-center text-8xl text-slate-600 bg-slate-100 
                                            w-64 h-64 rounded-full">
                                                {{ strtoupper(substr($first_name, 0, 1)) . strtoupper(substr($last_name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <x-form.error name="newImage"/>
                                    </div>
                                    <div class="flex flex-col w-full space-y-2">
                                        
                                        <div class="grid grid-cols-2 grid-rows-1 gap-2">
                                            <label for="file" class="cursor-pointer flex items-center px-4 py-2 space-x-2 rounded-md border border-slate-300 text-blue-primary text-xs tracking-widest uppercase hover:bg-slate-100">
                                                <x-svg-icon name="change" class="w-[16px] h-[16px]"/>
                                                <span>Change</span>
                                            </label>
                                            <input type="file" id="file" wire:model="newImage" class="hidden">
                                            <button type="button" class="cursor-pointer flex items-center px-4 py-2 space-x-2 rounded-md border border-slate-300 text-blue-primary text-xs tracking-widest uppercase hover:bg-slate-100">
                                                <x-svg-icon name="trash" class="w-[16px] h-[16px]"/>
                                                <span>Remove</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="relative w-full">
                                    <div class="w-full h-4 pb-8">
                                        <div x-show.transition="uploading" class="rounded-xl bg-gray-dark">
                                            <div
                                                class="pl-2 text-center text-xs text-white bg-odc-blue-700 rounded-xl"
                                                x-bind:style="`width: ${progress}%`"
                                                role="progressbar"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                                x-text="progress ? progress + '%': '0%'"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    {{-- * First Name --}}
                                    <x-form.input name="first_name" labelname="First Name" type="text" wire:model.lazy='first_name' class="-mt-[2rem]"/>
                                    {{-- * Last Name --}}
                                    <x-form.input name="last_name" labelname="Last Name" type="text" wire:model.lazy='last_name' class="-mt-2"/>
                                    {{-- * Username --}}
                                    <x-form.input name="username" labelname="Username" type="text" wire:model.lazy='username' class="-mt-2"/>
                                    {{-- * Role --}}
                                    <x-form.field>
                                        <select name="role_id" wire:model="role_id" id="role_id"
                                        class="appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
                                        ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0">
                                            <option value="{{ $defaultRoleId }}" selected>User</option>
                                            @foreach($roles as $role)
                                                @if($role->name !== 'User')
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <x-form.label class="-translate-y-[6px] peer-focus:-translate-y-[6px]" name="role" labelname="Roles"/>
                                        <x-form.error name="role"/>
                                    </x-form.field>
                                </div>
                            </div>
                    
                            {{-- * Email --}}
                            <x-form.input name="email" labelname="Email" type="email" wire:model.blur='email'/>
                    
                            {{-- * Password --}}
                            <x-form.field>
                                <x-form.input-password name="password" labelname="Password" type="password" wire:model.live.debounce.150ms='password'/>
                                <div class="mt-4 relative w-full flex items-center text-sm text">
                                    <span class="absolute left-0 text-odc-blue-800 text-opacity-55">{{ $strengthLevels[$strengthScore]['status'] ?? 'Weak' }}</span>
                                    <div class="absolute right-0 flex gap-2">
                                        @for($i = 1; $i <= $strengthScore; $i++)
                                        <div class="{{$strengthLevels[$strengthScore]['color']}} bg-gray-dark rounded-full h-2 w-12"></div>
                                        @endfor
                                    </div>
                                </div>
                            </x-form.field>
                    
                            {{-- * Confirm Password --}}
                            <x-form.input name="password_confirmation" labelname="Confirm Password" type="password" wire:model='password_confirmation'/>
                    
                            <div class="flex items-center justify-end mt-10 space-x-2">
                                <x-primary-button wire:loading.remove @click.prevent="open = false" type="button" class="border border-slate-300">Cancel</x-primary-button>
                                <p wire:loading class="hidden animate-pulse text-sm text-slate-500">Creating new user...</p>
                                <button wire:click="register" wire:loading.attr="disabled" class="px-3 py-2 text-xs tracking-widest text-white uppercase transition-colors duration-200 transform bg-odc-blue-800 rounded-md dark:bg-odc-blue-700 dark:hover:bg-odc-blue-800 dark:focus:bg-odc-blue-800 
                                hover:bg-odc-blue-900 focus:outline-none focus:bg-odc-blue-600 focus:ring focus:ring-odc-blue-400 focus:ring-opacity-50">
                                    <span class="text-white">
                                        <svg wire:loading wire:target="register" aria-hidden="true" role="status" class="hidden w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#FFF"/>
                                        </svg>
                                        {{ __('Register') }}
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ***** Edit Modal ***** --}}
    <div x-data="{ open: @entangle('showEditModal') }"> 
        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                <div x-cloak @click.prevent="modelOpen = false" x-show="open"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-opacity bg-slate-500 bg-opacity-40" aria-hidden="true"
                ></div>

                <div x-cloak x-show="open"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
                >
                    <div class="flex items-center justify-between space-x-4">
                        <h1 class="text-xl font-medium text-gray-800 ">Edit User</h1>
                    </div>

                    <p class="mt-2 text-base text-slate-500">
                        Kindly review the edited fields before updating.
                    </p>

                    <div class="mt-5">
                        <form wire:submit.prevent="update" enctype="multipart/form-data">

                            {{-- * User Image, First Name, Last Nama & Username --}}
                            <div
                                x-data="{ uploading: false, progress: 10 }"
                                x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false"
                                x-on:livewire-upload-cancel="uploading = false"
                                x-on:livewire-upload-error="uploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress" 
                                class="flex space-x-4"
                            >
                                <div class="flex flex-col space-y-2.5">
                                    <div class="min-w-64 min-h-64 w-64 h-64 border border-slate-200 rounded-full overflow-clip">
                                        @if ($newImage)
                                            <img src="{{ $newImage->temporaryUrl() }}" alt="newimage" class="overflow-clip object-contain object-center h-full">
                                        @elseif ($image)
                                            <img src="{{ asset('storage/' . $image) }}" alt="image" class="overflow-clip object-contain object-center h-full">
                                        @else 
                                            <div class="relative inline-flex items-center justify-center text-8xl text-slate-600 bg-slate-100 
                                            w-64 h-64 rounded-full">
                                                {{ strtoupper(substr($first_name, 0, 1)) . strtoupper(substr($last_name, 0, 1)) }}
                                            </div>
                                        @endif
                                        
                                    </div>
                                    <div class="flex flex-col w-full space-y-2">
                                        <x-form.error name="newImage"/>
                                        
                                        <div class="grid grid-cols-2 grid-rows-1 gap-2">
                                            <label for="file2" class="cursor-pointer flex items-center px-4 py-2 space-x-2 rounded-md border border-slate-300 text-blue-primary text-xs tracking-widest uppercase hover:bg-slate-100">
                                                <x-svg-icon name="change" class="w-[16px] h-[16px]"/>
                                                <span>Change</span>
                                            </label>
                                            <input type="file" id="file2" wire:model="newImage" class="hidden">
                                            <button wire:click='removeFile' type="button" class="flex items-center px-4 py-2 space-x-2 rounded-md border border-slate-300 text-blue-primary text-xs tracking-widest uppercase hover:bg-slate-100">
                                                <x-svg-icon name="trash" class="w-[16px] h-[16px]"/>
                                                <span>Remove</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="relative w-full">
                                    {{-- * Loading --}}
                                    <div class="w-full h-4 pb-8">
                                        <div x-show.transition="uploading" class="rounded-xl bg-gray-dark">
                                            <div
                                                class="pl-2 text-center text-xs text-white bg-odc-blue-700 rounded-xl"
                                                x-bind:style="`width: ${progress}%`"
                                                role="progressbar"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                                x-text="progress ? progress + '%': '0%'"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    {{-- * First Name --}}
                                    <x-form.input name="first_name" labelname="First Name" type="text" wire:model.lazy='first_name' class="-mt-[2rem]"/>
                                    {{-- * Last Name --}}
                                    <x-form.input name="last_name" labelname="Last Name" type="text" wire:model.lazy='last_name' class="-mt-2"/>
                                    {{-- * Username --}}
                                    <x-form.input name="username" labelname="Username" type="text" wire:model='username' class="-mt-2"/>
                                    {{-- * Role --}}
                                    <x-form.field>
                                        <select name="role_id" wire:model="role_id"
                                        class="appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
                                        ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0">
                                            <option value="{{ $defaultRoleId }}">User</option>
                                            @foreach($roles as $role)
                                                @if($role->name !== 'User')
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        {{-- <select name="role_id" wire:model="role_id"
                                        class="appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
                                        ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0">
                                            <option value="">Select Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select> --}}
                                        <x-form.label class="-translate-y-[6px] peer-focus:-translate-y-[6px]" name="role" labelname="Role"/>
                                        <x-form.error name="role"/>
                                    </x-form.field>
                                </div>
                            </div>
                           
                            
                            {{-- * Email --}}
                            <x-form.input name="email" labelname="Email" type="email" wire:model.blur='email'/>

                            
                    
                            <div class="flex items-center justify-end mt-10 space-x-2">
                                <x-primary-button wire:loading.remove @click="open = false" type="button" class="border border-slate-300">Cancel</x-primary-button>
                                <p wire:loading class="hidden animate-pulse text-sm text-slate-500">Updating user...</p>
                                <button wire:loading.attr="disabled" type="submit" class="px-3 py-2 text-xs tracking-widest text-white uppercase transition-colors duration-200 transform bg-odc-blue-800 rounded-md dark:bg-odc-blue-700 dark:hover:bg-odc-blue-800 dark:focus:bg-odc-blue-800 
                                hover:bg-odc-blue-900 focus:outline-none focus:bg-odc-blue-600 focus:ring focus:ring-odc-blue-400 focus:ring-opacity-50">
                                    <span class="text-white">
                                        <svg wire:loading wire:target="update" aria-hidden="true" role="status" class="hidden w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#FFF"/>
                                        </svg>
                                        {{ __('Update') }}
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
                    class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
                >
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 w-12 h-12 text-red-primary dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <div class="mb-3 flex flex-col">
                            <h1 class="text-xl font-extrabold text-gray-800 ">Are you sure you want to delete this user?</h1>
                            
                            <div class="flex justify-center ">
                                <div class="flex items-center space-x-2 px-4 py-2.5 rounded-full bg-slate-50">
                                    <div>
                                        @if ($image)
                                            <div class="relative">
                                                <div class="w-10 h-10 rounded-full border border-slate-100 overflow-clip">
                                                    <img src="{{ asset("storage/" . $image) }}" alt="User Image" class="overflow-clip object-contain object-center h-full">
                                                </div>
                                            </div>
                                        @else
                                            <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                {{ strtoupper(substr($first_name, 0, 1)) . strtoupper(substr($last_name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col text-left ">
                                        <span class="font-bold text-odc-blue-800">
                                            {{ $first_name . ' ' . $last_name }}
                                        </span>
                                        <span class="text-slate-500">
                                            {{ '@' . $username }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="mb-4 text-sm font-normal text-gray-500 opacity-55 dark:text-gray-400">This action is irrevocable!</h3>
                        <div class="space-x-4">
                            <x-primary-button @click="open = false" wire:loading.attr="disabled" type="button"  class="border border-slate-300">No, cancel</x-primary-button>
                            <button wire:click="confirmDelete" wire:loading.attr="disabled" type="submit" class="px-3 py-2 text-xs tracking-widest text-white uppercase transition-colors duration-200 transform bg-odc-red-600 rounded-md dark:bg-odc-red-700 dark:hover:bg-odc-red-800 dark:focus:bg-odc-red-800 hover:bg-odc-red-700 focus:outline-none focus:bg-odc-red-600 focus:ring focus:ring-odc-red-400 focus:ring-opacity-50">
                                <svg wire:loading wire:target="confirmDelete" aria-hidden="true" role="status" class="hidden w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#FFF"/>
                                </svg>
                                <span>Yes, delete it</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ***** Toast ***** --}}
    <x-action-message-toast on="create-user-success" icon="check-circle" key="User Creation Successful!">
        {{ __("You've created a new user!") }}
    </x-action-message-toast>
    <x-action-message-toast on="update-user-success" icon="check-circle" key="User Updated Successful!">
        {{ __("You've updated the user successfully!") }}
    </x-action-message-toast>
    <x-action-message-toast on="delete-user-success" icon="check-circle" key="User Deleted Successful!">
        {{ __("You've deleted the user successfully!") }}
    </x-action-message-toast>
</div>
