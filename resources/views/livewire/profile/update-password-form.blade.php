<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;
use ZxcvbnPhp\Zxcvbn;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';
    public int $strengthScore = 1;
    public array $strengthLevels = [
        1 => ['status' => 'Weak', 'color' => 'odc-bg-clr-red'],
        2 => ['status' => 'Fair', 'color' => 'odc-bg-clr-yellow'],
        3 => ['status' => 'Good', 'color' => 'odc-bg-clr-lightblue'],
        4 => ['status' => 'Strong', 'color' => 'odc-bg-clr-green'],
    ];

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }

    public function generatePassword(): void
    {
        $lowercase = range('a', 'z');
        $uppercase = range('A', 'Z');
        $digits = range(0,9);
        $special = ['!', '@', '#', '$', '%', '^', '*'];
        $chars = array_merge($lowercase, $uppercase, $digits, $special);
        $length = 12;
        do {
            $password = array();

            for ($i = 0; $i <= $length; $i++) {
                $int = rand(0, count($chars) - 1);
                $password[] = $chars[$int];
            }

        } while (empty(array_intersect($special, $password)));

        $this->setPasswords(implode('', $password));
    }

    public function updatedPassword($value)
    {
        $this->strengthScore = (new Zxcvbn())->passwordStrength($value)['score'];
    }

    private function setPasswords($value): void
    {
        $this->password = $value;
        $this->password_confirmation = $value;
        $this->updatedPassword($value);
    }

}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        
        <x-form.input name="current_password" labelname="Current Password" type="password" wire:model.blur='current_password'/>
        {{-- <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div> --}}
        <x-form.field>
            <x-form.input-password name="password" labelname="New Password" type="password" wire:model.live.debounce.150ms='password'/>
            <div class="mt-4 relative w-full flex items-center text-sm text">
                <span class="absolute left-0 text-odc-blue-800 text-opacity-55">{{ $strengthLevels[$strengthScore]['status'] ?? 'Weak' }}</span>
                <div class="absolute right-0 flex gap-2">
                    @for($i = 1; $i <= $strengthScore; $i++)
                    <div class="{{$strengthLevels[$strengthScore]['color']}} bg-gray-dark rounded-full h-2 w-12"></div>
                    @endfor
                </div>
            </div>
        </x-form.field>
        {{-- <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div> --}}

        <x-form.input name="password_confirmation" labelname="Confirm Password" type="password" wire:model.blur='password_confirmation'/>
        {{-- <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div> --}}

        <div class="flex items-center gap-4">
            <button wire:click="updatePassword" wire:loading.attr="disabled" class="px-3 py-2 text-xs tracking-widest text-white uppercase transition-colors duration-200 transform bg-odc-blue-800 rounded-md dark:bg-odc-blue-700 dark:hover:bg-odc-blue-800 dark:focus:bg-odc-blue-800 
            hover:bg-odc-blue-900 focus:outline-none focus:bg-odc-blue-600 focus:ring focus:ring-odc-blue-400 focus:ring-opacity-50">
                <span class="text-white">
                    <svg wire:loading wire:target="updatePassword" aria-hidden="true" role="status" class="hidden w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#FFF"/>
                    </svg>
                    {{ __('Save') }}
                </span>
            </button>

            <x-action-message class="me-3 text-odc-blue-600" on="password-updated">
                {{ __('Password is updated!') }}
            </x-action-message>
        </div>
    </form>
</section>
