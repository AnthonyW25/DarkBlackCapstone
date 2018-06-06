<?php

namespace Tests\Feature;

use App\Forecast;
use App\Site;
use App\COGS;
use Carbon\Carbon;
use Tests\TestCase;

class ForecastTest extends TestCase
{
    /** @test */
    public function it_exists()
    {
        new Forecast(new Site()); // Not sure why, but need to call this for the tests below to find the class

        $this->assertClassHasAttribute('site', 'app\Forecast');
        $this->assertClassHasAttribute('date', 'app\Forecast');
        $this->assertClassHasAttribute('growth_rate', 'app\Forecast');
        $this->assertClassHasAttribute('seven_day', 'app\Forecast');
    }

    // TODO: Development suggestion
    // Comment out all the tests and start with only one test that is failing, make that pass, then uncomment the next section
    // That's Test Driven Development
    // I should be able to see a series of commits, each one with a piece of test uncommented and the code to make it pass
    // I've tried to write the tests in a rational order, they should guide you to create the code you need a step at a time

    /** @test */
    public function provides_seven_day_forecast()
    {
        // Setup some Sales Data
        // The Site will provide all the necessary Sales Data
        $site = new Site();

        $forecast = new Forecast($site);
        $forecast->forecastCalculation();

        // You will have to write the mostRecent28DayAverage method
        // The default is 0% growth, so the forecast should be the same as the 28 day average
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
        $forecast->forecastCalculation();// we have to run this function to set the seven_day -- for now
        

        // The default is 0% growth
        $this->assertEquals($site->mostRecent28DayAverage(), $forecast->seven_day);

        // Test a bunch of growth rates
        $growth_rates = [5.25, 4.75, 1.1, 0.1, -0.1, -1.24, -4.32];

        foreach ($growth_rates as $growth_rate) {
            $forecast->growth($growth_rate);
            $forecast->forecastCalculation();
            $this->assertEquals($site->mostRecent28DayAverage() * (1 + $growth_rate / 100), $forecast->seven_day);
        }
    }

    /** @test */
    public function can_set_date()
    {
        // The forecast will default to calculate using the most recent data
        // However, we want the option of determining what a previous forecast was

        $site = new Site();

        $forecast = new Forecast($site);

        $forecast->date('2018-05-31');

        $this->assertEquals('2018-05-31', $forecast->date());
    }

    /** @test */
    public function can_save_and_load_settings()
    {
        $site = new Site();

        $forecast = new Forecast($site);

        $growth_rate = 1.23;

        $date = '2018-05-31';

        // Set and save the forecast settings
        // $forecast->forecastCalculation();
        $forecast->growth($growth_rate);
        $forecast->date($date);
        $forecast->forecastCalculation();//store date and growth in database
        
        // Those values should be saved in the database
        $this->assertDatabaseHas('sales', [
            'site_id'       => $site->id,
            'date'          => $date,
            'forecast_rate' => $growth_rate
        ]);

        // Load the settings

        // You may optionally pass in a date to the forecast, which will look for settings on that date
        $forecast = new Forecast($site, $date);//new forecast, forecasta uto calls date now
        
        $forecast->forecastCalculation();
        $forecast->getPercentage();

        $this->assertEquals($date, $forecast->date());
        $this->assertEquals($growth_rate, $forecast->growth());
    }

    /** @test */
    public function forecast_from_specific_date()
    {
        // We want to be able to specify a past date and determine the forecast 7 days after that

        $site = new Site();

        $forecast = new Forecast($site);

        $five_days_ago = Carbon::now()->subDay(5)->toDateString();

        $forecast->date($five_days_ago);
        $forecast->forecastCalculation();

        // You will have to write this method, let the site provide it's sales data on a specific date
        // Expect this to return a Sale model
        $sales = $site->salesOn($five_days_ago);


        // default is 0% growth
        $this->assertEquals($sales->twenty_eight_day_average, $forecast->seven_day);

        // Change the rate and recalculate
        $growth_rate = 1.23;
        $forecast->growth($growth_rate);
        $forecast->forecastCalculation();
        
        $this->assertEquals($sales->twenty_eight_day_average * (1 + $growth_rate / 100), $forecast->seven_day);
    }

    /** @test */
    public function provides_forecast_by_category()
    {
        // Setup some Sales Data
        // The Site will provide all the necessary Sales Data
        $site = new Site();
        $cogs = new COGS($site);
        $cogs->calculate();
        $forecast = new Forecast($site);
        $forecast->forecastCalculation();// we have to run this function to set the seven_day -- for now

        // The Food Forecast is the total forecast times the ratio (or sales mix) of the site
        // because the forecast defaults to a straight line it will just be the most recent 28 day \average
        
        $this->assertEquals($site->mostRecent28DayAverage() * $site->salesRatio('Food'), $forecast->sevenDay('Food'));
        $this->assertEquals($site->mostRecent28DayAverage() * $site->salesRatio('Beverage'), $forecast->sevenDay('Beverage'));
        $this->assertEquals($site->mostRecent28DayAverage() * $site->salesRatio('Alcohol'), $forecast->sevenDay('Alcohol'));
    }
}
