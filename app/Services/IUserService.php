<?php

namespace App\Services;

use App\Models\User;

interface IUserService
{
    function register(array $request): ?User;
    function login(array $request): ?string;
    function logout(): void;
    function getUserById(string $id): ?User;
    function getUserByEmail(string $email): ?User;
    function isAuthenticated(): bool;
    function authenticatedUser(): ?User;
}
