<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-05-23
 * Time: 10:18 AM
 */

namespace App;

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
        // return the sum of all the food sales between the two dates
        return 28 * 1000000; // just an example for testing
    }

    public function foodExpenses($from_date, $to_date)
    {
        // return the sum of all the food expenses between the two dates
        return 50000; // just an example for testing
    }
}