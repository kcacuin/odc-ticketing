<?php

namespace App\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Http;

class ApiUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        // This could be used to fetch user data from API by ID
        // For now, we'll return a user model with data from session
        if (session()->has('api_user')) {
            $userData = session('api_user');
            $user = new User();
            $user->forceFill([
                'id' => $userData['id'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'first_name' => $userData['fname'],
                'last_name' => $userData['lname'],
                // Add other fields as needed
            ]);
            return $user;
        }
        
        return null;
    }

    public function retrieveByToken($identifier, $token)
    {
        // Not used in this implementation
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Not used in this implementation
    }

    public function retrieveByCredentials(array $credentials)
    {
        // This method is called during Auth::attempt()
        // We'll just return a temporary user object that will be validated by validateCredentials
        $user = new User();
        $user->username = $credentials['username'];
        return $user;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // This is where we'll check with the API
        try {
            $data = [
                "username" => $credentials['username'],
                "password" => $credentials['password'],
                "ipaddress" => request()->ip(),
                "location" => "web", 
                "rememberToken" => isset($credentials['remember']) ? $credentials['remember'] : null
            ];

            $response = Http::withToken(getenv('APP_API_TOKEN'))
                ->post(getenv('APP_API_URL').'/User/isLoggedIn', $data);
            
            $userData = $response->json();
            
            if (isset($userData[0]) && $userData[0]['isLoggedIn'] === true) {
                // Store the API user data in session for later use
                session(['api_user' => $userData[0]]);
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}