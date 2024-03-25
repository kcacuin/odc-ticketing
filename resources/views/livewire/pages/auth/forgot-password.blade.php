<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="mx-32">
    <div class="flex flex-col items-center mb-6">
        <h4 class="mt-10 text-lg font-semibold uppercase tracking-widest text-white">Reset Your Password</h4>
    </div>

    <div class="mb-4 text-sm text-white dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        {{-- * Email --}}
        <x-form.input name="email" labelname="Email" type="email" wire:model='form.email'/>

        <div class="flex items-center justify-between mt-4">
            <x-primary-button-tr class="flex justify-center pointer-events-none" >
                <a class="underline font-light pointer-events-auto text-white dark:text-white hover:text-slate-300 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-odc-blue-500 dark:focus:ring-offset-white" href="{{ route('login')}}" wire:navigate>
                    {{ __('Back to login') }}
                </a>
            </x-primary-button-tr>
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</div>
