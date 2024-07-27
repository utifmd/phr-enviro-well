<?php

namespace App\Utils;

enum WellMasterStatusEnum: string
{
    case CANCELED = 'CANCELED';
    case COMPLETE = 'COMPLETE';
    case IN_PROGRESS = 'IN_PROGRESS';
    case RELEASE = 'RELEASE';
    case SUSPENDED = 'SUSPENDED';
}
