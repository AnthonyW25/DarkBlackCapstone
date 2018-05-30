<?php
/**
 * Created by PhpStorm.
 * User: dirk
 * Date: 2018-05-28
 * Time: 6:32 PM
 */

namespace App;

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


}