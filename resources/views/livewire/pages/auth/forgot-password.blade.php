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

    <x-auth-session-status class="mb-4" icon="check-circle" key="Request For New Password Sent!" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        {{-- * Email --}}
        <x-form.input name="email" labelname="Email" type="email" wire:model='email'/>

        <div class="flex items-center justify-between mt-4">
            <x-primary-button-tr wire:loading.remove class="flex justify-center pointer-events-none" >
                <a class="underline font-light pointer-events-auto text-white dark:text-white hover:text-slate-300 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-odc-blue-500 dark:focus:ring-offset-white" href="{{ route('login')}}" wire:navigate>
                    {{ __('Back to login') }}
                </a>
            </x-primary-button-tr>
            <p wire:loading class="animate-pulse text-sm text-slate-500">Sending your request...</p>
            <x-primary-button wire:click='sendPasswordResetLink' wire:loading.attr="disabled">
                <span class="text-blue-primary">
                    <svg wire:loading.delay wire:target="sendPasswordResetLink" aria-hidden="true" role="status" class="inline w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                    </svg>
                    {{ __('Email Password Reset Link') }}
                </span>
            </x-primary-button>
        </div>
    </form>
</div>
