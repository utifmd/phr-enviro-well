<?php

namespace App\Repository;

use App\Mapper\IUserMapper;
use App\Models\User;
use App\Utils\Enums\UserRoleEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository implements IUserRepository
{
    private IUserMapper $mapper;
    private ?Builder $builder;

    public function __construct(IUserMapper $mapper)
    {
        $this->mapper = $mapper;
        $this->builder = User::query();
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

    public function create(array $request): Model|Builder|null
    {
        $builder = User::query();
        $isUsernameExist = $builder
            ->where('username', '=', $request['username'])
            ->get();
        if ($isUsernameExist->isNotEmpty()) {
            $request['username'] = ($request['username'].($isUsernameExist->count() +1));
        }
        return $builder->create($request);
    }

    public function update(string $userId, array $request): Model|Builder|null
    {
        $builder = $this->builder->find($userId);
        $builder['username'] = $request['username'];
        $builder['email'] = $request['email'];

        if (isset($request['password'])) {
            $builder['password'] = Hash::make($request['password']);
        }
        $builder['role'] = $request['role'];
        if (!$builder->save()) return null;
        return $builder;
    }
    public function delete(string $userId): bool|null
    {
        $builder = $this->builder->find($userId);
        if ($builder->get()->isEmpty()) return null;

        return $builder->delete();
    }

    function register(array $request): ?User
    {
        try {
            $registeredUser = $this->create($request);
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
            $user = $this->builder
                ->find($id)
                ->get();

        } catch (\Throwable $t){
            Log::debug($t->getMessage());
            return null;
        }
        return $user
            ->first();
    }

    function getUserByEmail(string $email): ?User
    {
        return $this->builder
            ->where("email", "=", $email)
            ->get()
            ->first();
    }

    public function pagedUsersByRole(string $role): LengthAwarePaginator
    {
        return $this->builder
            ->where("role", "=", $role)
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->paginate();
    }

    public function pagedUsers(): LengthAwarePaginator
    {
        return $this->builder
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->paginate();
    }

    public function searchUsersBy(string $nameOrEmail): Collection
    {
        return $this->builder
            ->where("username", "LIKE", "'%$nameOrEmail%'")
            ->orWhere("email", "LIKE", "'%$nameOrEmail%'")
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();
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
