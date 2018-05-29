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
    public $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }
}