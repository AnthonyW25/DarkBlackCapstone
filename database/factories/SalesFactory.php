<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Sales::class, function (Faker $faker) {
    return [

        'site_id' => '1',
        'food_sales' => $faker->numberBetween($min = 0, $max = 1000000),
        //$food_sales = 'food_sales',
        'alcohol_sales' => $faker->numberBetween($min = 0, $max = 100000),
        //$alcohol_sales = 'alcohol_sales',
        'beverage_sales' => $faker->numberBetween($min = 0, $max = 100000),
        //$beverage_sales = 'beverage_sales',
        //$net = $food_sales + $alcohol_sales + $beverage_sales,
        'net' => '1',
        'seven_day_average' => '1',
        'twenty_eight_day_average' => '1',
        'receipts' => '1',
        'date' => $faker->date($format = 'Y-m-d', $min = '2018-5-1', $max = 'now'),
    ];
});
