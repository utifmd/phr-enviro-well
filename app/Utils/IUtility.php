<?php

namespace App\Utils;

interface IUtility
{
    function daysOfMonthLength(?int $month): int|false;
    function datesOfTheMonthBy(int $daysOfMonthLength): array;
    function datesOfTheMonth(?int $count): array;
    function timeAgo(string $datetime): string;
    function combineDashboardArrays(array $loads, array $days): array;
}
