<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Auth\ApiGuard;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    // public function login(): void
    // {
    //     $this->validate();

    //     // $data = [
    //     //     "username" => $this->form->username,
    //     //     "password" => $this->form->password,
    //     //     "ipaddress" => request()->ip(),
    //     //     "location" => "string",
    //     //     "rememberToken" => $this->form->remember ? Str::random(60) : null
    //     // ];

    //     // // dd($data);

    //     // $resp =  Http::withToken(getenv('APP_API_TOKEN'))->post(getenv('APP_API_URL').'/User/isLoggedIn', $data); 
        
    //     // $userData = $resp->json();

    //     // Session::regenerate();

    //     // Session::flash('login-success', "Welcome, " . Auth::user()->first_name ."!");

    //     // $this->redirect(
    //     //     session('url.intended', RouteServiceProvider::HOME),
    //     //     navigate: true
    //     // );

    //     if (Auth::attempt([
    //         'username' => $this->form->username,
    //         'password' => $this->form->password,
    //         'remember' => $this->form->remember,
    //     ])) {
    //         // User is authenticated
    //         Session::regenerate();
            
    //         // Get the user data from session
    //         $user = session('api_user');
    //         Session::flash('login-success', "Welcome, " . $user['fname'] . "!");
            
    //         $this->redirect(
    //             session('url.intended', RouteServiceProvider::HOME),
    //             navigate: true
    //         );
    //     } else {
    //         // Authentication failed
    //         throw ValidationException::withMessages([
    //             'username' => 'These credentials do not match our records.',
    //         ]);
    //     }
    // }

    public function login(): void
    {
        $this->validate();
        
        $data = [
            "username" => $this->form->username,
            "password" => $this->form->password,
            "ipaddress" => request()->ip(),
            "location" => "web",
            "rememberToken" => $this->form->remember ? \Illuminate\Support\Str::random(60) : null
        ];
        
        try {
            $response = Http::withToken(getenv('APP_API_TOKEN'))
                ->post(getenv('APP_API_URL').'/User/isLoggedIn', $data);
            
            $userData = $response->json();
            
            if (isset($userData[0]) && $userData[0]['isLoggedIn'] === true) {
                session(['api_user' => $userData[0]]);
                session(['auth.api_logged_in' => true]);
                
                Session::regenerate();

                Session::flash('login-success', "Welcome, " . $userData[0]['fname'] . "!");
                
                $this->redirect(
                    session('url.intended', RouteServiceProvider::HOME),
                    navigate: true
                );
            } else {
                throw ValidationException::withMessages([
                    'username' => 'These credentials do not match our records.',
                ]);
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'username' => 'An error occurred while attempting to log in.',
            ]);
        }
    }
}; ?>




<div>
    <x-auth-session-status class="mb-4" icon="check-circle" key="New Password Has Been Created!" :status="session('status')" />

    <div class="flex flex-col items-center">
        <x-odc-support-app-logo />
        <h4 class="mt-10 text-lg font-semibold uppercase tracking-widest text-white">Login</h4>
    </div>

    <form wire:submit="login" class="w-full">
        <div class="relative">
            <x-form.input name="username" labelname="Username" type="text" wire:model='form.username' />

            <x-form.input name="form.password" labelname="Password" type="password" wire:model='form.password'/>
        </div>

        <div class="mt-5 flex gap-8 justify-between">
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

        <div class="mt-10 flex flex-col justify-center" >
            <x-primary-button wire:click='login' wire:loading.attr="disabled" class="flex justify-center">
                <span class="text-blue-primary">
                    <svg wire:loading.delay wire:target="login" aria-hidden="true" role="status" class="inline w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                    </svg>
                    <span>Log<span wire:loading.delay>ging</span> In<span wire:loading.delay>...</span></span>
                </span>
            </x-primary-button>
        </div>
    </form>

</div>
