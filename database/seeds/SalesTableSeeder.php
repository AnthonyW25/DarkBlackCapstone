<?php

use Illuminate\Database\Seeder;

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
        $sale = factory(App\Sales::class, 50)->make();

        //factory(App\Sales::class, 28)->create()->each(function($sale) {
        //    $sale->posts()->save(factory(App\Sales::class)->make());
        //});
    }
}
