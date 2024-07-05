<?php

namespace App\Mapper;

use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserMapper implements IUserMapper
{
    function fromArray(array $user): User
    {
        return /*$model = */ new User($user);

        /*if(isset($user['id']))
            $model->id = $user['id'];
        if(isset($user['email_verified_at']))
            $model->email_verified_at = $user['email_verified_at'];
        if(isset($user['created_at']))
            $model->created_at = $user['created_at'];
        if(isset($user['updated_at']))
            $model->updated_at = $user['updated_at'];

        $model->name = $user['name'];
        $model->email = $user['email'];
        return $model;*/
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
}
