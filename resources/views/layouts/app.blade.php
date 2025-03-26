<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - {{ config('app.name', 'Odecci Ticketing') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="shortcut icon" href="{{ asset('storage/img/odc-favicon.svg') }}" type="image/x-icon">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
        <link
            href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
            rel="stylesheet"
        />
        @stack('styles')
        {{-- @vite(['resources/css/app.css', 'resources/css/build.css', 'resources/css/filepond.css', 'resources/js/app.js']) --}}
        @vite(['resources/css/app.css', 'resources/css/filepond.css', 'resources/js/app.js'])
        <x-rich-text::styles theme="richtextlaravel" data-turbo-track="false" />
    </head>
    <body 
        x-data="{
            theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? '--dark' : '--light'),
            init() {
                // Set the initial theme based on the preferred color scheme or saved theme
                const preferredScheme = window.matchMedia('(prefers-color-scheme: dark)');
                const updateTheme = () => {
                    this.theme = preferredScheme.matches ? '--dark' : '--light';
                    localStorage.setItem('theme', this.theme);
                };

                // Update the theme if the preferred color scheme changes
                preferredScheme.addEventListener('change', updateTheme);

                // Set the theme initially
                updateTheme();
            }
        }" 
        :class="theme"
        x-init="init(); $watch('theme', value => localStorage.setItem('theme', value))"
        x-cloak
        class="font-sans antialiased overflow-hidden"
        {{-- x-data="{ theme: localStorage.getItem('theme') || '--light' }" 
        :class="theme"
        x-init="theme = localStorage.getItem('theme') || '--light'; $watch('theme', value => localStorage.setItem('theme', value))"
        x-cloak
        class="font-sans antialiased overflow-hidden" --}}
    >
        <div class="flex min-h-screen overflow-hidden">
            <livewire:layout.navigation />

            <div class="flex flex-col w-full">
                @if (isset($header))
                    <header class="relative bg-gradient-to-br from-primary to-secondary shadow">
                        <div class="relative odc-header-overlay z-10 flex items-center justify-between h-20 w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                            <div class="mx-4">
                                <button 
                                    class="px-2 py-1 rounded bg-cta hover:bg-cta/50 text-cta-text"
                                    x-text="theme === '--light' ? 'Switch to Dark Mode' : 'Switch to Light Mode'"
                                    x-on:click="theme = theme === '--light' ? '--dark' : '--light'"
                                />
                            </div>
                            <div>
                                <div class="hidden space-x-2 sm:flex sm:items-center sm:ms-6">
                                    <div class="flex justify-center mt-3">
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
                                            class="relative"
                                        >
                                        @php
                                            $ticketModel = new \App\Models\Ticket;
                                            $latestTickets = $ticketModel->getLatestWeeklyTickets();
                                        @endphp
                                            <button 
                                                x-ref="button"
                                                x-on:click="toggle()"
                                                :aria-expanded="open"
                                                :aria-controls="$id('dropdown-button')"
                                                type="button" 
                                            >
                                                <span class="sr-only">Notifications</span>
                                                <div>
                                                    <x-svg-icon name="bell" class="text-white w-7 h-7" />
                                                    @if (!empty($latestTickets))
                                                    <span class="relative flex h-[10px] w-[10px]">
                                                        <span class="animate-ping absolute -top-7 -end-4 inline-flex h-full w-full rounded-full bg-odc-red-400 opacity-75"></span>
                                                        <span class="relative inline-flex -top-7 -end-4 rounded-full h-[10px] w-[10px] bg-odc-red-500"></span>
                                                    </span>
                                                    @endif
                                                </div>
                                            </button>
                                            <div
                                                x-ref="panel"
                                                x-show="open"
                                                x-transition.origin.top.right
                                                x-on:click.outside="close($refs.button)"
                                                :id="$id('dropdown-button')"
                                                style="display: none;"
                                                class="absolute right-0 z-50 mt-2 w-[30rem] h-[30rem] rounded-lg border border-border bg-primary-background shadow-lg overflow-clip"
                                            >
                                                <div class="p-5 h-full overflow-y-auto">
                                                    <h3 class="mb-4 text-xl font-bold text-text">Notifications</h3>
                                                    
                                                    @foreach($latestTickets as $date => $tickets)
                                                    <div>
                                                        <div class="border-b border-border">
                                                            <time class="text-base font-semibold text-text">{{ Carbon\Carbon::parse($date)->format('F j, Y') }}</time>
                                                        </div>
                                                        <ol class="my-2 space-y-2">
                                                            @foreach($tickets as $ticket) 
                                                            <li class="border border-border rounded-md">
                                                                <a href="{{ route('tickets.show', $ticket) }}" class="items-center block p-3 rounded-md sm:flex hover:bg-white/5">
                                                                    <div class="mr-3">
                                                                        @if ($ticket->user->image)
                                                                            <div class="relative">
                                                                                <div class="w-10 h-10 rounded-full overflow-clip">
                                                                                    <img src="{{ asset("storage/" . $ticket->user->image) }}" alt="User Image">
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div class="relative inline-flex items-center justify-center text-slate-600 bg-slate-300 w-10 h-10 rounded-full">
                                                                                {{ strtoupper(substr($ticket->user->fname, 0, 1)) . strtoupper(substr($ticket->user->lname, 0, 1)) }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="text-gray-600 dark:text-gray-400">
                                                                        <div class="text-sm font-normal">
                                                                            <span class="font-medium text-text">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span> 
                                                                            created an incident requested by 
                                                                            <span class="font-medium text-text">{{ Str::limit($ticket->requested_by, 20) }}</span>
                                                                            -
                                                                            <span class="bg-slate-100 text-odc-blue-900 text-xs font-normal me-2 px-2.5 py-0.5 rounded dark:bg-gray-600 dark:text-gray-300">{{ Str::limit($ticket->client, 20) }}</span>
                                                                        </div>
                                                                        <div class="text-sm font-bold text-text/50">
                                                                            <span>"{{ Str::limit($ticket->title, 45) }}"</span>
                                                                        </div>
                                                                        <div class="text-xs font-normal">
                                                                            <span>{{ $ticket->created_at->diffForHumans() }}</span>
                                                                            •
                                                                            <x-badge class="{{ $ticket->status_color }} {{ $ticket->status_text_color }}">{{ $ticket->status->name }}</x-badge>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ol>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- * Profile's Dropdown --}}
                                    <div class="flex justify-end">
                                        <div x-data="{ open: false }" class="relative inline-block">
                                        <button
                                            type="button"
                                            class="inline-flex items-center justify-center space-x-2 rounded-full p-1 text-sm font-semibold leading-5 text-white  focus:ring focus:ring-odc-blue-400 focus:ring-opacity-50 active:border-odc-blue-700 active:bg-odc-blue-700 dark:focus:ring-odc-blue-400 dark:focus:ring-opacity-90"
                                            id="tk-dropdown"
                                            aria-haspopup="true"
                                            x-bind:aria-expanded="open"
                                            x-on:click="open = true"
                                        >
                                        @if (Auth::check() && Auth::user()->image)
                                            <div class="relative">
                                                <div class="w-10 h-10 rounded-full overflow-clip">
                                                    <img src="{{ asset("storage/" . Auth::user()->image) }}" alt="User Image">
                                                </div>

                                                <x-svg-icon name="chev-down" class="absolute bg-white w-[10.2px] h-[10.2px] rounded-[50%] left-[27px] bottom-0 text-slate-600 ring-2 ring-[#1B557B]" />
                                            </div>
                                        @else
                                            <div class="relative inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-300">
                                                {{-- <div class="w-10 h-10  rounded-full overflow-clip"> --}}
                                                    <span class="absolute z-10 font-medium text-slate-600">{{ strtoupper(substr(Auth::user()->fname, 0, 1)) . strtoupper(substr(Auth::user()->lname, 0, 1)) }}</span>
                                                {{-- </div> --}}
                                                {{-- * DP-Container --}}
                                                {{-- <span class="absolute w-[40px] h-[40px] overflow-hidden rounded-[50%] after:content-['']  --}}
                                                {{-- after:absolute after:w-[13px] after:h-[13px] after:shadow-[0px_0px_0px_2000px_#f1f5f9] after:rounded-[50%] after:left-1/2 after:bottom-0 --}}
                                                {{-- after:translate-x-[5.4px] after:translate-y-[1.2px]"></span> --}}
                                                <x-svg-icon name="chev-down" class="absolute bg-slate-100 w-[10.2px] h-[10.2px] rounded-[50%] left-[27px] bottom-0  text-slate-600 ring-2 ring-[#1B557B]"/>
                                            </div>
                                        @endif
                                        </button>
                                        
                                        <div
                                            x-cloak
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 scale-90"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-90"
                                            x-on:click.outside="open = false"
                                            role="menu"
                                            aria-labelledby="tk-dropdown"
                                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-lg shadow-xl"
                                        >
                                            <div
                                            class="divide-y divide-border rounded-lg bg-primary-background border border-border ring-1 ring-black ring-opacity-5"
                                            >
                                            <div class="space-y-1 p-2.5">
                                                <a
                                                role="menuitem"
                                                href="{{ route('profile') }}"
                                                class="group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium text-text/75 bg-primary-background hover:bg-slate-200/50 hover:text-text active:border-blue-100 dark:hover:bg-white/10"
                                                >
                                                <svg
                                                    class="hi-mini hi-user-circle inline-block size-5 flex-none opacity-25 group-hover:opacity-50"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                    fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                                                    clip-rule="evenodd"
                                                    />
                                                </svg>
                                                <span class="grow">Profile</span>
                                                </a>
                                            </div>
                                            <div class="space-y-1 p-2.5">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        role="menuitem"
                                                        class="group flex w-full items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-left text-sm font-medium text-red-primary/75 bg-primary-background hover:bg-slate-200/50 hover:text-red-primary active:border-odc-red-100 dark:hover:bg-white/10"
                                                    >
                                                        <svg
                                                        class="hi-mini hi-lock-closed inline-block size-5 flex-none opacity-25 group-hover:opacity-50"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        aria-hidden="true"
                                                        >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                                            clip-rule="evenodd"
                                                        />
                                                        
                                                        </svg>
                                                        <span class="grow">Log out</span>
                                                    </button>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="-me-2 flex items-center sm:hidden">
                                    <button @click="open = ! open" class="inline-flex items-center text-white justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 w-full h-[1px] bg-nav-border"/>
                    </header>
                @endif

                <main class="odc-main-con-height overflow-y-auto">
                    {{ $slot }}
                </main>

                <x-flash-message key="login-success" icon="check-circle">Your session is now active.</x-flash-message>
            </div>

        </div>
        <livewire:scripts />
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        @stack('scripts')
    </body>
</html>
