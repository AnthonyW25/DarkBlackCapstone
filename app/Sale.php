<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable =
    ['id', 'net', 'seven_day_average', 'twenty_eight_day_average', 'forecast_percentage', 'cogs_target', 'food_cogs_target', 'alcohol_cogs_target', 'beverage_cogs_target'];
}
