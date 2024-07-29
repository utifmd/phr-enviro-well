<?php

namespace App\Utils\Enums;

enum WellMasterStatusEnum: string
{
    case CANCELED = 'CANCELED';
    case COMPLETE = 'COMPLETE';
    case IN_PROGRESS = 'IN_PROGRESS';
    case RELEASE = 'RELEASE';
    case SUSPENDED = 'SUSPENDED';
}
