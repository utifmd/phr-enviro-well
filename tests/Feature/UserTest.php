<?php

namespace Tests\Feature;

use App\Mapper\IUserMapper;
use App\Utils\Enums\UserRoleEnum;
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
            'username' => 'phrtest',
            'email' => 'phrtest@example.com',
            'role' => UserRoleEnum::USER_GUEST_ROLE->value,
        ];
        $this->mapper = $this->app->make(IUserMapper::class);

        DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM users");
    }

    public function testUserLogin()
    {
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->mapper
            ->fromAndToRawArray($user)
            ->save();

        $userLogin = [
            'email' => $user['email'],
            'password' => 'password'
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
        $user = $this->user;
        $user['password'] = Hash::make('password');

        $this->mapper
            ->fromAndToRawArray($user)
            ->save();

        $this->assertDatabaseHas('users', [
            'email' => $user['email']
        ]);
    }
}
