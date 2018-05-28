<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-05-23
 * Time: 10:06 AM
 */

namespace App;

use Carbon\Carbon;

class COGS
{
    public $site;

    public $seven_day_beverage;
    public $seven_day_food;
    public $seven_day_alcohol;
    public $seven_day_total;
    public $twenty_eight_day_beverage;
    public $twenty_eight_day_food;
    public $twenty_eight_day_alcohol;
    public $twenty_eight_day_total;

    /*
     * For any give site, which has daily sales and expenses
     * The COGS class will calculate the Food, Alcohol, and Total COGS for the previous 7 and 28 day periods
     */

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function calculate()
    {
        /*
         *  Calculate all the COGS variables
         */

        $yesterday = Carbon::now()->subDay();
        $seven_days_ago = $yesterday->copy()->subDay(7);
        $twenty_eight_days_ago = $yesterday->copy()->subDay(28);

        $this->seven_day_food = $this->site->foodExpenses($seven_days_ago->toDateString(), $yesterday->toDateString())
                                / $this->site->foodSales($seven_days_ago->toDateString(), $yesterday->toDateString());
        $this->twenty_eight_day_food = $this->site->foodExpenses($twenty_eight_days_ago->toDateString(), $yesterday->toDateString())
                                       / $this->site->foodSales($twenty_eight_days_ago->toDateString(), $yesterday->toDateString());
        // etc...


    }
}