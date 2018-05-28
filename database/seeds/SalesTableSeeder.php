<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //$sale = factory(App\Sales::class)->make();

        //factory(App\Sales::class, 10)->create()->each(function($sale) {
        //   $sale->posts()->save(factory(App\Sales::class)->make());
        //});

        $carbon_date = \Carbon\Carbon::now()->subDay(28);

        for ($i = 0; $i < 28; $i++) {

            $food = rand(600000, 800000);
            $beverage = rand(100000, 150000);
            $alcohol = rand(300000, 50000);

            \App\Sale::create([
                'site_id' => '1',
                'food_sales' => $food,
                'alcohol_sales' => $alcohol,
                'beverage_sales' => $beverage,
                'net' => $food + $beverage + $alcohol,
                'seven_day_average' => '1',
                'twenty_eight_day_average' => '1',
                'receipts' => '1',
                'date' => $carbon_date->addDay()->toDateString(),
            ]);
        }
//
//        //Manually seeded data
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-01',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '10000',
//            'alcohol_sales' => '20000',
//            'beverage_sales' => '30000',
//            'net' => '60000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-02',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '100000',
//            'alcohol_sales' => '200000',
//            'beverage_sales' => '300000',
//            'net' => '600000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-03',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '2000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '7000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-04',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-05',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-06',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-07',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-08',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-09',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-10',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-11',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-12',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-13',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-14',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-15',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '10000',
//            'alcohol_sales' => '20000',
//            'beverage_sales' => '30000',
//            'net' => '60000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-16',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '100000',
//            'alcohol_sales' => '200000',
//            'beverage_sales' => '300000',
//            'net' => '600000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-17',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '2000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '7000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-18',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-19',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-20',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-21',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-22',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-23',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-24',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-25',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-26',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-27',
//        ]);
//
//        DB::table('sales')->insert([
//            'site_id' => '1',
//            'food_sales' => '1000',
//            'alcohol_sales' => '2000',
//            'beverage_sales' => '3000',
//            'net' => '6000',
//            'seven_day_average' => '1',
//            'twenty_eight_day_average' => '1',
//            'receipts' => '1',
//            'date' => '2018-05-28',
//        ]);


    }
}
