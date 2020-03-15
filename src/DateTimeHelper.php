<?php

declare(strict_types=1);

namespace App;

use DateTime;

class DateTimeHelper
{
    public function getDiffInHours(DateTime $time1, DateTime $time2)
    {
        $diff = $time1->diff($time2);
        return intval($diff->format("%d")*24) + intval($diff->format('%h'));
    }

    public function createDateTimeFromDateAndTime(string $date, string $time): DateTime
    {
        return DateTime::createFromFormat('d/m/y H:i', $date . ' ' . $time);
    }
}
