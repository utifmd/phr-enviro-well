<?php

namespace Tests\Services;

use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public function testLogin()
    {
        $user = [
            'name' => 'Phr test',
            'email' => 'phrtest@example.com',
            'password' => Hash::make('password')
        ];
        $registeredOrNull = $this->service->register($user);

        $this->assertNotNull($registeredOrNull);
        $this->assertDatabaseHas('users', [
            'email' => $user['email']
        ]);
    }
}
