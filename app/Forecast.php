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

    private $calculated = false; // We will calculate the forecast values only once

    public function __construct(Site $site, $date = null)
    {
        $this->site = $site;
        $this->date($date);
    }

    // DB: Let me help
    // Here is a common getter / setter pattern I like, this will get some of the tests I wrote to pass
    // Do the same thing with date
    public function growth($growth_rate = null)
    {
        if ( ! is_null($growth_rate)) {
            $this->growth_rate = $growth_rate;
        }
        return $this->growth_rate;
    }

    //Function for date
    public function date($date = null)
    {
        if ( ! is_null($date)) {
            $this->date = $date;
        }
        return $this->date;
    }

    public function forecastCalculation(){
			$sales = Sale::where('site_id', '=', $this->site->id)
    			->orderBy('date', 'desc')
    			->first();

            if(is_null($this->date)){
                $this->date = $sales->date;
            }
            if(is_null($this->growth_rate)){
                $this->getPercentage();
            }

			DB::table('sales')
    			->where('date', '=', $this->date)
    			->where('site_id', '=', $this->site->id)
    			->update(['forecast_rate' => $this->growth_rate]);

    		$twenty_eight_day_avg = $sales->twenty_eight_day_average;

    		$this->seven_day = ($twenty_eight_day_avg + ($twenty_eight_day_avg * ($this->growth_rate/100)));  
    }

    public function getPercentage(){
    	$sales = DB::table('sales')
                ->where('date', '=', $this->date)
                ->where('site_id', '=', $this->site->id)->get();
        foreach($sales as $sale){
            $this->growth_rate = $sale->forecast_rate;
        }
    }
}


 // DB: More help
    // It's nice not to have to call a specific "calculate the values I want method"
    // instead we want the class to figure out if it has to do some work without being told
    // You will notice in the ForecastTest I do not call a "calculate" method, I just directly access the properties I want
    // On elequent models you can use the getVariableAttribute method
    // but on regular classes we can use the magic PHP __get and __set methods
    // public function __get($property)
    // {
    //     if (property_exists($this, $property)) {

    //         $this->calculate($property); // Before returning a public property of Forecast we will always make sure we calculate

    //         return $this->$property;
    //     }
    // }
    // private function calculate($property)
    // {
    //     // We only want to calculate the values once, so if we've already done it, just return
    //     if ($this->calculated) {
    //         return true;
    //     }

    //     // Do any work needed
    //     $this->forecastCalculation($property);
    //     $this->getPercentage();
    //     // etc.

    //     // flag that this has been done so we don't recalculate everytime we ask for a value
    //     $this->calculated = true;
    // }

    // Now we can turn all these methods to private, we only access the public properties of this method, the class knows to do all the work necessary