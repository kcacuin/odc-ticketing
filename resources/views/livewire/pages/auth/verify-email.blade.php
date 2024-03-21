<?php

use App\Livewire\Actions\Logout;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'Verification Link Sent!');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="mx-28">
    <div class="text-sm mb-5 text-white dark:text-gray-400">
        <div class="flex flex-col items-center">
            <x-odc-support-app-logo />
            <h4 class="my-6 text-lg font-semibold uppercase tracking-widest text-white">Verification</h4>
            <span class="text-center">
                <p>Please wait, for the admin is verifying your registration credentials.</p>
                <span>Thank you.</span>
            </span>
        </div>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <x-primary-button wire:click="sendVerification">
            {{ __('Resend Verification Email') }}
        </x-primary-button>
        <x-primary-button-tr wire:click="logout" type="submit" class="flex justify-center pointer-events-none">
            <span class="underline font-light pointer-events-auto">
                {{ __('Log Out') }}
            </span>
        </x-primary-button-tr>

    </div>

    <x-flash-message key="status" icon="info-circle">Your account is currently being verified by the administrator.</x-flash-message>
    <x-flash-message key="success" icon="info-circle">Your account is currently being verified by the administrator.</x-flash-message>
</div>

