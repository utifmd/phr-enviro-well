<?php

namespace App\Utils;

enum UserRoleEnum: string
{
    case USER_DEV_ROLE = "USER_DEV_ROLE";
    case USER_PHR_ROLE = "USER_PHR_ROLE";
    case USER_PT_ROLE = "USER_PT_ROLE";
    case USER_GUEST_ROLE = "USER_GUEST_ROLE";
}
