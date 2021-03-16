<?php


namespace App\Services;

use Illuminate\Support\Carbon;

/**
 * Contains business logic for holidays
 *
 * @package App\Services
 */
class HolidayService
{
    /**
     * @var array[] list of available holidays
     */
    private static $holidays = [
        1 => [
            'name' => 'New Year (1st of January)',
            'startDay' => 1,
            'endDay' => null,
            'startMonth' => 1,
            'endMonth' => null,
            'weekNumber' => null,
            'dayOfWeek' => null,
        ],
        2 => [
            'name' => 'Orthodox Christmas (7th of January)',
            'startDay' => 7,
            'endDay' => null,
            'startMonth' => 1,
            'endMonth' => null,
            'weekNumber' => null,
            'dayOfWeek' => null,
        ],
        3 => [
            'name' => 'Some Holidays from 1st of May till 7th of May',
            'startDay' => 1,
            'endDay' => 7,
            'startMonth' => 5,
            'endMonth' => 5,
            'weekNumber' => null,
            'dayOfWeek' => null,
        ],
        4 => [
            'name' => 'Some Holiday (Monday of the 3rd week of January)',
            'startDay' => null,
            'endDay' => null,
            'startMonth' => 1,
            'endMonth' => null,
            'weekNumber' => 3,
            'dayOfWeek' => 1,
        ],
        5 => [
            'name' => 'Some Holiday (Monday of the last week of March)',
            'startDay' => null,
            'endDay' => null,
            'startMonth' => 3,
            'endMonth' => null,
            'weekNumber' => 5,
            'dayOfWeek' => 1,
        ],
        6 => [
            'name' => 'Some Holiday (Thursday of the 4th week of November)',
            'startDay' => null,
            'endDay' => null,
            'startMonth' => 11,
            'endMonth' => null,
            'weekNumber' => 4,
            'dayOfWeek' => 4,
        ],
    ];

    /**
     * Checks is there a certain holiday on the given date
     *
     * @param $date Carbon a date to check for holiday
     * @return array holiday info according to the check or empty array
     */
    public function checkForHoliday(Carbon $date): array
    {
        foreach (static::$holidays as $holiday) {
            // Check by day and month
            if ($date->day == $holiday['startDay'] &&
                $date->month == $holiday['startMonth']) return $holiday;

            // Check by interval of dates (within the same year)
            if ($date->day >= $holiday['startDay'] &&
                $date->day <= $holiday['endDay'] &&
                $date->month >= $holiday['startMonth'] &&
                $date->month <= $holiday['endMonth']) return $holiday;

            // Check by day of week and week in month
            if ($date->dayOfWeekIso == $holiday['dayOfWeek'] &&
                $date->weekNumberInMonth == $holiday['weekNumber'] &&
                $date->month == $holiday['startMonth']) return $holiday;
        }

        // Check for additional day off
        // (if previous Sunday or Saturday is a holiday)
        if ($date->isMonday()) {
            $sundayInfo = $this->checkForHoliday($date->subDay());
            $saturdayInfo = $this->checkForHoliday($date->subDay());

            $dayOffInfo = $sundayInfo ?: $saturdayInfo;

            if(!empty($dayOffInfo)) $dayOffInfo['is_day_off'] = true;

            return $dayOffInfo;
        }

        return [];
    }
}
