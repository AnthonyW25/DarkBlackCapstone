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


        //Manually seeded data
        DB::table('sales')->insert([
            'site_id' => '1',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-01',
        ]);

        DB::table('sales')->insert([
            'site_id' => '2',
            'food_sales' => '10000',
            'alcohol_sales' => '20000',
            'beverage_sales' => '30000',
            'net' => '60000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-02',
        ]);

        DB::table('sales')->insert([
            'site_id' => '3',
            'food_sales' => '100000',
            'alcohol_sales' => '200000',
            'beverage_sales' => '300000',
            'net' => '600000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-03',
        ]);

        DB::table('sales')->insert([
            'site_id' => '4',
            'food_sales' => '2000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '7000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-04',
        ]);

        DB::table('sales')->insert([
            'site_id' => '5',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-05',
        ]);

        DB::table('sales')->insert([
            'site_id' => '6',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-06',
        ]);

        DB::table('sales')->insert([
            'site_id' => '7',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-07',
        ]);

        DB::table('sales')->insert([
            'site_id' => '8',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-08',
        ]);

        DB::table('sales')->insert([
            'site_id' => '9',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-09',
        ]);

        DB::table('sales')->insert([
            'site_id' => '10',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-10',
        ]);

        DB::table('sales')->insert([
            'site_id' => '11',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-11',
        ]);

        DB::table('sales')->insert([
            'site_id' => '12',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-12',
        ]);

        DB::table('sales')->insert([
            'site_id' => '13',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-13',
        ]);

        DB::table('sales')->insert([
            'site_id' => '14',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-14',
        ]);

        DB::table('sales')->insert([
            'site_id' => '15',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-15',
        ]);

        DB::table('sales')->insert([
            'site_id' => '16',
            'food_sales' => '10000',
            'alcohol_sales' => '20000',
            'beverage_sales' => '30000',
            'net' => '60000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-16',
        ]);

        DB::table('sales')->insert([
            'site_id' => '17',
            'food_sales' => '100000',
            'alcohol_sales' => '200000',
            'beverage_sales' => '300000',
            'net' => '600000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-17',
        ]);

        DB::table('sales')->insert([
            'site_id' => '18',
            'food_sales' => '2000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '7000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-18',
        ]);

        DB::table('sales')->insert([
            'site_id' => '19',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-19',
        ]);

        DB::table('sales')->insert([
            'site_id' => '20',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-20',
        ]);

        DB::table('sales')->insert([
            'site_id' => '21',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-21',
        ]);

        DB::table('sales')->insert([
            'site_id' => '22',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-22',
        ]);

        DB::table('sales')->insert([
            'site_id' => '23',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-23',
        ]);

        DB::table('sales')->insert([
            'site_id' => '24',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-24',
        ]);

        DB::table('sales')->insert([
            'site_id' => '25',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-25',
        ]);

        DB::table('sales')->insert([
            'site_id' => '26',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-26',
        ]);

        DB::table('sales')->insert([
            'site_id' => '27',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-27',
        ]);

        DB::table('sales')->insert([
            'site_id' => '28',
            'food_sales' => '1000',
            'alcohol_sales' => '2000',
            'beverage_sales' => '3000',
            'net' => '6000',
            'seven_day_average' => '1',
            'twenty_eight_day_average' => '1',
            'receipts' => '1',
            'date' => '2018-05-28',
        ]);


    }
}
