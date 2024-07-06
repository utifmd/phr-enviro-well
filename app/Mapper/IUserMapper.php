<?php

namespace App\Mapper;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;

interface IUserMapper
{
    function fromArray(array $user): User;
    function fromCollection(Collection $user): User;
    function fromAuth(?Authenticatable $auth): ?User;
}
