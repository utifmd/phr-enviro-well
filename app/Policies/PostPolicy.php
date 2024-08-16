<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Utils\Enums\UserRoleEnum;
use App\Utils\Enums\WorkOrderStatusEnum;

class PostPolicy
{
    const IS_USER_OWNED = 'isUserOwnThePost';

    const IS_USER_OR_PHR_OWNED = 'isPhrOrUserOwnThePost';

    const IS_THE_POST_STILL_PENDING = 'isThePostStillPending';
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function isUserOwnThePost(User $user, Post $post): bool
    {
        return $post->user_id == $user->id ||
            $user->role == UserRoleEnum::USER_DEV_ROLE->value;
    }

    public function isPhrOrUserOwnThePost(User $user, Post $post): bool
    {
        return
            $post->user_id == $user->id ||
            $user->role == UserRoleEnum::USER_PHR_ROLE->value ||
            $user->role == UserRoleEnum::USER_DEV_ROLE->value;
    }

    public function isThePostStillPending(User $user, Post $post): bool
    {
        $woStatuses = collect($post->workOrders)->map(
            function($wo) { return $wo['status']; }
        );
        /*$isAtLeastGotApproval = !; return $post->user_id == $user->id&&  $isAtLeastGotApproval;*/
        return $woStatuses->contains(WorkOrderStatusEnum::STATUS_PENDING->value);
    }
    /*public function onUserOwnThePost(User $user, Post $post): Response
    {
        return  $post->user_id == $user->id ||
        $user->role == UserRoleEnum::USER_DEV_ROLE->value
            ? Response::allow()
            : Response::deny('You do not own this request.');
    }*/
}
