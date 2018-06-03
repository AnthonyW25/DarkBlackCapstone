<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-05-23
 * Time: 10:18 AM
 */

namespace App;

use Illuminate\Support\Facades\DB;

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
}