<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        Session::flash('login-success', "Welcome Back!". " " . Auth::user()->username);

        $this->redirect(
            session('url.intended', RouteServiceProvider::HOME),
            navigate: true
        );
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col items-center">
        <x-odc-support-app-logo />
        <h4 class="mt-10 text-lg font-semibold uppercase tracking-widest text-white">Login</h4>
    </div>

    <form wire:submit="login" class="w-full">
        <div class="relative">
            {{-- * Email --}}
            <x-form.input name="email" labelname="Email" type="email" wire:model='form.email' />

            {{-- * Password --}}
            <x-form.input name="form.password" labelname="Password" type="password" wire:model='form.password'/>
        </div>

        <div class="mt-5 flex gap-8 justify-between">
            <!-- Remember Me -->
            <div class="flex">
                <label for="remember" class="inline-flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-odc-blue-600 shadow-sm focus:ring-odc-blue-500 dark:focus:ring-odc-blue-600 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-white dark:text-white">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white dark:text-white hover:text-slate-300 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-odc-blue-500 dark:focus:ring-offset-white" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-10 flex flex-col justify-center">
            <x-primary-button class="flex justify-center">
                <span class=" text-blue-primary">
                    {{ __('Log in') }}
                </span>
            </x-primary-button>
            <x-primary-button-tr class="flex justify-center pointer-events-none" >
                <a class="underline font-light pointer-events-auto text-white dark:text-white hover:text-slate-300 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-odc-blue-500 dark:focus:ring-offset-white" href="{{ route('register')}}" wire:navigate>
                    {{ __('Register') }}
                </a>
            </x-primary-button-tr>
        </div>
    </form>

</div>
