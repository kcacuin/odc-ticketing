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

<nav x-data="{ open: false }" class="odc-nav h-screen group relative bg-white dark:bg-gray-800 w-28 ease-out duration-300 hover:w-72 dark:border-gray-700">

    {{-- * Primary Navigation --}}
    <div class="odc-nav-bg-overlay overflow-hidden h-full bg-gradient-to-br from-blue-primary to-blue-secondary dark:bg-gray-700 w-28 ease-out duration-300 group-hover:w-72 shadow-lg lg:block">
        <div class="h-full flex flex-col mx-6">
            <div class="flex items-center justify-center pt-6 round">
                <div class="odc-logo-clip shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo-full class="block h-9 w-auto" />
                    </a>
                </div>
            </div>
            <nav class="h-full mt-6 flex flex-col justify-between">
                <div class="flex flex-col">
                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')" wire:navigate>
                        <x-svg-icon
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
                            name="ticket"
                            :active="request()->routeIs('tickets.index')" />
                        <x-nav-link-icon class="flex text-nowrap"
                            :active="request()->routeIs('tickets.index')">
                            Ticket<span class="text-transparent">_</span>List
                        </x-nav-link-icon>
                    </x-nav-link>
                </div>
                {{-- <div>
                    <x-nav-link
                        :href="route('settings')"
                        :active="request()->routeIs('settings')">
                        <x-svg-icon
                            name="settings"
                            :active="request()->routeIs('settings')" />
                        <x-nav-link-icon
                            :active="request()->routeIs('settings')"
                            src="{{ asset('storage/icons/settings.svg') }}"
                            alt="settings">
                            Settings
                        </x-nav-link-icon>
                    </x-nav-link>
                    <x-nav-link
                        :href="route('admin')"
                        :active="request()->routeIs('admin')">
                        <x-svg-icon
                            name="admin"
                            :active="request()->routeIs('admin')" />
                        <x-nav-link-icon
                            :active="request()->routeIs('admin')"
                            src="{{ asset('storage/icons/admin.svg') }}"
                            alt="admin">
                            Admin
                        </x-nav-link-icon>
                    </x-nav-link>
                </div> --}}
            </nav>
        </div>
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

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>

</nav>
