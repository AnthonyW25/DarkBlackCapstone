<?php

namespace Tests\Feature;

use App\Forecast;
use App\Site;
use Tests\TestCase;

class ForecastTest extends TestCase
{
    /** @test */
    public function it_exists()
    {
        $forecast = new Forecast(new Site());

        $this->assertClassHasAttribute('site', 'app\Forecast');
        $this->assertClassHasAttribute('growth_rate', 'app\Forecast');
        $this->assertClassHasAttribute('seven_day', 'app\Forecast');
    }

    /** @test */
    public function provides_seven_day_forecast()
    {
        // Setup some Sales Data
        // The Site will provide all the necessary Sales Data
        $site = new Site();

        $forecast = new Forecast($site);

        // You will have to write the mostRecent28DayAverage method
        $this->assertEquals($site->mostRecent28DayAverage(), $forecast->seven_day);
    }

    /** @test */
    public function can_set_growth_rate()
    {
        $site = new Site();

        $forecast = new Forecast($site);

        // The forecast should default to a zero growth rate
        $this->assertEquals(0, $forecast->growth());

        // We should be able to set the growth rate
        // Try out a few valid inputs
        // Growth is percentage increase / decrease each week

        $forecast->growth(1);
        $this->assertEquals(1, $forecast->growth());

        $forecast->growth(-1);
        $this->assertEquals(-1, $forecast->growth());

        $forecast->growth(1.5);
        $this->assertEquals(1.5, $forecast->growth());

        $forecast->growth(-1.5);
        $this->assertEquals(-1.5, $forecast->growth());
    }

    /** @test */
    public function growth_rate_determines_forecast()
    {
        // Setup some Sales Data
        // The Site will provide all the necessary Sales Data
        $site = new Site();

        $forecast = new Forecast($site);

        $twenty_eight_day_sales_average = $site->mostRecent28DayAverage();

        // The default is 0% growth
        $this->assertEquals($twenty_eight_day_sales_average, $forecast->seven_day);

        // Test a bunch of growth rates
        $growth_rates = [5.25, 4.75, 1.1, 0.1, -0.1, -1.24, -4.32];

        foreach ($growth_rates as $growth_rate) {
            $forecast->growth($growth_rate);
            $this->assertEquals($twenty_eight_day_sales_average * (1 + $growth_rate / 100), $forecast->seven_day);
        }
    }
}
