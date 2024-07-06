<?php

namespace App\Services;

use App\Mapper\IUserMapper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserService implements IUserService
{
    private IUserMapper $mapper;
    public function __construct(IUserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    function login(array $request): ?string
    {
        $login = [
            "email" => $request['email'],
            "password" => $request['password']
        ];
        if(!Auth::attempt($login)) return null;

        return Auth::user()->getAuthIdentifier();
    }

    function logout(): void
    {
        if(Auth::check()) Auth::logout();
    }

    function register(array $request): ?User
    {
        try {
            $user = $this->mapper->fromArray($request);

            if (!$user->save()) return null;

            return $this->getUserByEmail($request['email']);
        } catch (\Throwable $t) {
            Log::debug($t->getMessage());
            return null;
        }
    }

    function getUserById(string $id): ?User
    {
        return User::query()
            ->find($id)
            ->get()
            ->first();
    }

    function getUserByEmail(string $email): ?User
    {
        return User::query()
            ->where("email", "=", $email)
            ->get()
            ->first();
    }

    function isAuthenticated(): bool
    {
        return Auth::check();
    }

    function authenticatedUser(): ?User
    {
        if(!$this->isAuthenticated()) return null;
        return $this->mapper->fromAuth(
            Auth::user()
        );
    }
}
