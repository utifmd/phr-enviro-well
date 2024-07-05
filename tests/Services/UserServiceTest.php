<?php

namespace Tests\Services;

use App\Services\IUserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private array $user;
    private IUserService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = [
            'name' => 'Pertamina Hulu Rokan Test',
            'email' => 'phrtest@example.com',
            'password' => 'password',
        ];
        $this->service = $this->app->make(IUserService::class);

        DB::connection('mysql')->delete("DELETE FROM users");
    }
    /*function login(array $request): string;
    function logout(): void;
    function register(array $request): ?User;
    function getUserById(string $id): ?User;
    function getUserByEmail(string $email): ?User;
    function isAuthenticated(): bool;
    function authenticatedUser(): ?User;*/
    public function testRegister()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $registeredOrNull = $this->service->register($user);

        $this->assertNotNull($registeredOrNull);
    }

    public function testLogin()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');
        $userOrNull = $this->service->register($user);

        $this->assertNotNull($userOrNull);

        $idLoggedIn = $this->service->login($this->user);

        $this->assertNotEmpty($idLoggedIn);
    }
}
