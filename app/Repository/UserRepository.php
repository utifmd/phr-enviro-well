<?php

namespace App\Repository;

use App\Mapper\IUserMapper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserRepository implements IUserRepository
{
    private IUserMapper $mapper;
    public function __construct(IUserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    function login(array $request, bool $isRemembering = false): ?string
    {
        $login1 = [
            "username" => $request['username'],
            "password" => $request['password']
        ];
        $login2 = [
            "email" => $request['username'],
            "password" => $request['password']
        ];
        if(!(Auth::attempt($login1) || Auth::attempt($login2))) return null;

        /*Auth::loginUsingId($userId);
        return $userId;*/
        return Auth::user()->getAuthIdentifier();
    }

    function logout(): void
    {
        if(Auth::check()) Auth::logout();
    }

    function register(array $request): ?User
    {
        try {
            $registeredUser = User::query()->create($request);
            if (is_null($registeredUser['id'])) return null;
            // event(new Registered(user: $registeredUser));
            return $this->mapper->fromBuilderOrModel($registeredUser);
        } catch (\Throwable $t) {

            Log::debug($t->getMessage());
            return null;
        }
    }

    function getUserById(string $id): ?User
    {
        try {
            $user = User::query()
                ->find($id)
                ->get();
        } catch (\Throwable $t){
            return null;
        }
        return $user
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

    public function authenticate(array $user): bool
    {
        /*
         * TODO: ensureIsNotRateLimited(); $this->login($user);
         * */
        return false;
    }

    function authenticatedUser(): ?User
    {
        if(!$this->isAuthenticated()) return null;
        return $this->mapper->fromAuth(
            Auth::user()
        );
    }
}
