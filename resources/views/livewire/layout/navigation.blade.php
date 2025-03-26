<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false  }" class="odc-nav h-screen group relative w-28 ease-out duration-300 hover:w-72">

    {{-- * Primary Navigation --}}
    <div x-on:mouseover="open = true" x-on:mouseleave="open = false" 
    {{-- :class="theme === '--dark' ? 'border border-border' : ''" --}}
    class="odc-nav-bg-overlay relative overflow-hidden h-full bg-gradient-to-br from-primary to-secondary w-28 ease-out duration-300 group-hover:w-72 shadow-lg lg:block">
        <div class="relative h-full flex flex-col mx-6">
            <div class="absolute items-center justify-center pt-6">
                <div class="odc-logo-clip shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center space-y-1">
                        <x-application-logo-full />
                        <div x-cloak :class="open ? 'visible opacity-100 transition ease-in-out delay-100' : 'invisible opacity-0 transition ease-in-out delay-100'">
                            <x-application-logo-full-label/>
                        </div>
                    </a>
                </div>
            </div>
            <nav class="h-full mt-32 mb-4 flex flex-col justify-between">
                <div>
                    <div class="pb-2">
                        <span class="ml-4 uppercase tracking-widest text-xs text-center text-slate-400 text-opacity-65 font-thin">Main</span>
                    </div>
                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')" wire:navigate>
                        <x-svg-icon
                            class="scale-90"
                            name="dashboard"
                            :active="request()->routeIs('dashboard')" />
                        <x-nav-link-icon
                            :active="request()->routeIs('dashboard')">
                                Dashboard
                        </x-nav-link-icon>
                    </x-nav-link>
                    <x-nav-link
                        :href="route('tickets.index')"
                        :active="request()->routeIs('tickets.index')" wire:navigate>
                        <x-svg-icon
                            class="scale-90"
                            name="ticket"
                            :active="request()->routeIs('tickets.index')" />
                        <x-nav-link-icon class="flex text-nowrap"
                            :active="request()->routeIs('tickets.index')">
                            <span class="whitespace-nowrap">Ticket List</span>
                        </x-nav-link-icon>
                    </x-nav-link>
                </div>
                <div>
                    <div class="pb-2">
                        <span 
                            x-cloak
                            x-show="open"
                            x-transition:enter.duration.500ms
                            x-transition:leave.duration.50ms
                            class="ml-5 uppercase tracking-widest text-xs text-center text-slate-400 text-opacity-65 font-thin">System Settings</span>
                    </div>
                    <x-nav-link
                        :href="route('settings.index')"
                        :active="request()->routeIs('settings.index')" wire:navigate
                    >
                        <x-svg-icon
                            class="scale-90"
                            name="settings"
                            :active="request()->routeIs('settings.index')"
                        />
                        <x-nav-link-icon
                            :active="request()->routeIs('settings.index')"
                            alt="settings"
                        >
                            Settings
                        </x-nav-link-icon>
                    </x-nav-link>
                    @php
                        $user = auth()->user()['userType'];
                    @endphp
                    @if ($user === 2)
                    <x-nav-link
                        :href="route('admin.index')"
                        :active="request()->routeIs('admin.index')" wire:navigate
                       >
                        <x-svg-icon
                            class="scale-90"
                            name="admin"
                            :active="request()->routeIs('admin.index')"
                            />
                        <x-nav-link-icon
                            :active="request()->routeIs('admin.index')"
                            alt="admin">
                            Admin
                        </x-nav-link-icon>
                    </x-nav-link>
                    @endif
                </div>
            </nav>
        </div>
        <div class="absolute top-0 right-0 w-[1px] h-full bg-nav-border"/>
    </div>

    {{-- * Responsive Navigation Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index')" wire:navigate>
                {{ __('Tickets') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>

</nav>
