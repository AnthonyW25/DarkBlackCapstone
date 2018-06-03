<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->default('1');
            $table->integer('food_sales')->default('0')->nullable();
            $table->integer('alcohol_sales')->default('0')->nullable();
            $table->integer('beverage_sales')->default('0')->nullable();
            $table->integer('net')->default('0')->nullable();
            $table->integer('seven_day_average')->default('0')->nullable();
            $table->integer('twenty_eight_day_average')->default('0')->nullable();
            $table->decimal('forecast_rate')->default('0')->nullable();
            $table->integer('receipts')->default('0')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
