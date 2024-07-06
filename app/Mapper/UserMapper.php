<?php

namespace App\Mapper;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;

class UserMapper implements IUserMapper
{
    function fromArray(array $user): User
    {
        return new User($user);
    }

    function fromAuth(?Authenticatable $auth): ?User
    {
        $user = new User();
        if (!$auth) return null;

        $user->id = $auth->id;
        $user->name = $auth->name;
        $user->email = $auth->email;
        $user->email_verified_at = $auth->email_verified_at;
        $user->created_at = $auth->created_at;
        $user->updated_at = $auth->updated_at;

        return $user;
    }

    function fromCollection(Collection $user): User
    {
        $model = new User();
        $model->id = $user->get('id');
        $model->email_verified_at = $user->get('email_verified_at');
        $model->created_at = $user->get('created_at');
        $model->updated_at = $user->get('updated_at');
        $model->name = $user->get('name');
        $model->email = $user->get('email');
        $model->password = $user->get('password');
        return $model;
    }
}
