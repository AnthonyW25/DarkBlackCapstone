<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-06-03
 * Time: 2:39 PM
 */

namespace App;

use App\Exceptions\DarkBlackException;
use DB;
class Budget
{
    public $forecast;

    public $cogs_target;

    public $categoryTarget = array();
    public $defaultTarget;

    public $weekly_food;
    public $weekly_alcohol;
    public $weekly_beverage;

    public $result;


    public function __construct(Forecast $forecast)
    {
        $this->forecast = $forecast;

    }

    //This function should set the cogs target to whatever is passed in as wanted target
    // and apply to all the categories
    public function cogsTarget($target = null, $category = null)
    {       
            //$target = number_format((float)$target, 1, '.', '');
            if( ! is_null($target)) // If something is in target
            {
                //$this->cogs_target = $target; //Assign the global cogs_target to whatever was passed in
                if (!is_null($category)) { //If something is in category
                    $this->categoryTarget[$category] = $target; // Create an index with the name of the category, and give it the passed in target value
                    $sales = Sale::where('site_id', '=', $this->forecast->site->id)
                        ->orderBy('date', 'desc')
                        ->first();
                        
                    if($category == 'Food'){

                        DB::table('sales')->where('date', $sales->date)->update(['food_cogs_target'=>$target]);

                    }else if($category == 'Alcohol'){

                        DB::table('sales')->where('date', $sales->date)->update(['alcohol_cogs_target'=>$target]);

                    }else if($category == 'Beverage'){
                
                        DB::table('sales')->where('date', $sales->date)->update(['beverage_cogs_target'=>$target]);

                    }else{

                        DB::table('sales')->where('date', $sales->date)->update(['cogs_target'=>$target]);
                    }


                    $this->cogsCategoryTarget($category); //Call the method with specified category for the target
                } else { //If category is null
                    $this->cogs_target = $target; // Assign the cogs target variable the value that was passed in
                    $this->cogsCategoryTarget(); //Call the method with a null category to assign this cogs value to the default categories
                }
                $sales = Sale::where('site_id', '=', $this->forecast->site->id)
                ->orderBy('date', 'desc')
                ->first();

                DB::table('sales')->where('date', $sales->date)->update(['cogs_target'=>$target]);
            } else { //If the target is null
                if (isset($this->cogs_target)) { // Check to see if it has been set
                    $this->cogsCategoryTarget(); // If it has, call the method with a null category to assign this cogs value to the default categories
                } else { //Throw an exception if target is null and hasn't been previously set
                    throw new DarkBlackException("No target specified, please enter a target");
                }
            }
        //$this->cogs_target = number_format((float)$target, 1, '.', '');
        
        return number_format((float)$this->cogs_target, 1, '.', '');
    }


    public function getCOGS($category){
         $sales = Sale::where('site_id', '=', $this->forecast->site->id)
                        ->orderBy('date', 'desc')
                        ->first();
    
        if($category == 'Food'){
            return $sales->food_cogs_target;
        }
        else if($category == 'Alcohol'){
            return $sales->alcohol_cogs_target;
        }
        else if($category == 'Beverage'){
            return $sales->beverage_cogs_target;
        }
        
    }

    //This should only set the cogs target for a specified category
    public function cogsCategoryTarget($category = null)
    {
        //If there is a category, need to assign it to whatever was passed in
        if(isset($this->categoryTarget[$category])) { // Checks to see if the category has been set
            $newTarget = $this->categoryTarget[$category]; // If it is set, assigns new target the value in that index
            $newTarget = number_format((float)$newTarget, 1, '.', ''); // Format the number to 1 decimal

            $this->byCategory($category); //Call the byCategory function in order to calculate budget
        } else { //If the specified category index isn't found, just assign new index to the default cogs value
            $newTarget = $this->cogs_target; // newTarget is given the default cogs target that was assigned
            $this->categoryTarget[$category] = $newTarget; // The category that was specified is created and assigned the value given to newTarget
            $newTarget = number_format((float)$newTarget, 1, '.', ''); // Format the number to 1 decimal

            $this->byCategory($category); //Call the byCategory function in order to calculate budget
        }
        return $newTarget;
    }


    //Provides an expense budget for the specified category
    // If my forecast sales is S, and my COGS target is Y%, then my spending budget = S x Y
    public function byCategory($category = null)
    {
        //$result = 0.0;
        if ($category == 'Food'){
            
            $this->weekly_food = (($this->forecast->sevenDay($category)) * ($this->categoryTarget[$category] / 100));
            $this->result = $this->weekly_food;
        } else if ($category == 'Alcohol') {
            $this->weekly_alcohol = ($this->forecast->sevenDay($category) * ($this->categoryTarget[$category] / 100));
            $this->result = $this->weekly_alcohol;
        } else if ($category == 'Beverage') {
            $this->weekly_beverage = ($this->forecast->sevenDay($category) * ($this->categoryTarget[$category] / 100));
            $this->result = $this->weekly_beverage;
        } else {
            $this->result += ($this->forecast->sevenDay($category) * ($this->categoryTarget[$category] / 100));
        }
        //$this->result = number_format((float)$this->result, 1, '.', '');

        return $this->result;
    }

 

}