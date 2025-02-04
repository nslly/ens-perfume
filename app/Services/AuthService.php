<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Dotenv\Exception\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Access\AuthorizationException;

class AuthService
{


    /**
     * Log in a user.
     *
     * @param array $credentials
     * 
     * @return bool
     */
    public function login(array $formData): bool
    {
        return Auth::attempt($formData);
    }

    /**
     * Log out the current user.
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
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

        $user = User::create([
            'name' => $formData['name'],
            'email' => $formData['email'],
            'password' => Hash::make($formData['password']),
        ]);

        Auth::login($user);

        return $user;
    }

    /**
     * Send a password reset link to the user.
     *
     * @param string $email
     * 
     * @return string
     */
    public function sendResetLink(string $email): string
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status !== Password::RESET_LINK_SENT) {
            throw new AuthorizationException('Unable to send password reset link.');
        }

        return 'Password reset link sent.';
    }

    /**
     * Reset the user's password.
     *
     * @param array $data
     * 
     * @return string
     */
    public function resetPassword(array $data): string
    {
        $status = Password::reset($data, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });

        if ($status !== Password::PASSWORD_RESET) {
            throw new AuthorizationException('Unable to reset password.');
        }

        return 'Password reset successfully.';
    }
}
