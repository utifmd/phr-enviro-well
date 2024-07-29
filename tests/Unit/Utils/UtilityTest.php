<?php

namespace Utils;

use App\Utils\IUtility;
use App\Utils\Utility;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UtilityTest extends TestCase
{
    private IUtility $utility;
    protected function setUp(): void
    {
        parent::setUp();

        $this->utility = $this->app->make(IUtility::class);
    }

    public function testNumberOfGivenMonth()
    {
        $daysOfMonthLength = $this->utility->daysOfMonthLength();
        self::assertSame(31, $daysOfMonthLength);
    }

    public function testName()
    {
        $daysOfMonthLength = $this->utility->daysOfMonthLength();
        $datesOfTheMonthBy = $this->utility->datesOfTheMonthBy($daysOfMonthLength);
        Log::debug("datesOfTheMonthBy: ".json_encode($datesOfTheMonthBy));

        self::assertSame(31, count($datesOfTheMonthBy));
    }
}
