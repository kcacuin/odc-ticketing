<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left text-xl text-white dark:text-gray-200 leading-3">
            <p class="text-xs font-bold uppercase">Incident</p>
            <div x-data="{ copied: false, timer: null, showclipboard: false, }" x-init="timer = null">
                <button class="font-thin" 
                @click.prevent="
                    clearTimeout(timer); 
                    navigator.clipboard.writeText('{{ $ticket->number }}').then(() => {
                        copied = true;
                        timer = setTimeout(() => copied = false, 1000);
                    }),
                    showclipboard = false
                "
                @mouseover="showclipboard = true"
                @mouseout="showclipboard = false"
                class="relative"
                >
                    ODC{{ $ticket->number }}
                    <span x-show="copied"  x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="absolute -translate-y-4 translate-x-1 opacity-75"
                    >
                        <span class="flex space-x-1 items-center text-xs ">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs">Copied</span>
                        </span>
                    </span>
                    <span x-show="showclipboard" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                        class="absolute -translate-y-4 translate-x-1 opacity-75"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </span>
                </button>
            </div>
        </h2>
    </x-slot>
    @section('title', 'Incident ' . $ticket->number)

    <div class="mt-6 px-6 py-6 max-w-6xl mx-auto bg-primary-background rounded-md border border-border">
        <div class="flex justify-between">
            <div class="mr-32">
                <div>
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-xl text-text font-semibold">
                                {!! clean($ticket->title) !!}
                            </h1>
                            <div class="flex space-x-1 text-xs">
                                <span class="text-text/35">
                                    {{ $ticket->created_at->diffForHumans() }} by
                                </span>
                                <span class="font-bold text-text/45">
                                    {!! clean($ticket->user->first_name . ' ' . $ticket->user->last_name) !!}
                                </span>
                            </div>
                        </div>
                        <div>
                            <a class="group font-bold transition rounded-full cursor-pointer" href="{{ route('tickets.edit', $ticket) }}">
                                <div>
                                    <x-svg-icon
                                        class="scale-75 text-text/50 group-hover:text-white group-hover:scale-[.85] transition-all"
                                        name="edit"
                                    />
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="prose my-6 py-6 border-t text-text/75 border-b border-border">
                        {!! clean($ticket->issue->toTrixHTML()) !!}
                    </div>
                </div>
                <div>
                    @auth
                    <div class="mb-2">
                        <h3 class="text-lg font-bold text-text">Notes</h3>
                    </div>
                    <div class="ml-4">
                        <ol class="relative pl-2 border-s border-border">
                            @php
                                $timeline = $ticket->changes->merge($notes);
                                $timeline = $timeline->sortByDesc('created_at');
                            @endphp
                            @if ($timeline->isNotEmpty())
                                @foreach ($timeline as $item)
                                    @if ($item instanceof \App\Models\TicketChange)
                                        @if ($item->field == 'status') 
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-300 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="items-center justify-between w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="flex space-x-1 items-center text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                        <span>has updated</span>
                                                        <a href="#" class="font-semibold text-blue-600 hover:underline">Incident {{ $ticket->number }}</a> 
                                                        <span>status from</span>
                                                        <span>
                                                            <x-badge class="mb-1 
                                                            {{ $ticket->getUpdatedStatusColor($item->previous_value) . ' ' . $ticket->getUpdatedStatusTextColor($item->previous_value) }}">{{ $item->previous_value }}</x-badge>
                                                            <span class="pl-1">to</span>
                                                            <x-badge class="mb-1 {{ $ticket->getUpdatedStatusColor($item->new_value) . ' ' . $ticket->getUpdatedStatusTextColor($item->new_value) }}">{{ $item->new_value }}</x-badge>
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif ($item->field == 'number')
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="items-center justify-between w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                        has updated incident number from 
                                                        <span class="font-semibold">{{ $item->previous_value }}</span>
                                                        to 
                                                        <a href="#" class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">{{ $item->new_value }}</a> 
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif ($item->field == 'date_received')
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="items-center justify-between w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                        has changed date receieved from 
                                                        <span class="font-semibold">{{ $item->previous_value }}</span>
                                                        to 
                                                        <a href="#" class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">{{ $item->new_value }}</a> 
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif ($item->field == 'files' && $item->file_added)
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="items-center justify-between w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                        attached a file
                                                        <a href="{{ asset('storage/' . $item->file_path .'/'. $item->file_name )}}" class="font-bold text-odc-blue-600">{{ $item->new_value }}</a>
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif ($item->field == 'files' && $item->file_deleted)
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="items-center justify-between w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                        <span class="text-odc-red-700">deleted</span>
                                                        an attached file
                                                        <span class="font-bold text-odc-red-700">{{ $item->file_name }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif ($item->field == 'title')
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="items-center justify-between w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                        has updated the <span class="italic">title</span> from 
                                                        <span class="font-semibold">{{ $item->previous_value }}</span>
                                                        to 
                                                        <a href="#" class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">{{ $item->new_value }}</a> 
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif ($item->field == 'issue')
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="flex flex-col w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <div class="flex items-center justify-between text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <p class="flex space-x-1">
                                                            <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                            <span class="flex items-center space-x-1">
                                                                <span>has updated the issue</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                                                    <path fill-rule="evenodd" d="M13.836 2.477a.75.75 0 0 1 .75.75v3.182a.75.75 0 0 1-.75.75h-3.182a.75.75 0 0 1 0-1.5h1.37l-.84-.841a4.5 4.5 0 0 0-7.08.932.75.75 0 0 1-1.3-.75 6 6 0 0 1 9.44-1.242l.842.84V3.227a.75.75 0 0 1 .75-.75Zm-.911 7.5A.75.75 0 0 1 13.199 11a6 6 0 0 1-9.44 1.241l-.84-.84v1.371a.75.75 0 0 1-1.5 0V9.591a.75.75 0 0 1 .75-.75H5.35a.75.75 0 0 1 0 1.5H3.98l.841.841a4.5 4.5 0 0 0 7.08-.932.75.75 0 0 1 1.025-.273Z" clip-rule="evenodd" />
                                                                </svg>
                                                            </span>
                                                        </p>
                                                        <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    </div>
                                                    <div class="pt-4 space-y-2 w-full text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <div class="p-3 bg-slate-50 text-xs text-slate-400 border border-border rounded-lg">
                                                            <div class="trix-content">
                                                                {!! clean($item->previous_value) !!}
                                                            </div>
                                                        </div>
                                                        <div class="p-3 bg-slate-50 text-xs border border-border rounded-lg">
                                                            <div class="trix-content">
                                                                {!! clean($item->new_value) !!}
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif ($item->field == 'requested_by')
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="items-center justify-between w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                        has updated requested by from
                                                        <span class="font-semibold">{{ $item->previous_value }}</span>
                                                        to 
                                                        <a href="#" class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">{{ $item->new_value }}</a> 
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif ($item->field == 'client')
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="items-center justify-between w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                        has updated the client from
                                                        <span class="font-semibold">{{ $item->previous_value }}</span>
                                                        to 
                                                        <a href="#" class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">{{ $item->new_value }}</a> 
                                                    </div>
                                                </div>
                                            </li>
                                        @elseif ($item->field == 'product')
                                            <li class="mb-10 ms-6 flex">
                                                <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                    @if ($item->user->image)
                                                        <div class="relative">
                                                            <div class="w-10 h-10 rounded-full overflow-clip">
                                                                <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                            {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </span>
                                                <div class="items-center justify-between w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                        has updated the product from
                                                        <span class="font-semibold">{{ $item->previous_value }}</span>
                                                        to 
                                                        <a href="#" class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">{{ $item->new_value }}</a> 
                                                    </div>
                                                </div>
                                            </li>
                                        @else
                                        @endif
                                    @elseif ($item instanceof \App\Models\Note)
                                        <li class="mb-10 ms-6 flex">
                                            <span class="absolute flex items-center justify-center w-10 h-10 bg-primary-background rounded-full -start-5">
                                                @if ($item->user->image)
                                                    <div class="relative">
                                                        <div class="w-10 h-10 rounded-full overflow-clip">
                                                            <img src="{{ asset("storage/" . $item->user->image) }}" alt="User Image">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-100 w-10 h-10 rounded-full">
                                                        {{ strtoupper(substr($item->user->first_name, 0, 1)) . strtoupper(substr($item->user->last_name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </span>
                                            <div class="w-full p-4 bg-primary-background border border-border rounded-lg shadow-sm">
                                                <div class="items-center justify-between mb-3 sm:flex">
                                                    <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ $item->created_at->diffForHumans() }}</time>
                                                    <div class="text-sm font-normal text-gray-500 lex dark:text-gray-300">
                                                        <span class="font-medium text-slate-500">{{ $item->user->first_name . ' ' . $item->user->last_name }}</span>
                                                    </div>
                                                </div>
                                                <div class="p-3 text-xs font-normal text-gray-500 border border-border rounded-lg bg-background">{!! clean($item->body) !!}</div>
                                            </div>
                                            @if (Auth::user()->id === $item->user_id)
                                            <div
                                                x-data="{
                                                    open: false,
                                                    toggle() {
                                                        if (this.open) {
                                                            return this.close()
                                                        }
            
                                                        this.$refs.button.focus()
            
                                                        this.open = true
                                                    },
                                                    close(focusAfter) {
                                                        if (! this.open) return
            
                                                        this.open = false
            
                                                        focusAfter && focusAfter.focus()
                                                    }
                                                }"
                                                x-on:keydown.escape.prevent.stop="close($refs.button)"
                                                x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                                                x-id="['dropdown-button']"
                                                class="relative flex items-center justify-center"
                                            >
                                                <button
                                                    x-ref="button"
                                                    x-on:click="toggle()"
                                                    :aria-expanded="open"
                                                    :aria-controls="$id('dropdown-button')"
                                                    type="button"
                                                    class="text-slate-500"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                    </svg>
                                                </button>
                                                <div
                                                    x-ref="panel"
                                                    x-show="open"
                                                    x-transition.origin.bottom.right
                                                    x-on:click.outside="close($refs.button)"
                                                    :id="$id('dropdown-button')"
                                                    style="display: none;"
                                                    class="absolute z-10 left-6 bottom-2 rounded-md"
                                                >
                                                    <form action="{{ route('tickets.notes.destroy', ['ticket' => $ticket, 'note' => $item])}}"
                                                        method="POST" class="mt-2">
                                                        @csrf
                                                        @method('DELETE')
                    
                                                        <x-danger-button type="submit">
                                                            <x-svg-icon class="scale-75 mr-2" name="trash"/>
                                                            Delete
                                                        </x-danger-button>
                                                    </form>
                                                </div>
                                            </div>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <p class="px-6 py-2 text-xs text-slate-500 bg-primary-background border border-border rounded-lg shadow-sm">No updates yet recorded for this ticket.</p>
                            @endif
                        </ol>
                    </div>
                    <form action="{{ route('tickets.notes.store', $ticket) }}" method="POST" class="mt-2">
                        @csrf
                        <div class="relative">
                            <div class="mt-6">
                                <x-form.trix-input value="{!! $ticket->notes->body->toTrixHTML() !!}" id="body" name="body" class="h-52 rounded-md overflow-y-auto" placeholder="Write your notes here..."/>
                            </div>
                            <div class="relative">
                                <div class="absolute right-4 bottom-2">
                                    <button type="submit" class="group text-blue-secondary hover:text-odc-blue-950">
                                        <x-svg-icon class="transition group-hover:drop-shadow-xl group-focus    :trangray-x-1 " name="send"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endauth

                    <div class="mt-2">
                        {{ $notes->fragment('notes')->links() }}
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-4 w-80 text-text text-xs">
                <div class="flex flex-col rounded border border-border overflow-clip">
                    <div class="p-3 bg-primary-background border-b border-border">
                        <h3>Your request has been submitted</h3>
                    </div>
                    <div class="p-3 bg-primary-background">
                        <div class="flex justify-between py-3">
                            <p class="font-bold">Number</p>
                            {{ $ticket->number }}
                        </div>
                        <div class="flex justify-between py-3">
                            <p class="font-bold">Status</p>
                            <x-badge class="{{ $ticket->status_color }} . ' ' . {{ $ticket->status_color }}">{{ $ticket->status->name }}</x-badge>
                        </div>
                        <div class="flex justify-between py-3">
                            <p class="font-bold">Created</p>

                            <div x-data="{ tooltip: false }" class="relative inline-flex">
                                <span x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-between py-3">
                            <p class="font-bold">Updated</p>
                            <div x-data="{ tooltip: false }" class="relative inline-flex">
                                <span x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false">
                                    {{ $ticket->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col rounded border border-border overflow-clip">
                    <div class="p-3 flex justify-between border-b border-border bg-primary-background">
                        <h3>Attachments</h3>
                        <x-svg-icon class="scale-90" name="attachment" />
                    </div>
                    <div class="p-3 flex flex-col bg-primary">
                        @if ($files->isNotEmpty())
                            <ul class="flex flex-col gap-4">
                                <div>
                                    @foreach($files as $file)
                                    <li class="flex items-center justify-between" x-data="{ submitting: false }">
                                        <a href="{{ asset('storage/attached_files/' . $file->file_path) }}" target="_blank">{{ $file->file_name }}</a>
                                        <form action="{{ route('tickets.files.destroy', ['ticket' => $ticket, 'file' => $file])}}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <div x-data="{ modelOpen: false }">
                                                <button @click.prevent="modelOpen =!modelOpen" class="text-red-primary">
                                                    <x-svg-icon name="trash" class="scale-75" />
                                                </button>

                                                <div x-show="modelOpen" x-bind:class="{ 'pointer-events-none': submitting }" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                    <div class="flex items-center justify-center min-h-screen text-center md:items-center sm:block sm:p-0">
                                                        <div x-cloak @click.prevent="modelOpen = false" x-show="modelOpen"
                                                            x-transition:enter="transition ease-out duration-300 transform"
                                                            x-transition:enter-start="opacity-0"
                                                            x-transition:enter-end="opacity-100"
                                                            x-transition:leave="transition ease-in duration-200 transform"
                                                            x-transition:leave-start="opacity-100"
                                                            x-transition:leave-end="opacity-0"
                                                            class="fixed inset-0 transition-opacity bg-background0 bg-opacity-55" aria-hidden="true"
                                                        ></div>

                                                        <div x-cloak x-show="modelOpen"
                                                            x-transition:enter="transition ease-out duration-300 transform"
                                                            x-transition:enter-start="opacity-0 trangray-y-4 sm:trangray-y-0 sm:scale-95"
                                                            x-transition:enter-end="opacity-100 trangray-y-0 sm:scale-100"
                                                            x-transition:leave="transition ease-in duration-200 transform"
                                                            x-transition:leave-start="opacity-100 trangray-y-0 sm:scale-100"
                                                            x-transition:leave-end="opacity-0 transate-y-4 sm:trangray-y-0 sm:scale-95"
                                                            class="inline-block w-full max-w-sm p-4 my-20 overflow-hidden text-left transition-all transform bg-primary-background rounded-lg shadow-xl 2xl:max-w-2xl"
                                                        >
                                                            <div class="p-4 md:p-5 text-center">
                                                                <svg class="mx-auto mb-4 w-12 h-12 text-red-primary dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                                </svg>
                                                                <h1 class="mb-3 text-xl font-extrabold text-gray-800 ">Are you sure?</h1>
                                                                <h3 class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400">This action will delete <span class="font-bold">{{ $file->file_name }}</span>!</h3>
                                                                <div class="space-x-4">
                                                                    <x-primary-button @click.prevent="modelOpen = false" type="button" class="border border-gray-300">No, cancel</x-primary-button>
                                                                    <button :disabled="submitting" class="px-3 py-2 text-xs tracking-widest text-white uppercase transition-colors duration-200 transform bg-odc-red-600 rounded-md dark:bg-odc-red-700 dark:hover:bg-odc-red-800 dark:focus:bg-odc-red-800 hover:bg-odc-red-700 focus:outline-none focus:bg-odc-red-600 focus:ring focus:ring-odc-red-400 focus:ring-opacity-50">
                                                                        <span x-show="!submitting">Yes, delete it</span>
                                                                        <span x-show="submitting">
                                                                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                                                            </svg>
                                                                            Deleting...
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </li>
                                    @endforeach
                                </div>
                            </ul>
                        @else
                            <p class="text-slate-100/25">No files attached to this ticket.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-flash-message key="update-ticket-success" icon="check-circle"/>
</x-app-layout>
