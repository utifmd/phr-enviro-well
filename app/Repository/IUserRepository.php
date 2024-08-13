<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface IUserRepository
{
    function create(array $request): Model|Builder|null;
    function update(string $userId, array $request): Model|Builder|null;
    function register(array $request): ?User;
    function login(array $request, bool $isRemembering): ?string;
    function authenticate(array $user): bool;
    function authenticatedUser(): ?User;
    function getUserById(string $id): ?User;
    function getUserByEmail(string $email): ?User;
    function isAuthenticated(): bool;
    function logout(): void;
}
