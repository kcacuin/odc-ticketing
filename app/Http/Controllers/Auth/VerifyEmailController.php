<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        // * Check if the email domain is allowed
        if (!$this->isValidEmailDomain($request->user()->email)) {
            return redirect()->route('/register')
                            ->withErrors(['email' => 'Invalid email domain.']);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }

    /**
     * Check if the email domain is allowed.
     *
     * @param string $email
     * @return bool
     */
    private function isValidEmailDomain(string $email): bool
    {
        // Extract the domain from the email address
        $domain = substr(strrchr($email, "@"), 1);

        // Check if the domain matches the allowed domain
        return $domain === 'odecci.com';
    }
}
