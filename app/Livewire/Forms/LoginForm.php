<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Repository\IUserRepository;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Form;
use Illuminate\Validation\Rules\Password;

class LoginForm extends Form
{
    public ?User $userModel;
    private IUserRepository $userRepository;

    public ?string $email;
    public ?string $username;
    public ?string $password;
    public ?bool $remember;

    public function boot(IUserRepository $repository): void
    {
        $this->userRepository = $repository;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'max:255'],
            'password' => ['required', 'string', Password::defaults()],
            'username' => ['string'],
            'remember' => ['boolean']
        ];
    }

    public function setUserModel(User $userModel): void
    {
        $this->userModel = $userModel;

        $this->email = $userModel->email;
        $this->password = $userModel->password;
        $this->username = $userModel->email ?? "";
        $this->remember = false;
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        // $this->ensureIsNotRateLimited();
        $this->username = $this->email;

        $request = $this->only(['email', 'username', 'password']);
        $login = $this->userRepository->login($request, $this->remember);
        if (is_null($login)) {
            // RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }
        // RateLimiter::clear($this->throttleKey());
        Session::regenerate();
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
