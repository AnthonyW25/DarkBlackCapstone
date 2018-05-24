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

        factory(App\Sales::class, 10)->create()->each(function($sale) {
           $sale->posts()->save(factory(App\Sales::class)->make());
        });
    }
}
