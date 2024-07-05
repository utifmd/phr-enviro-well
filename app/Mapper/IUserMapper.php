<?php

namespace App\Mapper;

use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

interface IUserMapper
{
    function fromArray(array $user): User;
    function fromAuth(?Authenticatable $auth): ?User;
}
