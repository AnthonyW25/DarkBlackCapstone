<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable =
    ['net', 'seven_day_average', 'twenty_eight_day_average'];
}
