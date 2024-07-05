<?php

namespace Tests\Feature;

use App\Mapper\IUserMapper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    private array $user;
    private IUserMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = [
            'name' => 'Pertamina Hulu Rokan Test',
            'email' => 'phrtest@example.com',
        ];
        $this->mapper = $this->app->make(IUserMapper::class);

        DB::connection('mysql')->delete("DELETE FROM users");
    }

    public function testUserLogin()
    {
        $userRegister = [
            'name' => $this->user['name'],
            'email' => $this->user['email'],
            'password' => Hash::make('password')
        ];

        $this->mapper
            ->fromArray($userRegister)
            ->save();

        $userLogin = [
            'password' => 'password',
            'email' => $this->user['email']
        ];
        $isLoggedIn = Auth::attempt($userLogin);

        if($isLoggedIn) {
            $hashedPassword = Auth::user()->getAuthPassword();
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
        $this->mapper
            ->fromArray($user)
            ->save();

        $this->assertDatabaseHas('users', [
            'email' => $user['email']
        ]);
    }
}
