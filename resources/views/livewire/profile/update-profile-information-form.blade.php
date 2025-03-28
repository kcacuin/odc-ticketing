<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component
{
    use WithFileUploads;

    public string $fname = '';
    public string $lname = '';
    public string $username = '';
    public string $email = '';
    
    public $newImage;
    public $image;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->fname = Auth::user()->fname;
        $this->lname = Auth::user()->lname;
        $this->username = Auth::user()->username;
        $this->email = Auth::user()->email;
        $this->image = Auth::user()->image;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'newImage' => ['image', 'max:5120', 'nullable'],
        ]);

        $filename = null;

        if ($this->newImage) {
            $filename = $this->newImage->store('images');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->update([
            'fname' => $this->fname,
            'lname' => $this->lname,
            'username' => $this->username,
            'email' => $this->email,
            'image' => $filename,
        ]);

        $this->dispatch('profile-updated', name: $user->username);
    }

    public function removeFile()
    {
        if ($this->newImage) {
            $filePath = $this->newImage->getRealPath();
            
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $this->newImage = null;
        } 

        if ($this->image) {
            $filePath = asset('storage/' . $this->image);
            
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $this->image = null;
        } 
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: RouteServiceProvider::HOME);

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-text">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-text">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">

        <div class="flex w-full space-x-8">
            <div>
                <div 
                    x-data="{ uploading: false, progress: 10 }"
                    x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-cancel="uploading = false"
                    x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                    class="flex space-x-4"
                >
                    <div class="flex flex-col space-y-2.5">
                        <div class="min-w-64 min-h-64 w-64 h-64 border border-border rounded-full overflow-clip">
                            @if ($newImage)
                                <img src="{{ $newImage->temporaryUrl() }}" alt="newimage" class="overflow-clip object-contain object-center h-full">
                            @elseif ($image)
                                <img src="{{ asset('storage/' . $image) }}" alt="image" class="rounded-full overflow-clip object-cover">
                            @else 
                                <div class="relative inline-flex items-center justify-center text-8xl text-slate-600 bg-slate-100 
                                w-64 h-64 rounded-full">
                                    {{ strtoupper(substr($fname, 0, 1)) . strtoupper(substr($lname, 0, 1)) }}
                                </div>
                            @endif
                            <x-form.error name="newImage"/>
                        </div>
                        <div class="w-full h-4">
                            <div x-show.transition="uploading" class="rounded-xl bg-gray-dark">
                                <div
                                    class="pl-2 text-center text-xs text-white bg-odc-blue-700 rounded-xl"
                                    x-bind:style="`width: ${progress}%`"
                                    role="progressbar"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                    x-text="progress ? progress + '%': '0%'"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col w-full space-x-2">
                            <div class="grid grid-cols-2 grid-rows-1 gap-2">
                                <label for="file" class="cursor-pointer flex items-center justify-center px-4 py-1 rounded-md bg-cta border border-cta-border text-cta-text text-xs tracking-widest uppercase hover:bg-cta-hover">
                                    <x-svg-icon name="edit" class="size-3"/>
                                    <span class="ml-2">Change</span>
                                </label>
                                <input type="file" id="file" wire:model="newImage" class="hidden">
                                <button wire:click.prevent='removeFile' type="button" class="cursor-pointer flex flex-row items-center justify-center px-4 py-2 rounded-md bg-cta border border-cta-border text-cta-text text-xs tracking-widest uppercase hover:bg-cta-hover">
                                    <x-svg-icon name="trash" class="mb-[1px] w-[15px] h-[15px]"/>
                                    <span class="ml-2">Remove</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-96">
                <x-form.input name="fname" labelname="First Name" type="text" wire:model='fname'/>
                <x-form.input name="lname" labelname="Last Name" type="text" wire:model='lname'/>
                <x-form.input name="username" labelname="Username" type="text" wire:model='username'/>
                <div>
                    <x-form.input name="email" labelname="Email" type="email" wire:model='email'/>
        
                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                {{ __('Your email address is unverified.') }}
        
                                <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>
        
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-teal-600 dark:text-teal-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <div class="flex items-center gap-4">
            <button wire:click="updateProfileInformation" wire:loading.attr="disabled" class="px-3 py-2 text-xs tracking-widest text-cta-text uppercase transition-colors duration-200 transform bg-cta rounded-md 
            hover:bg-odc-blue-900 focus:outline-none focus:bg-cta-active focus:ring focus:ring-odc-blue-400 focus:ring-opacity-50">
                <span class="text-white">
                    <svg wire:loading wire:target="updateProfileInformation" aria-hidden="true" role="status" class="hidden w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#FFF"/>
                    </svg>
                    {{ __('Save') }}
                </span>
            </button>

            <x-action-message class="me-3 text-cta-text" on="profile-updated">
                {{ __("You've successfully updated your profile information!🎉") }}
            </x-action-message>
        </div>
    </form>
</section>
