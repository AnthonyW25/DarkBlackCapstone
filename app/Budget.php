<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-06-03
 * Time: 2:39 PM
 */

namespace App;

class Budget
{
    public $forecast;

    public function __construct(Forecast $forecast)
    {
        $this->forecast = $forecast;
    }
}