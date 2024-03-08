<?php

use App\Mail\VerificationEmail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\AllowedEmailDomain;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Contracts\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use ZxcvbnPhp\Zxcvbn;

new #[Layout('layouts.guest')] class extends Component
{
    use WithFileUploads;

    public string $first_name = '';
    public string $last_name = '';
    public $image;
    public string $username = '';
    public string $email = '';
    public $text;
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
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', new AllowedEmailDomain('odecci.com')],
            'password' => ['required', 'string', 'min:7', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        if ($this->image) {
            $validated['image'] = $this->image->store('images');
        }

        // Mail::to($user->email)->send(new VerificationEmail($user));
        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        Session::flash('success', 'Registration successful!');

        $this->redirect(Route('verification.notice'));
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
    <div class="flex flex-col items-center mb-6">
        <h4 class="mt-8 text-lg font-semibold uppercase tracking-widest text-white">Register</h4>
    </div>

    <form wire:submit="register" enctype="multipart/form-data">

        <div
            x-data="{ isUploading: false, progress: 5 }"
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false; progress: 5"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
            class="flex items-center gap-4 w-96"
            >
            <div x-data="{ fileName: '' }" class="bg-transparent h-screen max-h-48 w-full max-w-48 relative rounded-md">
                <div x-ref="dnd"
                    class="relative overflow-clip h-full p-6 text-white font-light border-2 border-white border-dashed rounded-md cursor-pointer">
                    <input accept=".jpg, .jpeg, .png, .webp" wire:model='image' type="file" name="image" x-ref="file" @change="fileName = $refs.file.files[0].name"
                        class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                        @dragover="$refs.dnd.classList.add('bg-odc-blue-700')"
                        @dragleave="$refs.dnd.classList.remove('bg-odc-blue-700')"
                        @drop="$refs.dnd.classList.remove('bg-odc-blue-700')"
                    />
                    <div class="flex flex-col items-center justify-center text-xs text-center">
                        @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" alt="image" class="absolute p-2 -z-10 inset-0 w-full h-full object-cover">
                        @else
                        <x-svg-icon name="export"/>
                        <div class="mt-2 text-center">
                            <p>Drag and Drop here</p>
                            <p>or</p>
                            <p class="underline">Browse Files</p>
                        </div>
                        @endif
                        <p class="mt-2 text-white text-opacity-55"
                            x-text="fileName ? '' : 'Supported File Types: PNG, JPG, JPEG and WEBP only.'"></p>
                    </div>
                </div>
                <div class="mt-2 relative w-full">
                    <div x-show.transition="isUploading" class="rounded-xl bg-gray-dark">
                        <div
                            class="pl-2 text-center text-xs text-white bg-blue-500 rounded-xl"
                            x-bind:style="`width: ${progress}%`"
                            role="progressbar"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            x-text="progress ? progress + '%': '0%'"
                            >
                        </div>
                    </div>
                </div>
                <div x-text="fileName" class="mt-2 text-xs text-center text-white"></div>
            </div>
            <div class="relative">
                {{-- * First Name --}}
                <x-form.input name="first_name" labelname="First Name" type="text" wire:model='first_name' class="w-full"/>
                {{-- * Last Name --}}
                <x-form.input name="last_name" labelname="Last Name" type="text" wire:model='last_name' class="w-full"/>
            </div>
        </div>

        {{-- * Username --}}
        <x-form.input name="username" labelname="Username" type="text" wire:model='username'/>

        {{-- * Email --}}
        <x-form.input name="email" labelname="Email" type="email" wire:model='email'/>

        {{-- * Password --}}
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

        {{-- * Confirm Password --}}
        <x-form.input name="password_confirmation" labelname="Confirm Password" type="password" wire:model='password_confirmation'/>

        <div class="mt-6 flex flex-col justify-center">
            <x-primary-button class="flex justify-center">
                <span class=" text-blue-primary">
                    {{ __('Register') }}
                </span>
            </x-primary-button>
            <x-primary-button-tr class="flex justify-center pointer-events-none" >
                <a class="underline font-light pointer-events-auto text-white dark:text-white hover:text-slate-300 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-odc-blue-500 dark:focus:ring-offset-white" href="{{ route('login')}}" wire:navigate>
                    {{ __('Already registered?') }}
                </a>
            </x-primary-button-tr>
        </div>
    </form>
</div>
