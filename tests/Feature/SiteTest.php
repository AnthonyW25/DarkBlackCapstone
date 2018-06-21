<?php

namespace Tests\Feature;

use App\Sale;
use App\Site;
use Carbon\Carbon;
use Tests\TestCase;

class SiteTest extends TestCase
{
    /** @test */
    public function provides_sales_at_date()
    {
        $site = new Site();

        $five_days_ago = Carbon::now()->subDay(5)->toDateString();

        $sales = $site->salesOn($five_days_ago);

        $this->assertInstanceOf(Site::class, $site);

        $this->assertEquals($five_days_ago, $sales->date);
    }

    /** @test */
    public function provides_sales_category_ratio()
    {
        /*
         * Sales are split into categories
         * We want the ratio: sales_by_category / total_sales over the last 28 days
         * This is called the sales mix
         * The assumption is that the sales mix will remain consistent into the future and we can use it to forecast
         */

        $site = new Site();

        // get last 28 days of sales data
        $sales = Sale::orderBy('date', 'desc')
            ->limit(28)
            ->get();
            //dd($sales);
        $food_sales = 0;
        $alcohol_sales = 0;
        $beverage_sales = 0;
        $total_sales = 0;

        foreach ($sales as $sale) {
            $food_sales += $sale->food_sales;
            $alcohol_sales += $sale->alcohol_sales;
            $beverage_sales += $sale->beverage_sales;
            $total_sales += $sale->net;
        }

        // Ratios should be reported to 3 decimal places only
        $expected_food_ratio = round($food_sales / $total_sales, 3);
        $expected_alcohol_ratio = round($alcohol_sales / $total_sales, 3);
        $expected_beverage_ratio = round($beverage_sales / $total_sales, 3);

        $this->assertEquals($expected_food_ratio, $site->salesRatio('Food'));
        $this->assertEquals($expected_alcohol_ratio, $site->salesRatio('Alcohol'));
        $this->assertEquals($expected_beverage_ratio, $site->salesRatio('Beverage'));
    }
}
