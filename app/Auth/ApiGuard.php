<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class ApiGuard implements Guard
{
    use GuardHelpers;

    protected $request;
    protected $provider;
    protected $user;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        if (session()->has('api_user')) {
            $this->user = $this->provider->retrieveById(session('api_user')['id']);
        }

        return $this->user;
    }

    public function validate(array $credentials = [])
    {
        return $this->provider->validateCredentials(
            $this->provider->retrieveByCredentials($credentials),
            $credentials
        );
    }

    public function attempt(array $credentials = [], $remember = false)
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        if ($this->provider->validateCredentials($user, $credentials)) {
            $this->login($user);
            return true;
        }

        return false;
    }

    public function login(Authenticatable $user, $remember = false)
    {
        $this->user = $user;
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        // Clear the user from the guard
        $this->user = null;
        
        // Remove API user data from session
        session()->forget('api_user');
        
        // You might also want to make an API call to logout the user on the API side if needed
        // For example:
        // Http::withToken(getenv('APP_API_TOKEN'))->post(getenv('APP_API_URL').'/User/logout', [
        //     'username' => session('api_user.username')
        // ]);
    }
}