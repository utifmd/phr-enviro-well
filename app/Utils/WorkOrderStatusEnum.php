<?php

namespace App\Utils;

enum WorkOrderStatusEnum: string
{
    case STATUS_SENT = 'SENT';
    case STATUS_DENIED = 'DENIED';
    case STATUS_ACCEPTED = 'ACCEPTED';
}
