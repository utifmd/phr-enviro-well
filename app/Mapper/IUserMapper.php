<?php

namespace App\Mapper;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

interface IUserMapper
{
    function fromAndToRawArray(array $user): User;
    function fromCollection(Collection $user): User;
    function fromBuilderOrModel(Builder|Model $user): User;
    function fromAuth(?Authenticatable $auth): ?User;
}
