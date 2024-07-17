<?php

namespace App\Services;

use App\Models\User;

interface IUserService
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
