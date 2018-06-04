<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-06-03
 * Time: 2:39 PM
 */

namespace App;

use App\Exceptions\DarkBlackException;

class Budget
{
    public $forecast;
    public $cogs_target;

    public $categoryTarget;
    public $defaultTarget;

    public $weekly_food;
    public $weekly_alcohol;
    public $weekly_beverage;


    public function __construct(Forecast $forecast)
    {
        $this->forecast = $forecast;
    }


    //This function should set the cogs target to whatever is passed in as wanted target
    // , and apply to all the categories
    public function cogsTarget($target = null, $category = null)
    {
        if( ! is_null($target))
        {
            $this->cogs_target = $target; //Assign the global cogs_target to whatever was passed in
            if( ! is_null($category)){ //If something is in category

                $this->categoryTarget = $this->cogs_target;
                //$this->cogs_target = $categoryTarget;

                $this->cogsCategoryTarget($category); //Call the method to assign this cogs value to all categories
            } else { //If category is null

                $this->defaultTarget = $this->cogs_target;
                //$this->cogs_target = $defaultTarget;

                $this->cogsCategoryTarget(); //Call the method with specified category for the target
            }

        } else {
            //Throw an exception if target is null
            throw new DarkBlackException("No target specified, please enter a target");
        }
        return $this->cogs_target;
    }


    //This should only set the cogs target for a specified category ???!!!???
    public function cogsCategoryTarget($category = null)
    {
        //If there is a category, need to assign it to whatever was passed in
        if( ! is_null($category)) {
            $categoryTarget = $this->cogs_target;
        } else { //If category is null, assign the category target to the default global assigned in cogsTarget
            $categoryTarget = $this->defaultTarget;
        }
        return $categoryTarget;
    }


    //Provides an expense budget for the specified category
    public function byCategory($category = null)
    {

    }

    //Provides the total expense budget that includes all categories
    public function calculateTotal()
    {

    }
}