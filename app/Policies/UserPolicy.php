<?php

namespace App\Policies;

use App\Models\User;
use App\Utils\Enums\UserRoleEnum;

class UserPolicy
{
    const IS_NOT_GUEST_ROLE = 'isUserRoleIsNotGuest';

    const IS_PT_ROLE = 'isUserRoleIsPT';

    const IS_PHR_ROLE = 'isUserRoleIsPhr';

    const IS_DEV_ROLE = 'isUserRoleIsDev';
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function isUserRoleIsPhr(User $user): bool
    {
        return $user->role == UserRoleEnum::USER_PHR_ROLE->value ||
            $user->role == UserRoleEnum::USER_DEV_ROLE->value;
    }
    public function isUserRoleIsPT(User $user): bool
    {
        return $user->role == UserRoleEnum::USER_PT_ROLE->value ||
            $user->role == UserRoleEnum::USER_DEV_ROLE->value;
    }
    public function isUserRoleIsNotGuest(User $user): bool
    {
        return $user->role != UserRoleEnum::USER_GUEST_ROLE->value;
    }
    public function isUserRoleIsDev(User $user): bool {
        return $user->role == UserRoleEnum::USER_DEV_ROLE->value;
    }
}
