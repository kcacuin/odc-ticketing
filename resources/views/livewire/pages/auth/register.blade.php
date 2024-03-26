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
                <x-form.input name="first_name" labelname="First Name" type="text" wire:model='first_name' class="w-full"/>
                <x-form.input name="last_name" labelname="Last Name" type="text" wire:model='last_name' class="w-full"/>
            </div>
        </div>

        <x-form.input name="username" labelname="Username" type="text" wire:model='username'/>

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

        <x-form.input name="password_confirmation" labelname="Confirm Password" type="password" wire:model='password_confirmation'/>

        <div class="mt-6 flex flex-col justify-center">
            <x-primary-button wire:click="register" class="flex justify-center">
                <svg wire:loading wire:target="register" aria-hidden="true" role="status" class="inline w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                </svg>
                <span class=" text-blue-primary" wire:loading.remove>
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
