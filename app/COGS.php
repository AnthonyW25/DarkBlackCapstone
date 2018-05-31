<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-05-23
 * Time: 10:06 AM
 */

namespace App;

use Carbon\Carbon;
use App\Http\Controllers\ExpenseController;
use DB;
class COGS
{
    public $site;


    // COGS
    public $seven_day_beverage;
    public $seven_day_food;
    public $seven_day_alcohol;
    public $seven_day_total;
    public $twenty_eight_day_beverage;
    public $twenty_eight_day_food;
    public $twenty_eight_day_alcohol;
    public $twenty_eight_day_total;

    //average sales
    public $twenty_eight_day_avg;
    public $seven_day_avg;


    /*
     * For any give site, which has daily sales and expenses
     * The COGS class will calculate the Food, Alcohol, and Total COGS for the previous 7 and 28 day periods
     */

    // TODO: Bring back the constructor. We want the site to provide the sales data
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    
    //calculates cost of goods and average    
     public function calculate()
    {
        //Calculate all the COGS variables
        $today = Carbon::now();

        $seven_days_ago = $today->copy()->subDay(7);

        $twenty_eight_days_ago = $today->copy()->subDay(28);

        //---------------SEVEN DAY COGS-----------------------------------------------------------------------------------------

        // Nice. This is the right idea. Let another class be responsible for providing Expense Data
        // Things below are looking much neater and easier to understand
        $seven_day_cogs = ExpenseController::categoryTotal($seven_days_ago->toDateString(), $today->toDateString());

        if (isset($seven_day_cogs['Food'])){
            $this->seven_day_food = ($seven_day_cogs['Food']
                                / $this->site->foodSales($seven_days_ago->toDateString(), $today->toDateString())) * 100;
        }else{
            $this->seven_day_food = 0;
        }
        
        if(isset($seven_day_cogs['Alcohol'])){
            $this->seven_day_alcohol = ($seven_day_cogs['Alcohol']
                                / $this->site->alcoholSales($seven_days_ago->toDateString(), $today->toDateString())) * 100;
        }else{
            $this->seven_day_alcohol = 0;
        }
        
        if(isset($seven_day_cogs['Beverage'])){
            $this->seven_day_beverage = ($seven_day_cogs['Beverage']
                                / $this->site->beverageSales($seven_days_ago->toDateString(), $today->toDateString())) * 100;
        }else{
            $this->seven_day_beverage = 0;
        }
        


        //---------------TWENTY EIGHT DAY COGS-----------------------------------------------------------------------------------------

        $twenty_eight_day_cogs  = ExpenseController::categoryTotal($twenty_eight_days_ago->toDateString(), $today->toDateString());

        if(isset($twenty_eight_day_cogs['Food'])){
            $this->twenty_eight_day_food = ($twenty_eight_day_cogs['Food']
                                       / $this->site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString())) * 100;
        }else{
            $this->twenty_eight_day_food = 0;
        }
        
        if(isset($twenty_eight_day_cogs['Alcohol'])){
            $this->twenty_eight_day_alcohol = ($twenty_eight_day_cogs['Alcohol']
                                       / $this->site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString())) * 100;
        }else{
            $this->twenty_eight_day_alcohol = 0;
        }
        
        if(isset($twenty_eight_day_cogs['Beverage'])){
            $this->twenty_eight_day_beverage = ($twenty_eight_day_cogs['Beverage']
                                       / $this->site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString())) * 100;
        }else{
            $this->twenty_eight_day_beverage = 0;
        }
       
        //-------------INSERT AVERAGES TO DATABASE----------------------------------------------------------
        $sales = Sale::orderBy('id', 'desc')->first();

        $this->seven_day_avg = (int)(($this->site->foodSales($seven_days_ago->toDateString(), $today->toDateString())
            + $this->site->alcoholSales($seven_days_ago->toDateString(), $today->toDateString())
            + $this->site->beverageSales($seven_days_ago->toDateString(), $today->toDateString()))/7);

        $this->twenty_eight_day_avg = (int)(($this->site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString())
            + $this->site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString())
            + $this->site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString()))/28);

        DB::table('sales')->where('id', $sales->id)->update(['seven_day_average'=>$this->seven_day_avg]);
        DB::table('sales')->where('id', $sales->id)->update(['twenty_eight_day_average'=>$this->twenty_eight_day_avg]);

    }
    
}