<?php

namespace App\Repository;

use App\Models\User;

interface IUserRepository
{
    function register(array $request): ?User;
    function login(array $request, bool $isRemembering): ?string;
    function authenticate(array $user): bool;
    function authenticatedUser(): ?User;
    function getUserById(string $id): ?User;
    function getUserByEmail(string $email): ?User;
    function isAuthenticated(): bool;
    function logout(): void;
}
