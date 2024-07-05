<?php

namespace Tests\Services;

use App\Services\IUserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function testRegister()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $registeredOrNull = $this->service->register($user);

        $this->assertNotNull($registeredOrNull);
    }
}
