<?php

namespace App\Services;

use App\Models\User;
use App\Models\Admin\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class AuthService
{


    /**
     * Log in a user.
     *
     * @param array $credentials
     * @param string $guard a ('web' for users, 'admin' for admins)
     * @return bool
     */
    public function login(array $formData, string $guard): bool
    {
        $remember = $formData['remember'] ?? false;
        unset($formData['remember']);
        if (Auth::guard($guard)->attempt($formData, $remember)) {
            session()->regenerate();
            return true;
        }

        throw ValidationException::withMessages([
            'error' => trans('These credentials do not match our records.'),
        ]);
    }

    /**
     * Log out the current user.
     *
     * @return void
     */
    public function logout(): void
    {
        $guard = $this->getAuthenticatedGuard();

        if ($guard) {
            Auth::guard($guard)->logout();
            session()->invalidate();
            session()->regenerateToken();
        }
    }


    /**
     * Get the currently authenticated guard.
     *
     * @return string|null
     */
    protected function getAuthenticatedGuard(): ?string
    {
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }

        if (Auth::guard('web')->check()) {
            return 'web';
        }

        return null;
    }

    /**
     * Register a new user.
     *
     * @param array $formData
     * 
     * @return User
     */
    public function register(array $formData): User
    {

        $user = User::query()->create([
            'name' => $formData['name'],
            'email' => $formData['email'],
            'password' => Hash::make($formData['password']),
        ]);

        Auth::login($user);


        if (Auth::check()) {
            return $user;
        }


        throw new \Exception('Failed to authenticate the user.');
    }

    /**
     * Send a password reset link to the user.
     *
     * @param array $data
     * @return string
     */
    public function sendResetLink(array $data): string
    {
        $status = Password::sendResetLink($data);

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages(['email' => __($status)]);
        }

        return $status;
    }

    /**
     * Reset the user's password.
     *
     * @param array $data
     * @return string
     */
    public function resetPassword(array $data): string
    {
        $status = Password::reset($data, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();

            event(new PasswordReset($user));
        });

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages(['email' => __($status)]);
        }

        return $status;
    }
}
