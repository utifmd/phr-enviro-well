<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    private array $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = [
            'name' => 'Pertamina Hulu Rokan Test',
            'email' => 'phrtest@example.com',
        ];

        DB::connection('mysql')->delete("DELETE FROM users");
    }

    public function testUserLogin()
    {
        $userRegister = [
            'name' => $this->user['name'],
            'email' => $this->user['email'],
            'password' => Hash::make('password')
        ];
        $user = new User($userRegister);
        $user->save();

        $userLogin = [
            'password' => 'password',
            'email' => $this->user['email']
        ];
        $isLoggedIn = Auth::attempt($userLogin);

        if($isLoggedIn) {
            $hashedPassword = Auth::user()->getAuthPassword();
            // Log::debug('password: ' . $hashedPassword);
            self::assertTrue(
                Hash::check($userLogin['password'], $hashedPassword)
            );
        }
        self::assertTrue($isLoggedIn);
    }

    public function testUserRegister()
    {
        $user = [
            'name' => $this->user['name'],
            'email' => $this->user['email'],
            'password' => Hash::make('password')
        ];
        User::query()->create($user);

        $this->assertDatabaseHas('users', [
            'email' => $user['email']
        ]);
    }
}
