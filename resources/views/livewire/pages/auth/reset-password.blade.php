<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;
use ZxcvbnPhp\Zxcvbn;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
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
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
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
        $this->passwordConfirmation = $value;
        $this->updatedPassword($value);
    }

}; ?>

<div>
    <form wire:submit="resetPassword">
        <div class="flex flex-col items-center">
            <h4 class="mt-10 text-lg font-semibold uppercase tracking-widest text-white">Set Your New Password</h4>
        </div>

        <div class="mb-4 text-sm text-center text-slate-300 dark:text-gray-400">
            Make sure you create a strong password.
        </div>

        <x-form.input name="email" labelname="Email" type="email" wire:model='email'/>

        <x-form.field>
            <x-form.input-password name="password" labelname="Password" type="password" wire:model.live.debounce.150ms='password'/>
            <div class="mt-3 relative w-full flex items-center text-sm text">
                <span class="absolute left-0 text-white text-opacity-55">{{ $strengthLevels[$strengthScore]['status'] ?? 'Weak' }}</span>
                <div class="absolute right-0 flex gap-2">
                    @for($i = 1; $i <= $strengthScore; $i++)
                    <div class="{{$strengthLevels[$strengthScore]['color']}} bg-gray-dark rounded-full h-2 w-12"></div>
                    @endfor
                </div>
            </div>
        </x-form.field>

        <x-form.input name="password_confirmation" labelname="Password Confirmation" type="password" wire:model='password_confirmation'/>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</div>
