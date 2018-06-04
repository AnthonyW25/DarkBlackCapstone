<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-05-23
 * Time: 10:18 AM
 */

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\COGS;
class Site
{
    /*
     * In the complete system this would be an Eloquent Model class with records in the DB
     * We are just stubbing it out here for now
     */

    public $id = 1; // hard code an id that would normally reference the Site record in the DB

    public $sample_data = [];

    public function foodSales($from_date, $to_date)
    {
        return Sale::where('site_id', $this->id)
            ->whereBetween('date', array($from_date, $to_date))
            ->sum('food_sales');
    }

    public function alcoholSales($from_date, $to_date)
    {
        return Sale::where('site_id', $this->id)
            ->whereBetween('date', array($from_date, $to_date))
            ->sum('alcohol_sales');
    }

    public function beverageSales($from_date, $to_date)
    {
        return Sale::where('site_id', $this->id)
            ->whereBetween('date', array($from_date, $to_date))
            ->sum('beverage_sales');
    }

    public function mostRecent28DayAverage(){
        $sales = Sale::where('site_id', $this->id)
            ->orderBy('date', 'desc')
            ->first();

        return $sales->twenty_eight_day_average;
    } 

    public function salesOn($date){
        $sales = DB::table('sales')
            ->where('site_id', $this->id)
            ->where('date', '=', $date)
            ->first();

        return $sales;
    }

    public function salesRatio($category){
        //sales * actual cogs
        $site = new Site();
        $cogs = new COGS($site);

        $today = Carbon::now();

        $twenty_eight_days_ago = Carbon::now()->subDay(28);

        //decides which COGS to use depending on what the $category was
        if($category == 'Food'){
            $total_sales = self::foodSales($twenty_eight_days_ago, $today); 
            return $total_sales * $cogs->twenty_eight_day_food;
        }else if($category == 'Alcohol'){
             $total_sales  = self::alcoholSales($twenty_eight_days_ago, $today);
            return $total_sales * $cogs->twenty_eight_day_alcohol;
        }else{
             $total_sales = self::beverageSales($twenty_eight_days_ago, $today);
            return $total_sales * $cogs->twenty_eight_day_beverage;
        }
    }
}