<?php

namespace Tests\Unit\Helpers;

use App\Helpers\DateHelpers;
use App\Helpers\Helper;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class DateHelpersTest extends TestCase
{
    use WithFaker;

    private DateHelpers $dateHelpers;

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->dateHelpers = $this->app->make('App\Helpers\DateHelpers');
    }

    /** @test */
    public function itShouldReturnTrueSinceSpecifiedDateIsAWednesday()
    {
        $date = "2021-02-24";
        $dayOfTheWeek = 3; // Wednesday
        $isSpecifiedWeekDay = $this->dateHelpers->isSpecifiedWeekDay($date, $dayOfTheWeek);

        $this->assertEquals(true, $isSpecifiedWeekDay);
    }

    /** @test */
    public function itShouldReturnFalseSinceSpecifiedDateIsAFriday()
    {
        $date = "2021-02-26";
        $dayOfTheWeek = 3; // Wednesday
        $isSpecifiedWeekDay = $this->dateHelpers->isSpecifiedWeekDay($date, $dayOfTheWeek);

        $this->assertEquals(false, $isSpecifiedWeekDay);
    }

    /** @test */
    public function itShouldReturnThreeSinceTheSpecifiedDayIsInTheThirdWeek()
    {
        $date = "2021-12-16"; // the 3rd Thursday of the month
        $dateTimestamp = strtotime($date);
        $dayOfWeekValue = date('N', $dateTimestamp);

        $isSpecifiedWeekDay = $this->dateHelpers->monthWeekNumber($date, $dayOfWeekValue);

        $this->assertEquals(3, $isSpecifiedWeekDay);
    }



}
