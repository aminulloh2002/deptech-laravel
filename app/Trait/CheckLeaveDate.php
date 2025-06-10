<?php

namespace App\Trait;
use Illuminate\Support\Carbon;

trait CheckLeaveDate
{
    function verifyLeaveDate($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $days = $start->diffInDays($end) + 1;

        if ($start->month == $end->month && $days > 1) {
            return false;
        }

        if ($start->month !== $end->month && $days > 2) {
            return false;
        }

        return true;
    }
}
