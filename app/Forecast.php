<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-05-28
 * Time: 6:32 PM
 */

namespace App;
use DB;

class Forecast
{
    public $date;
    public $site;
    public $growth_rate;
    public $seven_day;

    public function __construct(Site $site, $date = null)
    {
        $this->site = $site;
    }

    public function forecastCalculation(int $percent){
			DB::table('sales')
    			->where('site_id', '=', $this->site->id)
    			->update(['forecast_percentage' => $percent]);

    		$sales = Sale::where('site_id', '=', $this->site->id)
    			->orderBy('id', 'desc')
    			->first();

    		$seven_day_avg = $sales->seven_day_average;

    		$this->seven_day = ($seven_day_avg + ($seven_day_avg * ($percent/100)));

    }

    public function getPercentage(){
    	$sales = Sale::where('site_id', '=', $this->site->id)
    			->orderBy('id', 'desc')
    			->first();

    	$this->growth_rate = $sales->forecast_percentage;
    }


}