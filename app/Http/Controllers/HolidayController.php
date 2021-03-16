<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckDateForHolidayRequest;
use App\Services\HolidayService;
use Illuminate\Support\Carbon;

class HolidayController extends Controller
{
    /**
     * @var HolidayService
     */
    private $holidayService;

    public function __construct()
    {
        $this->holidayService = app(HolidayService::class);
    }

    public function check(CheckDateForHolidayRequest $request)
    {
        $givenDate = new Carbon($request->check_date);

        $holidayInfo = $this->holidayService->checkForHoliday(clone $givenDate);

        return view('holidays.check',
            compact(['givenDate', 'holidayInfo']));
    }
}
