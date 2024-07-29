<?php

namespace App\Utils;

use App\Utils\IUtility;
use Illuminate\Support\Facades\Log;

class Utility implements IUtility
{
    function daysOfMonthLength(?int $month = null): int|false
    {
        $firstDateOfMonth = date_create(date('Y-m-') . '01');
        $lastDateOfMonth = date_create($firstDateOfMonth->format('Y-m-t'));
        $dateInterval = date_diff($firstDateOfMonth, $lastDateOfMonth);
        return $dateInterval->days +1;
    }

    function datesOfTheMonthBy(int $daysOfMonthLength): array
    {
        $dates = [];
        $i = 0;
        do { ++$i;
            $dates[] = $i;
        } while($i < $daysOfMonthLength);
        return $dates;
    }
    public function datesOfTheMonth(?int $count = 31): array
    {
        $result = [];
        for ($i = 1; $i <= $count; $i++) {
            $result[] = $i;
        }
        return $result;
    }
}
