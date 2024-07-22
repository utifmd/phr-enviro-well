<?php

namespace Tests\Repository;

use App\Repository\IUserRepository;
use App\Utils\UserRoleEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    private array $user;
    private IUserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $email = 'phrtest@example.com';
        $this->user = [
            'username' => explode("@", $email)[0],
            'email' => $email,
            'password' => 'password',
            'role' => UserRoleEnum::USER_GUEST_ROLE->value,
            'remember' => false,
        ];
        $this->repository = $this->app->make(IUserRepository::class);

        DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM users");
    }

    public function testRegister()
    {
        $user = $this->user;
        $user['password'] = Hash::make($user['password']);
        $registeredOrNull = $this->repository->register($user);

        $this->assertNotNull($registeredOrNull);
        $this->assertSame($user['username'], $registeredOrNull->username);
        $this->assertSame($user['email'], $registeredOrNull->email);
    }

    public function testLogin()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->repository->register($user);
        $idLoggedIn = $this->repository->login([
            'username' => $this->user['username'],
            'password' => $this->user['password'],
        ]);

        $this->assertNotNull($idLoggedIn);
        $this->assertNotEmpty($idLoggedIn);
    }

    public function testIsAuthenticated()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->repository->register($user);
        $this->repository->login($this->user);
        $isAuthenticated = $this->repository->isAuthenticated();

        $this->assertTrue($isAuthenticated);
    }

    public function testAuthenticatedUser()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->repository->register($user);
        $this->repository->login($this->user);
        $authenticatedUserOrNull = $this->repository->authenticatedUser();

        $this->assertNotNull($authenticatedUserOrNull);
        $this->assertSame($user['username'], $authenticatedUserOrNull->username);
        $this->assertSame($user['email'], $authenticatedUserOrNull->email);
    }

    public function testGetUserById()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->repository->register($user);
        $this->repository->login($this->user);
        $authenticatedUserOrNull = $this->repository->authenticatedUser();
        $authIdentifier = $authenticatedUserOrNull->getAuthIdentifier();
        $userOrNull = $this->repository->getUserById($authIdentifier);

        $this->assertNotNull($userOrNull->id);
        $this->assertSame($user['username'], $userOrNull->username);
        $this->assertSame($user['email'], $userOrNull->email);
    }

    public function testGetUserByEmail()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->repository->register($user);
        $this->repository->login($user);
        $userOrNull = $this->repository->getUserByEmail($user['email']);

        $this->assertNotNull($userOrNull);
        $this->assertSame($user['username'], $userOrNull->username);
        $this->assertSame($user['email'], $userOrNull->email);
    }
}
