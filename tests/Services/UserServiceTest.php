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
            'username' => 'phrtest',
            'email' => 'phrtest@example.com',
            'password' => 'password',
        ];
        $this->service = $this->app->make(IUserService::class);

        DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM users");
    }

    public function testRegister()
    {
        $user = $this->user;
        $user['password'] = Hash::make($user['password']);

        $registeredOrNull = $this->service->register($user);

        $this->assertNotNull($registeredOrNull);
        $this->assertSame($user['username'], $registeredOrNull->name);
        $this->assertSame($user['email'], $registeredOrNull->email);
    }

    public function testLogin()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->service->register($user);
        $idLoggedIn = $this->service->login($this->user);

        $this->assertNotEmpty($idLoggedIn);
    }

    public function testIsAuthenticated()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->service->register($user);
        $this->service->login($this->user);
        $isAuthenticated = $this->service->isAuthenticated();

        $this->assertTrue($isAuthenticated);
    }

    public function testAuthenticatedUser()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->service->register($user);
        $this->service->login($this->user);
        $authenticatedUserOrNull = $this->service->authenticatedUser();

        $this->assertNotNull($authenticatedUserOrNull);
        $this->assertSame($user['username'], $authenticatedUserOrNull->name);
        $this->assertSame($user['email'], $authenticatedUserOrNull->email);
    }

    public function testGetUserById()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->service->register($user);
        $this->service->login($this->user);
        $authenticatedUserOrNull = $this->service->authenticatedUser();
        $authIdentifier = $authenticatedUserOrNull->getAuthIdentifier();
        $userOrNull = $this->service->getUserById($authIdentifier);

        $this->assertNotNull($userOrNull);
        $this->assertSame($user['username'], $userOrNull->name);
        $this->assertSame($user['email'], $userOrNull->email);
    }

    public function testGetUserByEmail()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->service->register($user);
        $this->service->login($user);
        $userOrNull = $this->service->getUserByEmail($user['email']);

        $this->assertNotNull($userOrNull);
        $this->assertSame($user['username'], $userOrNull->name);
        $this->assertSame($user['email'], $userOrNull->email);
    }
}
