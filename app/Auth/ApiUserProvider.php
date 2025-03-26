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
        if (session()->has('api_user')) {
            $userData = session('api_user');
            $user = new User();
            $user->forceFill([
                'id' => $userData['id'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'fname' => $userData['fname'],
                'lname' => $userData['lname'],
                "mname" => $userData['mname'],
                "suffix" => $userData['suffix'],
                "email" => $userData['email'],
                "gender" => $userData['gender'],
                "employeeId" => $userData['employeeId'],
                "jwtoken" => $userData['jwtoken'],
                "filePath" => $userData['filePath'],
                "active" => $userData['active'],
                "cno" => $userData['cno'],
                "address" => $userData['address'],
                "status" => $userData['status'],
                "dateCreated" => $userData['dateCreated'],
                "dateUpdated" => $userData['dateUpdated'],
                "deleteFlag" => $userData['deleteFlag'],
                "createdBy" => $userData['createdBy'],
                "updatedBy" => $userData['updatedBy'],
                "dateDeleted" => $userData['dateDeleted'],
                "deletedBy" => $userData['deletedBy'],
                "dateRestored" => $userData['dateRestored'],
                "restoredBy" => $userData['restoredBy'],
                "department" => $userData['department'],
                "agreementStatus" => $userData['agreementStatus'],
                "rememberToken" => $userData['rememberToken'],
                "userType" => $userData['userType'],
                "employeeType" => $userData['employeeType'],
                "salaryType" => $userData['salaryType'],
                "rate" => $userData['rate'],
                "daysInMonth" => $userData['daysInMonth'],
                "payrollType" => $userData['payrollType'],
                "dateStarted" => $userData['dateStarted'],
                "position" => $userData['position'],
                "positionLevelId" => $userData['positionLevelId'],
                "managerId" => $userData['managerId'],
                "isLoggedIn" => $userData['isLoggedIn'],
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